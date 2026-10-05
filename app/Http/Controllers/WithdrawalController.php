<?php
namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\MitraBalance;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $query = Withdrawal::with(['user']);
        if ($request->filled('status')) $query->where('status',$request->status);
        if ($request->filled('search')) {
            $query->whereHas('user',fn($q)=>$q->where('name','like','%'.$request->search.'%'));
        }

        return view('admin.withdrawals.index',[
            'withdrawals'=>$query->latest()->paginate(10)->withQueryString(),
            'pending'=>Withdrawal::whereIn('status',['pending','menunggu'])->count(),
            'processing'=>Withdrawal::where('status','processing')->count(),
            'success'=>Withdrawal::where('status','success')->count(),
            'failed'=>Withdrawal::where('status','failed')->count(),
            'rejected'=>Withdrawal::where('status','rejected')->count(),
        ]);
    }

    public function show($id)
    {
        $withdrawal=Withdrawal::with(['user.bank','user.ewallet'])->findOrFail($id);
        return view('admin.withdrawals.show',compact('withdrawal'));
    }

    public function approve($id)
    {
        DB::beginTransaction();
        try{
            $withdrawal=Withdrawal::with(['user.bank','user.ewallet'])->findOrFail($id);
            if(!in_array($withdrawal->status,['pending','menunggu'])){
                return back()->with('error','Pencairan sudah diproses.');
            }

            $user=$withdrawal->user;
            $map=['BCA'=>'BCA','BNI'=>'BNI','BRI'=>'BRI','MANDIRI'=>'MANDIRI','GOPAY'=>'GOPAY','OVO'=>'OVO','DANA'=>'DANA','LINKAJA'=>'LINKAJA','SHOPEEPAY'=>'SHOPEEPAY'];
            $bankCode=$map[strtoupper($withdrawal->bank_name??'')]??optional($user->bank)->brick_code??optional($user->ewallet)->brick_code;
            $account=$withdrawal->bank_account;

            if(!$bankCode||!$account){
                return back()->with('error','Data rekening belum lengkap.');
            }

            $amount=max(0,$withdrawal->amount-2500);

            $withdrawal->update(['status'=>'processing']);

            $response=Http::withBasicAuth(env('XENDIT_SECRET_KEY'),'')->post('https://api.xendit.co/disbursements',[
                'external_id'=>'WD-'.$withdrawal->id.'-'.time(),
                'bank_code'=>$bankCode,
                'account_holder_name'=>$withdrawal->account_holder??$user->name,
                'account_number'=>$account,
                'amount'=>$amount,
                'description'=>'Pencairan Dana '.$user->name,
            ]);

            $json=$response->json();

           if($response->successful() && isset($json['id'])){

    $withdrawal->update([

        'status'=>'success',

        'xendit_id'=>$json['id']

    ]);

    MitraBalance::create([
    'mitra_id' => $withdrawal->mitra_id,
    'order_id' => 0,
    'amount'   => $withdrawal->amount,
    'type'     => 'withdraw'
]);

DB::commit();

return redirect()
    ->route('admin.withdrawals.show', $withdrawal->id)
    ->with('success','Pencairan berhasil diproses.');

// dd('withdraw berhasil dicatat');

    /*
|--------------------------------------------------------------------------
| KURANGI SALDO MITRA
|--------------------------------------------------------------------------
*/

$sisa = $withdrawal->amount;

$balances = MitraBalance::where('mitra_id', $withdrawal->mitra_id)
    ->where('type', 'income')
    ->where('status', 'available')
    ->orderBy('created_at')
    ->get();

foreach ($balances as $balance) {

    if ($sisa <= 0) {
        break;
    }

    if ($balance->amount <= $sisa) {

        $balance->update([
            'status' => 'withdrawn'
        ]);

        $sisa -= $balance->amount;

    }

}

    /*
|--------------------------------------------------------------------------
| CATAT TRANSAKSI WITHDRAW
|--------------------------------------------------------------------------
*/

// MitraBalance::create([

//     'mitra_id' => $withdrawal->mitra_id,

//     'order_id' => null,

//     'amount' => $withdrawal->amount,

//     'type' => 'withdraw',

//     'status' => 'withdrawn'

// ]);

    /*
    |--------------------------------------------------------------------------
    | UPDATE SALDO MITRA
    |--------------------------------------------------------------------------
    */

    

    DB::commit();

    return redirect()
        ->route('admin.withdrawals.show', $withdrawal->id)
        ->with('success', 'Pencairan berhasil diproses.');
}

            DB::rollBack();
            return back()->with('error',$json['message']??'Gagal memproses pencairan.');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error',$e->getMessage());
        }
    }

    public function reject(Request $request,$id)
    {
        DB::beginTransaction();
        try{
            $withdrawal=Withdrawal::findOrFail($id);
            $withdrawal->update([
                'status'=>'rejected',
                'note'=>$request->note??'Ditolak oleh admin'
            ]);
            if($withdrawal->user){
                $withdrawal->user->increment('saldo',$withdrawal->amount);
            }
            DB::commit();
            return redirect()->route('admin.withdrawals.index')->with('success','Pengajuan berhasil ditolak.');
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error',$e->getMessage());
        }
    }
}

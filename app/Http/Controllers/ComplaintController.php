<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Storage;
use App\Models\Bank;
use App\Models\Ewallet;
use App\Models\CustomerBalance;
use App\Models\CustomerBalanceTransaction;

class ComplaintController extends Controller
{
  public function create($id)
{
    $order = Order::with([
        'mitra',
        'items.service'
    ])
    ->where('user_id', auth()->id())
    ->findOrFail($id);

    $banks = Bank::orderBy('nama_bank')->get();

    $ewallets = Ewallet::orderBy('nama_wallet')->get();

    return view(
        'pelanggan.complaints.create',
        compact(
            'order',
            'banks',
            'ewallets'
        )
    );
}

  public function store(Request $request, $id)
{
    $request->validate([
        

        'category'   => 'required',

        'subject'    => 'required|max:255',

        'complaint'  => 'required',

        'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        'video'      => 'nullable|mimes:mp4,mov,avi|max:20480',

        
    ]);
  

    $order = Order::where('user_id', auth()->id())
                    ->findOrFail($id);

    /*
    |--------------------------------------------------------------------------
    | Upload Foto
    |--------------------------------------------------------------------------
    */

    $photo = null;

    if ($request->hasFile('photo')) {

        $file = $request->file('photo');

        $photo = time() . '_' . $file->getClientOriginalName();

        $file->move(
            public_path('uploads/complaints/photos'),
            $photo
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Upload Video
    |--------------------------------------------------------------------------
    */

    $video = null;

    if ($request->hasFile('video')) {

        $file = $request->file('video');

        $video = time() . '_' . $file->getClientOriginalName();

        $file->move(
            public_path('uploads/complaints/videos'),
            $video
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Generate Nomor Komplain
    |--------------------------------------------------------------------------
    */

   

    /*
    |--------------------------------------------------------------------------
    | Simpan Komplain
    |--------------------------------------------------------------------------
    */

  $complaint = Complaint::create([

    'complaint_number' => 'CMP-' . $order->invoice_number,

    'order_id' => $order->id,

    'user_id' => auth()->id(),

    'mitra_id' => $order->mitra_id,

    'category' => $request->category,

    'subject' => $request->subject,

    'complaint' => $request->complaint,

    'photo' => $photo,

    'video' => $video,

    'refund_type' => $request->refund_type,

    'bank_id' => $request->bank_id,

    'ewallet_id' => $request->ewallet_id,

    'account_number' => $request->account_number,

    'account_holder' => $request->account_holder,

    'status' => 'pending',

]);



    /*
    |--------------------------------------------------------------------------
    | Update Status Order
    |--------------------------------------------------------------------------
    */

    $order->update([

        'status' => 'komplain',

        'customer_confirmation' => 'complain'

    ]);

    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

    return redirect('/my-orders')->with(

        'success',

        'Komplain berhasil dikirim. Admin akan segera meninjau laporan Anda.'

    );
}
public function show($id)
{
   $complaint = Complaint::with([
    'order',
    'user',
    'mitra',
    'bank',
    'ewallet'
])->findOrFail($id);

    return view(

        'pelanggan.complaints.show',

        compact('complaint')

    );
}

public function showMitra($id)
{
    $complaint = Complaint::where('order_id', $id)
        ->where('mitra_id', auth()->id())
        ->with(['order', 'user'])
        ->firstOrFail();

    return view('mitra.complaints.show', compact('complaint'));
}

public function responseMitra(Request $request, $id)
{
    $request->validate([
        'mitra_response' => 'required'
    ]);

    $complaint = Complaint::where('order_id',$id)
        ->where('mitra_id',auth()->id())
        ->firstOrFail();

    $complaint->update([
        'mitra_response'=>$request->mitra_response,
        'status'=>'review'
    ]);

    return back()->with(
        'success',
        'Tanggapan berhasil dikirim.'
    );
}
}
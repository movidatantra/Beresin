<?php

namespace App\Http\Controllers;




use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MitraService;
use App\Models\Service;

class MitraServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $services = MitraService::with('service')
        ->where('mitra_id', Auth::id())
        ->get();

    return view('mitra.services.index', compact('services'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $services = Service::orderBy('name')->get();

    return view(
        'mitra-services.create',
        compact('services')
    );
}

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
{
    $request->validate([
        'service_id' => 'required|exists:services,id',
        'price' => 'required|numeric|min:0',
        'duration' => 'required|integer|min:1',
        'status' => 'required'
    ]);

    $exists = MitraService::where('mitra_id', Auth::id())
        ->where('service_id', $request->service_id)
        ->exists();

    if ($exists) {
        return back()
            ->withErrors([
                'service_id' => 'Layanan sudah ditambahkan.'
            ])
            ->withInput();
    }

    MitraService::create([
        'mitra_id' => Auth::id(),
        'service_id' => $request->service_id,
        'price' => $request->price,
        'duration' => $request->duration,
        'status' => $request->status,
        'total_order' => 0
    ]);

    return redirect()
        ->route('mitra-services.index')
        ->with('success','Layanan berhasil ditambahkan.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(MitraService $mitraService)
{
    if ($mitraService->mitra_id != Auth::id()) {
        abort(403);
    }

    return view('mitra.services.edit', compact('mitraService'));
}

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, MitraService $mitraService)
{
    if ($mitraService->mitra_id != Auth::id()) {
        abort(403);
    }

    $request->validate([
        'price'=>'required|numeric|min:0',
        'duration'=>'required|integer|min:1',
        'status'=>'required'
    ]);

    $mitraService->update([
        'price'=>$request->price,
        'duration'=>$request->duration,
        'status'=>$request->status
    ]);

    return redirect()
        ->route('mitra-services.index')
        ->with('success','Layanan berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    MitraService::findOrFail($id)->delete();

    return redirect('/mitra-services')
        ->with('success','Layanan berhasil dihapus');
}
}

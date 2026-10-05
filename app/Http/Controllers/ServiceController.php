<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{

    // ======================
    // LIST SERVICE
    // ======================

    public function index()
{

    $services = Service::where('mitra_id', Auth::id())
                ->latest()
                ->get();

    return view('services.index', compact('services'));
}

    // ======================
    // FORM CREATE
    // ======================

    public function create()
    {
        return view('services.create');
    }

    // ======================
    // STORE DATA
    // ======================

public function store(Request $request)
{

    $request->validate([

        'name' => 'required',

        'category' => 'required',

        'price' => 'required',

        'description' => 'required',

        'duration' => 'required',

        'status' => 'required',

        'image' => 'required|image'

    ]);

    // UPLOAD IMAGE

    $imageName = time().'.'.$request->image->extension();

    $request->image->move(

        public_path('uploads'),

        $imageName

    );

    // SAVE

    Service::create([

        'mitra_id' => Auth::id(),

        'name' => $request->name,

        'category' => $request->category,

        'price' => $request->price,

        'description' => $request->description,

        'duration' => $request->duration,

        'status' => $request->status,

        'image' => $imageName

    ]);

    return redirect('/services')
            ->with('success', 'Layanan berhasil ditambahkan');
}

    // ======================
    // EDIT
    // ======================

    public function edit($id)
    {
        $service = Service::findOrFail($id);

        return view('services.edit', compact('service'));
    }

    // ======================
    // UPDATE
    // ======================

   public function update(Request $request, $id)
{

    $service = Service::findOrFail($id);

    // VALIDASI

    $request->validate([

        'name' => 'required',

        'category' => 'required',

        'price' => 'required',

        'description' => 'required',

        'duration' => 'required',

        'status' => 'required',

    ]);

    // IMAGE

    if($request->hasFile('image')){

        $imageName = time().'.'.$request->image->extension();

        $request->image->move(

            public_path('uploads'),

            $imageName

        );

        $service->image = $imageName;
    }

    // UPDATE

    $service->update([

        'name' => $request->name,

        'category' => $request->category,

        'price' => $request->price,

        'description' => $request->description,

        'duration' => $request->duration,

        'status' => $request->status,

        'image' => $service->image

    ]);

    return redirect('/services')
            ->with('success', 'Layanan berhasil diupdate');
}

    // ======================
    // DELETE
    // ======================

    public function destroy($id)
    {

        $service = Service::findOrFail($id);

        $service->delete();

        return redirect('/services')
                ->with('success', 'Layanan berhasil dihapus');
    }

}
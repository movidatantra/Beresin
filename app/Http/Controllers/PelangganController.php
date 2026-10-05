<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\BookingSlot;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;


class PelangganController extends Controller
{


public function updateLocation(Request $request)
{
    $request->validate([
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    $user = Auth::user();

    $user->latitude = $request->latitude;
    $user->longitude = $request->longitude;

    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Lokasi berhasil diperbarui'
    ]);
}
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD PELANGGAN
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $services = Service::with('mitra')
                    ->where(
                        'status',
                        'aktif'
                    )
                    ->latest()
                    ->get();

        $totalOrder = Order::where(
                            'user_id',
                            Auth::id()
                        )
                        ->count();

        return view(
            'pelanggan.dashboard',
            compact(
                'services',
                'totalOrder'
            )
        );
    }

 public function category($category)
{
    $customerLat = Auth::user()->latitude;
    $customerLng = Auth::user()->longitude;

    if (!$customerLat || !$customerLng) {
        return back()->with(
            'error',
            'Lokasi Anda belum tersedia. Aktifkan GPS terlebih dahulu.'
        );
    }

    $mitras = User::selectRaw("
        *,
        (
            6371 * acos(
                cos(radians(?))
                * cos(radians(latitude))
                * cos(radians(longitude) - radians(?))
                + sin(radians(?))
                * sin(radians(latitude))
            )
        ) AS distance
    ", [
        $customerLat,
        $customerLng,
        $customerLat
    ])

    ->with([
    'services' => function ($q) use ($category) {
        $q->where('category', $category)
          ->where('status', 'aktif');
    }
])

->withAvg('review', 'rating')
->withCount('review')

->whereHas('services', function ($q) use ($category) {
    $q->where('category', $category)
      ->where('status', 'aktif');
})

->where('role', 'mitra')
->where('verification_status', 'verified')
->orderBy('distance')
->get();

    return view(
        'pelanggan.category',
        compact('mitras', 'category')
    );
}

    /*
    |--------------------------------------------------------------------------
    | DETAIL SERVICE
    |--------------------------------------------------------------------------
    */

 public function show($id)
{
   $service = Service::with([
    'mitra' => function ($query) {
        $query->withAvg('reviews', 'rating')
              ->withCount('reviews');
    }
])->findOrFail($id);

    $cart = Cart::where(
                'user_id',
                Auth::id()
            )
            ->where(
                'service_id',
                $id
            )
            ->first();

    $qty = $cart ? $cart->qty : 0;

    return view(
        'pelanggan.detail-service',
        compact(
            'service',
            'qty'
        )
    );
}

    /*
    |--------------------------------------------------------------------------
    | BOOKING SERVICE
    |--------------------------------------------------------------------------
    */

  public function booking(Request $request, $id)
{
    if (Auth::user()->role != 'pelanggan') {
        abort(403);
    }

    $request->validate([

        'jadwal' => 'required|date',

        'jam' => 'required',

        'address' => 'required',

        'payment_method' => 'required'

    ]);

    // Ambil layanan
    $service = Service::findOrFail($id);

    // ==========================
    // LOKASI PELANGGAN
    // SEMENTARA HARDCODE DULU
    // NANTI BISA DIAMBIL DARI GPS
    // ==========================
   // ==========================
// LOKASI PELANGGAN DARI DATABASE
// ==========================

$customerLat = Auth::user()->latitude;
$customerLng = Auth::user()->longitude;

if (!$customerLat || !$customerLng) {

    return back()->with(
        'error',
        'Lokasi Anda belum tersedia. Mohon aktifkan GPS terlebih dahulu.'
    );
}

    // ==========================
    // HAVERSINE
    // CARI MITRA TERDEKAT
    // ==========================
    $mitras = User::selectRaw("
        *,
        (
            6371 * acos(
                cos(radians(?))
                * cos(radians(latitude))
                * cos(radians(longitude) - radians(?))
                + sin(radians(?))
                * sin(radians(latitude))
            )
        ) AS distance
    ", [
        $customerLat,
        $customerLng,
        $customerLat
    ])

    ->where('role', 'mitra')

    ->whereHas('services', function ($q) use ($service) {

        $q->where(
            'category',
            $service->category
        );

    })

    ->orderBy('distance')

    ->get();

    // ==========================
    // GREEDY
    // PILIH MITRA PERTAMA
    // YANG BELUM PUNYA ORDER
    // ==========================
    $mitraTerpilih = null;

    foreach ($mitras as $mitra) {

        $sudahAdaOrder = Order::where(
                'mitra_id',
                $mitra->id
            )

            ->where(
                'jadwal',
                $request->jadwal
            )

            ->where(
                'jam',
                $request->jam
            )

            ->exists();

        if (!$sudahAdaOrder) {

            $mitraTerpilih = $mitra;

            break;
        }
    }

    if (!$mitraTerpilih) {

        return back()->with(
            'error',
            'Tidak ada mitra yang tersedia'
        );
    }

    // ==========================
    // SIMPAN ORDER
    // ==========================
    // Order::create([

    //     'user_id' => Auth::id(),

    //     'mitra_id' => $mitraTerpilih->id,

    //     'service_id' => $service->id,

    //     'slot_id' => null,

    //     'total_price' => $service->price,

    //     'jadwal' => $request->jadwal,

    //     'jam' => $request->jam,

    //     'address' => $request->address,

    //     'note' => $request->note,

    //     'payment_method' => $request->payment_method,

    //     'status' => 'pending',

    //     'payment_status' => 'belum_bayar'

    // ]);

    // ==========================
// HARGA
// ==========================

$subtotal = $service->price;

// Biaya admin Beres.in
$serviceFee = 10000;

// Total yang dibayar pelanggan
$totalPrice = $subtotal + $serviceFee;


// ==========================
// SIMPAN ORDER
// ==========================

Order::create([

    'user_id' => Auth::id(),

    'mitra_id' => $mitraTerpilih->id,

    'service_id' => $service->id,

    'slot_id' => null,

    // Harga jasa
    'subtotal' => $subtotal,

    // Biaya admin Beres.in
    'service_fee' => $serviceFee,

    // Total pembayaran
    'total_price' => $totalPrice,

    'jadwal' => $request->jadwal,

    'jam' => $request->jam,

    'address' => $request->address,

    'note' => $request->note,

    'payment_method' => $request->payment_method,

    'status' => 'pending',

    'payment_status' => 'belum_bayar'

]);

    return redirect('/my-orders')

        ->with(
            'success',
            'Booking berhasil dibuat'
        );
}




    /*
    |--------------------------------------------------------------------------
    | PESANAN SAYA
    |--------------------------------------------------------------------------
    */

   public function myOrders()
{
    $orders = Order::with([
                    'items.service',
                    'mitra'
                ])
                ->where(
                    'user_id',
                    Auth::id()
                )
                ->latest()
                ->get();

    return view(
        'pelanggan.orders.orders',
        compact('orders')
    );
}
    
    /*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

public function profile()
{
    return view('pelanggan.profile.profile');
}


public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([

        'name' => 'required',

        'address' => 'required',

        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5000'

    ], [

        'name.required' => 'Nama lengkap wajib diisi',

        'address.required' => 'Alamat wajib diisi',

        'photo.image' => 'File harus berupa gambar',

        'photo.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',

        'photo.max' => 'Ukuran foto maksimal 5 MB',

    ]);

    // Pakai foto lama jika tidak upload baru
    $photoName = $user->photo;

    // Upload foto baru
    if ($request->hasFile('photo')) {

        $photoName =
            time().'_profile.'.
            $request->file('photo')->extension();

        $request->file('photo')->move(
            public_path('uploads/profile'),
            $photoName
        );
    }

    // Update database
    $user->update([

        'name' => $request->name,

        'address' => $request->address,

        'photo' => $photoName,

    ]);

    // Refresh user yang login
    Auth::setUser($user->fresh());

    return back()->with(
        'success',
        'Profile berhasil diperbarui'
    );
}
/*
|--------------------------------------------------------------------------
| UBAH PASSWORD
|--------------------------------------------------------------------------
*/

public function showChangePassword()
{
    return view(
        'pelanggan.profile.password'
    );
}

public function changePassword(Request $request)
{
    $request->validate([

        'old_password' => 'required',

        'password' => 'required|min:8|confirmed'

    ],[

        'old_password.required' =>
            'Password lama wajib diisi',

        'password.required' =>
            'Password baru wajib diisi',

        'password.min' =>
            'Password minimal 8 karakter',

        'password.confirmed' =>
            'Konfirmasi password tidak cocok'

    ]);

    $user = Auth::user();

    if(
        !Hash::check(
            $request->old_password,
            $user->password
        )
    )
    {
        return back()->with(

            'error',

            'Password lama salah'

        );
    }

    $user->update([

        'password' =>
            Hash::make(
                $request->password
            )

    ]);

    return back()->with(

        'success',

        'Password berhasil diubah'

    );
}

public function settings()
{
    return view(
        'pelanggan.profile.settings'
    );
}

public function deleteAccount()
{
    $user = Auth::user();

    Auth::logout();

    $user->delete();

    return redirect('/')
            ->with(
                'success',
                'Akun berhasil dihapus'
            );
}
public function mitraDetail($id)
{
    $mitra = User::with('services')
                ->findOrFail($id);

    return view(
        'pelanggan.mitra-detail',
        compact('mitra')
    );
}

}


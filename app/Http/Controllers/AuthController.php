<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Provinsi;
use App\Models\Bank;

use App\Models\Ewallet;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

use App\Services\BrickService;



class AuthController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | REGISTER PELANGGAN
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }

   public function register(Request $request)
{
    // EMAIL HARUS SUDAH DIVERIFIKASI

    if (!session('email_verified')) {

        return back()
            ->with('error', 'Email belum diverifikasi')
            ->withInput();
    }

    // WHATSAPP HARUS SUDAH DIVERIFIKASI

    if (!session('phone_verified')) {

        return back()
            ->with('error', 'Nomor WhatsApp belum diverifikasi')
            ->withInput();
    }

    // VALIDASI

    $request->validate([

        'name' => 'required',

        'email' => 'required|email|unique:users',

        'phone' => 'required|unique:users',

        'password' => 'required|min:8|confirmed',

        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:3045',

    ], [

        'name.required' => 'Nama lengkap wajib diisi',

        'email.required' => 'Email wajib diisi',

        'email.email' => 'Format email tidak valid',

        'email.unique' => 'Email sudah digunakan',

        'phone.required' => 'Nomor WhatsApp wajib diisi',

        'phone.unique' => 'Nomor WhatsApp sudah digunakan',

        'password.required' => 'Password wajib diisi',

        'password.min' => 'Password minimal 8 karakter',

        'password.confirmed' => 'Konfirmasi password tidak cocok',

    ]);

    // UPLOAD FOTO PROFIL

    $photoName = null;

    if ($request->hasFile('photo')) {

        $photoName =
            time().'_profile.'.
            $request->photo->extension();

        $request->photo->move(

            public_path('uploads/profile'),

            $photoName

        );
    }

    // SIMPAN PELANGGAN

    User::create([

        'name' => $request->name,

        'email' => $request->email,

        'phone' => $request->phone,
        'email_verified' => true,
'phone_verified' => true,

        'photo' => $photoName,

        'password' => Hash::make($request->password),

        'role' => 'pelanggan',

    ]);

    // HAPUS SESSION OTP

    session()->forget([

        'email_otp',
        'phone_otp',

        'email_verified',
        'phone_verified'

    ]);

    return redirect('/login')

        ->with(

            'success',

            'Register pelanggan berhasil'

        );
}

public function cekRekening(Request $request, BrickService $brick)
{
    $result = $brick->verifyAccount(
        $request->bank,
        $request->rekening
    );

    return response()->json($result);
}
    /*
    |--------------------------------------------------------------------------
    | REGISTER MITRA
    |--------------------------------------------------------------------------
    */

  public function showRegisterMitra()
{
    $provinces = Provinsi::orderBy('nama_prov')->get();

    $banks = Bank::orderBy('nama_bank')->get();

    $ewallets = Ewallet::orderBy('nama_wallet')->get();

    return view(
        'auth.register-mitra',
        compact(
            'provinces',
            'banks',
            'ewallets'
        )
    );
}

    public function registerMitra(Request $request)
    {
       if(!session('email_verified'))
{
    return back()
    ->with('error', 'Email belum diverifikasi')
    ->withInput();
}

if(!session('phone_verified'))
{
    return back()
    ->with('error', 'Nomor WhatsApp belum diverifikasi')
    ->withInput();
}

       

    $request->validate([

    'name' => 'required',
    'nik' => 'required|digits:16',
    'email' => 'required|email|unique:users',
    'phone' => 'required',

    'password' => 'required|min:8|confirmed',

    'address' => 'required',

    'business_name' => 'required',
    'specialization' => 'required',
    'experience' => 'required',
    'description' => 'required',

    'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    'ktp_photo' => 'required|image|mimes:jpg,jpeg,png|max:4096',

    // 'bank_id' => 'required',
    'withdraw_type' => 'required|in:bank,ewallet',

'withdraw_number' => 'required',

'withdraw_name' => 'required',

    'kd_prov' => 'required',
    'kd_kab' => 'required',
    'kd_kec' => 'required',

    // BARU
    'birth_place' => 'required',
    'birth_date' => 'required|date',

    'open_time' => 'required',
'close_time' => 'required',

'holiday' => 'required',

    'instagram_url' => 'nullable|url',
    'facebook_url' => 'nullable|url',
    'tiktok_url' => 'nullable|url',

    'business_photo' => 'required|image|mimes:jpg,jpeg,png|max:4096',

'portfolio_photos' => 'required',

'portfolio_photos.*' => 'required|image|mimes:jpg,jpeg,png|max:4096',

]);
// FOTO USAHA

$businessPhoto = null;

if ($request->hasFile('business_photo')) {

    $businessPhoto =
        time().'_business.'.
        $request->business_photo->extension();

    $request->business_photo->move(
        public_path('uploads/business'),
        $businessPhoto
    );

}
if($request->withdraw_type == 'bank')
{
    $request->validate([
        'bank_id' => 'required'
    ]);
}

if($request->withdraw_type == 'ewallet')
{
    $request->validate([
        'ewallet_id' => 'required'
    ]);
}

        // UPLOAD FOTO

        $photoName = time().'.'.$request->photo->extension();

        $request->photo->move(

            public_path('uploads/profile'),

            $photoName

        );
        //upload foto ktp
        $ktpName = time().'_ktp.'.$request->ktp_photo->extension();

$request->ktp_photo->move(
    public_path('uploads/ktp'),
    $ktpName
);
$portfolioPhotos = [];

if ($request->hasFile('portfolio_photos')) {

    foreach ($request->file('portfolio_photos') as $index => $photo) {

        $fileName =
            time().'_'.$index.'.'.
            $photo->extension();

        $photo->move(
            public_path('uploads/portfolio'),
            $fileName
        );

        $portfolioPhotos[] = $fileName;

    }

}

        // SAVE MITRA

        User::create([

    'name' => $request->name,
    'email' => $request->email,
    'phone' => $request->phone,
    'email_verified' => true,
'phone_verified' => true,

    'nik' => $request->nik,

    'password' => Hash::make($request->password),

    'birth_place' => $request->birth_place,
    'birth_date' => $request->birth_date,

    'kd_prov' => $request->kd_prov,
    'kd_kab' => $request->kd_kab,
    'kd_kec' => $request->kd_kec,

    'withdraw_type' => $request->withdraw_type,

'bank_id' => $request->withdraw_type == 'bank'
                ? $request->bank_id
                : null,

'ewallet_id' => $request->withdraw_type == 'ewallet'
                ? $request->ewallet_id
                : null,

'withdraw_number' => $request->withdraw_number,

'withdraw_name' => $request->withdraw_name,

    'ktp_photo' => $ktpName,

    'address' => $request->address,

    'business_name' => $request->business_name,
    'specialization' => $request->specialization,

    'experience' => $request->experience,

    'description' => $request->description,

    'photo' => $photoName,

    'latitude' => $request->latitude,
    'longitude' => $request->longitude,

    // BARU

    'open_time' => $request->open_time,
    'close_time' => $request->close_time,

    'holiday' => $request->holiday,

    'instagram_url' => $request->instagram_url,
    'facebook_url' => $request->facebook_url,
    'tiktok_url' => $request->tiktok_url,

    'service_warranty' =>
        $request->has('service_warranty'),

    'business_photo' => $businessPhoto,

    'portfolio_photos' =>
        json_encode($portfolioPhotos),

    'role' => 'mitra',

    'verification_status' => 'pending',

]);

        return redirect('/login')
                ->with('success', 'Pendaftaran mitra berhasil');

    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->only(

        'email',

        'password'

    );

    if(Auth::attempt($credentials))
    {
        $user = Auth::user();

        // CEK VERIFIKASI MITRA

        if(
            $user->role == 'mitra'
            &&
            $user->verification_status != 'verified'
        )
        {
            Auth::logout();

            return back()->with(
                'error',
                'Akun mitra masih menunggu verifikasi admin'
            );
        }

        // ADMIN

        if($user->role == 'admin')
        {
            return redirect('/admin');
        }

        // MITRA

        if($user->role == 'mitra')
        {
            return redirect('/mitra');
        }

        // PELANGGAN

        return redirect('/pelanggan');
    }

    return back()
            ->with(
                'error',
                'Email atau password salah'
            );
}

    /*
    |--------------------------------------------------------------------------
    | PROFILE MITRA
    |--------------------------------------------------------------------------
    */

    public function profileMitra()
    {
        return view('mitra.profile');
    }

    public function updateProfileMitra(Request $request)
    {

        $user = Auth::user();

        $request->validate([

            'name' => 'required',

            'phone' => 'required',

            'business_name' => 'required',

            'business_area' => 'required',

            'specialization' => 'required',

            'experience' => 'required',

            'description' => 'required',

            'address' => 'required',

        ]);

        // FOTO

        if($request->hasFile('photo')){

            $photoName = time().'.'.$request->photo->extension();

            $request->photo->move(

                public_path('uploads/profile'),

                $photoName

            );

            $user->photo = $photoName;

        }

        // UPDATE

        $user->update([

            'name' => $request->name,

            'phone' => $request->phone,

            'business_name' => $request->business_name,

            'business_area' => $request->business_area,

            'specialization' => $request->specialization,

            'experience' => $request->experience,

            'description' => $request->description,

            'address' => $request->address,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

            'photo' => $user->photo,

        ]);

        return back()->with(

            'success',

            'Profile berhasil diperbarui'

        );

    }


    public function sendEmailOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $otp = rand(100000, 999999);

    session([
        'email_otp' => $otp,
        'email_verified' => false
    ]);

    Mail::raw(

        "Kode OTP Beres.in Anda adalah: $otp",

        function ($message) use ($request) {

            $message
                ->to($request->email)
                ->subject('Verifikasi Email Beres.in');

        }

    );

    return response()->json([
        'success' => true
    ]);
}

public function verifyEmailOtp(Request $request)
{
    if (
        $request->otp ==
        session('email_otp')
    ) {

        session([
            'email_verified' => true
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    return response()->json([
        'success' => false
    ]);
}

public function sendPhoneOtp(Request $request)
{
    $request->validate([
        'phone' => 'required'
    ]);

    $otp = rand(100000, 999999);

    session([
        'phone_otp' => $otp,
        'phone_verified' => false
    ]);

    // Ubah 08xxx menjadi 628xxx
    $phone = preg_replace('/^0/', '62', $request->phone);

    Http::withHeaders([

        'Authorization' => env('FONNTE_TOKEN')

    ])->post(

        'https://api.fonnte.com/send',

        [

            'target' => $phone,

            'message' =>

"🔐 BERES.IN

Kode OTP Anda:

$otp

Kode berlaku 5 menit.

Jangan berikan kode ini kepada siapa pun."

        ]

    );

    return response()->json([
        'success' => true
    ]);
}

public function verifyPhoneOtp(Request $request)
{
    if(
        $request->otp ==
        session('phone_otp')
    )
    {

        session([
            'phone_verified' => true
        ]);

        return response()->json([
            'success' => true
        ]);

    }

    return response()->json([
        'success' => false
    ]);
}
    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout()
    {

        Auth::logout();

        return redirect('/login');

    }

    public function forgotPassword()
{
    return view(
        'auth.forgot-password'
    );
}
public function sendResetOtp(Request $request)
{
    $request->validate([

        'email' => 'required|email'

    ]);

    $user = User::where(
        'email',
        $request->email
    )->first();

    if(!$user)
    {
        return response()->json([

            'success' => false,

            'message' => 'Email tidak ditemukan'

        ]);
    }

    $otp = rand(100000,999999);

    session([

        'reset_email' => $request->email,

        'reset_otp' => $otp

    ]);

    Mail::raw(

        "Kode OTP reset password Anda: ".$otp,

        function($message) use($request){

            $message
                ->to($request->email)
                ->subject(
                    'OTP Reset Password Beres.in'
                );

        }

    );

    return response()->json([

        'success' => true

    ]);
}
public function verifyResetOtp(Request $request)
{
    if(
        $request->otp ==
        session('reset_otp')
    )
    {
        session([

            'reset_verified' => true

        ]);

        return response()->json([

            'success' => true

        ]);
    }

    return response()->json([

        'success' => false,

        'message' => 'OTP salah'

    ]);
}
public function resetPassword(Request $request)
{
    if(!session('reset_verified'))
    {
        return back()->with(

            'error',

            'OTP belum diverifikasi'

        );
    }

    $request->validate([

        'password' =>
            'required|min:8|confirmed'

    ]);

    User::where(

        'email',
        session('reset_email')

    )->update([

        'password' =>
            Hash::make(
                $request->password
            )

    ]);

    session()->forget([

        'reset_email',

        'reset_otp',

        'reset_verified'

    ]);

    return redirect('/login')
            ->with(
                'success',
                'Password berhasil diubah'
            );
}

}
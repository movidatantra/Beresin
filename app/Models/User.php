<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Service;
use App\Models\Bank;
use App\Models\Ewallet;
use App\Models\Review;
use App\Models\MitraService;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [

        // Akun
        'name',
        'email',
        'phone',
        'password',

        // Data pribadi
        'nik',
        'birth_place',
        'birth_date',

        'kd_prov',
        'kd_kab',
        'kd_kec',

        'address',

        'photo',
        'ktp_photo',

        // Data usaha
        'business_name',
        'business_area',
        'specialization',
        'experience',
        'description',

        'latitude',
        'longitude',

        // Jam operasional
        'open_time',
        'close_time',
        'holiday',

        // Media sosial
        'instagram_url',
        'facebook_url',
        'tiktok_url',

        // Garansi
        'service_warranty',

        // Foto usaha
        'business_photo',
        'portfolio_photos',

        // Rekening
        'bank_name',
        'bank_account',
        'account_holder',

        // Sistem
        
'role',
'status',
'verification_status',

        //OTP
        'email_otp',
'email_verified',

'phone_otp',
'phone_verified',

'is_online',
'withdraw_type',
'bank_id',
'ewallet_id',
'withdraw_number',
'withdraw_name',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [

            'email_verified_at' => 'datetime',

            'password' => 'hashed',

            'birth_date' => 'date',

            'service_warranty' => 'boolean',

            'portfolio_photos' => 'array',
            'email_verified' => 'boolean',
'phone_verified' => 'boolean',

        ];
    }

    // REVIEW

    public function reviews()
    {
        return $this->hasMany(
            Review::class,
            'mitra_id'
        );
    }
    public function services()
{
    return $this->hasMany(Service::class, 'mitra_id');
}

public function carts()
{
    return $this->hasMany(Cart::class);
}
public function bank()
{
    return $this->belongsTo(Bank::class, 'bank_id');
}

public function ewallet()
{
    return $this->belongsTo(Ewallet::class, 'ewallet_id');
}
public function withdrawals()
{
    return $this->hasMany(Withdrawal::class);
}
public function orders()
{
    return $this->hasMany(Order::class);
}
public function review()
{
    return $this->hasMany(Review::class, 'mitra_id');
}
public function mitraServices()
{
    return $this->hasMany(MitraService::class, 'mitra_id');
}
public function notifications()
{
    return $this->hasMany(Notification::class);
}
public function complaints()
{
    return $this->hasMany(
        Complaint::class,
        'user_id'
    );
}
public function balances()
{
    return $this->hasMany(
        MitraBalance::class,
        'mitra_id'
    );
}
public function customerBalance()
{
    return $this->hasOne(CustomerBalance::class);
}

public function balanceTransactions()
{
    return $this->hasMany(CustomerBalanceTransaction::class);
}
}
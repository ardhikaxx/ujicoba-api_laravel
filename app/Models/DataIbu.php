<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class DataIbu extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'orang_tua';
    protected $primaryKey = 'nik_ibu';
    protected $fillable = [
        'nama_ibu',
        'nik_ibu',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'gol_darah_ibu',
        'nik_ayah',
        'nama_ayah',
        'alamat',
        'telepon',
        'email_orang_tua',
        'password_orang_tua',
    ];

    protected $hidden = [
        'password_orang_tua',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
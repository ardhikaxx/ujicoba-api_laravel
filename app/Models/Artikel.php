<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artikel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'judul', 'gambar', 'tanggal_upload', 'deskripsi',
    ];
}
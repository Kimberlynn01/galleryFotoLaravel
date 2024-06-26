<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $table = 'album';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function foto()
    {
        return $this->hasMany(Photo::class, 'albumId', 'id');
    }
}

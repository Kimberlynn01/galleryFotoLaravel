<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $table = 'foto';
    protected $primariKey = 'id';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'statusId', 'id');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'albumId', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Influence extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }
}

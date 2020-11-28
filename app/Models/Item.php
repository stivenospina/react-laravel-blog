<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $casts = [
        'photos' => 'array'
    ];

    // allow and prevent the mass assignment error that gets me every time!
    protected $guarded = [];

    public function Project() {

        return $this->belongsTo('\App\Models\Project');
    }
}

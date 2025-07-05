<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Store extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];


    public function products()
    {
        return $this->hasMany(Product::class);
    }

}

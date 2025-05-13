<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    use HasFactory;

    protected $primaryKey = 'user_id';              // we added this code caz there is no id on this table there is only user_id which is the primary key and also foreign key

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'birthday',
        'gender',
        'street_address',
        'city',
        'state',
        'postal_code',
        'country',
        'locale',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}

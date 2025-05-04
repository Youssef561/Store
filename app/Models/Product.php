<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use HasFactory, softDeletes;

    protected $guarded = [];


    protected static function booted()
    {
        static::addGlobalScope(new StoreScope());
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,     // Related Model
            'product_tag',      // Pivot Table name
            'product_id',       // FK in pivot table for the current model
            'tag_id',       // FK in pivot table for the related model
            'id',           // PK current model
            'id',           // PK related model
        );
    }


    public function scopeFilter(Builder $builder , $filters){

        $builder->when($filters['name'] ?? false, function ($builder, $value) {
            $builder->where('name' , 'LIKE' , '%' . $value . '%');
        });

        $builder->when($filters['status'] ?? false, function ($builder, $value) {
            $builder->where('status' , '=' , $value);
        });

        // use where statement instead of if statement for performance

//        if($filters['name'] ?? false){
//            $builder->where('name','like','%'.$filters['name'].'%');
//        }
//
//        if ($filters['status'] ?? false) {
//            $builder->where('status','=',$filters['status']);
//        }

    }

}

<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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

    public static function rules($id = 0){

        return [
            //'name' => 'required|min:4|unique:products,name,' . $id,           // That tells Laravel to ignore the current record's name during the uniqueness check.
            'name' =>  ['required', 'min:3', 'max:255',
                Rule::unique('products', 'name')->ignore($id),
                new Filter(),
            ],

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string|max:255|min:3',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,draft,archived',
            'tags' => 'nullable',
        ];

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

    public function scopeActive(Builder $builder){
        $builder->where('status','=','active');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if(!$this->image) {
            return 'https://www.incathlab.com/images/products/default_product.png';
        }

        if (Str::startsWith($this->image, ['http://','https://'])) {
            return $this->image;
        }

        return asset('storage/' . $this->image);        // if we are not use laravel storage, then we have to remove 'storage'
    }

    public function getSalePercentAttribute()
    {
        if (!$this->compare_price || $this->compare_price == 0) {
            return 0;
        }

        $discount = $this->compare_price - $this->price;
        return round(($discount / $this->compare_price) * 100,1);
    }


}

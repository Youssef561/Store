<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{

    use HasFactory, softDeletes;

    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'slug',
        'image',
        'status',
    ];


    public function scopeActive(Builder $builder){
        $builder->where('status','=','active');
    }


    public function scopeFilter(Builder $builder , $filters){

        $builder->when($filters['name'] ?? false, function ($builder, $value) {
            $builder->where('name' , 'LIKE' , '%' . $value . '%');
        });

        $builder->when($filters['status'] ?? false, function ($builder, $value) {
            $builder->where('status' , '=' , $value);
        });


//        if($filters['name'] ?? false){
//            $builder->where('name','like','%'.$filters['name'].'%');
//        }
//
//        if ($filters['status'] ?? false) {
//            $builder->where('status','=',$filters['status']);
//        }

    }



    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')
            ->withDefault([
                'name' => 'Primary Category',                // we use withDefault with belongsTo only caz if there is no parent it gives me new empty object and i can pass value for any input
            ]);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }


    public static function rules($id = 0){

        return [
            //'name' => 'required|min:4|unique:categories,name,' . $id,           // That tells Laravel to ignore the current record's name during the uniqueness check.
            'name' =>  ['required', 'min:3', 'max:255',
                Rule::unique('categories', 'name')->ignore($id),
                new Filter(),
                ],

            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string|max:255|min:3',
            'status' => 'required|in:active,archived',
        ];

    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id','id');
    }


}

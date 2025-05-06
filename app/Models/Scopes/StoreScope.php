<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class StoreScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Global scope
        $user = Auth::user();
        if ($user && $user->store_id) {           // if a user has store id apply this query if no, so he is admin and can view all products
            $builder->where('store_id', '=', $user->store_id);
        }
    }
}

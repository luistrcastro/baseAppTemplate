<?php

namespace App\Scopes;

use \Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AuthUserScope implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::hasUser())
        {
            $builder->where($model->getTable() . '.user_id', Auth::user()->getKey());
        }
    }
}

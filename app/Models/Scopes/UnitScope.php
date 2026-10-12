<?php

namespace App\Models\Scopes;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class UnitScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Don't apply in console/seeders unless session explicitly has it
        if (app()->runningInConsole() && ! session()->has('active_unit_id') && ! session()->has('active_jenjang_id')) {
            return;
        }

        $user = Auth::user();

        // If user is admin with dedicated gender restriction
        if ($user && $user->role === 'admin') {
            if ($user->admin_level === 'putra') {
                $builder->whereHas('unit', function ($query) {
                    $query->where('gender', 'putra');
                });
                return;
            }

            if ($user->admin_level === 'putri') {
                $builder->whereHas('unit', function ($query) {
                    $query->where('gender', 'putri');
                });
                return;
            }
        }

        // Session-based switcher for Admin Global
        if (session()->has('active_unit_id') && session('active_unit_id')) {
            $builder->where($model->getTable() . '.unit_id', session('active_unit_id'));
        } elseif (session()->has('active_jenjang_id') && session('active_jenjang_id')) {
            $builder->whereHas('unit', function ($query) {
                $query->where('jenjang_id', session('active_jenjang_id'));
            });
        }
    }
}

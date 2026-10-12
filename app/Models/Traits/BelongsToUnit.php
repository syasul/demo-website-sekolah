<?php

namespace App\Models\Traits;

use App\Models\Scopes\UnitScope;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToUnit
{
    /**
     * Boot the BelongsToUnit trait for a model.
     */
    public static function bootBelongsToUnit(): void
    {
        static::addGlobalScope(new UnitScope);

        // Auto-assign unit_id on create if active_unit_id exists in session and not explicitly provided
        static::creating(function ($model) {
            if (empty($model->unit_id) && session()->has('active_unit_id') && session('active_unit_id')) {
                $model->unit_id = session('active_unit_id');
            }
        });
    }

    /**
     * Get the unit associated with the model.
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    /**
     * Scope query without the unit scope.
     */
    public function scopeWithoutUnitScope($query)
    {
        return $query->withoutGlobalScope(UnitScope::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $primaryKey = 'record_id';

    protected $fillable = [
        'supplier_id',
        'lorry_amount',
        'lorry_units',
        'tractor_amount',
        'tractor_units',
        'expected_profit_lorry',
        'expected_profit_tractor',
        'total_expected_profit',
        'confirmed_cubic_meters',
        'extra_cubic',
        'less_cubic',
        'deleted'
    ];

    protected $casts = [
        'lorry_amount' => 'decimal:2',
        'lorry_units' => 'decimal:2',
        'tractor_amount' => 'decimal:2',
        'tractor_units' => 'decimal:2',
        'expected_profit_lorry' => 'decimal:2',
        'expected_profit_tractor' => 'decimal:2',
        'total_expected_profit' => 'decimal:2',
        'confirmed_cubic_meters' => 'decimal:2',
        'extra_cubic' => 'decimal:2',
        'less_cubic' => 'decimal:2',
        'deleted' => 'integer',
    ];

    // Pricing constants
    const LORRY_BUYING_PRICE = 2000;
    const LORRY_SELLING_PRICE = 2200;
    const TRACTOR_BUYING_PRICE = 2200;
    const TRACTOR_SELLING_PRICE = 2400;

    /**
     * Scope to get only active (non-deleted) records
     */
    public function scopeActive($query)
    {
        return $query->where('deleted', 0);
    }

    /**
     * Relationship with Supplier
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }

    /**
     * Calculate expected profit for lorry based on units
     */
    public function calculateLorryProfit()
    {
        return ($this->lorry_units * (self::LORRY_SELLING_PRICE - self::LORRY_BUYING_PRICE));
    }

    /**
     * Calculate expected profit for tractor based on units
     */
    public function calculateTractorProfit()
    {
        return ($this->tractor_units * (self::TRACTOR_SELLING_PRICE - self::TRACTOR_BUYING_PRICE));
    }

    /**
     * Calculate total expected profit
     */
    public function calculateTotalProfit()
    {
        return $this->calculateLorryProfit() + $this->calculateTractorProfit();
    }

    /**
     * Soft delete the record by setting deleted = 1
     */
    public function softDelete()
    {
        $this->update(['deleted' => 1]);
    }

    /**
     * Restore the record by setting deleted = 0
     */
    public function restore()
    {
        $this->update(['deleted' => 0]);
    }
}

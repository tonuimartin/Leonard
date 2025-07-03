<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTransportationProfit extends Model
{
    use HasFactory;

    protected $primaryKey = 'record_id';

    protected $fillable = [
        'supplier_id',
        'transport_date',
        'lorry_logs_amount',
        'lorry_logs_units',
        'expected_profit_lorry',
        'tractor_logs_amount',
        'tractor_logs_units',
        'expected_profit_tractor'
    ];

    protected $casts = [
        'transport_date' => 'date',
        'lorry_logs_amount' => 'decimal:2',
        'expected_profit_lorry' => 'decimal:2',
        'tractor_logs_amount' => 'decimal:2',
        'expected_profit_tractor' => 'decimal:2',
        'total_expected_profit' => 'decimal:2'
    ];    // Relationships
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }

    // Accessors
    public function getSupplierNameAttribute()
    {
        return $this->supplier->name ?? null;
    }

    // Scopes
    public function scopeByDate($query, $date)
    {
        return $query->where('transport_date', $date);
    }

    public function scopeBySupplier($query, $supplierId)
    {
        return $query->where('supplier_id', $supplierId);
    }

    public function scopeWithSupplier($query)
    {
        return $query->with('supplier');
    }

    // Helper methods
    public function getTotalLogsTransported()
    {
        return $this->lorry_logs_units + $this->tractor_logs_units;
    }

    public function getTotalTransportationCost()
    {
        return $this->lorry_logs_amount + $this->tractor_logs_amount;
    }
}

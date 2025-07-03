<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $primaryKey = 'supplier_id';
    protected $fillable = ['supplier_name', 'phone_number', 'role_id', 'deleted'];

    protected $casts = [
        'deleted' => 'integer',
    ];

    /**
     * Scope to get only active (non-deleted) suppliers
     */
    public function scopeActive($query)
    {
        return $query->where('deleted', 0);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    /**
     * Soft delete the supplier by setting deleted = 1
     */
    public function softDelete()
    {
        $this->update(['deleted' => 1]);
    }

    /**
     * Restore the supplier by setting deleted = 0
     */
    public function restore()
    {
        $this->update(['deleted' => 0]);
    }
}


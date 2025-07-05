<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone_number',
        'deleted',
        'admin_approved',
        'admin_approval_token',
        'admin_approved_at',
        'approved_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'deleted' => 'integer',
            'admin_approved' => 'boolean',
            'admin_approved_at' => 'datetime',
        ];
    }

    /**
     * Scope to get only active (non-deleted) users
     */
    public function scopeActive($query)
    {
        return $query->where('deleted', 0);
    }

    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    /**
     * Soft delete the user by setting deleted = 1
     */
    public function softDelete()
    {
        $this->update(['deleted' => 1]);
    }

    /**
     * Restore the user by setting deleted = 0
     */
    public function restore()
    {
        $this->update(['deleted' => 0]);
    }

    /**
     * Check if the user is an admin (role_id = 1)
     */
    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    /**
     * Check if the user can access admin features
     */
    public function canAccessAdmin()
    {
        return $this->isAdmin();
    }

    /**
     * Check if the user is fully verified (email verified AND admin approved)
     */
    public function isFullyVerified()
    {
        return $this->hasVerifiedEmail() && $this->admin_approved;
    }

    /**
     * Generate admin approval token
     */
    public function generateAdminApprovalToken()
    {
        $this->admin_approval_token = Str::random(64);
        $this->save();
        return $this->admin_approval_token;
    }

    /**
     * Approve user by admin
     */
    public function approveByAdmin($adminId)
    {
        $this->admin_approved = true;
        $this->admin_approved_at = now();
        $this->approved_by = $adminId;
        $this->admin_approval_token = null; // Clear the token
        $this->save();
    }

    /**
     * Get the admin who approved this user
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope to get users pending admin approval (email verified but not admin approved)
     */
    public function scopePendingApproval($query)
    {
        return $query->whereNotNull('email_verified_at')
            ->where('admin_approved', false)
            ->where('deleted', 0);
    }

    /**
     * Scope to get fully verified users (email verified AND admin approved)
     */
    public function scopeFullyVerified($query)
    {
        return $query->whereNotNull('email_verified_at')
            ->where('admin_approved', true)
            ->where('deleted', 0);
    }
}

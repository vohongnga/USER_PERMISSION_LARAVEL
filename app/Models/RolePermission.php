<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    /**
     * Define table
     *
     * @var string
     */
    protected $table = 'roles_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id','permission_id'];

    /**
     * Get roles in permission
     *
     * @return array
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}

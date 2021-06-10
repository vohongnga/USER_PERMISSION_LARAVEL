<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * Define table
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','slug'];

    /**
     * Get roles in permission
     *
     * @return array
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }

    /**
     * Get roles_permissions in role
     *
     * @return mixed
     */
    public function roles_permissions()
    {
        return $this->hasMany(Role_Permission::class);
    }
}

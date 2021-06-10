<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','slug'];

    /**
     * Get users in role
     *
     * @return array
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get permissions in role
     *
     * @return array
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }

    /**
     * Get roles_permissions in role
     *
     * @return array
     */
    public function roles_permissions()
    {
        return $this->hasMany(Role_Permission::class);
    }
}

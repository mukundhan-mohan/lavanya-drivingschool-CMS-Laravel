<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sluggable():array
    {
        return [
            'slug' => [
                'source' => ['first_name']
            ]
        ];
    }

    public function menuPrivileges() {
        return $this->hasMany(UserMenuPrivilege::class);
    }

    public function getUserMenuPrivilegesAttribute()
    {
        return $this->menuPrivileges->pluck('menu_slug')->toArray();
    }

    // public function getRoleNameAttribute(){
    //     return $this->roles->last()->name;
    // }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getRoleAttribute() {
        if($this->roles) {
            return ucfirst($this->roles->first()->role);
        }
        return "";
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function getIsAdminAttribute() {
        if($this->roles) {
            $roleIds = $this->roles->pluck('id')->toArray();
            if(in_array(1, $roleIds)) {
                    return true;
            }
        }
        return false;
    }
}

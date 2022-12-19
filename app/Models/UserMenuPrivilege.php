<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserMenuPrivilege extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'left_menu_id', 'creator_id', 'updated_by', 'menu_slug'
    ];


    	public function roles() {
	        return $this->hasMany(User::class);
	}

    	/**
	 * @param array $attributes
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
	}

}

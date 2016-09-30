<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    /**
	 * name table
	 * @var string
	 */
    protected $table = 'role_user';

    /**
     * define create_at update_at
     * @var boolean
     */
    public $timestamps = true;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'create_at', 'update_at',
    ];
  
    //public function role()
    //{
    //    return $this->belongsToMany ('App\Models\Role');
    //}
/*

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
*/
}

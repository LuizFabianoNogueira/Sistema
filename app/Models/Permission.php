<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
	 * nome da tabela
	 * @var string
	 */
    protected $table = 'permissions';

    /**
     * Os atributos que são atribuíveis
     *
     * @var array
     */
    protected $fillable = [
        'id', 'action_id', 'role_id', 'user_id', 'permission'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'create_at', 'update_at'
    ];

    /**
     * define create_at update_at
     * @var boolean
     */
    public $timestamps = true;

    public function action()
    {
        return $this->belongsTo('App\Models\Action');
    }
}

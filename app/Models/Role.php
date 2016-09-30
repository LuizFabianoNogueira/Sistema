<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
	 * nome da tabela
	 * @var string
	 */
    protected $table = 'roles';

    /**
     * Os atributos que são atribuíveis
     *
     * @var array
     */
    protected $fillable = [
        'name', 'active'
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

    /**
     * definne relacionamento com usuarios
     * @return [type] [description]
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}

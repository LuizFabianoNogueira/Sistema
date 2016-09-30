<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * name table
     * @var string
     */
    protected $table = 'menus';

    /**
     * define create_at update_at
     * @var boolean
     */
    public $timestamps = true;

    /**
     * Os atributos que são atribuíveis
     *
     * @var array
     */
    protected $fillable = [
        'id', 'parent_id', 'order', 'name', 'route', 'active', 'grupo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'create_at', 'update_at'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * name table
     * @var string
     */
    protected $table = 'accounts';

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
        'id',
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

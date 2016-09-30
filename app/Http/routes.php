<?php

//dd(App::make('InfinityServices'));

/********************
* Rotas fora do acl *
********************/

/********************
 * login | logOut   *
 *******************/
Route::get(
	'/login',
	[
        'middleware' => ['filter'],
        'filter' => ['before' => ['translator']],
		'as' => 'auth.loginGet',
		'uses' => 'Auth\AuthController@showLoginForm'
	]
);

Route::post(
	'/login',
	[
        'middleware' => ['filter'],
        'filter' => ['before' => ['translator']],
		'as' => 'auth.loginPost',
		'uses' => 'Auth\AuthController@login'
	]
);

Route::get(
	'/logout',
	[
        'middleware' => ['filter'],
        'filter' => ['before' => ['translator']],
		'as' => 'auth.logoutGet',
		'uses' => 'Auth\AuthController@logout'
	]
);

/********************
 * password | reset *
 *******************/
Route::group(
	[
		'as' => 'password.',
		'prefix' => 'password'
	],
	function ()
	{
	  	Route::post(
	  		'email',
	  		[
                'middleware' => ['filter'],
                'filter' => ['before' => ['translator']],
	  			'as' => 'email',
	  			'uses' => 'Auth\PasswordController@sendResetLinkEmail'
  			]
		);

	  	Route::post(
  			'reset',
  			[
                'middleware' => ['filter'],
                'filter' => ['before' => ['translator']],
  				'as' => 'reset',
  				'uses' => 'Auth\PasswordController@reset'
			]
		);

	  	Route::get(
	  		'reset/{token?}',
	  		[
                'middleware' => ['filter'],
                'filter' => ['before' => ['translator']],
	  			'as' => 'reset_token',
	  			'uses' => 'Auth\PasswordController@showResetForm'
  			]
		);
	}
);

/********************
 * home             *
 *******************/
Route::get(
	'/',
	[
		'as' => 'site',
		function ()
		{
    		return redirect()->route('home');
		}
	]
);

Route::get(
	'/home',
	[
        'middleware' => ['filter'],
        'filter' => ['before' => ['translator']],
		'as' => 'home',
		'uses' => 'HomeController@index'
	]
);

/*********************
* Police             *
* *******************/
Route::get(
	'/police',
	[
		'as' => 'police',
		'uses' => 'AclController@police'
	]
);

Route::get(
    '/locale/{locale}',
    [
        'as' => 'locale',
        'uses' => 'LocaleController@setLocale'
    ]
);

/*********************
 * Menus            *
 ********************/
Route::group(
    [
        'as' => 'menus.',
        'prefix' => 'menus'
    ],
    function ()
    {
        Route::get(
            '/',
            function ()
            {
                return redirect()->route('menus.listGruposGet');
            }
        );

        Route::get(
            '/list/grupos',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'listGruposGet',
                'uses' => 'MenuController@listGruposGet'
            ]
        );

        Route::get(
            '/list/grupo/{grupo}',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'listMenuGrupoGet',
                'uses' => 'MenuController@listMenuGrupoGet'
            ]
        );

        Route::get(
            '/new',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'newGet',
                'uses' => 'MenuController@newGet'
            ]
        );

        Route::post(
            '/new',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'newPost',
                'uses' => 'MenuController@newPost'
            ]
        );

        Route::post(
            '/edit',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'editPost',
                'uses' => 'MenuController@editPost'
            ]
        );

        Route::post(
            '/update',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl']],
                'as' => 'updatePost',
                'uses' => 'MenuController@updatePost'
            ]
        );
    }
);

/*********************
 * Usuários          *
 ********************/
Route::group(
    [
        'as' => 'users.',
        'prefix' => 'users'
    ],
    function ()
    {
        Route::get(
            '/',
            function ()
            {
                return redirect()->route('users.listGet');
            }
        );

        Route::get(
            '/list',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'listGet',
                'uses' => 'UserController@listGet'
            ]
        );

        Route::get(
            '/new',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'newGet',
                'uses' => 'Auth\AuthController@showRegistrationForm'
            ]
        );

        Route::post(
            '/new',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'newPost',
                'uses' => 'Auth\AuthController@register'
            ]
        );

        Route::get(
            '/edit/{id}',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'editGet',
                'uses' => 'UserController@editGet'
            ]
        );

        Route::post(
            '/edit',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'editPost',
                'uses' => 'UserController@editPost'
            ]
        );
    }
);

/*********************
 * Roles | Grupos    *
 ********************/
Route::group(
    [
        'as' => 'roles.',
        'prefix' => 'roles'
    ],
    function ()
    {
        Route::get(
            '/',
            function ()
            {
                return redirect()->route('roles.listGet');
            }
        );

        Route::get(
            '/list',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'listGet',
                'uses' => 'RoleController@listGet'
            ]
        );

        Route::get(
            '/new',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'newGet',
                'uses' => 'RoleController@newGet'
            ]
        );

        Route::post(
            '/new',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'newPost',
                'uses' => 'RoleController@newPost'
            ]
        );

        Route::get(
            '/edit/{id}',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'editGet',
                'uses' => 'RoleController@editGet'
            ]
        );
    }
);


/*********************
 * Contas            *
 ********************/
Route::group(
    [
        'as' => 'accounts.',
        'prefix' => 'accounts'
    ],
    function ()
    {
        Route::get(
            '/',
            function ()
            {
                return redirect()->route('accounts.listGet');
            }
        );

        Route::get(
            '/list',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'listGet',
                'uses' => 'AccountController@listGet'
            ]
        );

        Route::get(
            '/create',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'create',
                'uses' => 'AccountController@create'
            ]
        );

        Route::get(
            '/lancamentoTeste',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'teste',
                'uses' => 'AccountController@teste'
            ]
        );
    }
);

































/********************
* ACL 				*
********************/
Route::group(
	[
		'as' => 'acl.',
		'prefix' => 'acl'
	],
	function ()
	{
   		Route::get(
   			'permissions/role/{id}',
   			[
   				'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
   				'as' => 'roleGet',
   				'uses' => 'AclController@roleGet'
			]
		);

        Route::post(
            'permissions/role',
            [
                'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
                'as' => 'rolePost',
                'uses' => 'AclController@rolePost'
            ]
        );

		Route::get(
   			'permissions/user/{id}',
   			[
   				'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
   				'as' => 'userGet',
   				'uses' => 'AclController@userGet'
			]
		);

		Route::post(
			'permissions/user',
			[
				'middleware' => ['filter'],
                'filter' => ['before' => ['acl', 'translator']],
				'as' => 'userPost',
				'uses' => 'AclController@userPost'
			]
		);
		
		Route::get(
			'refresh',
			[
				'as' => 'refresh',
				function()
				{
                    $ignore = Config::get('constants.ROUTE_IGNORE');

					$RouteCollection = Route::getRoutes();
					$AclList = array();
					foreach ($RouteCollection as $route)
					{
						$localController = $route->getActionName();
						$localController_arr = explode("\\", trim($localController));
						$Controler_Action = $localController_arr[count($localController_arr)-1];
						$Controle_Action_arr = explode("@", $Controler_Action);
						if(is_array($Controle_Action_arr))
						{
							if(isset($Controle_Action_arr[0]))
							{
								$controller = str_replace("Controller", "", $Controle_Action_arr[0]);
							}
							if(isset($Controle_Action_arr[1]))
							{
								$Action = $Controle_Action_arr[1];
							}
							$rota['ControllerAction'] = $Action;
							$rota['Name'] = $route->getName();
							if(!in_array($rota['Name'], $ignore))
							{
								$AclList[$controller][] = $rota;
							}
						}
					}

					foreach ($AclList as $ControllerName => $ActionPropriet) 
					{
						if(is_array($ActionPropriet) && count($ActionPropriet)>0)
						{
							foreach ($ActionPropriet as $key_action => $Action) 
							{
								$DbAction = App\Models\Action::where(
									[
										'action' => trim($Action['ControllerAction']),
										'controller' => $ControllerName
									]
								)->first();
								if($DbAction)
								{
									if(!empty(trim($Action['Name'])))
									{
										$DbAction->name = $Action['Name'];
									}
									$DbAction->active = 1;
									$DbAction->save();
								}
								else
								{
									$DbAction = new App\Models\Action;
									if(!empty(trim($Action['Name'])))
									{
										$DbAction->name = $Action['Name'];
									}
									$DbAction->action = $Action['ControllerAction'];
									$DbAction->controller= $ControllerName;
									$DbAction->save();
								}
							}
						}
					}
					return redirect()->route('home');
				}
			]
		);
	}
);

/*
Route::group(['domain' => '{account}.myapp.com'], function () {
    Route::get('user/{id}', function ($account, $id) {
        //
    });
});
*/



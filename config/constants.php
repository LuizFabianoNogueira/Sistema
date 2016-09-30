<?php

return
[
	/**
	 * Ignora os alias na hora de fazer refresh das rotas
	 */
    'ROUTE_IGNORE' =>
	[
		'auth.loginForm',
		'auth.login',
		'auth.logout',
		'auth.password.emailForm',
		'auth.password.resetTokem',
		'acl.aclPolice',
	],
];

?>
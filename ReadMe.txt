Laravel Sanctrum
	- Sanctum it is a simple package to issue API tokens to your users without the complication of OAuth. Sanctum uses Laravel's built-in cookie based session authentication services.
	- to authenticate the api and spa should share the same top domain.
Laravel passport
	-  
	- done login, register and logout

laravel errors:
	issue:
		code:
			>>> factory(\App\User::class)->create();
		error:
			PHP Fatal error:  Call to undefined function factory() in Psy Shell code on line 1
		issue:
			In Laravel 8 the factory helper function no longer exists. There is a legacy package to pull in if you have old factories to use.
		solution: 
			-	However, new factories are called of the model, as such:
				User::factory()->create();
---------------------------------------------------------------------------------------------------
	issue:
		test the authentication of user in postman
		error:
			Laravel and Passport getting SQLSTATE[42S22]: Column not found: 1054 Unknown column 'api_token'
		solution:
			- its all about the configuration. go to config/auth.php  and change driver name of api array to passport within the guards array

			CODE:
				'guards' => [
				    'web' => [
				        'driver' => 'session',
				        'provider' => 'users',
				    ],

				    'api' => [
				        'driver' => 'passport',//instead of token 
				        'provider' => 'users',
				        'hash' => false,
				    ],
				],

			- or just run this command to clear the cache of config file
			COMMAND:
				php artisan config:cache
				php artisan cache:clear
<?php

// Documentation

Route::get('docs', 'omnivox::docs@index');
Route::get(array('docs/api/(:any)', 'docs/api/(:any)/(:any)'), 'omnivox::docs@api');

// API calls

Route::post('(:bundle)/auth.(json|xml)', 'omnivox::auth@index');
Route::get('(:bundle)/auth.(json|xml)/(:any)/(:any)', 'omnivox::auth@index');

Route::group(array('before' => 'auth', 'after' => 'sweep'), function()
{
	// API calls needing authorization

	//Log::auth(Session::get('auth'));
	//Log::studentID(Session::get('id'));

	Route::get('(:bundle)/logout.(json|xml)', 'omnivox::auth@logout');

	Route::get('(:bundle)/alerts.(json|xml)', 'omnivox::alerts@index');
	Route::get('(:bundle)/news.(json|xml)', 'omnivox::news@index');
	Route::get('(:bundle)/schedule.(json|xml)', 'omnivox::schedule@index');

	// Lea
	Route::get('(:bundle)/lea/grades.(json|xml)', 'omnivox::lea.grades@index');

	// Mio
	Route::group(array('before' => 'auth-mio'), function ()
	{
		Route::get('(:bundle)/mio/inbox.(json|xml)', 'omnivox::mio@inbox');
		Route::get('(:bundle)/mio/sent.(json|xml)', 'omnivox::mio@sent');
		Route::get('(:bundle)/mio/trash.(json|xml)', 'omnivox::mio@trash');
		Route::get('(:bundle)/mio/totalPages.(json|xml)', 'omnivox::mio@totalPages');
		Route::get('(:bundle)/mio/message.(json|xml)', 'omnivox::mio@message');

		Route::get('(:bundle)/mio/send.(json|xml)', 'omnivox::mio@send');
	});

	Route::get('(:bundle)/registration/seats.(json|xml)', 'omnivox::registration@seats');
});

Route::filter('auth', function()
{
	if (!Session::get('auth', false)) {
		// User not auth'd, return error

		$c = Bundle::path('omnivox').'cookies/'.Session::instance()->session['id'];
		if (file_exists($c)) {
			unlink($c);
		}

		$result = array(
			'message' => 'Unauthorized.',
		);

		return Omnivox\Libraries\Output::outputWithFormat($result, Request::route()->parameters[0], 401);
	}
});

Route::filter('auth-mio', function()
{
	if (Session::get('auth-mio') !== true) {
		Log::info("Authenticating user to MIO...");
		Omnivox\Models\MIO::authenticate();
	}
});

Route::filter('sweep', function()
{
	$sweepage = Config::get('session.sweepage');
	if (mt_rand(1, $sweepage[1]) <= $sweepage[0]) {
		// Get list of cookies
		$cookies = array_diff(scandir(Bundle::path('omnivox').'cookies/'), array('.', '..'));

		// Get array of valid sessions that have cookie files
		$query = DB::table('sessions')/*->where_in('id', $cookies)*/->get('id');

		// Create an array of (string) id's from rows returned
		$sessions = array();
		foreach ($query as $c) {
			$sessions[] = $c->id;
		}

		// Get cookies that are not in the database
		$diff = array_diff($cookies, $sessions);

		// Remove dead cookies from system
		foreach ($diff as $c) {
			unlink(Bundle::path('omnivox').'cookies/'.$c);
		}
		unset($c);
	}
	unset($sweepage);
});

// View helpers

View::composer('omnivox::partials.header', function()
{
	Asset::container('header')->bundle('omnivox');

	header('X-UA-Compatible: IE=edge,chrome=1');

	Asset::container('header')->add('bootstrap-css', 'css/bootstrap.min.css');
	Asset::container('header')->add('prettify-css', 'js/google-code-prettify/prettify.css');
	Asset::container('header')->add('main', 'css/main.css');
	Asset::container('header')->add('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
	Asset::container('header')->add('prettify-js', 'js/google-code-prettify/prettify.js');
});
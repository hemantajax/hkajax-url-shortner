<?php
Route::get('/', function()
{
	return View::make('home.index');
});

Route::post('/', function()
{
	$url = Input::get("url");

	//validate url

	$validation = Url::validate(array(
			'url' => $url
		));


	if($validation->fails()){
		return Redirect::to("/")->with_errors($validation->errors);
	}

	// already in db reyturn it
	$record = Url::where_url($url)->first();
	if($record){
		return View::make("home.result", array("shortenurl" => $record->shortenurl));
	}
	// otherwise add new in db , shorten and return it
	function get_unique_shorten_url(){
		$shortened = base_convert(rand(10000, 99999), 10, 36);

		if(Url::where_url($shortened)->first()){
			return get_unique_shorten_url();
		}

		return $shortened;
	}

	$shortenurl = get_unique_shorten_url();

	$row = Url::create(array(
		'url' => $url,
		'shortenurl' => $shortenurl
	));

	if($row){
		return View::make("home.result", array("shortenurl" => $row->shortenurl));
	}

	// present to user
});

Route::get('(:any)', function($row)
{
	$r = Url::where_shortenurl($row)->first();

	if(is_null($r)){
		return Redirect::to("/");
	}

	return Redirect::to($r->url);
});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});
@layout('omnivox::docs.api.master')

@section('name')
POST auth
@endsection

@section('method')
POST
@endsection

@section('auth')
Yes
@endsection

@section('formats')
json<br />xml
@endsection

@section('description')
<p>This is the initial call you will have to make before any request. It is used to refresh your session on the Omnivox server, which expires after an hour of inactivity.</p>
<p>Upon success, it will return true and your session cookie will now be ready to use in other requests. If an error occurs, an error message is sent.</p>
@endsection

<?php

$params = array();

$params[] = array(
	'name' => 'id',
	'required' => true,
	'description' => "The user's 7-digit student ID number.",
	'example' => "1234567"
);

$params[] = array(
	'name' => 'password',
	'required' => true,
	'description' => "The user's password used on the Omnivox portal.",
	'example' => "abc1234"
);

?>

@section('url')
api/auth.json
@endsection
		
@section('output')
{
    "success":true
}
@endsection
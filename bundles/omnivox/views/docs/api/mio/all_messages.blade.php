@layout('omnivox::docs.api.master')

@section('name')
GET mio/all_messages
@endsection

@section('method')
GET
@endsection

@section('auth')
Yes
@endsection

@section('formats')
json<br />xml
@endsection

@section('description')
<p>This will return an array of all MIO messages in the inbox, regardless if they have been categorized or not.</p>
@endsection

<?php

$params = array();

?>

@section('url')
api/mio/all_messages.json
@endsection
		
@section('output')
{
    "success":true,
    "result":[
        {
            "sender":"Claudiu Robert Scotnotis",
            "date":"16:38",
            "subject":"Reminder: Lockers reservation & Wednesday is a...",
            "body":"Hello Class, 1. I was told to inform you a that if you have not requested any locker and plans to d"
        },
        {
            "sender":"Shery Halim Yakoub Mikhail",
            "date":"2012-08-29",
            "subject":"solution manuel",
            "body":"Dear NYA class, The uploading of the solutions to the various sections of the new Stewart NYA text "
        }
    ]
}
@endsection
@layout('omnivox::docs.api.master')

@section('name')
GET schedule
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
<p>This will return all classes in a specified semester, directly from the schedule.</p>
@endsection

<?php

$params = array();

$params[] = array(
	'name' => 'semester',
	'required' => true,
	'description' => "The semester ID for the schedule to scrape. This is a 5 digit number, composed of the full year and a semester identifier, one of the below:</p><p>
							Winter: 1<br />
							Summer: 2<br />
							Fall: 3",
	'example' => "20123"
);

?>

@section('url')
api/schedule.json
@endsection
		
@section('output')
{
    "success":true,
    "result":[
        {
            "name":"Algorithm Design",
            "number":"420-306-AB",
            "section":"1",
            "room":"P-107",
            "teacher":"Daniel Gryte",
            "day":2,
            "startTime":8.5,
            "endTime":10
        },
        {
            "name":"Business Systems",
            "number":"401-803-AB",
            "section":"1",
            "room":"P-327",
            "teacher":"Matthew Hill",
            "day":5,
            "startTime":8.5,
            "endTime":11.5
        },
        {
            "name":"Calculus I",
            "number":"201-NYA-05",
            "section":"19",
            "room":"H-430",
            "teacher":"Shery Halim Yakoub Mikhail",
            "day":1,
            "startTime":10,
            "endTime":11.5
        },
        {
            "name":"Algorithm Design",
            "number":"420-306-AB",
            "section":"1",
            "room":"P-327",
            "teacher":"Daniel Gryte",
            "day":2,
            "startTime":10,
            "endTime":11.5
        },
        {
            "name":"Calculus I",
            "number":"201-NYA-05",
            "section":"19",
            "room":"P-208",
            "teacher":"Shery Halim Yakoub Mikhail",
            "day":5,
            "startTime":12.5,
            "endTime":14.5
        }
    ]
}

{
    "success": true,
    "result": [
        "20121",
        "20122",
        "20123"
    ]
}
@endsection
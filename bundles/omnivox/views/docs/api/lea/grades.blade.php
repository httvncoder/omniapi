@layout('omnivox::docs.api.master')

@section('name')
GET lea/grades
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
<p>This will return an array current grades. <code>null</code> will be returned for any grade if it does not yet exist.</p>
@endsection

<?php

$params = array();

?>

@section('url')
api/lea/grades.json
@endsection
		
@section('output')
{
    "success":true,
    "result":[
        {
            "name":"BADMINTON",
            "number":"109-102-MQ",
            "section":30,
            "grade":85,
            "average":null,
            "absenceHours":0
        },
        {
            "name":"Calculus I",
            "number":"201-NYA-05",
            "section":19,
            "grade":97,
            "average":null,
            "absenceHours":2
        },
        {
            "name":"Business Systems",
            "number":"401-803-AB",
            "section":1,
            "grade":99,
            "average":26,
            "absenceHours":0
        }
    ]
}
@endsection
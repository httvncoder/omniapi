@layout('omnivox::docs.api.master')

@section('name')
GET schedule_semesters
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
<p>This will return all possible semesters listed in the schedule selection list. Note that these semesters do not necessarily have a valid schedule available.</p>
<p>Other schedules may be available as well, as Omnivox generally stores old schedules.</p>
@endsection

<?php

$params = array();

?>

@section('url')
api/schedule_semesters.json
@endsection
		
@section('output')
{
    "success": true,
    "result": [
        "20121",
        "20122",
        "20123"
    ]
}
@endsection
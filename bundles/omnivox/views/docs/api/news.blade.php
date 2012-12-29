@layout('omnivox::docs.api.master')

@section('name')
GET news
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
<p>This will return an array of news posts from the front page.</p>
@endsection

<?php

$params = array();

?>

@section('url')
api/news.json
@endsection
		
@section('output')
{
    "success":true,
    "result":[
        {
            "name":"Please Slow Down on Campus",
            "date":"published on\u00a0\u00a0August 30, 2012",
            "source":"Source:\u00a0\u00a0Emergency Notification\u00a0",
            "description":"Pedestrians + Vehicular Traffic + Construction + Deliveries = Potential Problems.\u00a0 Please respect the speed limit (30km) on campus roads.",
            "url":"\/intr\/webpart.gestion?IdWebPart=00000000-0000-0000-0003-000000000007&mode=one&idNews=7099&idProv=2&modeProvenance=lst"
        },
        {
            "name":"OPUS CARD PHOTO SESSION: FINAL DAY - FRIDAY IN AGORA",
            "date":"published on\u00a0\u00a0August 30, 2012 at 17:00",
            "source":"Source:\u00a0\u00a0Student Activities Contests & Events\u00a0",
            "description":"All full-time students UNDER 26 years of age on October 31 are eligible to use public transportation at the reduced rate. The STM and CIT La Presqu'ile provides a personalized OPUS card mandatory for this privilege. The OPUS PHOTO session will be in the Agora on Friday August 31 - FINAL DAY. Come prepared! On Thursday, the wait for an OPUS Card was no longer than half hour.\r\n \r\n What to Bring:\r\n*Photo ID, Proof of Age (Medicare), College Schedule, $14 (CASH ONLY). If you are (or will be) 18+ on October 31, bring something with your address on it.\u00a0\r\n \r\n IMPORTANT: If you have an OPUS card prior to August 1, 2012 YOU MUST RENEW IT at a cost of $14.00. Access to the student discount expires October 31 of this year. RENEW NOW and the student privileges continue to October 31, 2013.\u00a0\r\n \r\n\"Click in Documents and Files\" (located in the Student Activities community) to know exactly what to bring.\u00a0",
            "url":"\/intr\/webpart.gestion?IdWebPart=00000000-0000-0000-0003-000000000007&mode=one&idNews=1503&idProv=2&modeProvenance=lst"
        }
    ]
}
@endsection
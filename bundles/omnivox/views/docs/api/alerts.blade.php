@layout('omnivox::docs.api.master')

@section('name')
GET alerts
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
<p>This will return an array of alerts shown to the user on the front page.</p>
@endsection

<?php

$params = array();

?>

@section('url')
api/alerts.json
@endsection
		
@section('output')
{
    "success":true,
    "result":[
        {
            "name":"3 new documents from the College",
            "description":"View them right now",
            "url":"\/intr\/Module\/ServicesExterne\/Skytech.aspx?IdServiceSkytech=Skytech_Omnivox&lk=%252FESTD%252FDINF%252FLISTEDOCUMENTSDISTRIBUES.OVX&C=JAC&E=P&L=ANG&Ref=20120830000000"
        },
        {
            "name":"30 new job offers related to your field of study",
            "description":"Click here to view the list of all new offers",
            "url":"\/intr\/Module\/ServicesExterne\/Skytech.aspx?IdServiceSkytech=Skytech_Omnivox&lk=%252FESTD%252FPLET%252FREDIRIGE.OVX&C=JAC&E=P&L=ANG&Ref=20120830000000"
        },
        {
            "name":"4 new documents from your teachers",
            "description":"View them right now",
            "url":"\/intr\/Module\/ServicesExterne\/Skytech.aspx?IdServiceSkytech=Skytech_Omnivox&lk=%252FESTD%252FCVIE%253FANSES%253D20123%2526MODULE%253DDDLE%2526ITEM%253DINTRO&C=JAC&E=P&L=ANG&Ref=20120830000000"
        }
    ]
}
@endsection
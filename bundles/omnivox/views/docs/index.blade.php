@layout('omnivox::docs.master')

@section('breadcrumb')
	@parent
	<li class="active">Documentation</li>
@endsection

@section('content')
	
	<div class="page-header">
		<h1>OmniAPI Documentation</h1>
	</div>
	
	<div class="alert">
		<strong>Proceed with caution!</strong> These docs are still incomplete and may not reflect the actual API.
	</div>
	
	<table class="table table-striped api-resource-table">
		<caption>
			<h3>Authentication</h3>
			<p>Authenticating with the server.</p>
		</caption>
		<thead>
			<tr>
				<th class="api-list-resource">Resource</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="api-list-resource"><a href="/docs/api/auth">POST auth</a></td>
				<td>Authenticate with the Omnivox servers and the API.</td>
			</tr>
		</tbody>
	</table>
	
	<table class="table table-striped api-resource-table">
		<caption>
			<h3>Schedule</h3>
			<p>Scraping the schedule.</p>
		</caption>
		<thead>
			<tr>
				<th class="api-list-resource">Resource</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="api-list-resource"><a href="/docs/api/schedule_semesters">GET schedule_semesters</a></td>
				<td>Get a list of semesters currently available to the user.</td>
			</tr>
			<tr>
				<td class="api-list-resource"><a href="/docs/api/schedule">GET schedule</a></td>
				<td>Get a list of classes with proper times for the selected semester.</td>
			</tr>
		</tbody>
	</table>
	
	<table class="table table-striped">
		<caption>
			<h3>Main Page</h3>
			<p>Scraping resources from the main page.</p>
		</caption>
		<thead>
			<tr>
				<th class="api-list-resource">Resource</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="api-list-resource"><a href="/docs/api/alerts">GET alerts</a></td>
				<td>Get a list of alerts ("My Updates") for the user.</td>
			</tr>
			<tr>
				<td class="api-list-resource"><a href="/docs/api/news">GET news</a></td>
				<td>Get all the news posts available to the user.</td>
			</tr>
		</tbody>
	</table>
	
	<table class="table table-striped">
		<caption>
			<h3>L&eacute;a</h3>
			<p>Scraping resources from L&eacute;a.</p>
		</caption>
		<thead>
			<tr>
				<th class="api-list-resource">Resource</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="api-list-resource"><a href="/docs/api/lea/grades">GET lea/grades</a></td>
				<td>Get a list of grades for the current semester.</td>
			</tr>
		</tbody>
	</table>
	
	<table class="table table-striped">
		<caption>
			<h3>Messaging in Omnivox</h3>
			<p>Scraping resources from MIO.</p>
		</caption>
		<thead>
			<tr>
				<th class="api-list-resource">Resource</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="api-list-resource"><a href="/docs/api/mio/all_messages">GET mio/all_messages</a></td>
				<td>Get a list of all MIOs, categorized or not, in the user's inbox.</td>
			</tr>
		</tbody>
	</table>
	
@endsection
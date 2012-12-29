<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>OmniAPI Docs</title>
	<?php echo Asset::container('header')->styles(); ?>
</head>
<body>
	<div class="container">
	
		<div class="navbar navbar-fixed-top navbar-inverse">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="#">OmniAPI</a>
				</div>
			</div>
		</div>
		<!--
		<ul class="breadcrumb">
		  <li><a href="#">Home</a> <span class="divider">/</span></li>
		  <li><a href="#">Library</a> <span class="divider">/</span></li>
		  <li class="active">Data</li>
		</ul>
		-->
		<div class="page-header">
			<h1>OmniAPI REST Documentation</h1>
		</div>
		
		
		<table class="table table-striped">
			<caption>
				<strong>Authentication</strong>
				<p>Calls to authenticate you to the Omnivox portal.</p>
			</caption>
			<thead>
				<tr>
					<th class="call-method">Method</th>
					<th class="call-url">URL</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="call-method">POST</td>
					<td class="call-url">auth</td>
					<td>Logs user into Omnivox using the sent credentials. This must be called before starting further API calls.</td>
				</tr>
				<tr>
					<td class="call-method">GET</td>
					<td class="call-url">auth</td>
					<td><strong>Debug use only.</strong> Same as above, but over GET.</td>
				</tr>
			</tbody>
		</table>
		
		<table class="table table-striped">
			<caption>
				<strong>My Updates</strong>
				<p>Retrieves alerts shown on main page.</p>
			</caption>
			<thead>
				<tr>
					<th class="call-method">Method</th>
					<th class="call-url">URL</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="call-method">GET</td>
					<td class="call-url">alerts</td>
					<td>Returns an array of all alerts, empty if the user has none.</td>
				</tr>
			</tbody>
		</table>
		
		<table class="table table-striped">
			<caption>
				<strong>News</strong>
				<p>Retrieves all news posts on the portal.</p>
			</caption>
			<thead>
				<tr>
					<th class="call-method">Method</th>
					<th class="call-url">URL</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="call-method">GET</td>
					<td class="call-url">news</td>
					<td>Returns an array of all news items.</td>
				</tr>
			</tbody>
		</table>
		
		<table class="table table-striped">
			<caption>
				<strong>Schedule</strong>
				<p>Retrieves the user's schedule with class items.</p>
			</caption>
			<thead>
				<tr>
					<th class="call-method">Method</th>
					<th class="call-url">URL</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="call-method">GET</td>
					<td class="call-url">schedule</td>
					<td>Returns an array of possible semesters to select from.</td>
				</tr>
				<tr>
					<td class="call-method">GET</td>
					<td class="call-url">schedule?semester=</td>
					<td>Returns the schedule with proper class objects.</td>
				</tr>
			</tbody>
		</table>
		
		<table class="table table-striped">
			<caption>
				<strong>L&eacute;a</strong>
				<p>Various API calls for interacting with L&eacute;a.</p>
			</caption>
			<thead>
				<tr>
					<th class="call-method">Method</th>
					<th class="call-url">URL</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="call-method">GET</td>
					<td class="call-url">lea/grades</td>
					<td>Returns an array classes with (final) grades and class averages.</td>
				</tr>
			</tbody>
		</table>
		
		<table class="table table-striped">
			<caption>
				<strong>MIO</strong>
				<p>Various API calls for interacting with Messaging in Omnivox.</p>
			</caption>
			<thead>
				<tr>
					<th class="call-method">Method</th>
					<th class="call-url">URL</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="call-method">GET</td>
					<td class="call-url">mio/list</td>
					<td>Returns an array of MIOs in the user's mailbox.</td>
				</tr>
			</tbody>
		</table>
		
	</div>
</body>
</html>
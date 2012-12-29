@render('omnivox::partials.header')	

<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="/">OmniAPI</a>
			<ul class="nav">
				<li><a href="/">Home</a></li>
				<li class="active"><a href="/docs">Docs</a></li>
				<li><a href="/calendar">Calendar Exporter</a></li>
			</ul>
		</div>
	</div>
</div>

<ul class="breadcrumb">
	@section('breadcrumb')
	<li><a href="/">Home</a> <span class="divider">/</span></li>
	<li><a href="/docs">Documentation</a> <span class="divider">/</span></li>
	<li class="active">API Resource</li>
	@yield_section
</ul>
	
	<div class="page-header">
		<h1>@yield('name')</h1>
	</div>
	
	<div class="api-block">
	@yield('description')
	</div>
	
	<div class="row">
		<div class="span9">
			<div class="api-block">
				<h2>Full URL</h2>
				<p>https://vps.paslawski.me/@yield('url')</p>
			</div>
			
			<div class="api-block">
				<h2>Parameters</h2>
				@if (count($params) == 0)
				<p>None.</p>
				@endif
				@foreach ($params as $p)
				<div class="api-parameter first">
					<span class="parameter-name">
						{{ $p['name'] }}
						<span>{{ $p['required'] ? 'required' : 'optional' }}</span>
					</span>
					<p>{{ $p['description'] }}</p>
					<p><strong>Example value:</strong> <code>{{ $p['example'] }}</code></p>
				</div>				
				@endforeach
			</div>
			
			<div class="api-block">
				<h2>Sample Output</h2>
<pre class="prettyprint lang-js linenums">
@yield('output')
</pre>
			</div>
		</div>
	
		<div class="span3">
			<div class="well" id="information">
				<h2>Information</h2>
				<table class="table">
					<tbody>
						<tr>
							<td>HTTP Method</td>
							<td>@yield('method')</td>
						</tr>
						<tr>
							<td>Authentication Required?</td>
							<td>@yield('auth')</td>
						</tr>
						<tr>
							<td>Response Formats</td>
							<td>@yield('formats')</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
	$(function() {
		prettyPrint();
	});
	</script>
@render('omnivox::partials.footer')
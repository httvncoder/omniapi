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
	@yield_section
</ul>

@yield('content')
		
@render('omnivox::partials.footer')
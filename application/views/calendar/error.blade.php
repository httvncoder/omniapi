@render('partials.header')

<div class="page-header">
	<h1>John Abbott Schedule Exporter</h1>
</div>

<h2>Oops! Something went wrong!</h2>

<p>We were unable to create your calendar file.</p>
<p>The error returned was: {{ $error }}</p>
<p>Please try again later, or <a href="mailto:chris@paslawski.me">notify me</a> if it happens again.</p>

@render('partials.footer')
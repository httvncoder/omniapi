<?php echo $header; ?>
<div id="header">
	<h1>Omnivox Portal API</h1>
</div>
<div id="body">
	<div class="code warning">
		<strong>WARNING:</strong> This API is still under heavy development and will change at any given moment.
	</div>
	
	<p>This API is RESTful. Different request types (GET, POST, etc.) have different actions, and the correct one must be used. A 404 status will be returned a certain API function is incorrectly used.</p>
	<ul>
		<li>200: Success!</li>
		<li>401: Authorization was not made.</li>
		<li>404: The API call was not found.</li>
	</ul>
	<p>Multiple formats may be used as responses:</p>
	<ul>
		<li>.json</li>
		<li>.xml</li>
	</ul>
	<h2><a href="#authorization">Authorization</a></h2>
	<p>To login with credentials...</p>
	<div class="code">
		<div class="request">
			<span class="type">POST</span>
			<? echo URL::to_action('api'); ?>/auth.<span class="variable">json</span>
		</div>
		<div class="variables">
			<span class="post">id=<span class="variable">student ID (numbers only)</span></span><br />
			<span class="post">password=<span class="variable">password</span></span><br />
			<span class="post">url=<span class="variable">college URL (ex. johnabbott)</span></span>
		</div>
	</div>
	<p>This will set a session cookie named <span class="ms">omniapi_session</span> which must be included in any further requests. It expires in 30 minutes of idling.</p>
	<p>Successfully logged in? Good. Let's move on to the real data...</p>
	
	<h2><a href="#alerts">Alerts ("My Updates")</a></h2>
	<p>This method will return any new alerts in the "My Updates" section on the main page.</p>
	<div class="code">
		<div class="request">
			<span class="type">GET</span>
			<? echo URL::to_action('api'); ?>/alerts.<span class="variable">json</span>
		</div>
		<!--<div class="variables">
			<span class="post">id=<span class="variable">student ID</span></span><br />
			<span class="post">password=<span class="variable">password</span></span>
		</div>-->
	</div>
	<p>Example JSON output:</p>
	<div class="code">
		["17 new documents from your teachers","7 new documents from the College"]
	</div>
</div>
<?php echo $footer; ?>
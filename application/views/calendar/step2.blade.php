<div class="span6" id="left-col">
	<h2>Step 2</h2>
	<p>Once it loads, select a semester you want to fetch the schedule for.</p>
	<p>You will also need to select a start date and an end date for your events.</p>
	<br />
	<div id="error" class="alert alert-error" style="display: none;"></div>
</div>
<div class="span6" id="right-col">
	<form class="form-horizontal well" id="auth-form">
		<fieldset>
			<div class="control-group">
				<label class="control-label" for="semester">Semester</label>
				<div class="controls">
					<select name="semester" id="semester" disabled="disabled"></select>
					<p class="help-block"><span class="spinner"><img src="/img/ajax-loader.gif" /> Loading semesters, please wait...</span></p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="date-from">Start Date</label>
				<div class="controls">
					<input type="text" class="input-medium" name="date-from" id="date-from" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="date-to">End Date</label>
				<div class="controls">
					<input type="text" class="input-medium" name="date-to" id="date-to" />
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-primary" value="Download (this may take a while!)" id="auth-form-submit" onclick="App.getICS();" />
					<span class="spinner" style="padding-left: 10px; display: none;"><img src="/img/ajax-loader.gif" /></span>
				</div>
			</div>
		</fieldset>
	</form>
</div>
<?php
$seasons = array(
	1 => 'Winter',
	2 => 'Summer',
	3 => 'Fall'
);
?>

@render('partials.header')

<div class="page-header">
	<h1>John Abbott Schedule Exporter</h1>
</div>

<div class="row" id="step-1">
	<div class="span6">
		<h2>Step 1</h2>
		<p>Enter your John Abbott Omnivox account information to continue.</p>
		<p>Your information is not stored and is only used for authenticating you to the Omnivox system.</p>
		<br />
		<div class="alert alert-error" style="display: none;"></div>
	</div>
	<div class="span6">
		<form class="form-horizontal well" id="step-1-form">
			<fieldset>
				<div class="control-group error">
					<label class="control-label" for="id">Student ID</label>
					<div class="controls">
						<input type="text" class="input-medium" id="id" name="id" maxlength="7" onkeyup="App.step1Validation(this);" />
						<span class="help-inline"><i class="icon-remove"></i></span>
					</div>
				</div>
				<div class="control-group error">
					<label class="control-label" for="password">Password</label>
					<div class="controls">
						<input type="password" class="input-medium" id="password" name="password" onkeyup="App.step1Validation(this);" />
						<span class="help-inline"><i class="icon-remove"></i></span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="submit" class="btn btn-primary" value="Submit" id="step-1-submit" disabled="disabled" />
						<span class="spinner" style="padding-left: 10px; display: none;"><img alt="Loading..." src="/img/ajax-loader.gif" /></span>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>

<div class="row" id="step-2" style="display: none;">
	<div class="span6">
		<h2>Step 2</h2>
		<p>Select a semester you want to fetch the schedule for. Please ensure your selected semester's schedule is accessible via Omnivox, or else your download <strong>may not work</strong>.</p>
		<p>You will also need to select a start date and an end date for your events to appear in the calendar.</p>
		<p>To see when your semester starts and ends, <a href="http://www.johnabbott.qc.ca/current-students/registrars-office/academic-calendar">please click here</a>.
		For reference, here are some dates for 2012:</p>
		<ul>
			<li>Fall 2012: Aug. 27 - Dec. 11</li>
			<li><strong>Winter 2013: Jan. 21 - May 14</strong></li>
		</ul>
		<br />
		<div class="alert alert-error" style="display: none;"></div>
	</div>
	<div class="span6">
		<form class="form-horizontal well" id="step-2-form" action="/calendar/download" method="get">
			<fieldset>
				<div class="control-group error">
					<label class="control-label" for="semester">Semester</label>
					<div class="controls">
						<select name="semester" id="semester" class="input-medium" onchange="App.step2Validation(this);">
							<option></option>
							@for ($i = 0; $i < 9; $i++)
							<option value="{{ (2012 + floor($i / 3)) . ($i % 3 + 1) }}">{{ $seasons[$i % 3 + 1] . ' ' . (2012 + floor($i / 3)) }}</option>
							@endfor
						</select>
						<span class="help-inline"><i class="icon-remove"></i></span>
					</div>
				</div>
				<div class="control-group error">
					<label class="control-label" for="date-from">Start Date</label>
					<div class="controls">
						<input type="text" class="input-medium" name="date-from" id="date-from" onkeyup="App.step2Validation(this);" />
						<span class="help-inline"><i class="icon-remove"></i></span>
					</div>
				</div>
				<div class="control-group error">
					<label class="control-label" for="date-to">End Date</label>
					<div class="controls">
						<input type="text" class="input-medium" name="date-to" id="date-to" onkeyup="App.step2Validation(this);" />
						<span class="help-inline"><i class="icon-remove"></i></span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="submit" class="btn btn-primary" value="Download (this may take a while!)" id="step-2-submit" disabled="disabled" />
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>

@render('partials.footer')
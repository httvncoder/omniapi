$(function () {
	App.init();

	$('#step-1-submit').click(function () {
		App.auth();
		return false;
	});

	//$('#step-1').hide();
	//$('#step-2').show();
	//$("#step-2-form input, #step-2-form select").removeAttr("disabled");
});

var App = {
	init: function () {
		App.spinner = $('.spinner');
		App.error = $('.alert-error');
		App.semesterLoadText = $('#semester-loading');
		App.dateTest = /([0-9]{2}\/){2}[0-9]{4}/;

		App.enableDatePicker();
		App.step1Validation();
	},
	seasons: {
		'1' : 'Winter',
		'2' : 'Summer',
		'3' : 'Fall'
	},
	isNumber: function (n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	},
	step1Validation : function (e) {
		var e = $(e);
		var id = $('#id');
		var password = $('#password');

		var bad = false;
		var errors = 0;

		if (!App.isNumber(id.val()) || id.val().length != 7) {
			if (e.is(id)) {
				bad = true;
			}
			errors++;
		}

		if (password.val().length == 0) {
			if (e.is(password)) {
				bad = true;
			}
			errors++;
		}

		if (bad == true) {
			e.parents().eq(1).addClass('error');
			e.parent().find('i').attr('class', 'icon-remove');
		}
		else {
			e.parents().eq(1).removeClass('error');
			e.parent().find('i').attr('class', 'icon-ok');
		}

		if (errors == 0) {
			$('#step-1-submit').removeAttr('disabled');
		}
		else {
			$('#step-1-submit').attr('disabled', 'disabled');
		}
	},
	step2Validation: function (e) {
		var e = $(e);
		var semester = $('#semester');
		var from = $('#date-from');
		var to = $('#date-to');

		var bad = false;
		var errors = 0;

		if (semester.val() == "") {
			if (e.is(semester)) {
				bad = true;
			}
			errors++;
		}

		if (from.val() == "" || App.dateTest.test(from.val()) == false) {
			if (e.is(from)) {
				bad = true;
			}
			errors++;
		}

		if (to.val() == "" || App.dateTest.test(to.val()) == false) {
			if (e.is(to)) {
				bad = true;
			}
			errors++;
		}

		if (bad == true) {
			e.parents().eq(1).addClass('error');
			e.parent().find('i').attr('class', 'icon-remove');
		}
		else {
			e.parents().eq(1).removeClass('error');
			e.parent().find('i').attr('class', 'icon-ok');
		}

		if (errors == 0) {
			$('#step-2-submit').removeAttr('disabled');
		}
		else {
			$('#step-2-submit').attr('disabled', 'disabled');
		}
	},
	auth: function () {
		App.spinner.show();
		App.error.hide();

		var data = $('#step-1-form').serialize();
		$("#step-1-form input").attr("disabled", "disabled");

		$.ajax({
			type: 'POST',
			url: '/calendar/auth',
			data: data,
			dataType: 'json',
		}).done(function(json) {
			if (json.success == true) {
				$('#error').fadeOut(100);

				$('#step-1').fadeOut('fast', function () {
					$('#step-2').fadeIn('fast');
				});
			}
			else {
				App.displayError(json.message);
			}

			App.spinner.hide();
			$("#step-1-form input").removeAttr("disabled");
		});
	},
	enableDatePicker: function () {
		$('#date-from').datepicker({
			changeMonth: true,
			onSelect: function (selectedDate) {
				$('#date-to').datepicker("option", "minDate", selectedDate);
				App.step2Validation(this);
			}
		});

		$('#date-to').datepicker({
			changeMonth: true,
			onSelect: function (selectedDate) {
				$('#date-from').datepicker("option", "maxDate", selectedDate);
				App.step2Validation(this);
			}
		});
	},
	displayError: function (msg) {
		App.error.html('<strong>Something went wrong!</strong> ' + msg).fadeIn('fast');
	}
};
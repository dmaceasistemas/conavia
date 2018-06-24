window.addEvent('load', function() {
	new DatePicker('.date_toggled', {
		pickerClass: 'datepicker_dashboard',
		allowEmpty: true,
		toggleElements: '.date_toggler'
	});
});

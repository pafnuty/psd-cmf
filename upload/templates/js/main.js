var doc = $(document),
	// Ladda var
	laddaLoad,
	formOptions = {
		// dataType: 'json',
		beforeSubmit: processStart,
		success: processDone
	};

doc
	.on('click', '[data-open-form]', function() {
		var dataForm = $(this).data('openForm');
		$('#form-' + dataForm).slideToggle(400);

	})
	.on('submit', '.ajaxForm', function(event) {
		event.preventDefault();
		laddaLoad = $(this).find('.ladda-button').ladda();
		$(this).ajaxSubmit(formOptions);

		return false;
	});


/**
 * [processStart description]
 * @return {[type]} [description]
 */
function processStart() {
	laddaLoad.ladda('start')
};

/**
 * [processDone description]
 * @param  {[type]} data [description]
 * @return {[type]}      [description]
 */
function processDone(data) {
	var progress = 0;
	var interval = setInterval(function () {
		progress = Math.min(progress + Math.random() * 0.2, 1);
		laddaLoad.ladda('setProgress', progress);

		if (progress === 1) {
			laddaLoad.ladda('stop');
			clearInterval(interval);
		}
	}, 100);
	console.log(data);

};
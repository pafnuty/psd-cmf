var doc = $(document);
var TemplateEngine = function(html, options) {
	var re = /<%(.+?)%>/g,
		reExp = /(^( )?(var|if|for|else|switch|case|break|{|}|;))(.*)?/g,
		code = 'with(obj) { var r=[];\n',
		cursor = 0,
		result;
	var add = function(line, js) {
		js? (code += line.match(reExp) ? line + '\n' : 'r.push(' + line + ');\n') :
			(code += line != '' ? 'r.push("' + line.replace(/"/g, '\\"') + '");\n' : '');
		return add;
	}
	while(match = re.exec(html)) {
		add(html.slice(cursor, match.index))(match[1], true);
		cursor = match.index + match[0].length;
	}
	add(html.substr(cursor, html.length - cursor));
	code = (code + 'return r.join(""); }').replace(/[\r\t\n]/g, '');
	try { result = new Function('obj', code).apply(options, [options]); }
	catch(err) { console.error("'" + err.message + "'", " in \n\nCode:\n", code, "\n"); }
	return result;
}

var template =
	'<ul class="project-list">' +
		'<%for(var i in this.files) {%>' +
			'<li class="clearfix">' +
				'<%if(this.files[i].error) {%>' +
					'<div class="alert"><%this.files[i].name%> <br /> <b><%this.files[i].error%></b></div>' +
				'<%} else {%>' +
					'<div class="col col-mb-6 col-2">' +
						'<img src="<%this.files[i].thumbnailUrl%>" alt="<%this.files[i].name%>" width="100">' +
						'<input type="hidden" name="image[<%i%>][name]" value="<%this.files[i].name%>" />' +
					'</div>' +
					'<div class="col col-mb-6 col-8">' +
						'Сортировка: <input class="input input-small" type="text" name="image[<%i%>][sort_index]" value="500">' +
						'<select name="image[<%i%>][type]" class="styler styler-small">' +
							'<option value="1" selected>Публиковать</option>' +
							'<option value="2">Не публиковать</option>' +
						'</select>' +
					'</div>' +
				'<%}%>' +
				'</li>' +
		'<%}%>' +
	'</ul>' +
	'<p><button class="btn" type="submit">Сохранить добавленые файлы</button></p>' +
	'<hr />' ;



doc
	.on('click', '.project-list li', function(e) {
		var $this = $(this),
			$target = $(e.target);
		if ($target.is('img') || $target.is('a')) {
			return;
		};

		$this.toggleClass('active');

	})
	.on('submit', '.ajaxform', function(event) {
		var options = {
			beforeSubmit: showRequest, // pre-submit callback
			success: showResponse // post-submit callback
		}

		$(this).ajaxSubmit(options);

		return false;
	})
	.on('submit', '.addProject', function(event) {
		var options = {
			beforeSubmit: showRequestAddProj,
			success: showResponseAddProj
		}

		$(this).ajaxSubmit(options);

		return false;
	})
	.on('submit', '#fileupload', function() {
		var $bar = $('.bar'),
			$percent = $('.percent'),
			$status = $('#status');

		$(this).ajaxSubmit({
			beforeSend: function () {
				$status.empty();
				var percentVal = '0%';
				$bar.width(percentVal)
				$percent.html(percentVal);
			},
			uploadProgress: function (event, position, total, percentComplete) {
				var percentVal = percentComplete + '%';
				var percentValText = (percentComplete == 100) ? 'Идёт обработка...' : percentComplete + '%';
				$bar.width(percentVal);
				$percent.html(percentValText);
				console.log(percentVal, position, total);
			},
			success: function () {
				var percentVal = '100%';
				var percentValText = 'Идёт обработка...';
				$bar.width(percentVal);
				$percent.html(percentValText);
				setTimeout

			},
			complete: function (xhr) {
				$status.empty();
				var percentVal = 'Готово!';
				$bar.width('100%');
				$percent.html(percentVal);

				var $items = $.parseJSON(xhr.responseText);

				var show = (TemplateEngine(template, {
					files: $items.files,
					parseTemplate: true
				}));
				$status.html(show);
				$status.find('.styler').selectize();
			}
		});
		return false;
	});



jQuery(document).ready(function($) {
	if ($('.styler').length) {
		$('.styler').selectize();
	};
});


// pre-submit callback
function showRequest(formData, jqForm, options) {
	var queryString = $.param(formData);
	console.log('About to submit: \n\n' + queryString);
	return true;
}

// post-submit callback
function showResponse(responseText, statusText, xhr, $form) {
	if (statusText == 'success') {
		location.reload();
	};
	console.log('status: ' + statusText + '\n\nresponseText: \n' + responseText +
		'\n\nThe output div should have already been updated with the responseText.');
}

function showRequestAddProj(formData, jqForm, options) {
	$('.addStatus').html();

	return true;
}

function showResponseAddProj(responseText, statusText, xhr, $form) {
	var $response = $.parseJSON(responseText);
	var $addStatus = $('.addStatus');
	if ($response.error) {
		$addStatus.html('<p class="alert">'+$response.error+'</p>')
	};
	if ($response.text) {
		$addStatus.html('<p class="alert alert-info">'+$response.text+'</p>')
	};
}



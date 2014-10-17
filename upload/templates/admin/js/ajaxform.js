!(function ($) {
	'use strict';

	var script = {};

	script.ajax = {
		errorMessage: tr('error:ajax-request'),

		ajaxSettings: {
			$loaderEl: $('#loader'),

			beforeSend: function () {
				this.$loaderEl.show();
			},

			complete: function () {
				this.$loaderEl.hide();
			}
		},

		init: function () {
			$.ajaxSetup(this.ajaxSettings);
		},

		callbacks: {
			login: function ($form, data) {
				if (data.status === 'ok') {
					if (data.data && data.data.redirect) {
						window.location.href = data.data.redirect;
					}
				}
			},

			logout: function ($form, data) {
				if (data.status === 'ok') {
					if (data.data && data.data.redirect) {
						window.location.href = data.data.redirect;
					}
				}
			},

			register: function ($form, data) {
				if (data.status === 'ok') {
					if (data.data && data.data.redirect) {
						window.location.href = data.data.redirect;
					}
				}
			}

		}
	};

	script.ajaxform = {
		$forms: null,

		init: function (selector) {
			this.$forms = $(selector);
			this.$forms.attr('novalidate', 'novalidate');
			this.initHandler();
		},

		initHandler: function () {
			this.$forms.submit(function () {
				var $_this = $(this);
				var result = script.ajaxform.validate($_this);

				if (result === true) {
					script.ajaxform.go($_this);
				}

				return false;
			});
		},

		callback: function ($form, data) {
			var action = getURLParam('act', $form.attr('action'));

			if (!action || action === ';') {
				action = $form.find('[name|="act"]').val();
			}

			if (action !== ';' && action.length) {
				var callbackFunction = script.ajax.callbacks[action];
				if (typeof callbackFunction === 'function') {
					callbackFunction.call(this, $form, data);
				}
			}
		},

		validate: function ($form) {
			var $fields = $form.find(':input'),
				isValid = true,
				$e;

			$fields.each(function (i, e) {
				$(e).removeClass('error-message');
			});

			$form.find('.error-message').remove();

			$fields.each(function (i, e) {
				if (e.hasAttribute('required')) {
					$e = $(e);
					if (!$e.val().trim()) {
						$e.addClass('error-message').focus();
						isValid = false;
						return isValid;
					}
				}
			});
			return isValid;
		},

		go: function ($form) {
			var method = $form.attr('method') || 'GET';
			var action = $form.attr('action') || '.';

			var ajaxSettings = {
				type: method,
				url: action,
				data: $form.serialize()
			};

			var $formInputs = $form.find('input,textarea,select');
			$formInputs.attr('readonly', 'readonly');

			var $formButtons = $form.find(':button,input[type="submit"]');

			$formButtons.attr("disabled", "disabled");

			ajaxSettings.complete = function () {
				script.ajax.ajaxSettings.$loaderEl.hide();
				$formInputs.removeAttr('readonly');
				$formButtons.removeAttr('disabled');
			};

			ajaxSettings.success = function (response) {
				var data;
				if (typeof response === 'object') {
					// mime type application/json responsed
					data = response;
				}
				else {
					try {
						data = JSON.parse(response);
					}
					catch (e) {
						window.alert(tr('error:form-submit'));
						return;
					}
				}
				script.ajaxform.validateByAjax($form, data);
			};

			$.ajax(ajaxSettings);
		},

		validateByAjax: function ($form, data) {
			if (data.status === 'ok') {
				if (data.message !== undefined && data.message !== null) {
					// window.alert(data.message);
				}
				if (data.redirect === true) {
					if (data.url !== undefined && data.url !== null) {
						window.location.href = data.url;
					}
					else {
						window.location.reload();
					}
				}
			}
			else if (data.status === 'err') {
				var $mainErrorContainer = $form.find('.main-error');
				if (data.code === 'main') {
					if ($mainErrorContainer !== null) {
						$mainErrorContainer.html('<p class="error">' + data.message + '</p>');
					}
					else {
						$form.append('<p class="error">' + data.message + '</p>');
					}
				}
				else {
					var $errField = $form.find('[name|="' + data.code + '"]');
					$mainErrorContainer.html(data.message).show();
					$errField.focus();
				}
			}

			this.callback($form, data);
		}
	};

	function getURLParam(name, url) {
		url = url || window.location.href;
		name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var regexS = "[\\?&]" + name + "=([^&#]*)",
			regex = new RegExp(regexS),
			results = regex.exec(url);

		if (results === undefined || results === null) {
			return ';';
		}
		else {
			return decodeURIComponent(results[1].replace(/\+/g, " "));
		}
	}

	function tr(params, lang) {
		var messages = {},
			translated = '',
			code;

		messages.ru_RU = {
			'error': {
				'form-submit': 'Произошла ошибка при отправке формы',
				'ajax-request': 'Произошла ошибка при отправке запроса'
			},

			'notice': {
				'confirm': 'Подтвердите действие'
			}
		};
		lang = lang || 'ru_RU';
		params = params.toLowerCase().split(':');
		if (messages[lang] !== undefined && params.length) {
			for (var i = 0, msgcat = messages[lang]; i < params.length; i++) {
				code = params[i];
				if (typeof msgcat[code] === 'object') {
					msgcat = msgcat[code];
				}
				if (typeof msgcat[code] === 'string') {
					translated = msgcat[code];
					break;
				}
			}
		}
		return translated;
	}

	script.init = function () {
		this.ajaxform.init('form.ajax');
		this.ajax.init();
	};

	$(document).ready(function ($) {
		script.init();
	});
})(jQuery);
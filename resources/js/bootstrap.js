window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
	window.Popper = require('popper.js').default;
	window.$ = window.jQuery = require('jquery');
	import('../../public/js/lib/turn.js')
	import('../../public/js/chromoselector/src/chromoselector.js')
	// import('../../public/js/gradx/colorpicker/js/colorpicker.js')
	// import('../../public/js/gradx/dom-drag.js')
	// import('../../public/js/gradx/grad.js')
	import('../../public/js/gpickr/dist/gpickr.min.js')

	window.bootstrap = require('bootstrap');

} catch (e) { }

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Noty = require('noty');
import Cleave from 'cleave.js';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

jQuery(function ($) {
	$('.login-signup-switch-button').click(function (e) {
		e.preventDefault()
		$(this).closest('.tabule').addClass('d-none').removeClass('d-block').next().show().addClass('d-block').removeClass('d-none')
	})
	$('.back-arrow').click(function () {
		$(this).closest('.tabule').addClass('d-none').removeClass('d-block').prev().show().addClass('d-block').removeClass('d-none')
	})

	$('#su_password').keyup(function (e) {
		var pwd = $(this).val()

		if (pwd.length === 0) {
			$('#password_progress').val(0)
			return;
		}

		var prog = [/[$@$!%*#?&]/, /[A-Z]/, /[0-9]/, /[a-z]/]
			.reduce((memo, test) => memo + test.test(pwd), 0);

		if (prog > 2 && pwd.length > 7) {
			prog++;
		}

		var progress = "";
		switch (prog) {
			case 0:
			case 1:
			case 2:
				progress = "25";
				break;
			case 3:
				progress = "50";
				break;
			case 4:
				progress = "75";
				break;
			case 5:
				progress = "100";
				break;
		}
		$('#password_progress').val(progress);
	})

	if (window.location.hash == '#signup') {
		$('#signupModal').modal('show')
	}

	$('#modal-confirm-wizard').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var recipient = button.data('href') // Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this)
		modal.find('.btn-confirm').attr('href', recipient)
	});

	$('#modal-confirm-download').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var recipient = button.data('href') // Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this)
		modal.find('.btn-confirm').attr('href', recipient)
	})
})

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

import VTooltip from 'v-tooltip'
Vue.use(VTooltip)

import { routes } from './routes';
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('new-brandbook',
	require('./components/NewBrandbook.vue').default);
Vue.component('image-upload', require('./components/upload.vue').default);
Vue.component('share', require('./components/share.vue').default);
Vue.component('share-init', require('./components/share-init.vue').default);
Vue.component('refer-a-friend', require('./components/refer-a-friend.vue').default);
Vue.component('preview', require('./components/preview.vue').default);
Vue.component('order-summary', require('./components/order-summary.vue').default);
Vue.component('checkout', require('./components/checkout.vue').default);
Vue.component('gfont-item', require('./components/gfont-item.vue').default);

Vue.component('switch-toggle', require('./components/switch-toggle.vue').default);
Vue.component('hidden-input', require('./components/hidden-input.vue').default);
Vue.component('packages', require('./components/packages/packages.vue').default);
Vue.component('modal-packages', require('./components/packages/modal-packages').default);
Vue.component('animated-integer', require('./components/animated-integer.vue').default);
Vue.component('customize-book', require('./components/customize-book').default);
Vue.component('monthly-annualy', require('./components/monthly-annualy.vue').default);
Vue.component('font-select', require('./components/font-select').default);

Vue.component('plan-item', require('./components/profile/plan-item.vue').default);
Vue.component('cc-form', require('./components/profile/cc-form.vue').default);
Vue.component('payment-method', require('./components/profile/payment-method').default);

require('./components/profile/modals/modals.js');

Vue.use(VueRouter);

const router = new VueRouter({
	mode: 'history',
	routes
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
	el: '#app',
	router
});


jQuery(function () {
	function buttons_sizer() {
		if ($('.brandbook-block:not(".add-new-block")').length > 0) {
			var w = $('main #aside').outerWidth()
			$('.add-new-block').css({
				'width': $('.brandbook-block:not(".add-new-block"):first .image').outerHeight() + 16,
				'height': $('.brandbook-block:not(".add-new-block"):first .image').outerHeight() + 16,
				'left': w - $('.brandbook-block:not(".add-new-block"):first .image').outerHeight() - 16,
			}).removeClass('d-none')
			$('.add-new-block').next().css({
				'width': $('.brandbook-block:not(".add-new-block"):first .image').outerHeight() + 16,
				'top': $('.brandbook-block:not(".add-new-block"):first .image').outerHeight() + 127 + 16,
				'left': w - $('.brandbook-block:not(".add-new-block"):first .image').outerHeight() - 16,
			}).removeClass('d-none')
			$('.header-add-new').css({ 'width': $('.brandbook-block:not(".add-new-block"):first .image').outerHeight() + 16 }).removeClass('d-none')
			var h = $('.brand-logo-block').width()
			$('.brand-logo-block').css('width', h - $('.header-add-new').width())


			$('header .col-3').css({ maxWidth: w + 'px' })
			// $('.margined').css({marginLeft: (w-10)+'px'})
		} else {
			$('.header-add-new').removeClass('d-none')
			$('.add-new-block').css({ 'width': $('.header-add-new').width(), 'height': $('.header-add-new').width() }).removeClass('d-none')
			$('.add-new-block').next().css({ 'width': $('.header-add-new').width(), 'top': $('.header-add-new').width() + 165 }).removeClass('d-none')
			var h = $('.brand-logo-block').width()
			$('.brand-logo-block').css('width', h - $('.header-add-new').width())
		}
	}
	buttons_sizer()
	window.addEventListener('resize', () => {
		setTimeout(() => {
			buttons_sizer()
		}, 400)
	})
})

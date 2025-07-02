/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap.js';
import '@/utils/new-brand/additionalBootstrap';
import './additionalBootstrap';
import 'vue-select/dist/vue-select.css';

window.Vue = require('vue');
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import { store } from './store.js';
import VTooltip from 'v-tooltip'
import vSelect from 'vue-select';
import VueObserveVisibility from 'vue-observe-visibility';
import updateCSSVariables from '@/utils/new-brand/updateCss';
import editableContent, { applyEditableContent } from './utils/new-brand/editableContent';
import _ from 'lodash';
Vue.prototype.$_ = _;

Vue.directive('editable-content', editableContent);

Vue.prototype.$applyEditableContent = applyEditableContent;

Vue.use(Vuex);
Vue.use(VueObserveVisibility);

Vue.use(VTooltip)
Vue.component('v-select', vSelect);

import { routes } from './routes';
//import './assets/scss/main.scss';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
if (window.user) {
	const user = JSON.parse(atob(window.user));
	store.dispatch('setLoggedInUser', user);
}
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
Vue.component('current-plan-card', require('./components/profile/CurrentPlanCard.vue').default);

require('./components/profile/modals/modals.js');

Vue.use(VueRouter);

const router = new VueRouter({
	mode: 'history',
	routes
});
router.beforeEach((to, from, next)=>{
	if(store.getters.getUser){
		next();
	} else {
		if(to.matched.some(record => !record.meta.authRequired)){
			next();
		}else{
			if(to.name != null){
				window.location.href = '/';
			}
		}
	}
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Update CSS variables initially
updateCSSVariables(
	store.state.mainColor,
	store.state.secondColor,
	store.state.tertiaryColor,
	store.state.pantoneColor1
  );

const app = new Vue({
	el: '#app',
	router,
	store,
	watch: {
		'$store.state': {
		  handler(newState) {
			updateCSSVariables(
			  newState.mainColor,
			  newState.secondColor,
			  newState.tertiaryColor,
			  newState.pantoneColor1
			);
		  },
		  deep: true,
		},
	  },
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

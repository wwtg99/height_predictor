
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import iView from 'iview';
import 'iview/dist/styles/iview.css';
import ICountUp from 'vue-countup-v2';

window.Vue = require('vue');

Vue.use(iView);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('CountUp', ICountUp);
// Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('predictor-home', require('./components/PredictorHome.vue'));
Vue.component('genotype-predictor', require('./components/GenotypePredictor.vue'));
Vue.component('parent-predictor', require('./components/ParentPredictor.vue'));

const app = new Vue({
    el: '#app'
});

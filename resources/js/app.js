import Vue from 'vue';

Vue.component('calc-component', require('./components/Calc').default);

Vue.filter('round',  (value) => {
    return Math.round(value * 100)/ 100;
})
const app = new Vue({
    el: '#app',
});

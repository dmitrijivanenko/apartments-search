require('./bootstrap');

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import Vue from 'vue';
import Apartments from './components/apartments'

Vue.use(ElementUI);

const app = new Vue({
    el: '#app',
    components: {
        Apartments
    }
});

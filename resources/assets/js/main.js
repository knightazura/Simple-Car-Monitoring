import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'

// Components
import HomeChart from './components/HomeChart.vue'
import RequestForm from './components/RequestForm.vue'
import FinishedForm from './components/FinishedForm.vue'


locale.use(lang)
Vue.use(ElementUI)
Vue.component('request-form', RequestForm)
Vue.component('finished-form', FinishedForm)
Vue.component('home-chart', HomeChart)

const app = new Vue({
  el: '#app'
})

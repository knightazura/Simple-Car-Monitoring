import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import RequestForm from './components/RequestForm.vue'
import FinishedForm from './components/FinishedForm.vue'

import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'

locale.use(lang)
Vue.use(ElementUI)
Vue.component('request-form', RequestForm)
Vue.component('finished-form', FinishedForm)

const app = new Vue({
  el: '#app'
})

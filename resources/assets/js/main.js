import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'

// Components
import RequestForm from './components/RequestForm.vue'
import FinishedForm from './components/FinishedForm.vue'
import EmployeeForm from './components/EmployeeForm.vue'
import DriverForm from './components/DriverForm.vue'
import CarForm from './components/CarForm.vue'

locale.use(lang)
Vue.use(ElementUI)
Vue.component('request-form', RequestForm)
Vue.component('finished-form', FinishedForm)
Vue.component('employee-form', EmployeeForm)
Vue.component('driver-form', DriverForm)
Vue.component('car-form', CarForm)

const app = new Vue({
  el: '#app'
})

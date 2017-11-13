import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'

// Components
import UserForm from './components/UserForm.vue'
import RequestForm from './components/RequestForm.vue'
import FinishedForm from './components/FinishedForm.vue'
import EmployeeForm from './components/EmployeeForm.vue'
import DriverForm from './components/DriverForm.vue'
import CarForm from './components/CarForm.vue'
import DriverCarForm from './components/DriverCarForm.vue'
import FuelForm from './components/FuelForm.vue'

locale.use(lang)
Vue.use(ElementUI)
Vue.component('user-form', UserForm)
Vue.component('request-form', RequestForm)
Vue.component('finished-form', FinishedForm)
Vue.component('employee-form', EmployeeForm)
Vue.component('driver-form', DriverForm)
Vue.component('car-form', CarForm)
Vue.component('driver-car-form', DriverCarForm)
Vue.component('fuel-form', FuelForm)

const app = new Vue({
  el: '#app'
})

import Vue from 'vue'
import 'element-ui/lib/theme-default/index.css'
import Example from './components/ExampleComponent.vue'

import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'

locale.use(lang)
Vue.component('example-component', Example)

const app = new Vue({
  el: '#app'
})

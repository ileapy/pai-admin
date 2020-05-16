import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import 'vant/lib/index.css';
import {Icon} from "vant";
import {Image as VanImage} from "vant";
import { Lazyload } from 'vant';

Vue.config.productionTip = false
Vue.use(Icon)
Vue.use(VanImage)
Vue.use(Lazyload);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')

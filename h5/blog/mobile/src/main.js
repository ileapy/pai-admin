import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import 'vant/lib/index.css';
import './utils/index.js'
import {Icon} from "vant";
import {Image as VanImage} from "vant";
import { Lazyload } from 'vant';
import {isAndroid, isIos, isWeixin} from "./utils";
import 'weixin-js-sdk'
import { Button } from 'vant';
import './utils/request'
import cookie from "./utils/cookie";

Vue.use(Button);
Vue.config.productionTip = false
Vue.use(Icon)
Vue.use(VanImage)
Vue.use(Lazyload);

store.state.isAndroid = isAndroid()
store.state.isIos = isIos()
// 恢复登录
if (cookie.has("token"))
{
  store.state.isLogin = true;
  store.state.token = cookie.get("token");
}
// 判断是否微信环境
if (isWeixin())
{
  store.state.isWeChat = true //微信
  // 加载微信环境配置，支付

}


new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')

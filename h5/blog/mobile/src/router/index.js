import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

  const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta:{title:'首页',keyword:'首页',description:'首页'},
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  }
]

const router = new VueRouter({
  mode:'history',
  routes
})

// 修改页面title
router.beforeEach((to, from, next) => {
  /* 路由发生变化修改页面title */
  if (to.meta.title) {
    document.title = to.meta.title
  }

  if(to.meta){
    let head = document.getElementsByTagName('head');
    let meta = document.createElement('meta');
    document.querySelector('meta[name="keywords"]').setAttribute('content', to.meta.keywords)
    document.querySelector('meta[name="description"]').setAttribute('content', to.meta.description)
    meta.content = to.meta.content;
    head[0].appendChild(meta)
  }

  next()
})

export default router

import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

  const routes = [
    {
      path: '/',
      name: 'Home',
      component: Home,
      meta:{title:'里派博客',keyword:'里派博客首页',description:'里派博客首页,PHP,Python,C#,技术分享,日志记录'},
    },
    {
      path: '/about',
      name: 'About',
      component: () => import(/* webpackChunkName: "about" */ '../views/About.vue'),
      meta:{title:'关于我们',keyword:'关于我们',description:'关于我们'},
    },
    {
      path: '/details/:id',
      name: 'Details',
      component: () => import(/* webpackChunkName: "details" */ '../views/Details.vue'),
      meta:{title:'文章详情',keyword:'文章详情',description:'文章详情'},
    },
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
  // 设置SEO
  if(to.meta){
    let head = document.getElementsByTagName('head');
    // keywords
    if (to.meta.keyword)
    {
      let meta = document.createElement('meta');
      meta.content = to.meta.keyword;
      meta.name = "keywords"
      head[0].appendChild(meta)
    }
    // description
    if (to.meta.description)
    {
      let meta = document.createElement('meta');
      meta.content = to.meta.description;
      meta.name = "description"
      head[0].appendChild(meta)
    }
    // 推荐
    let meta = document.createElement('meta');
    meta.content = "always";
    meta.name = "referrer"
    head[0].appendChild(meta)
  }

  next()
})

export default router

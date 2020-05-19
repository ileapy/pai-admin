<template>
  <div class="home">
    <van-nav-bar
            title="里派博客"
            z-index="999"
            left-arrow
            :fixed=true
            :border=false
            @click-left="onClickLeft"
            @click-right="onClickRight"
    >
      <template #left>
        <img width="32" height="32" src="@/assets/logo.png" alt="里派博客" title="里派博客"/>
      </template>
      <template #right>
        <img src="@/assets/iconfont/search.svg" width="24" height="24" alt="搜索" title="搜索"/>
      </template>
    </van-nav-bar>
    <van-tabs v-model="active" class="tab">
      <van-tab title="全部">
        <van-list
                v-model="loading"
                :finished="finished"
                finished-text="没有更多了"
                @load="onLoad"
        >
          <div class="card">
            <a href="/details/1" title="此景只应天上有，人间能得几回闻">
              <div class="card-image">
                <van-image src="http://file.cos.leapy.cn/image/20200516/91f08202005161354061360.jpg" alt="" title="" lazy-load/>
              </div>
              <h1 class="card-title">此景只应天上有，人间能得几回闻</h1>
              <h2 class="card-desc">我们本应珍惜,而物欲的膨胀带动下的所谓现代科学的发展,却正在无度的破坏着我们原本美好的家园,如此下去,也许有一天,梦中只有 “此景只应天上有,人间得有几回闻"</h2>
              <div class="card-foot">
                <van-image
                        round
                        src="http://file.cos.leapy.cn/image/20200509/29a4a202005092052147675.jpg"
                        alt=""
                        title=""
                        lazy-load class="card-foot-image"/>
                <span class="card-foot-author">cfn</span>
                <img src="@/assets/iconfont/zuji.svg" width="20" height="20" class="card-foot-zuji"/>
                <span class="card-foot-num">200</span>
                <span class="card-foot-time">20分钟之前</span>
              </div>
            </a>
          </div>
          <div class="card">
            <a href="/details/2" title="此景只应天上有，人间能得几回闻">
              <van-row>
                <van-col span="15">
                  <h1 class="card-title2">此景只应天上有，人间能得几回闻</h1>
                  <h2 class="card-desc">我们本应珍惜,而物欲的膨胀带动下的所谓现代科学的发展,却正在无度的破坏着我们原本美好的家园,如此下去,也许有一天,梦中只有 “此景只应天上有,人间得有几回闻"</h2>
                </van-col>
                <van-col span="9">
                  <div class="card-image2">
                    <van-image src="http://file.cos.leapy.cn/image/20200510/e570d202005102121265003.jpg" alt="" title="" lazy-load/>
                  </div>
                </van-col>
              </van-row>
              <div class="card-foot">
                <van-image
                        round
                        src="http://file.cos.leapy.cn/image/20200509/29a4a202005092052147675.jpg"
                        alt=""
                        title=""
                        lazy-load class="card-foot-image"/>
                <span class="card-foot-author">cfn</span>
                <img src="@/assets/iconfont/zuji.svg" width="20" height="20" class="card-foot-zuji"/>
                <span class="card-foot-num">200</span>
                <span class="card-foot-time">20分钟之前</span>
              </div>
            </a>
          </div>
        </van-list>
      </van-tab>
      <van-tab title="TP6">TP6</van-tab>
      <van-tab title="小程序">小程序开发</van-tab>
      <van-tab title="公众号">公众号</van-tab>
      <van-tab title="VUE">VUE</van-tab>
    </van-tabs>
  </div>
</template>

<script>
// @ is an alias to /src
import Vue from 'vue';

import {NavBar,Toast} from 'vant';
import { Tab, Tabs } from 'vant';
import { Col, Row } from 'vant';
import { List } from 'vant';

Vue.use(Col);
Vue.use(Row);
Vue.use(Tab);
Vue.use(Tabs);
Vue.use(NavBar);
Vue.use(List);

export default {
  data() {
    return {
      list:[],
      active: 0,
      loading: false,
      finished: false,
    };
  },
  methods: {
    onClickLeft() {
      window.location.href = "/"
    },
    onClickRight() {
      Toast('搜索');
    },
    onLoad() {
      // 异步更新数据
      // setTimeout 仅做示例，真实场景中一般为 ajax 请求
      console.log(111)
      setTimeout(() => {
        for (let i = 0; i < 10; i++) {
          this.list.push(this.list.length + 1);
        }
        // 加载状态结束
        this.loading = false;
        // 数据全部加载完成
        if (this.list.length >= 40) {
          this.finished = true;
        }
      }, 1000);
    },
  },
}
</script>

<style>
  .van-tabs__line{
    background: rgba(255,235,59,0.5) !important;
    bottom: 30px !important;
    height: 6px !important;
  }
  .card{
    margin: 10px;
    background: #ffffff;
    border-radius: 5px;
    overflow: hidden;
  }
  .card-image{
    width: 100%;
    height: 160px;
    overflow: hidden;
  }
  .card-image2{
    overflow: hidden;
    margin: 10px;
  }
  .card-title{
    font-size: 15px;
    margin: 0 10px;
    color: #383838;
    line-height: 38px;
    white-space: nowrap;
    text-overflow:ellipsis;
    overflow:hidden;
  }
  .card-title2{
    font-size: 15px;
    margin: 10px 10px;
    color: #383838;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow:hidden;
  }
  .card-desc{
    margin: 0 10px;
    font-size: 12px;
    color: #999;
    overflow: hidden;
    -webkit-line-clamp: 2;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    line-height: 16px;
  }
  .card-foot{
    margin: 15px 10px;
  }
  .card-foot-image{
    width: 20px;
    height: 20px;
  }
  .card-foot-author{
    color: #777;
    vertical-align: 26%;
    margin-left: 5px;
  }
  .card-foot-time{
    float: right;
    color: #888;
    font-size: 12px;
    margin-top: 3px;
  }
  .tab{
    margin-top: 45px;
  }
  .card-image2 .van-image img{
    width: 100%;
    height: 80px;
  }
  .card-foot-zuji{
    margin-left: 10px;
  }
  .card-foot-num{
    color: #777;
    vertical-align: 25%;
    margin-left: 5px;
  }
</style>
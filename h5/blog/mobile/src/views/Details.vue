<template>
    <div class="details">
        <header>
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
                    <img width="24" height="24" src="@/assets/iconfont/btn_return.svg" alt="返回" title="返回"/>
                </template>
                <template #right>
                    <img src="@/assets/iconfont/search.svg" width="24" height="24" alt="搜索" title="搜索"/>
                </template>
            </van-nav-bar>
        </header>
        <div class="page-footer-body">
            <van-skeleton title avatar :row="3" animate/>
        </div>
        <footer>
            <div class="page-footer">
                <van-row class="page-footer-con">
                    <van-col span="12">
                        <van-field
                                class="page-footer-comment"
                                name="comment"
                                placeholder="未登录"
                                border
                                readonly
                        />
                    </van-col>
                    <van-col span="3" class="page-footer-btn">
                        <img src="@/assets/iconfont/tianxie.svg" width="24" height="24" alt="评论" title="评论"/>
                    </van-col>
                    <van-col span="3" class="page-footer-btn">
                        <img src="@/assets/iconfont/shoucang.svg" width="24" height="24" alt="收藏" title="收藏"/>
                    </van-col>
                    <van-col span="3" class="page-footer-btn">
                        <img src="@/assets/iconfont/shanglast.svg" width="24" height="24" alt="打赏" title="打赏"/>
                    </van-col>
                    <van-col span="3" class="page-footer-btn">
                        <img src="@/assets/iconfont/weixin.svg" width="24" height="24" alt="分享" title="分享"/>
                    </van-col>
                </van-row>

            </div>
        </footer>
    </div>
</template>

<script>
    import Vue from 'vue';
    import {NavBar, Toast} from 'vant';
    import { Field } from 'vant';
    import { Col, Row } from 'vant';
    import { Skeleton } from 'vant';

    Vue.use(Skeleton);
    Vue.use(Col);
    Vue.use(Row);
    Vue.use(Field)
    Vue.use(NavBar);

    export default {
        data(){
            return {

            };
        },
        methods: {
            onClickLeft() {
                if (window.history.length <= 1) {
                    this.$router.push({ path: "/" });
                    return false;
                } else {
                    this.$router.go(-1);
                }
            },
            onClickRight() {
                Toast('搜索');
            },
        }
    }
</script>

<style scoped>
    /deep/ .page-footer-comment input{
        padding: 0 10px !important;
        background: #eee !important;
        border-radius: 5px !important;
    }
    body{
        background: #fff !important;
    }
    .page-footer{
        position: fixed;
        bottom: 0;
        width: 100%;
        background: #ffffff;
        height: 44px;
        line-height: 44px;
        overflow: hidden;
    }
    .page-footer-btn{
        text-align: center;
        line-height: 60px;
    }
    .page-footer-con{
        margin: 0 10px 0 20px;
    }
    .page-footer-comment{
        padding: 5px 10px 0 0 !important;
        line-height: 34px;
    }
    .page-footer-body{
        margin: 65px 20px;
        background: #fff;
    }
</style>
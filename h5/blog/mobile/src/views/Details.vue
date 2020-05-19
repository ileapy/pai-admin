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
            <van-skeleton title style="margin: 20px 0;" :loading="loading">
                <h1 class="d-title">Python和R之间转换的基本指南:使用Python或R知识来有效学习另一种语言的简单方法。</h1>
            </van-skeleton>
            <van-skeleton title style="margin: 20px 0;" :loading="loading">
                <div class="d-head">
                    <van-image
                            round
                            src="http://file.cos.leapy.cn/image/20200509/29a4a202005092052147675.jpg"
                            alt=""
                            title=""
                            lazy-load class="card-foot-image"/>
                    <span class="d-author">cfn</span>
                    <span class="d-time">25分钟之前</span>
                    <span class="d-copyright">原创</span>
                    <span class="d-tuijian">推荐</span>
                    <span class="d-zhuanfa">转发</span>
                </div>
            </van-skeleton>
            <van-skeleton title avatar :row="12" :loading="loading">
                <p>这里介绍的方法与我们自学习外语的时候使用的方法是有共同之处的，例如我们要学习英语，可以使用以下三个关键的练习帮助我从笨拙地将中文单词翻译成英语，转变为直接用英语思考和回答（英语思维）。</p>
                <p>把新的英语单词和我已经知道的中文单词关联起来。把英语和中文的单词作比较，使我能很快地领会这个生词的意思。</p>
                <p>重复这个词很多次，并在许多不同的场景中使用它，把这个词深深地刻在我的脑海里。</p>
                <p>利用上下文线索使我能够更好地理解这个词在同义词上的用法和原因。</p>
                <p>当你第一次学习编码时，重复和语境化是必不可少的。通过不断的重复，你开始记住词汇和语法。通过项目开发，你能够理解如何以及为什么使用不同的功能和技术，并开始看到在不同的上下文环境中如何使用的代码。但是不一定有一种简单的方法可以把新的思维方式和你所说的语言联系起来，这意味着你不仅要记住一个单词，而是要对每一个编程概念有一个新的理解。甚至你写的第一行代码，print（“你好，世界！“）要求您了解print函数的工作原理、编辑器如何返回print语句以及何时使用引号。当你学习第二种编程语言时，你可以将你所知道的语言中的概念翻译成新的语言，从而更有效、更快地学习。</p>
                <p>数据科学的世界被Python的拥护者和R的狂热者分割开来。但是，任何学习过其中一种语言的人，都应该充分利用它们的优势，深入到另一种语言中去，而不是宣称自己是一方。Python和R之间有着无限的相似性，而且这两种语言都是您可以使用的，您可以用最好的方式解决挑战，而不是将自己限制在工具库的一半。</p>
                <p>下面是一个连接R和Python的简单指南，便于两者之间的转换。通过建立这些连接、反复与新语言交互以及与项目的上下文化，任何理解Python或R的人都可以快速地开始在另一种语言中编程。</p>
            </van-skeleton>
            <van-skeleton title avatar :row="3" :loading="loading"/>
            <van-skeleton title avatar :row="3" :loading="loading"/>
            <van-skeleton title avatar :row="3" :loading="loading"/>
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
                loading:false
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
    .card-foot-image {
        width: 20px;
        height: 20px;
    }
    .details{
        width: 100%;
        height: 100%;
        background: #fff;
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
        padding: 45px 20px;
    }
    .d-title{
        font-size: 20px;
        -webkit-line-clamp: 2;
        text-overflow: ellipsis;
        display: -webkit-box;
        overflow: hidden;
        -webkit-box-orient: vertical;
    }
    /deep/ .d-author{
        color: #777;
        vertical-align: 5%;
        margin-left: 5px;
    }
    .d-time ,.d-copyright ,.d-zhuanfa,.d-tuijian{
        float: right;
        font-size: 12px;
        margin-left: 10px;
        color: #888;
    }
    .d-copyright ,.d-zhuanfa ,.d-tuijian{
        color: #ff9800;
    }
    .d-head{
        height: 30px;
        line-height: 30px;
        border-bottom: 1px solid #eee;
        padding-bottom: 5px;
    }
</style>
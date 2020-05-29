<template>
    <div>
        <van-form @submit="onSubmit">
            <van-field
                    v-model="tel"
                    label-align="right"
                    label="手机号"
                    placeholder="手机号"
                    :rules="[{ pattern : /^1(3|4|5|6|7|8|9)\d{9}$/,message: '手机号填写有误！'}]"
            />
            <van-field
                    v-model="sms"
                    label-align="right"
                    center
                    clearable
                    label="短信验证码"
                    :rules="[{ required: true }]"
            >
                <template #button>
                    <van-button size="small" type="primary" native-type="button">发送验证码</van-button>
                </template>
            </van-field>
            <div style="margin: 16px;">
                <van-button round block type="info" native-type="submit">
                    登录
                </van-button>
            </div>
        </van-form>
    </div>
</template>

<script>
    import Vue from 'vue';
    import store from '../store'
    import {_URL,parseQuery} from "../utils";
    import cookie from "../utils/cookie";
    import router from "../router";
    import { Form } from 'vant';
    import { Field } from 'vant';

    Vue.use(Field);
    Vue.use(Form);

    export default {
        data(){
            return {
                loading:false,
                tel: '',
                sms: '',
            };
        },
        mounted() {
            if (store.state.isLogin) router.replace({path:cookie.get("login_back_url")});
            if (store.state.isWeChat)
            {
                const { fullPath } = router.currentRoute;
                const parse = parseQuery(fullPath)
                if ('token' in parse)
                {
                    store.state.isLogin = true;
                    store.state.token = parse['token'];
                    cookie.set("token",parse['token'],60*60*24);
                    router.replace({path:cookie.get("login_back_url")})
                    cookie.remove("login_back_url");
                }
                else window.location.href = _URL+"/blog/auth/code";
            }
        },
        methods: {
            onSubmit(values) {
                console.log('tel', this.tel);
                console.log('sms', this.sms);
            },
        }
    }
</script>

<style scoped>

</style>
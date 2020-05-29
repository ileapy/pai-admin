<template>
    <div>
        <van-button round block type="info" native-type="submit" @click="login">
            授权登录
        </van-button>
    </div>
</template>

<script>
    import store from '../store'
    import {_URL,parseQuery} from "../utils";
    import cookie from "../utils/cookie";
    import router from "../router";

    export default {
        data(){
            return {
                loading:false
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
            login(){
                console.log(111)
            }
        }
    }
</script>

<style scoped>

</style>
<template>
    <div>
        <van-button round block type="info" native-type="submit" @click="login">
            授权登录
        </van-button>
    </div>
</template>

<script>
    import store from '../store'
    import {_URL} from "../utils";

    export default {
        data(){
            return {
                loading:false
            };
        },
        mounted() {
            if (store.state.isWeChat)
            {
                window.location.href = _URL+"/blog/auth/code";
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
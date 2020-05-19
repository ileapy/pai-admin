<template>
    <div>
        <van-button round block type="info" native-type="submit" @click="login">
            授权登录
        </van-button>
    </div>
</template>

<script>

    export default {
        data(){
            return {
                loading:false
            };
        },
        mounted() {
            if (store.state.isWeChat)
            {
                require
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
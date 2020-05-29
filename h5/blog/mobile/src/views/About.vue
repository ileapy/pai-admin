<template>
  <div class="about">
    <h1>This is an about page</h1>
  </div>
</template>
<script>
  import store from '../store'
  export default {
    data(){
      return {
      };
    },
    mounted() {
      console.log(store.state.token)
    },
    methods: {

    }
  }
</script>

<style scoped>

</style>
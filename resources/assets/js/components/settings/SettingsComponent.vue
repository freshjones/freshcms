<template>
  <div class="overlay" v-if="state.settings.isActive">
    Settings Interface {{ this.state.settings.authentication.email }}
  </div>
</template>

<script>
  export default {
    data: function(){
      return {
        state:Store.state
      }
    },
    methods:{
      toggle(){
        if(this.state.settings.authentication.authenticated)
          Store.setSetting('isActive',!this.state.settings.isActive);
      }
    }
  }
</script>

<style scoped>
  .overlay
  {
    position:absolute;
    width:100%;
    height:100%;
    top:0;
    left:0;
    background:rgba(0,0,0,0.85);
    z-index: 9999;
  }
</style>

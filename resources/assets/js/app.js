require('./bootstrap');

window.Vue = require('vue');

//Simple DataStore
window.Store = {
  state: {
    sections: [],
    billboards: [],
    settings: {
      isActive:false
    }
  },
  setState(name,value) {
    this.state[name] = value
  },
  setSetting(name,value) {
    this.state.settings[name] = value
  }
}

Vue.filter('yesno', function (value) {
  return parseInt(value) ? 'Yes' : 'No';
})


import Sections from './components/sections/SectionsComponent.vue'
import Billboards from './components/billboards/BillboardsComponent.vue'
//import Settings from './components/settings/SettingsComponent.vue'

const app = new Vue({
  el: '#app',
  components: {
    Sections,
    Billboards,
  },
  mounted(){
    /*
    axios.get('/authenticate')
      .then(response => {
        Store.setSetting('authentication',response.data);
      })
      .catch(error => {

      });
    */
  }
});

window.app = app


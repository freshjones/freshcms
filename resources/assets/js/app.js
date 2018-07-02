require('./bootstrap');

window.Vue = require('vue');

window.Store = {
  state: {
    sections: [],
    billboards: []
  },
  setState(name,value) {
    this.state[name] = value
  },
  setBillboardData (data) {
    this.state.billboards = data
  }
}

Vue.filter('yesno', function (value) {
  return parseInt(value) ? 'Yes' : 'No';
})


import Sections from './components/sections/SectionsComponent.vue'
import Billboards from './components/BillboardsComponent.vue'

const app = new Vue({
  el: '#app',
  components: {
    Sections,
    Billboards,
  },
});



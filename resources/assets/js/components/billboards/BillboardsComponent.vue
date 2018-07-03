<template>
  <div>
    <button type="button" class="btn btn-outline-primary mb-3" @click="handleModalToggle">Add Screen</button>
    <div class="border rounded p-3" >
      <div>
        <bb-list :page="page" :section="section"></bb-list>
        <bb-form style="position:fixed; height: 100%; width:100%; top:0; left:0;  background-color: rgba(0,0,0,0.8);" :page="page" :section="section" @close-modal="handleModalToggle"  :class="{ 'd-none' : isHidden }"></bb-form>
      </div>
    </div>
  </div>
</template>

<script>

    import bbList from './BillboardListComponent.vue'
    import bbForm from './BillboardFormComponent.vue'

    export default {
        components: {
          bbList,
          bbForm,
        },
        props: [
            'page',
            'section',
        ],
        data: function(){
            return {
                isHidden: true
            }
        },
        methods: {
          handleModalToggle: function(newData) {
            this.isHidden = !this.isHidden;
          }
        },
        mounted() {
          axios.get('/billboard_screen/' + this.page + '/' + this.section)
            .then(response => {
              Store.setState('billboards',response.data);
            })
            .catch(error => {
              console.log('oops');
            });
        }
    }
</script>

<template>
  <div>
    <draggable v-model="state.billboards" @end="onDraggableEnd" :options="{handle:'.handle'}">
      <transition-group>
        <div v-for="(billboard,index) in state.billboards" :key="index">
          <div class="border my-2 px-3 py-2 rounded bb-row">
              <div v-if="editing === index">
                <list-row-edit 
                  :page="page" 
                  :section="section" 
                  :index="index" 
                  :billboard="billboard" 
                  :editing="editing" 
                  @toggle-edit-screen="toggleEditScreen">
                </list-row-edit>
              </div>
              <div v-else>
                <list-row 
                  :billboard=billboard 
                  :index="index" 
                  :editing="editing" 
                  @toggle-edit-screen="toggleEditScreen">
                </list-row>
              </div>
            </div>
        </div>
      </transition-group>
    </draggable>
  </div>
</template>

<script>
  
  import draggable from 'vuedraggable'
  import listRow from './BillboardListRow'
  import listRowEdit from './BillboardListRowEdit'

  export default {
    components: {
      draggable,
      listRow,
      listRowEdit,
    },
    props: [
      'page',
      'section',
    ],
    data: function(){
      return {
          state:Store.state,
          editing:null
      }
    },
    methods: {

      toggleEditScreen(idx)
      {
        this.editing = idx;
      },
      onDraggableEnd() {

        axios.patch('/billboard/sort/' + this.page + '/' + this.section, this.state.billboards)
          .then(response => {
            console.log(response.data);
          })
          .catch(error => this.errors = errors.response.data);
      
      }

    }

  }
</script>

<style>
  .gripper
  {
    display:block; 
    width:20px; 
    height:20px; 
    overflow:hidden;
    color:#ccc;
    cursor:move;
  }

  .overlay
  {
    position: absolute;
    top:0;
    left:0;
    width:100%;
    height: 100%;
    background-color: rgba(255,255,255,0.8);
  }
  .feather
  {
    width:100%;
    height:100%;
    color:inherit;
  }

  .bb-bg
  {
    background-size: cover;
    width:150px;
    height:100px;
  }

  .bb-row
  {
    position:relative;
  }

  .bb-edit
  {
    position:absolute;
    right:10px;
    top:10px;
    color:#ccc;
    width:20px;
    height:20px;
    cursor:pointer;
  }

  .bb-edit:hover
  {
    color:#0069d9;
  }
</style>

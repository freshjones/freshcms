<template>
  <div>
    <div class="sections" v-if="isMounted">
      <div class="working" :class="{ 'd-none' : !isWorking }">
        <div>
          <div class="loader"></div>
        </div>
      </div>
      <div v-if="state.sections.length">
        <draggable v-model="state.sections" @end="onDraggableEnd" :options="{handle:'.handle'}">
          <div class="border my-2 px-3 py-2 rounded" v-for="(section,index) in state.sections" :key="index">
            
            <div class="d-flex align-items-center">
              <div class="handle d-flex"><span class="gripper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-move"><polyline points="5 9 2 12 5 15"></polyline><polyline points="9 5 12 2 15 5"></polyline><polyline points="15 19 12 22 9 19"></polyline><polyline points="19 9 22 12 19 15"></polyline><line x1="2" y1="12" x2="22" y2="12"></line><line x1="12" y1="2" x2="12" y2="22"></line></svg></span></div>
              <div class="col">
                <h3 class="m-0"><a href="/">{{ section.label }}</a></h3>
                <p class="small text-uppercase text-muted m-0 p-0"><span class="font-weight-bold text-dark">Id:</span>  <span class="font-weight-bold text-dark">Type:</span>  <span class="font-weight-bold text-dark">Display:</span> </p>
              </div>
              <div class=" ">
                  <div class="mx-1">
                    <a :href="getEditLink(page,section,index)" role="button" class="btn btn-primary">Edit</a>
                  </div>
              </div>
            </div>

          </div>
        </draggable>
      </div>
      <div v-else>No sections yet</div>
    </div>
    <div v-else>
      <div class="border my-2 px-3 py-2 rounded dummy"></div>
      <div class="border my-2 px-3 py-2 rounded dummy"></div>
      <div class="border my-2 px-3 py-2 rounded dummy"></div>
      <div class="border my-2 px-3 py-2 rounded dummy"></div>
    </div>
  </div>
</template>

<script>

  import draggable from 'vuedraggable'

  export default {
    props: [
      'page',
    ],
    components: {
      draggable,
    },
    data: function(){
      return {
        state:Store.state,
        isWorking: false,
        isMounted:false,
      }
    },
    methods: {

      getEditLink: function(page,section,index){
        if(section.type == 'billboards') section.type = 'billboard';
        return '/' + section.type + '/edit/' + page + '/' + index;
      },
      toggleLoader: function() {
        this.isWorking = !this.isWorking;
      },
      onDraggableEnd: function(event) {

        this.toggleLoader();
      
        axios.patch('/section/sort/' + this.page, this.state.sections)
          .then(response => {
            this.toggleLoader();
          })
          .catch(error => this.errors = errors.response.data);
      
      }

    },
    mounted() {
      axios.get('/section/' + this.page)
        .then(response => {
          this.isMounted = true;
          Store.setState('sections',response.data);
        })
        .catch(error => {
          console.log('oops');
        });
    }
  }
</script>

<style>
  .sections
  {
    position:relative;
  }

  .dummy
  {
    background-color:#f9f9f9;
    min-height: 66px;
  }
  .working
  {
    position:absolute;
    width:100%;
    height: 100%;
    top:0;
    left:0;
    background-color: rgba(255,255,255,0.8);
    z-index: 10;
  }

  .working > div
  {
    width:inherit;
    height: inherit;
    display:flex;
    justify-content: center;
    align-items: center;
  }

  .loader {
      border: 4px solid #f3f3f3;
      border-top: 4px solid #0069d9;
      border-radius: 50%;
      width: 75px;
      height: 75px;
      animation: spin 1s linear infinite;
  }

  @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
  }

  .gripper
  {
    display:block; 
    width:20px; 
    height:20px; 
    overflow:hidden;
    color:#ccc;
    cursor:move;
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
</style>

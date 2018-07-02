<template>
  <div>
    <div class="d-flex align-items-center">
      <div class="handle d-flex"><span class="gripper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-move"><polyline points="5 9 2 12 5 15"></polyline><polyline points="9 5 12 2 15 5"></polyline><polyline points="15 19 12 22 9 19"></polyline><polyline points="19 9 22 12 19 15"></polyline><line x1="2" y1="12" x2="22" y2="12"></line><line x1="12" y1="2" x2="12" y2="22"></line></svg></span></div>
      <div class="px-2">
        <div class="bb-bg" :style="{ backgroundImage: 'url(\'/storage/images/' + billboard.background + '\')' }" ></div>
      </div>
      <div class="px-2 small">
        <div>Display: {{ billboard.display | yesno }}</div>
        <div>Label: {{ billboard.label }}</div>
        <div>Heading: {{ billboard.heading }}</div>
        <div>Subheading: {{ billboard.subheading }}</div>
        <div>Link: {{ billboard.link }}</div>
      </div>
      <div class="bb-edit">
        <div @click="toggleEditScreen(index)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg></div>
      </div>
    </div>
    <div v-if="editing !== null" class="overlay"></div>
  </div>
</template>

<script>
  
  import draggable from 'vuedraggable'
  import listRow from './BillboardListRow'

  export default {
    components: {
      draggable,
      listRow,
    },
    props: [
      'billboard',
      'index',
      'editing',
    ],
    data: function(){
      return {
         
      }
    },
    methods: {

      toggleEditScreen(idx)
      {
        this.$emit('toggle-edit-screen',idx);
      },

    }

  }
</script>

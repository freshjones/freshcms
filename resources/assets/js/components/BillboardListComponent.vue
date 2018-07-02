<template>
  <div>
    <div v-if="state.billboards.length">
      <bb-list-sortable :page="page" :section="section"></bb-list-sortable>
    </div>
    <p v-else>No billboards yet</p>
  </div>
</template>

<script>
  import bbListSortable from './BillboardListSortable.vue'
  export default {
    components: {
      bbListSortable,
    },
    props: [
      'page',
      'section',
    ],
    data: function(){
      return {
          state:Store.state
      }
    }
  }
</script>

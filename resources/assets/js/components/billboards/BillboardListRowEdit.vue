<template>
  <div>
    <form name="update-billboard-form" action="/billboard" enctype="multipart/form-data" @submit.prevent="onSubmit">
      <div class="d-flex align-items-top">
        <div class="d-flex"><span class="gripper gripper-dummy">&nbsp;</span></div>
        <div class="px-2">
          <div class="bb-bg" :style="{ backgroundImage: 'url(\'/storage/images/' + billboard.background + '\')' }" ></div>
        </div>
        <div class="col px-2">
          <div class="form-group">
            <label for="content">Display</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="display" value="0" id="bb_display_no" v-model="display" >
              <label class="form-check-label" for="bb_display_no">No</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="display" value="1" id="bb_display_yes" v-model="display" >
              <label class="form-check-label" for="bb_display_yes">Yes</label>
            </div>
          </div>
          <div class="form-group">
            <label for="content">Admin Label</label>
            <input class="form-control" type="text" name="label" value="" v-model="label">
          </div>
          <div class="form-group">
            <label for="content">Heading</label>
            <input class="form-control" type="text" name="heading" value="" v-model="heading">
          </div>
          <div class="form-group">
            <label for="content">Subheading</label>
            <input class="form-control" type="text" name="subheading" v-model="subheading">
          </div>
          <div class="form-group">
            <label for="content">Link</label>
            <input class="form-control" type="text" name="link" v-model="link">
          </div>
          <div class="form-group">
            <label for="content">Background Image</label>
            <input class="form-control-file" type="file" ref="backgroundFile" name="background" /><br/>
          </div>
          <div class="form-group d-flex justify-content-end ">
            <button type="button" class="btn btn-outline-secondary mr-2" @click="toggleEditScreen">Cancel</button>
            <button type="submit" id="submit-all" class="btn btn-primary">Submit</button>
          </div>
        </div>
        <div class="bb-edit" @click="toggleEditScreen">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
        </div>
      </div>
    </form>
  </div>
</template>

<script>

  export default {
    props: [
      'page',
      'section',
      'index',
      'billboard',
      'editing',
    ],
    data: function(){
      return {
        background: '',
        display: '',
        label: '',
        subheading:'',
        heading: '',
        link:'',  
      }
    },
    methods: {

      toggleEditScreen()
      {
        this.$emit('toggle-edit-screen',null);
      },
      onSubmit(event) {

        let formData = new FormData(event.target)
        formData.append('page_id',this.page);
        formData.append('section_id',this.section);
        formData.append('billboard_id',this.billboard.id);
        formData.append('billboard_key',this.index);
        formData.append('type','billboard');

        axios.post('/billboard_screen', formData)
          .then(response => {
            Store.setState('billboards',response.data);
            this.toggleEditScreen();
          })
          .catch(error => {

          });
      },
    },
    mounted(){
      this.display = this.billboard.display;
      this.label = this.billboard.label;
      this.heading = this.billboard.heading;
      this.subheading = this.billboard.subheading;
      this.link = this.billboard.link;
    }

  }
</script>

<style>
  .gripper-dummy
  {
    color:#fff;
    cursor:default;
  }
</style>

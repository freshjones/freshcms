<template>
  <div>
    <div class="d-flex justify-content-center align-items-center" style="width:100%; height:100%;">
      <div class="col-md-6">
        <form method="POST" name="create-billboard-form" action="/billboard" enctype="multipart/form-data" @submit.prevent="onSubmit">
          <div class="card">
            <div class="card-header">
              Add a billboard
              <button type="button" class="close" @click="closeModal">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="card-body">
                <input type="hidden" name="page_id" v-model="page_id">
                <input type="hidden" name="section_id" v-model="section_id">
                <input type="hidden" name="billboard_id" v-model="billboard_id">
                <input type="hidden" name="type" v-model="type">
                <div class="form-group">
                  <label for="content">Display</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="display" id="bb_display_no" value="0" >
                    <label class="form-check-label" for="bb_display_no">No</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="display" id="bb_display_yes" value="1" >
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
                  <input class="form-control-file" type="file" ref="backgroundFile" name="background" @change="processFile($event)"  /><br/>
                </div>

            </div>
            <div class="card-footer text-muted">
              <button type="submit" id="submit-all" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-outline-secondary" @click="closeModal">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        props: [
            'page',
            'section'
        ],
        data: function(){
            return {
                page_id: this.page,
                section_id: this.section,
                billboard_id: 'create',
                type: 'billboard',
                background: '',
                display: '',
                label: '',
                subheading:'',
                heading: '',
                link:'',
                errors:{}
            }
        },
        methods:{
          closeModal(event) {
            this.$emit('close-modal');
          },
          onSubmit(event) {

            let formData = new FormData(event.target)
            formData.append('background', this.background)
          
            axios.post('/billboard', formData)
              .then(this.onSuccess)
              .catch(error => this.errors = errors.response.data);
          },
          onSuccess(response){
            Store.setBillboardData(response.data);
            this.resetForm();
            this.$emit('close-modal');
          },
          resetForm() {
            this.display = '';
            this.label = '';
            this.subheading = '';
            this.heading = '';
            this.link = '';
            this.background = '';
            this.$refs.backgroundFile.value = '';
          },
          processFile(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
              return;
            this.$data.background = files[0];
          }
        }
    }
</script>

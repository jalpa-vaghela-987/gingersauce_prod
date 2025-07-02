<template>
  <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModal" aria-hidden="true" ref="uploadModal">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-1000">
      <div class="modal-content">
        <div class="modal-header position-relative border-0">
          <h2 class="modal-title fs-24 fw-bold text-center sec-font mx-auto" id="imageModal">
            Upload image
          </h2>
          <button type="button" class="btn-close position-absolute" data-dismiss="modal" aria-label="Close" @click="closeModel"></button>
        </div>
        <div :class="['modal-body',imageError?'was-validated':null]" >
          <div class="container-fluid">
            <p class="info text-center" v-if="!imageData">
              Click for selecting or drag and drop image
            </p>
            <vue-dropzone
              ref="myDropzone"
              id="dropzone"
              :options="dropzoneOptions"
              @vdropzone-file-added="fileAdded"
              :class="[imageError?'form-control is-invalid':'form-control']"
            ></vue-dropzone>
            <div class="invalid-feedback">
              Please select an image
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 justify-content-center py-4 mb-2 gap-2">
          <button class="btn sec-btn px-5 col-3 justify-content-center" aria-label="Close" @click.prevent="closeModel">
            Cancel
          </button>
          <button class="btn main-btn px-5 col-3 justify-content-center" aria-label="Close"
            @click.prevent="saveImage">
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import VueDropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
export default {
  components: {
    VueDropzone,
  },
  data() {
    return {
      imagePaste: '',
      imageSrc: this.imageData,
      width: 200,
      originalWidth: 0,
      originalHeight: 0,
      originalMouseX: 0,
      originalMouseY: 0,
      dropzoneOptions: {
        url: 'no-url', // No actual URL is needed since we don't perform an upload
        autoProcessQueue: false,
        maxFilesize: 1,
        maxFiles: 1,
        addRemoveLinks: true,
        acceptedFiles: 'image/jpeg,image/png,image/svg',
      },
      imageData: null,
      resizeWidth: 300, // Initial width
      resizeHeight: 300, // Initial height
      showModal:false,
      modal:null,
      imageError:false
    };
  },
  computed: {
    imageStyle() {
      return {
        width: this.width + 'px',
      };
    },
  },
  methods: {
    fileAdded(file) {
      this.imageError = false;
      const reader = new FileReader();
      reader.onload = e => {
        this.imageData = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    initResize(event) {
      this.originalWidth = this.width;
      this.originalHeight = this.height;
      this.originalMouseX = event.clientX;
      this.originalMouseY = event.clientY;
      window.addEventListener('mousemove', this.resize);
      window.addEventListener('mouseup', this.stopResize);
    },
    resize(event) {
      const dx = event.clientX - this.originalMouseX;
      const dy = event.clientY - this.originalMouseY;
      const aspectRatio = this.originalWidth / this.originalHeight;

      if (Math.abs(dx) > Math.abs(dy)) {
        this.width = this.originalWidth + dx;
        this.height = this.width / aspectRatio;
      } else {
        this.height = this.originalHeight + dy;
        this.width = this.height * aspectRatio;
      }
    },
    stopResize() {
      window.removeEventListener('mousemove', this.resize);
      window.removeEventListener('mouseup', this.stopResize);
      this.imagePaste = new Object({ src: this.imageData, width: this.width });
    },
    saveImage() {
      if (this.imageData) {
        this.imagePaste = new Object({ src: this.imageData, width: this.width });
        this.$emit('save-image', this.imageData);
        this.imageData = null;
        this.imagePaste = '';
        this.showHideModal();
      }else{
        this.imageError = true;
      }
    },
    showHideModal(){
      this.imageError = false;
      !this.showModal ? this.modal.show() : this.modal.hide();
      this.showModal = !this.showModal;
    },
    closeModel() {
        this.imageData = null;
        this.imagePaste = '';
        this.$emit('save-image', this.imagePaste);
        this.$refs.myDropzone.removeAllFiles();
        this.showHideModal();
    },
    removeIconModelFiles() {
        this.imageData = null;
        this.imagePaste = '';
        this.$emit('save-image', this.imagePaste);
        this.$refs.myDropzone.removeAllFiles();
    }
  },
  mounted() {
    const modalElem = this.$refs.uploadModal;
    this.modal  = new window.bootstrap.Modal(modalElem,{
                    backdrop: 'static',
                    keyboard: false
                  });
    const img = new Image();
    img.src = this.imageData;
    img.onload = () => {
      const aspectRatio = img.width / img.height;
      if (img.width >= img.height) {
        this.width = 200;
        this.height = 200 / aspectRatio;
      } else {
        this.height = 200;
        this.width = 200 * aspectRatio;
      }
    };
  },
};
</script>

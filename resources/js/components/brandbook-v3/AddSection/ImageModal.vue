<template>
  <div
    class="modal fade"
    id="imageModal"
    tabindex="-1"
    aria-labelledby="imageModal"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered modal-lg modal-1000">
      <div class="modal-content">
        <div class="modal-header position-relative border-0">
          <h2 class="modal-title fs-24 fw-bold text-center sec-font mx-auto" id="imageModal">
            Upload image
          </h2>
          <button
            type="button"
            class="btn-close position-absolute"
            data-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <p class="info text-center" v-if="!imageData">
              Click for selecting or drag and drop image
            </p>
            <vue-dropzone
              v-if="!imageData"
              ref="myDropzone"
              id="dropzone"
              :options="dropzoneOptions"
              @vdropzone-file-added="fileAdded"
            ></vue-dropzone>
            <p class="info text-center" v-if="imageData">
              Drag with right bottom corner for resizing image
            </p>
            <div
              v-if="imageData"
              ref="imageContainer"
              class="resizable-image"
              @mousedown="initResize"
            >
              <img :src="imageData" :style="imageStyle" />
              <div class="resizer"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 justify-content-center py-4 mb-2 gap-2">
          <button
            class="btn sec-btn px-5 col-3 justify-content-center"
            aria-label="Close"
            data-dismiss="modal"
          >
            Cancel
          </button>
          <button
            class="btn main-btn px-5 col-3 justify-content-center"
            aria-label="Close"
            data-dismiss="modal"
            @click="saveImage"
          >
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
      imageData: null,
      dropzoneOptions: {
        url: 'no-url', // No actual URL is needed since we don't perform an upload
        autoProcessQueue: false,
        maxFiles: 1,
        addRemoveLinks: true,
        acceptedFiles: 'image/*',
      },
      width: 200,
      height: 200,
      originalWidth: 0,
      originalHeight: 0,
      originalMouseX: 0,
      originalMouseY: 0,
      aspectRatio: 1,
    };
  },
  computed: {
    imageStyle() {
      return {
        width: this.width + 'px',
        height: this.height + 'px',
      };
    },
  },
  methods: {
    fileAdded(file) {
      const reader = new FileReader();
      reader.onload = e => {
        this.imageData = e.target.result;
        this.setImageDimensions();
      };
      reader.readAsDataURL(file);
    },
    setImageDimensions() {
      const img = new Image();
      img.src = this.imageData;
      img.onload = () => {
        this.aspectRatio = img.width / img.height;
        if (img.width >= img.height) {
          this.width = 200;
          this.height = 200 / this.aspectRatio;
        } else {
          this.height = 200;
          this.width = 200 * this.aspectRatio;
        }
      };
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
      if (Math.abs(dx) > Math.abs(dy)) {
        this.width = this.originalWidth + dx;
        this.height = this.width / this.aspectRatio;
      } else {
        this.height = this.originalHeight + dy;
        this.width = this.height * this.aspectRatio;
      }
    },
    stopResize() {
      window.removeEventListener('mousemove', this.resize);
      window.removeEventListener('mouseup', this.stopResize);
    },
    saveImage() {
      const imagePaste = { src: this.imageData, width: this.width, height: this.height };
      this.$emit('save-image', imagePaste);
      this.imageData = null;
    },
  },
  mounted() {
    if (this.imageData) {
      this.setImageDimensions();
    }
  },
};
</script>

<style scoped>
.resizable-image {
  position: relative;
  display: inline-block;
}
.resizable-image img {
  display: block;
}
.resizer {
  width: 10px;
  height: 10px;
  background: #000;
  position: absolute;
  right: 0;
  bottom: 0;
  cursor: se-resize;
}
</style>

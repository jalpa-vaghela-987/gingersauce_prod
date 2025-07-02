<template>
  <div>
    <p class="info text-center" v-if="!imageData">Click for selecting or drag and drop image</p>
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
    <div v-if="imageData" ref="imageContainer" class="resizable-image" @mousedown="initResize">
      <img :src="imageData" :style="imageStyle" />
      <div class="resizer"></div>
    </div>
  </div>
</template>

<script>
import VueDropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';

export default {
  name: 'ImageUploader',
  components: {
    VueDropzone,
  },
  data() {
    return {
      imageSrc: this.imageData,
      width: 200,
      originalWidth: 0,
      originalHeight: 0,
      originalMouseX: 0,
      originalMouseY: 0,
      dropzoneOptions: {
        url: 'no-url', // No actual URL is needed since we don't perform an upload
        autoProcessQueue: false,
        maxFiles: 1,
        addRemoveLinks: true,
        acceptedFiles: 'image/*',
      },
      imageData: null,
      resizeWidth: 300, // Initial width
      resizeHeight: 300, // Initial height
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
    },
  },
  mounted() {
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

<style>
.wrapper-resize {
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  border: 1px solid #ccc;
  padding: 10px;
}
</style>

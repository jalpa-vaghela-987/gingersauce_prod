<template>
  <div>
    <vue-dropzone
      v-if="!imageData"
      ref="myDropzone"
      id="dropzone"
      :options="dropzoneOptions"
      @vdropzone-file-added="fileAdded"
    ></vue-dropzone>

    <div v-if="imageData" class="wrapper-cropper">
      <div>
        <img :src="imageData" ref="image" alt="Image to crop" />
      </div>
      <button @click="cropImage">Crop Image</button>
    </div>

    <div v-if="croppedImage">
      <h3>Cropped Image:</h3>
      <img :src="croppedImage" alt="Cropped Image" />
    </div>
  </div>
</template>

<script>
import VueDropzone from 'vue2-dropzone';
import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';

export default {
  name: 'ImageUploader',
  components: {
    VueDropzone,
  },
  data() {
    return {
      dropzoneOptions: {
        url: 'no-url', // No actual URL is needed since we don't perform an upload
        autoProcessQueue: false,
        maxFiles: 1,
        addRemoveLinks: true,
        acceptedFiles: 'image/*',
      },
      imageData: null,
      croppedImage: null,
      cropper: null,
    };
  },
  methods: {
    fileAdded(file) {
      const reader = new FileReader();
      reader.onload = e => {
        this.imageData = e.target.result;
        this.$nextTick(() => {
          this.initCropper();
        });
      };
      reader.readAsDataURL(file);
    },
    initCropper() {
      if (this.cropper) {
        this.cropper.destroy();
      }
      const imageElement = this.$refs.image;
      this.cropper = new Cropper(imageElement, {
        // naturalWidth: 400,
        aspectRatio: 1,
        viewMode: 2,
        // scalable: false,

        minContainerWidth: 800,
        minContainerHeight: 600,
      });
    },
    cropImage() {
      this.croppedImage = this.cropper.getCroppedCanvas().toDataURL();
    },
  },
};
</script>

<style scoped>
#dropzone {
  border: 2px dashed #007bff;
  border-radius: 5px;
  padding: 20px;
  text-align: center;
}
</style>

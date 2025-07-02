<template>
  <div>
    <div
      class="modal fade"
      id="headingModalEdit"
      tabindex="-1"
      aria-labelledby="headingModalEdit"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg modal-1000">
        <div class="modal-content">
          <div class="modal-header position-relative border-0">
            <h1
              class="modal-title fs-32 fw-bold text-center sec-font mx-auto"
              id="headingModalEdit"
            >
              Edit heading
            </h1>
            <button
              type="button"
              class="btn-close position-absolute"
              data-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <input
                type="text"
                v-model="headerText"
                class="form-control form-control-lg border-dark text-dark fw-500"
              />
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
              @click="saveChanges"
            >
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="textModalEdit"
      tabindex="-1"
      aria-labelledby="textModalEdit"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg modal-1000">
        <div class="modal-content">
          <div class="modal-header position-relative border-0">
            <h1 class="modal-title fs-32 fw-bold text-center sec-font mx-auto" id="textModalEdit">
              Edit text
            </h1>
            <button
              type="button"
              class="btn-close position-absolute"
              data-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <ckeditor
                :editor="editor"
                v-model="simpleText"
                :config="editorConfig"
                :height="330"
              ></ckeditor>
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
              @click="saveChanges"
            >
              Save
            </button>
          </div>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="imageModalEdit"
      tabindex="-1"
      aria-labelledby="imageModalEdit"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg modal-1000">
        <div class="modal-content">
          <div class="modal-header position-relative border-0">
            <h2 class="modal-title fs-24 fw-bold text-center sec-font mx-auto" id="imageModalEdit">
              Change image size
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
              <div v-if="imageData" class="mt-2">
                <button @click="imageData = ''" class="btn sec-btn mx-auto">Delete</button>
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
              @click="saveChanges"
            >
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import CKEditor from '@ckeditor/ckeditor5-vue2';
import { uploader } from '@/views/UploadAdapter';
import VueDropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
import { EventBus } from '../../eventBus.js';

export default {
  data() {
    return {
      headerText: '',
      simpleText: '',
      currentElement: null,
      currentWrapper: null,
      editor: ClassicEditor,
      editorData: '',
      editorConfig: {
        placeholder: this.placeholderArray,
        extraPlugins: [uploader],
        toolbar: {
          items: [
            'heading',
            'numberedList',
            'bulletedList',
            'bold',
            'italic',
            'uploadImage',
            'mediaEmbed',
            'undo',
            'redo',
          ],
        },
      },

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
        maxFiles: 1,
        addRemoveLinks: true,
        acceptedFiles: 'image/*',
      },
      imageData: null,
      resizeWidth: 300, // Initial width
      resizeHeight: 300, // Initial height
    };
  },
  components: {
    ckeditor: CKEditor.component,
    VueDropzone,
  },
  created() {
    EventBus.$on('openModal', ({ element, wrapper, text }) => {
      this.currentElement = element;
      this.currentWrapper = wrapper;
      if (element.nodeName.startsWith('H')) {
        this.headerText = text;
        $('#headingModalEdit').modal('show');
      } else if (element.nodeName == 'DIV') {
        this.simpleText = element.innerHTML;
        $('#textModalEdit').modal('show');
      } else if (element.nodeName == 'IMG') {
        this.imageData = element.src;
        this.width = element.offsetWidth;
        $('#imageModalEdit').modal('show');
      }
    });
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
      this.imagePaste = new Object({ src: this.imageData, width: this.width });
    },
    saveImage() {
      this.imagePaste = new Object({ src: this.imageData, width: this.width });
      this.$emit('save-image', this.imagePaste);
      this.imageData = '';
      this.imagePaste = ''; // Clear input after save
    },
    saveChanges() {
      if (this.currentElement) {
        if (this.currentElement.nodeName.startsWith('H')) {
          this.currentElement.textContent = this.headerText;
          $('#headingModalEdit').modal('hide');
        } else if (this.currentElement.nodeName == 'DIV') {
          this.currentElement.innerHTML = this.simpleText;
          $('#textModalEdit').modal('hide');
        } else if (this.currentElement.nodeName == 'IMG') {
          console.log(this.width);
          console.log(this.imageData);
          this.currentElement.src = this.imageData;
          this.currentElement.style.width = `${this.width}px`;
          $('#imageModalEdit').modal('hide');
        }
      }
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

<template>
  <div
    class="modal fade"
    id="textModal"
    tabindex="-1"
    aria-labelledby="textModal"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered modal-lg modal-1000">
      <div class="modal-content">
        <div class="modal-header position-relative border-0">
          <h1 class="modal-title fs-32 fw-bold text-center sec-font mx-auto" id="textModal">
            Add Text
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
              :height="height ? height : 330"
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
            @click="saveText"
          >
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import CKEditor from '@ckeditor/ckeditor5-vue2';
import { uploader } from '@/views/UploadAdapter';

export default {
  props: ['placeholderArray', 'showMenubar', 'height'],
  components: {
    ckeditor: CKEditor.component,
  },
  data() {
    return {
      simpleText: '',
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
    };
  },

  methods: {
    saveText() {
      this.$emit('save-text', this.simpleText);
    },
  },
};
</script>

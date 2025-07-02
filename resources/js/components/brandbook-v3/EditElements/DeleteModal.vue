<template>
  <div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    aria-labelledby="deleteModal"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered modal-lg modal-1000">
      <div class="modal-content">
        <div class="modal-header position-relative border-0">
          <h1 class="modal-title fs-32 fw-bold text-center sec-font mx-auto mt-2" id="deleteModal">
            Are you sure want delete the element?
          </h1>
          <button
            type="button"
            class="btn-close position-absolute"
            data-dismiss="modal"
            aria-label="Close"
          ></button>
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
            @click="deleteElement"
          >
            Yes
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { EventBus } from '../../eventBus.js';
export default {
  created() {
    EventBus.$on('openModalDelete', ({ element, wrapper, text }) => {
      this.currentElement = element;
      this.currentWrapper = wrapper;
      $('#deleteModal').modal('show');
    });
  },
  methods: {
    deleteElement() {
      if (this.currentElement) {
        this.currentElement.nextSibling.remove();
        this.currentElement.remove();
      }
    },
  },
};
</script>

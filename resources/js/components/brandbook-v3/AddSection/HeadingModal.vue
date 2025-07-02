<template>
  <div
    class="modal fade"
    id="headingModal"
    tabindex="-1"
    aria-labelledby="headingModal"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered modal-lg modal-1000">
      <div class="modal-content">
        <div class="modal-header position-relative border-0">
          <h1 class="modal-title fs-32 fw-bold text-center sec-font mx-auto" id="headingModal">
            Add Heading
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
              v-model="headerText"
              class="form-control form-control-lg border-dark text-dark fw-500"
              type="text"
              placeholder="Paste your header here"
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
            @click="saveHeader"
          >
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      headerText: '',
    };
  },
  methods: {
    saveHeader() {
      this.$emit('save-header', this.headerText);
      this.headerText = ''; // Clear input after save
    },
  },
};
</script>

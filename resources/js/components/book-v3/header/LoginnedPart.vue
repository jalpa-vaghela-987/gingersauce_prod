<template>
  <div class="d-flex justify-content-between flex-grow-1 align-content-center">
    <div class="d-none d-xl-flex gap-2 flex-grow-0">
      <button class="btn sec-btn">
        <svg class="icon icon-generate" width="17" height="17">
          <use href="images/symbol-defs.svg#icon-generate"></use>
        </svg>
        Regenerate book
      </button>
      <!-- <button class="btn main-btn">Save changes</button>
      <button class="btn sec-btn">Cancel</button> -->
    </div>

    <div class="d-flex gap-2 flex-grow-0 ms-auto">
      <SubMenu />
    </div>
  </div>
</template>
<script setup>
import SubMenu from './SubMenu.vue';
</script>
<style scoped>
.expir-date .title {
  font-size: 10px;
  font-weight: calc(var(--secFontWeight) + 300);
  line-height: 1.1;
  text-align: left;
}
.expir-date .date {
  font-size: 18px;
  font-weight: calc(var(--secFontWeight) + 300);
  line-height: 1.1;
  text-align: left;
}
</style>

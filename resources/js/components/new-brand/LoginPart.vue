<template>
  <div class="d-flex justify-content-between flex-grow-1 align-content-center">
    <DownloadAssets />

    <div class="d-flex gap-2">
      <button class="btn main-btn">Copy link</button>
      <button class="btn sec-btn">Login</button>
    </div>
  </div>
</template>

<script setup>
import DownloadAssets from './DownloadAssets.vue';
</script>

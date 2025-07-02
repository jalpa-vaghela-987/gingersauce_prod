<template>
  <a class="btn fs-14 brandbooks position-relative ms-2 fw-500" href="#">My Brandbooks</a>
</template>
<style scoped>
.brandbooks:before {
  content: '';
  display: block;
  height: calc(100% + 10px);
  width: 1px;
  background-color: #dadada;
  position: absolute;
  left: 0px;
  top: -5px;
  bottom: -5px;
}
</style>

<template>
  <div class="misuse-block-wrapper d-flex justify-content-between flex-column">
    <div class="misuse-block-crossed">
      <div class="misuse-block" :style="misuse.style">
          <img :src="misuse.logo_b64" :alt="misuse.id" />
      </div>
    </div>
    <div class="text fs-12 mx-auto text-center">{{ misuse.title }}</div>
  </div>
</template>

<script>
export default {
  props: {
      misuse : Object
  },
};
</script>
<style>
.misuse-block-wrapper {
    height: fit-content;
    position: relative;
    max-width: 410px;
}
.misuse-block-crossed {
    height: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 90%;
    margin: 0 auto 20px;
    position: relative;
    z-index: 1;
}
.misuse-block-crossed:after {
    content: '';
    height: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: url('data:image/svg+xml,%3Csvg width="143" height="102" viewBox="0 0 143 102" fill="none" xmlns="http://www.w3.org/2000/svg"%3E%3Cline x1="141.578" y1="0.815683" x2="0.578497" y2="100.816" stroke="%23FF0000" stroke-width="2"/%3E%3C/svg%3E');
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 100% 100%, auto;
    width: 90%;
    margin: 0 auto 20px;
    position: absolute;
    z-index: 1;
    top: 0px;
    left: 5%;
}
.misuse-block {
    width: 160px;
    height: 90%;
    margin: 0 auto;
    position: relative;
    z-index: -1;
}

.misuse-block img,
.misuse-block svg {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
</style>

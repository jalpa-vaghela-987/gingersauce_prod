<template>
  <div class="icons-block-wrapper d-flex justify-content-between flex-column">
    <div class="icons-block">
        <img class="icon client-icon" :src="img"/>
    </div>
    <div class="text fs-12 mx-auto text-center">{{ text }}</div>
  </div>
</template>

<script>
export default {
  props: {
    img: String,
    text: String,
  },
};
</script>
<style>
.icons-block .client-icon {
  max-width: 60px;
  max-height: 60px;
  margin: 0 auto;
  display: block;
}
.icons-block {
  margin-bottom: 20px;
}
</style>

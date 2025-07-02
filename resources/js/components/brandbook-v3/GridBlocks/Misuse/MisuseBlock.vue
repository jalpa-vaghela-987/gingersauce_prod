<template>
  <div class="misuse-block-wrapper d-flex justify-content-between flex-column">
    <div class="misuse-block-crossed">
      <div class="misuse-block" :style="customStyle"><img :src="img" :alt="text" /></div>
    </div>
    <div class="text fs-12 mx-auto text-center">{{ text }}</div>
  </div>
</template>

<script>
export default {
  props: {
    img: String,
    text: String,
    customStyle: {
        type: [Object, Array],
        default: () => ({}),
    },
  },
};
</script>

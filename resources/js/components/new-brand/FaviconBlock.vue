<template>
    <div class="favicon-block-wrapper d-flex justify-content-between flex-column">
        <!-- Display logo based on theme -->
        <div
        class="favicon-block"
        :class="type"
        :style="{ backgroundColor: bgColor ? bgColor : '#fff'}"
        >
        <!-- Use v-html to render SVG logo -->
        <img class="favicon-icon" :src="icon"/>
    </div>
    <div class="text fs-12 mx-auto text-center">{{ text }}</div>
  </div>
</template>

<script>
export default {
  props: {
    bgColor: String,
    type: String,
    text: String,
    icon: String
  },
};
</script>
<style>
.favicon-block-wrapper {
  min-height: 153px;
  position: relative;
  max-width: 200px;
}
.favicon-block {
  width: 80px;
  height: 80px;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto;
}
.favicon-block.circle {
  border-radius: 80px;
}
.favicon-block > div {
  width: 41px;
  height: 41px;
}
.favicon-block-wrapper svg {
  width: 100%;
  height: 100%;
  object-fit: contain;
}
.favicon-block-wrapper svg * {
  fill: #fff !important;
}
.favicon-block-wrapper .favicon-icon {
    width: 50px;
}

@media screen and (max-width: 992px) {
  .favicon-block-wrapper {
    min-height: 120px;
  }
  .favicon-block {
    width: 60px;
    height: 60px;
  }
  .favicon-block > div {
    width: 30px;
    height: 30px;
  }
  .favicon-block-wrapper .text {
    font-size: 10px;
  }
}
</style>

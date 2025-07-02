<template>
  <div
    :style="{ backgroundColor: bgColor ? bgColor : '#fff', width: width + '%' }"
    class="block-img"
    :class="theme"
  >
    <!-- Display logo based on theme -->
    <div class="logo-block">
      <!-- Use v-html to render SVG logo -->
      <div>
          <img :src="logo">
      </div>
    </div>
    <div class="text fs-12">{{ text }}</div>
  </div>
</template>

<script>
export default {
  props: {
    bgColor: String,
    width: Number,
    theme: String,
    logo: String,
    text: String
  },
  computed: {
    displayedLogo() {
      switch (this.logo) {
        case 'main':
          return this.$store.state.mainLogo || '';
        case 'alternative':
          return this.$store.state.alternativeLogo || '';
        case 'wide':
          return this.$store.state.wideLogo || '';
        default:
          return '';
      }
    },
  },
};
</script>
<style>
.block-img {
  min-height: 500px;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

.block-img.light {
  border-top: 1px solid #e1e1e1;
}
.block-img.dark * {
  fill: #fff !important;
}
.block-img.light:nth-child(2n + 1)::after {
  content: '';
  height: 100%;
  width: 1px;
  background-color: #e1e1e1;
  position: absolute;
  right: 0px;
  top: 0px;
}
.logo-block {
  width: 18vw;
  height: 7vw;
}
.logo-block * {
  width: 100%;
  height: 100%;
  object-fit: contain;
}
.block-img .text {
  position: absolute;
  bottom: 24px;
  color: #fff;
}
.block-img.light .text {
  color: #000;
}

@media screen and (max-width: 992px) {
  .block-img {
    width: 100% !important;
    border-top: 1px solid #e1e1e1;
    min-height: calc(100vw - 60px);
  }
  .block-img.light:nth-child(2n + 1)::after {
    content: none;
  }

  .logo-block {
    width: 40vw;
    height: 20vw;
  }
}
</style>

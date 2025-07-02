<template>
  <div class="proportions-block">
    <div class="proportions-left-arrow" :style="proportionsStyle">{{ proportionsY }}</div>

    <div class="proportions-wrapper">
      <div class="proportions-top-arrow" :style="proportionsStyle">
        {{proportionsX}}
      </div>
      <div :style="proportionsStyle" class="proportions-element">
          <img :src="logo" class="logo-proportions"/>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    ratio: {
      type: Number,
      required: true,
    },
    logo:String,
    proportionsX:String,
    proportionsY:String
  },
  data() {
    return {
      baseHeight: 100, // Base height for screens wider than 768px
      smallScreenHeight: 50, // Height for screens smaller than 768px
      windowWidth: window.innerWidth, // Current window width
    };
  },
  computed: {
    proportionsStyle() {
      const height = this.windowWidth < 768 ? this.smallScreenHeight : this.baseHeight;
      return {
        height: `${height}px`,
        width: `${height * this.ratio}px`,
      };
    },
  },
  created() {
    window.addEventListener('resize', this.handleResize);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.handleResize);
  },
  methods: {
    handleResize() {
      this.windowWidth = window.innerWidth;
    },
  },
};
</script>

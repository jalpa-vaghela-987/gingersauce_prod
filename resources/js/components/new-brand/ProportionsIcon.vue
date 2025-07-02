<template>
  <div class="proportions-block proportions-icon">
    <div class="proportions-wrapper">
      <div class="proportions-top-arrow" :style="proportionsStyle">
        <span>{{ proportionsXIcon }}</span>
      </div>
      <div :style="proportionsStyle" class="proportions-element">
          <img :src="icon"  class="logo-proportions" :style="{ backgroundColor: backgroundColor}"/>
      </div>
    </div>

    <div class="proportions-left-arrow" :style="proportionsStyle"><span>{{ proportionsYIcon }}</span></div>
  </div>
</template>

<script>
export default {
  props: {
    ratio: {
      type: Number,
      required: true,
    },
    icon:String,
    backgroundColor:String,
    proportionsXIcon:String,
    proportionsYIcon:String
  },
  data() {
    return {
      height: 80, // Fixed height
    };
  },
  computed: {
    proportionsStyle() {
      return {
        height: `${this.height}px`,
        width: `${this.height * this.ratio}px`,
      };
    },
  },
};
</script>

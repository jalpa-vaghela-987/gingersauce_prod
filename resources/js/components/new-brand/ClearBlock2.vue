<template>
  <div class="clear-block-wrapper">
    <div class="top-arrow arrow" :style="{ width: `${adjustedWidth + 2}px`, marginLeft: `30px` }">
      <span v-html="freeSpaceX"></span>
    </div>
    <div class="d-flex">
      <div class="left-arrow arrow" :style="{ height: `${adjustedHeight + 2}px` }">
        <span v-html="freeSpaceY"></span>
      </div>
      <div
        class="grid-container-clear2"
        :style="{
          gridTemplateColumns: `${adjustedWidth}px ${adjustedWidthL}px ${adjustedWidth}px`,
        }"
      >
        <div class="top-left" :style="spaceStyle">
            <img :src="logo" class="logo-favicon" v-if="showClearLogo"/>
            <span class="logo-favicon" v-else></span>
        </div>
        <div class=""></div>
        <div class="top-right" :style="spaceStyle">
            <img :src="logo" class="logo-favicon" v-if="showClearLogo"/>
            <span class="logo-favicon" v-else></span>
        </div>
        <div class=""></div>
        <div class="center" :style="logoStyle">
            <img :src="logo" class="logo-favicon"/>
        </div>
        <div class=""></div>
        <div class="bottom-left" :style="spaceStyle">
            <img :src="logo" class="logo-favicon" v-if="showClearLogo"/>
            <span class="logo-favicon" v-else></span>
        </div>
        <div class=""></div>
        <div class="bottom-right" :style="spaceStyle">
            <img :src="logo" class="logo-favicon" v-if="showClearLogo"/>
            <span class="logo-favicon" v-else></span>
        </div>
      </div>
      <div class="right-arrow arrow" :style="{ height: `${adjustedHeight + 2}px` }">
        <span v-html="freeSpYText"></span>
      </div>
    </div>
    <div
      class="bottom-arrow arrow"
      :style="{
        width: `${adjustedWidth + 2}px`,
        marginLeft: 'auto',
        marginLeft: `${adjustedWidth + 30 + adjustedWidthL + 2}px`,
      }"
    >
      <span v-html="freeSpXText"></span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    logo:String,
    width: {
      type: Number,
      required: true,
    },
    height: {
      type: Number,
      required: true,
    },
    widthL: {
      type: Number,
      required: true,
    },
    heightL: {
      type: Number,
      required: true,
    },
    freeSpXText: String,
    freeSpYText: String,
    freeSpaceX:String,
    freeSpaceY:String,
    showClearLogo:Boolean
  },
  data() {
    return {
      adjustedWidth: this.width,
      adjustedHeight: this.height,
      adjustedWidthL: this.widthL,
      adjustedHeightL: this.heightL,
    };
  },
  computed: {
    spaceStyle() {
      return {
        height: `${this.adjustedHeight}px`,
        width: `${this.adjustedWidth}px`,
      };
    },
    logoStyle() {
      return {
        height: `${this.adjustedHeightL}px`,
        width: `${this.adjustedWidthL}px`,
      };
    },
  },
  methods: {
    adjustSizes() {
      if (window.innerWidth < 576) {
        this.adjustedWidth = this.width / 1.75;
        this.adjustedHeight = this.height / 1.75;
        this.adjustedWidthL = this.widthL / 1.75;
        this.adjustedHeightL = this.heightL / 1.75;
      } else {
        this.adjustedWidth = this.width;
        this.adjustedHeight = this.height;
        this.adjustedWidthL = this.widthL;
        this.adjustedHeightL = this.heightL;
      }
    },
  },
  beforeUpdate() {
    this.adjustSizes();
    window.addEventListener('resize', this.adjustSizes);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.adjustSizes);
  },
};
</script>

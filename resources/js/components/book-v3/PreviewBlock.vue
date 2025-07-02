<template>
  <div class="preview-card-container">
    <!-- Logo Section -->
    <div class="logo-section" @click="goToPage" style="cursor: pointer;">
      <img :src="src" alt="Logo" class="logo" />
    </div>

    <!-- Font and Colors Section -->
    <div class="font-colors-section">
      <!-- Font Indicator -->
      <div class="font-indicator">
        <span class="font-icon" :style="`font-family: '${fontName}' !important`">Aa</span>
      </div>

      <!-- Color Bars -->
      <div class="color-bars">
        <!-- First 3 colors (primary, secondary, tertiary) -->
        <div
          v-for="(color, index) in colors.slice(0, 3)"
          :key="index"
          class="color-bar"
          :style="{ backgroundColor: color }"
        ></div>

        <!-- Wrap 4th to last colors in a single div -->
        <div class="other-colors" v-if="colors.length > 3">
          <div
            v-for="(color, index) in colors.slice(3)"
            :key="index + 3"
            class="color-bar"
            :style="{ backgroundColor: color }"
          ></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreviewBlock',
  props: {
    src: {
      type: String,
      required: true,
    },
    id: {
      type: Number,
      required: true,
    },
    fontName: {
      type: String,
      required: true,
    },
    fontUrl: {
      type: String,
      required: true,
    },
    colors: {
      type: Array,
      required: true,
      default: () => [],
    },
  },

  methods: {
    loadFont: function (url, name) {
      const style = document.createElement('style');
      style.textContent = `@import url('${url}');`;
      document.head.appendChild(style);
    },
    goToPage() {
      this.$router.push('/my/view-new-v3/'+this.id); // Replace with your actual route
    }
  },
  created() {
    this.loadFont(this.fontUrl, this.fontName);
  },
};
</script>

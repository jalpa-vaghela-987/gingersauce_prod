<template>
  <div class="simple-pantone-color">
    <div class="pantone-color-wrap">
      <ColorPicker
        :color="$store.state.pantoneColor1"
        v-model="$store.state.pantoneColor1"
        @input="changePantoneColor1"
      />
      <span class="hex-inside">{{ $store.state.pantoneColor1 }}</span>
    </div>
    <div class="text-color-picker">
      <div class="color-name">Guberman Wine Red</div>
      <div class="color-value">
        <div class="name">Hex</div>
        <div class="value">{{ $store.state.pantoneColor1 }}</div>
        <div class="name">RGB</div>
        <div class="value">{{ rgbColor }}</div>
        <div class="name">CMYK</div>
        <div class="value">{{ cmykColor }}</div>
        <div class="name">Pantone</div>
        <div class="value">{{ pantoneColor }}</div>
      </div>
    </div>
  </div>
</template>

<script>
import ColorPicker from './ColorPicker.vue';
import { hexToRgb, rgbToCmyk, hexToPantone } from '@/utils/new-brand/colorUtils';

export default {
  components: { ColorPicker },
  methods: {
    changePantoneColor1(newColor) {
      this.$store.commit('changePantoneColor1', newColor);
    },
  },
  computed: {
    rgbColor() {
      const { r, g, b } = hexToRgb(this.$store.state.pantoneColor1);
      return `${r} ${g} ${b}`;
    },
    cmykColor() {
      const { r, g, b } = hexToRgb(this.$store.state.pantoneColor1);
      const { c, m, y, k } = rgbToCmyk(r, g, b);
      return `${c} ${m} ${y} ${k}`;
    },
    pantoneColor() {
      return hexToPantone(this.$store.state.pantoneColor1);
    },
  },
};
</script>

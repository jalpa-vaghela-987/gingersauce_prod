<template>
  <div :class="(colorList.show_shades) ? 'add-pantone-color' : 'simple-pantone-color'">
    <div class="pantone-color-wrap">
      <div class="shade first-shade" v-if="colorList.show_shades" :style="{ backgroundColor: shades[0] }">
        <span class="hex-inside">{{ shades[0] }}</span>
      </div>
<!--      <ColorPicker-->
<!--        :color="$store.state.pantoneColor1"-->
<!--        v-model="$store.state.pantoneColor1"-->
<!--        @input="changePantoneColor1"-->
<!--      />-->
        <ColorPicker
            ref="colorPicker"
            :color="colorList.color.hex.value"
            @updateColor="updateColor"
        />
      <span class="hex-inside">{{ colorList.color.hex.value }}</span>
      <div class="shade second-shade" v-if="colorList.show_shades" :style="{ backgroundColor: shades[1] }">
        <span class="hex-inside">{{ shades[1] }}</span>
      </div>
      <div class="shade third-shade" v-if="colorList.show_shades" :style="{ backgroundColor: shades[2] }">
        <span class="hex-inside">{{ shades[2] }}</span>
      </div>
    </div>
    <div class="text-color-picker">
      <div class="color-name">{{ colorList.color.name.value }}</div>
      <div class="color-value">
            <div class="name">Hex</div>
            <div class="value">{{ colorList.color.hex.value }}</div>
            <div class="name">RGB</div>
            <div class="value">{{ rgbColor }}</div>
            <div class="name">CMYK</div>
            <div class="value">{{ cmykColor }}</div>
            <span v-if="colorList.pantone">
                <div class="name">Pantone</div>
                <div class="value">{{ colorList.pantone.name }}</div>
            </span>
      </div>
    </div>
  </div>
</template>

<script>
import ColorPicker from './ColorPicker.vue';
import { hexToRgb, rgbToCmyk, hexToPantone } from '@/utils/new-brand/colorUtils';
import Color from 'color';
import {mapActions} from "vuex";

export default {
    components: { ColorPicker },
    props: { colorList: Object, position: Number },
    data() {
    return {
      shades: [],
    };
  },
    watch: {
        'colorList.color.hex.value': {
          immediate: true,
          handler(newColor) {
            this.generateShades(newColor);
                if(this.$refs.colorPicker) {
                    this.$refs.colorPicker.setColor(newColor);
                }
          },
        },
      },
    methods: {
        ...mapActions([
            'changeMainColor'
        ]),
        updateColor(color, updateColor) {
            this.colorList.color = updateColor;
            this.$emit('updateBrandbookColorList', this.position, this.colorList.color);
            if(this.position == 0) {
                this.changeMainColor(updateColor.hex.value)
            }
        },
        changePantoneColor1(newColor) {
          this.$store.commit('changePantoneColor1', newColor);
        },
        generateShades(hexColor) {
          const color = Color(hexColor);
          this.shades = [color.darken(0.2).hex(), color.lighten(0.2).hex(), color.lighten(0.4).hex()];
        },
      },
    computed: {
        rgbColor() {
          const { r, g, b } = this.colorList.color.rgb;
          return `${r} ${g} ${b}`;
        },
        cmykColor() {
          const { c, m, y, k } = this.colorList.color.cmyk;
          return `${c} ${m} ${y} ${k}`;
        }
  },
};
</script>

<!-- ColorPicker.vue -->
<template>
  <div ref="colorpicker" class="input-group">
      <span v-if="isEditBook || isThemeColor">
           <span class="current-color" :style="'background-color: ' + colorValue" @click="togglePicker" />
           <chrome-picker v-if="displayPicker" :value="colors" @input="updateFromPicker" />
      </span>
      <span v-else>
           <span class="current-color" :style="'background-color: ' + colorValue"/>
           <chrome-picker v-if="displayPicker" :value="colors"/>
      </span>
  </div>
</template>

<script>
import { Chrome } from 'vue-color';
import {mapState} from "vuex";

export default {
  name: 'ColorPicker',
  components: {
    'chrome-picker': Chrome,
  },
  props: ['color', 'isThemeColor'],
  data() {
    return {
      colors: {
        hex: '#000000',
      },
      colorValue: '',
      displayPicker: false,
    };
  },
  watch: {
    colorValue(color) {
      if (color) {
          this.updateColors(color);
          this.$emit('input', color);
      }
    }
  },
  mounted() {
    this.setColor(this.color || '#000000');
  },
  destroyed() {
    this.hidePicker();
  },
    computed: {
        ...mapState(['isEditBook'])
    },
  methods: {
    setColor(color) {
      this.updateColors(color);
      this.colorValue = color;
    },
    updateColors(val) {
        this.colors = val;
    },
    showPicker() {
      document.addEventListener('click', this.documentClick);
      this.displayPicker = true;
    },
    hidePicker() {
      document.removeEventListener('click', this.documentClick);
      this.displayPicker = false;
    },
    togglePicker() {
      this.displayPicker ? this.hidePicker() : this.showPicker();
    },
    updateFromInput() {
      this.updateColors(this.colorValue);
    },
    updateFromPicker(color) {
      this.colors = color;
      if (color.rgba.a === 1) {
        this.colorValue = color.hex;
      } else {
        this.colorValue =
          'rgba(' +
          color.rgba.r +
          ', ' +
          color.rgba.g +
          ', ' +
          color.rgba.b +
          ', ' +
          color.rgba.a +
          ')';
      }
        axios.get('https://www.thecolorapi.com/id?hex='+this.colorValue.replace('#','')+'&format=json')
            .then(response => {
                this.$emit('updateColor', this.colorValue, response.data)
        })
    },
    documentClick(e) {
      const el = this.$refs.colorpicker;
      const target = e.target;
      if (el !== target && !el.contains(target)) {
        this.hidePicker();
      }
    },
  },
};
</script>

<style scoped>
.input-group,
.current-color {
  display: inline-block;
  width: 100%;
  height: 100%;
  cursor: pointer;
}
</style>

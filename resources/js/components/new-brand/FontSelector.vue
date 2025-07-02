<template>
  <v-select :options="fontOptions" v-model="selectedFont" @change="handleChange">
    <template #selected-option="{ label }">
      <span :style="{ fontFamily: label }">{{ label }}</span>
    </template>
    <template #option="{ label }">
      <span :style="{ fontFamily: label }">{{ label }}</span>
    </template>
  </v-select>
</template>
<script>
import { mapActions, mapState } from 'vuex';
export default {
  data() {
    return {
      fontOptions: []
    }
  },
  props: {
    fontType: {
      type: String,
      required: true,
      validator: value => ['main', 'secondary'].includes(value),
    },
  },
  mounted() {
    this.getFontOptions();
  },
  computed: {
    ...mapState(['mainFont', 'secFont']),
    selectedFont: {
      get() {
        if (this.fontOptions.length) {
          let font = this.fontType === 'main' ? this.mainFont : this.secFont;
          const fontObj = this.fontOptions.find((option) => option.label === font);
          if (fontObj) {
            this.handleChange(fontObj);
            return fontObj;
          }else{
            this.handleChange(this.fontOptions[0]);
            return this.fontOptions[0];
          }
        } else {
          return null;
        }
      },
      set(value) {
        this.handleChange(value);
      },
    },
  },
  methods: {
    ...mapActions(['changeMainFont', 'changeMainFontCategory', 'changeSecFont', 'changeSecFontCategory']),
    handleChange(newFont) {
      if (this.fontType === 'main') {
        this.changeMainFont(newFont?.label);
        this.changeMainFontCategory(newFont?.category);
      } else {
        this.changeSecFont(newFont?.label);
        this.changeSecFontCategory(newFont?.category);
      }
      this.$emit("updateFontWeightDropDown", this.fontType, newFont.variants);
    },
    async getFontOptions() {
      await axios.get('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAqNaDv_jucLZ9KxfCdR2x5l5C9FD4trgw').then(response => {
        this.fontOptions = response.data.items.map(item => (
          {
            label: item.family,
            category: item.category,
            variants: item.variants,
          }
        ));
      });
    },
  },
  watch: {
    mainFont(newFont, oldFont) {
      console.log('mainFont changed from', oldFont, 'to', newFont);
    }
  },
};
</script>

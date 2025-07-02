<template>
  <v-select :options="fontWeightOptions" v-model="selectedFontWeight" @change="handleChange">
    <template #selected-option="{ label }">
      <span :style="{ fontWeight: label }">{{ label }}</span>
    </template>
    <template #option="{ label }">
      <span :style="{ fontWeight: getFontWeight(label) }">{{ label }}</span>
    </template>
  </v-select>
</template>
<script>
import { mapActions,mapState } from 'vuex';
export default {
  data(){
    return {
      fontWeightOptions:[]
    }
  },
  props: {
    fontWeightType: {
      type: String,
      required: true,
      validator: value => ['main', 'secondary'].includes(value),
    },
  },
  computed: {
    ...mapState(['mainFontWeight','secFontWeight']),
    selectedFontWeight: {
      get() {
        if(this.fontWeightType === 'main'){
          const fontWeightObj = this.fontWeightOptions.find(option => option === this.mainFontWeight);
          return fontWeightObj??this.fontWeightOptions[0];
        }else{
          const fontWeightObj = this.fontWeightOptions.find(option => option === this.secFontWeight);
          return fontWeightObj??this.fontWeightOptions[0];
        }
      },
      set(value) {
        this.handleChange(value);
      },
    },
  },
  methods: {
    ...mapActions(['changeMainFontWeight','changeSecFontWeight']),
    setfontWeightOptions(variants) {
      this.fontWeightOptions  =  variants;
    },
    handleChange(newFontWeight) {
      if(this.fontWeightType === 'main'){
        this.changeMainFontWeight(newFontWeight)
      }else{
        this.changeSecFontWeight(newFontWeight)
      }
    },
    getFontWeight(label) {
      const option = this.fontWeightOptions.find(option => option === label);
      return option ? option.value : ''; // default to 'normal' if not found
    },
  },
};
</script>

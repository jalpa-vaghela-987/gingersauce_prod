<template>
  <div class="theme-color">
    <ColorPicker
      ref="themeColorPicker"
      :color="mainColorBook"
      @input="changeMainColor"
      :isThemeColor="true"
    />
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import ColorPicker from './ColorPicker.vue';

export default {
  components: { ColorPicker },
  computed:{
    ...mapState(['mainColorBook']),
  },
  methods: {
    ...mapActions(['changeMainColorBook']),
    changeMainColor(newColor) {
      this.changeMainColorBook(newColor);
    },
  },
  watch : {
    'mainColorBook' : function (newVal, oldVal){
        this.$refs.themeColorPicker.setColor(newVal);
    }
  }
};
</script>

<style>
.theme-color {
  width: 128px !important;
  height: 85px !important;
  border: 2px solid #000;
}
.theme-color .vc-color-wrap.transparent {
  width: 124px !important;
  height: 81px !important;
}
</style>

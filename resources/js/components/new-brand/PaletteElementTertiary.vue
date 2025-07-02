<template>
  <div id="tertiary-color" class="align-self-end mb-5">
    <ColorPicker
        ref="colorPicker"
        :color="defaultBrandbook.colors_list[2].id"
        @updateColor="updateColor"
    />
    <div class="text-color-picker">
      Tertiary Color <span class="color">{{ defaultBrandbook.colors_list[2].id }}</span>
    </div>
  </div>
</template>

<script>
import ColorPicker from './ColorPicker.vue';
import {mapState} from "vuex";

export default {
    components: { ColorPicker },
    data() {
        return {
          newColor: '',
        };
    },
    setup() {},
    methods: {
        updateColor(color, updateColor) {
            this.$emit('updateBrandbookColorList', 2 , updateColor);
        },

    },
    watch: {
        'defaultBrandbook.colors_list' : function (newVal, oldVal){
            if(newVal && newVal[2] && newVal[2].id) {
                this.$refs.colorPicker.setColor(newVal[2].id);
            }
        }
    },
    computed: {
        ...mapState(['defaultBrandbook']),
    },
};
</script>
<style>
#tertiary-color {
  position: relative;
  width: 154px !important;
  height: 170px !important;
}
#tertiary-color .current-color {
  width: 154px !important;
  height: 170px !important;
  clip-path: path(
    'M130.816 30.1378C155.925 60.6775 164.106 121.637 133.238 147.015C102.371 172.393 63.3736 177.271 31.3982 156.446C-14.8239 126.344 -4.31485 55.79 26.5526 30.412C57.4201 5.034 88.8989 -20.8466 130.816 30.1378Z'
  );
}
#tertiary-color .vc-color-wrap.transparent {
  background-image: none !important;
  box-shadow: none;
  width: fit-content !important;
  height: fit-content !important;
}
#tertiary-color .text-color-picker {
  font-size: 16px;
  font-weight: calc(var(--secFontWeight) + 100);
  line-height: 26px;
  text-align: left;
  color: #fff;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  position: absolute;
  display: flex;
  flex-direction: column;
  min-width: 120px;
}
#tertiary-color .text-color-picker .color {
  font-size: 24px;
  font-style: italic;
  font-weight: calc(var(--secFontWeight) + 200);
}
</style>

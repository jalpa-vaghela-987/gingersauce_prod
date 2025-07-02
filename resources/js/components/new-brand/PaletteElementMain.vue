<template>
  <div id="main-color">
    <ColorPicker
        ref="colorPicker"
        :color="defaultBrandbook.colors_list[0].id"
        @updateColor="updateColor"
      />
    <div class="text-color-picker">
      Primary Color <span class="color">{{ defaultBrandbook.colors_list[0].id }}</span>
    </div>
  </div>
</template>

<script>
import ColorPicker from './ColorPicker.vue';
import {mapActions, mapState} from "vuex";

export default {
    components: { ColorPicker},
    data() {
        return {
          newColor: '',
        };
    },
    setup() {},
    methods: {
        updateColor(color, updateColor) {
            this.$emit('updateBrandbookColorList', 0 , updateColor);
            this.changeMainColor(updateColor.hex.value)
        },
        ...mapActions([
            'changeMainColor'
        ]),
    },
    watch: {
        'defaultBrandbook.colors_list' : function (newVal, oldVal){
            if(newVal && newVal[0] && newVal[0].id) {
                this.$refs.colorPicker.setColor(newVal[0].id);
            }
        }
    },
    computed: {
        ...mapState(['defaultBrandbook']),
    },
};
</script>
<style>
#main-color {
  position: relative;
  width: 520px !important;
  height: 480px !important;
}
#main-color .current-color {
  width: 520px !important;
  height: 480px !important;
  clip-path: path(
    'M1.62025 188.102C-13.1535 427.378 225.026 556.622 373.956 419.969C501.634 295.064 515.5 200 507 141.499C483.44 -20.6497 18.7102 -88.6864 1.62025 188.102Z'
  );
}
#main-color .vc-color-wrap.transparent {
  background-image: none !important;
  box-shadow: none;
  width: fit-content !important;
  height: fit-content !important;
}
#main-color .text-color-picker {
  font-size: 16px;
  font-weight: calc(var(--secFontWeight) + 100);
  line-height: 26px;
  text-align: left;
  color: #fff;
  top: 40%;
  left: 50%;
  transform: translate(-50%, -50%);
  position: absolute;
  display: flex;
  flex-direction: column;
  min-width: 120px;
}
#main-color .text-color-picker .color {
  font-size: 24px;
  font-style: italic;
  font-weight: calc(var(--secFontWeight) + 200);
}

@media screen and (max-width: 992px) {
  #main-color {
    position: relative;
    width: 300px !important;
    height: 300px !important;
  }
  #main-color .current-color {
    width: 300px !important;
    width: 300px !important;
    clip-path: path(
      'm0.9 100c-7.9 127.2 118.5 195.9 197.5 123.2 67.7-66.4 75-116.9 70.5-148-12.5-86.2-259-122.3-268 24.8z'
    );
  }
}
</style>

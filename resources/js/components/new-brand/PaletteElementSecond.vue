<template>
  <div id="second-color">
    <ColorPicker
        ref="colorPicker"
        :color="defaultBrandbook.colors_list[1].id"
        @updateColor="updateColor"
      />
    <div class="text-color-picker">
      Secondary Color <span class="color">{{ defaultBrandbook.colors_list[1].id }}</span>
    </div>
  </div>
</template>

<script>
import ColorPicker from './ColorPicker.vue';
import {mapActions, mapState} from "vuex";

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
            this.$emit('updateBrandbookColorList', 1 , updateColor);
            this.changeSecondColor(updateColor.hex.value)
        },
        ...mapActions([
            'changeSecondColor'
        ]),
    },
    watch: {
        'defaultBrandbook.colors_list' : function (newVal, oldVal){
            if(newVal && newVal[1] && newVal[1].id) {
                this.$refs.colorPicker.setColor(newVal[1].id);
            }
        }
    },
    computed: {
        ...mapState(['defaultBrandbook']),
    },
};
</script>
<style>
#second-color {
  position: relative;
  width: 471px !important;
  height: 238px !important;
}
#second-color .current-color {
  width: 471px !important;
  height: 238px !important;
  clip-path: path(
    'M38.3558 70.2395C-76.1441 136.241 77.3557 363.74 378.678 142.403C680.001 -78.9343 151.495 8.38537 38.3558 70.2395Z'
  );
}
#second-color .vc-color-wrap.transparent {
  background-image: none !important;
  box-shadow: none;
  width: fit-content !important;
  height: fit-content !important;
}
#second-color .text-color-picker {
  font-size: 16px;
  font-weight: calc(var(--secFontWeight) + 100);
  line-height: 26px;
  text-align: left;
  color: #fff;
  top: 110px;
  left: 110px;
  position: absolute;
  display: flex;
  flex-direction: column;
  min-width: 120px;
}
#second-color .text-color-picker .color {
  font-size: 24px;
  font-style: italic;
  font-weight: calc(var(--secFontWeight) + 200);
}

@media screen and (max-width: 992px) {
  #second-color {
    width: 300px !important;
    height: 150px !important;
  }
  #second-color .current-color {
    width: 300px !important;
    height: 150px !important;
    clip-path: path('m22 40.1c-65.6 37.8 22.3 167.8 195.1 41.3 172.7-126.5-130.3-76.6-195.1-41.3z');
  }
  #second-color .text-color-picker {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
}
</style>

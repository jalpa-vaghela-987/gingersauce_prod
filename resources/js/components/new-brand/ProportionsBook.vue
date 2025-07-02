<template>
  <section class="align-self-start col-12 section-book" id="proportions-book" :style="`order:${orderClass}`">
    <div class="content">
        <span v-if="isEditBook">
            <EditDefaultInput
                :value="(brandbook.proportions_title) ? brandbook.proportions_title : 'Logo & Icon Proportions'"
                filed="proportions_title"
            />
            <EditDefaultDescription
                :description="(brandbook.proportions_text) ? brandbook.proportions_text : setDefaultDescription"
                filed="proportions_text"
                class="mb-50"
            />
        </span>
        <span v-else>
            <h1 class="mb-4">{{ (brandbook.proportions_title) ? brandbook.proportions_title : 'Logo & Icon Proportions' }}</h1>
            <span v-if="brandbook.proportions_text" v-html="brandbook.proportions_text"></span>
            <span class="mb-50" v-else v-html="setDefaultDescription"></span>
        </span>
        <WatermarkImage/>
         <div class="proportions-1 mb-50 ms-md-5">
            <ProportionsBlock
                :ratio="ratio"
                :logo="brandbook.logo_b64"
                :proportionsX="proportionsX"
                :proportionsY="proportionsY"
            />
        </div>
        <div class="proportions-2 mb-50 mx-auto" v-if="brandbook.approved_icon && brandbook.approved_icon[0]">
            <ProportionsIcon
                :ratio="ratioIcon"
                :icon="brandbook.icon_b64"
                :proportionsXIcon="proportionsXIcon"
                :proportionsYIcon="proportionsYIcon"
            />
        </div>
    </div>
  </section>
</template>

<script>
import ProportionsBlock from './ProportionsBlock.vue';
import ProportionsIcon from './ProportionsIcon.vue';
import EditDefaultDescription from "./EditDefaultDescription";
import EditDefaultInput from "./EditDefaultInput";
import {mapState} from "vuex";
import WatermarkImage from "./WatermarkImage";

export default {
    data() {
        return {
            proportionsTextSmall: null,
            proportionsTextSmallIcon: null,
            proportionsX: null,
            proportionsY: null,
            ratio: 0,
            ratioIcon: 0,
            proportionsXIcon: null,
            proportionsYIcon: null,
            orderClass: null
        };
    },
    props: { brandbook: Object },
    components: {
        ProportionsBlock,
        ProportionsIcon,
        EditDefaultDescription,
        EditDefaultInput,
        WatermarkImage
    },
    computed: {
        ...mapState(['isEditBook','currentBrandTabs']),
        setDefaultDescription() {
            return `<p>The ${this.brandbook.brand} Logo has a neat proportion of ${this.proportionsTextSmall} width.<br /> These proportions were chosen carefully and they are not to be changed.<br /> The Icon has a perfect square proportion of ${this.proportionsTextSmallIcon} and acts as the Favicon as well. </p>`
        }
    },
    mounted() {
        this.getOrderClass('logo');
        this.brandbook.logo_w = parseInt(this.brandbook.logo_w);
        this.brandbook.logo_h = parseInt(this.brandbook.logo_h);
        this.calculateProportionsRatio();
        this.calculateProportionsIcon();
    },
    methods: {
        calculateProportionsRatio() {
            if (this.brandbook.logo_w === 0) {
                this.brandbook.logo_w = 200;
            }
            if (this.brandbook.logo_h === 0) {
                this.brandbook.logo_h = 100;
            }

            let ratio = parseFloat(this.brandbook.logo_w / (this.brandbook.logo_h === 0 ? 1 : this.brandbook.logo_h));
            this.ratio = ratio;
            let proportions_x = 'x';
            let proportions_y = 'x';
            let proportions_text = '';

            let proportions_fibo_active_active = false;

            let prop_x_val = (ratio - Math.floor(ratio) > 0.1 ? Number(ratio.toFixed(1)) : Math.round(ratio));
            if (prop_x_val - Math.floor(prop_x_val) < 0.1) {
                prop_x_val = Math.floor(prop_x_val);
            }

            switch (this.brandbook.proportions) {
                case 'leonardo':
                    if (ratio > 1) {
                        proportions_x = `${prop_x_val}x`;
                        if (proportions_x === '1x') {
                            proportions_x = 'x';
                        }
                        proportions_y = 'x';
                    } else {
                        prop_x_val = ((1 / ratio) - Math.floor(1 / ratio) > 0.1 ? Number((1 / ratio).toFixed(1)) : Math.round(1 / ratio));
                        if (prop_x_val - Math.floor(prop_x_val) < 0.1) {
                            prop_x_val = Math.floor(prop_x_val);
                        }
                        proportions_y = `${prop_x_val}x`;
                        if (proportions_y === '1x') {
                            proportions_y = 'x';
                        }
                        proportions_x = 'x';
                    }
                    proportions_fibo_active_active = false;
                    break;
                case 'michaelangelo':
                    if (ratio > 1) {
                        proportions_y = `1/${prop_x_val}x`;
                        if (proportions_y === '1/3x') {
                            proportions_y = '&frac13;x';
                        }
                        if (proportions_y === '1/2x') {
                            proportions_y = '&frac12;x';
                        }
                        if (proportions_y === '1/4x') {
                            proportions_y = '&frac14;x';
                        }
                        if (proportions_y === '1/5x') {
                            proportions_y = '&frac15;x';
                        }
                        if (proportions_y === '1/6x') {
                            proportions_y = '&frac16;x';
                        }
                        if (proportions_y === '1/7x') {
                            proportions_y = '&frac17;x';
                        }
                        if (proportions_y === '1/8x') {
                            proportions_y = '&frac18;x';
                        }
                        if (proportions_y === '1x') {
                            proportions_y = 'x';
                        }
                        proportions_x = 'x';
                    } else {
                        proportions_x = `${prop_x_val}x`;
                        if (proportions_x === '1x') {
                            proportions_x = 'x';
                        }
                        proportions_y = 'x';
                    }
                    proportions_fibo_active_active = false;
                    break;
                case 'fibonacci':
                    proportions_fibo_active_active = true;
                    if (ratio >= 0.613 && ratio <= 0.86) {
                        proportions_x = 'x';
                        proportions_y = '1.618 x';
                    } else {
                        if (ratio > 1) {
                            proportions_x = `${prop_x_val}x`;
                            if (proportions_x === '1x') {
                                proportions_x = 'x';
                            }
                            proportions_y = 'x';
                        } else {
                            prop_x_val = ((1 / ratio) - Math.floor(1 / ratio) > 0.1 ? Number((1 / ratio).toFixed(1)) : Math.round(1 / ratio));
                            if (prop_x_val - Math.floor(prop_x_val) < 0.1) {
                                prop_x_val = Math.floor(prop_x_val);
                            }
                            proportions_y = `${prop_x_val}x`;
                            if (proportions_y === '1x') {
                                proportions_y = 'x';
                            }
                            proportions_x = 'x';
                        }
                    }
                    break;
                case 'vitruvious':
                    if (ratio > 1) {
                        proportions_x = `${Math.ceil(ratio)}x`;
                        proportions_y = 'x';
                    } else {
                        proportions_y = `${Math.ceil(ratio)}x`;
                        proportions_x = 'x';
                    }
                    break;
            }

            let proportions_fibo_active_golden = false;
            let proportions_fibo_active = [];
            let proportions_text_small = '';

            if (ratio >= 0.95 && ratio <= 1.05) {
                proportions_text = '1:1 Square Ratio';
                proportions_text_small = proportions_text;
                if (this.brandbook.proportions === 'fibonacci') {
                    proportions_text += '<br>The proportion is linked to the Fibonacci Sequence';
                }
                proportions_fibo_active.push(1);
            } else if (ratio >= 2.9 && ratio <= 3.1) {
                proportions_text = '1:3 Ratio';
                proportions_text_small = proportions_text;
                if (this.brandbook.proportions === 'fibonacci') {
                    proportions_text += '<br>The proportion is linked to the Fibonacci Sequence';
                }
                proportions_fibo_active.push(3);
            } else if (ratio >= 4.8 && ratio <= 5.2) {
                proportions_text = '1:5 Ratio';
                proportions_text_small = proportions_text;
                if (this.brandbook.proportions === 'fibonacci') {
                    proportions_text += '<br>The proportion is linked to the Fibonacci Sequence';
                }
                proportions_fibo_active.push(5);
            } else if (ratio >= 7.8 && ratio <= 8.2) {
                proportions_text = '1:8 Ratio';
                proportions_text_small = proportions_text;
                if (this.brandbook.proportions === 'fibonacci') {
                    proportions_text += "<br>The proportion is linked to the Fibonacci Sequence";
                }
                proportions_fibo_active.push(8);
            } else if (ratio >= 1.4 && ratio <= 1.58) {
                proportions_text = '2:3 Ratio';
                proportions_text_small = proportions_text;
                if (this.brandbook.proportions === 'fibonacci') {
                    proportions_text += "<br>The proportion is linked to the Fibonacci Sequence";
                }
                proportions_fibo_active.push(2);
                proportions_fibo_active.push(3);
            } else if (ratio >= 1.641 && ratio <= 1.7) {
                proportions_text = '3:5 Ratio';
                proportions_text_small = proportions_text;
                if (this.brandbook.proportions === 'fibonacci') {
                    proportions_text += "<br>The proportion is linked to the Fibonacci Sequence";
                }
                proportions_fibo_active.push(3);
                proportions_fibo_active.push(5);
            } else if (ratio >= 1.581 && ratio <= 1.64) {
                proportions_text = '1:1.681 Golden Ratio';
                proportions_text_small = proportions_text;
                if (this.brandbook.proportions === 'fibonacci') {
                    proportions_text += "<br>The proportion is the absolute Fibonacci Sequence";
                }
                proportions_fibo_active_golden = true;
            } else {
                let xx = parseFloat(proportions_x);
                let yy = parseFloat(proportions_y);
                if (isNaN(xx) || xx === 0) {
                    xx = 1;
                }
                if (isNaN(yy) || yy === 0) {
                    yy = 1;
                }

                if (proportions_x.includes('/')) {
                    xx = parseFloat(proportions_x.replace('x', '').replace('y', ''));
                }
                if (proportions_y.includes('/')) {
                    yy = parseFloat(proportions_y.replace('x', '').replace('y', ''));
                }

                if (proportions_x === '&frac12;x') {
                    xx = 1;
                    yy = 2;
                }
                if (proportions_x === '&frac13;x') {
                    xx = 1;
                    yy = 3;
                }
                if (proportions_x === '&frac14;x') {
                    xx = 1;
                    yy = 3;
                }
                if (proportions_x === '&frac15;x') {
                    xx = 1;
                    yy = 4;
                }
                if (proportions_x === '&frac16;x') {
                    xx = 1;
                    yy = 5;
                }
                if (proportions_x === '&frac17;x') {
                    xx = 1;
                    yy = 6;
                }
                if (proportions_x === '&frac18;x') {
                    xx = 1;
                    yy = 8;
                }

                if (proportions_y === '&frac12;x') {
                    xx = 1;
                    yy = 2;
                }
                if (proportions_y === '&frac13;x') {
                    xx = 1;
                    yy = 3;
                }
                if (proportions_y === '&frac14;x') {
                    xx = 1;
                    yy = 3;
                }
                if (proportions_y === '&frac15;x') {
                    xx = 1;
                    yy = 4;
                }
                if (proportions_y === '&frac16;x') {
                    xx = 1;
                    yy = 5;
                }
                if (proportions_y === '&frac17;x') {
                    xx = 1;
                    yy = 6;
                }
                if (proportions_y === '&frac18;x') {
                    xx = 1;
                    yy = 8;
                }

                proportions_text = `${xx}:${yy} Ratio`;
                proportions_text_small = `${xx}:${yy}`;
            }
            this.proportionsX = proportions_x;
            this.proportionsY = proportions_y;
            this.proportionsTextSmall = proportions_text_small;
        },
        calculateProportionsIcon() {
            if(this.brandbook.icon) {
                var brandbookIcon=this.brandbook.icon;
                var div = document.createElement('div');
                div.innerHTML = brandbookIcon;
                var element = div.firstElementChild;
                var icon_w = element.width.baseVal.value;
                var icon_h = element.height.baseVal.value;
            } else {
                var icon_w = 0;
                var icon_h = 0;
            }

            if (icon_w === 0) {
                this.brandbook.logo_w = 200;
            }
            if (icon_h === 0) {
                this.brandbook.logo_h = 100;
            }

            let ratio_icon = parseFloat(icon_w / (icon_h === 0 ? 1 : icon_h));
            this.ratioIcon = ratio_icon;
            let proportions_x_icon = 'x';
            let proportions_y_icon = 'x';
            let proportions_text_icon = '';

            let prop_x_val_icon = (ratio_icon - Math.floor(ratio_icon) > 0.1 ? Number(ratio_icon.toFixed(1)) : Math.round(ratio_icon));
            if (prop_x_val_icon - Math.floor(prop_x_val_icon) < 0.1) {
                prop_x_val_icon = Math.floor(prop_x_val_icon);
            }

            switch (this.brandbook.proportions) {
                case 'leonardo':
                    if (ratio_icon > 1) {
                        proportions_x_icon = `${prop_x_val_icon}x`;
                        if (proportions_x_icon === '1x') {
                            proportions_x_icon = 'x';
                        }
                        proportions_y_icon = 'x';
                    } else {
                        prop_x_val_icon = ((1 / ratio_icon) - Math.floor(1 / ratio_icon) > 0.1 ? Number((1 / ratio_icon).toFixed(1)) : Math.round(1 / ratio_icon));
                        if (prop_x_val_icon - Math.floor(prop_x_val_icon) < 0.1) {
                            prop_x_val_icon = Math.floor(prop_x_val_icon);
                        }
                        proportions_y_icon = `${prop_x_val_icon}x`;
                        if (proportions_y_icon === '1x') {
                            proportions_y_icon = 'x';
                        }
                        proportions_x_icon = 'x';
                    }
                    break;
                case 'michaelangelo':
                    if (ratio_icon > 1) {
                        proportions_y_icon = `1/${prop_x_val_icon}x`;
                        if (proportions_y_icon === '1/3x') {
                            proportions_y_icon = '&frac13;x';
                        }
                        if (proportions_y_icon === '1/2x') {
                            proportions_y_icon = '&frac12;x';
                        }
                        if (proportions_y_icon === '1/4x') {
                            proportions_y_icon = '&frac14;x';
                        }
                        if (proportions_y_icon === '1/5x') {
                            proportions_y_icon = '&frac15;x';
                        }
                        if (proportions_y_icon === '1/6x') {
                            proportions_y_icon = '&frac16;x';
                        }
                        if (proportions_y_icon === '1/7x') {
                            proportions_y_icon = '&frac17;x';
                        }
                        if (proportions_y_icon === '1/8x') {
                            proportions_y_icon = '&frac18;x';
                        }
                        if (proportions_y_icon === '1x') {
                            proportions_y_icon = 'x';
                        }
                        proportions_x_icon = 'x';
                    } else {
                        proportions_x_icon = `${prop_x_val_icon}x`;
                        if (proportions_x_icon === '1x') {
                            proportions_x_icon = 'x';
                        }
                        proportions_y_icon = 'x';
                    }
                    break;
                case 'fibonacci':
                    if (ratio_icon >= 0.613 && ratio_icon <= 0.86) {
                        proportions_x_icon = 'x';
                        proportions_y_icon = '1.618 x';
                    } else {
                        if (ratio_icon > 1) {
                            proportions_x_icon = `${prop_x_val_icon}x`;
                            if (proportions_x_icon === '1x') {
                                proportions_x_icon = 'x';
                            }
                            proportions_y_icon = 'x';
                        } else {
                            prop_x_val_icon = ((1 / ratio_icon) - Math.floor(1 / ratio_icon) > 0.1 ? Number((1 / ratio_icon).toFixed(1)) : Math.round(1 / ratio_icon));
                            if (prop_x_val_icon - Math.floor(prop_x_val_icon) < 0.1) {
                                prop_x_val_icon = Math.floor(prop_x_val_icon);
                            }
                            proportions_y_icon = `${prop_x_val_icon}x`;
                            if (proportions_y_icon === '1x') {
                                proportions_y_icon = 'x';
                            }
                            proportions_x_icon = 'x';
                        }
                    }
                    break;
            }

            let proportions_text_small_icon = '';
            let proportions_fibo_active_icon = [];

            if (ratio_icon >= 0.95 && ratio_icon <= 1.05) {
                proportions_text_icon = '1:1 Square Ratio';
                proportions_text_small_icon = proportions_text_icon;
                if (this.brandbook.proportions_icon === 'fibonacci') {
                    proportions_text_icon += "<br>The proportion is linked to the Fibonacci Sequence";
                }
                proportions_fibo_active_icon = [1];
            } else if (ratio_icon >= 2.9 && ratio_icon <= 3.1) {
                proportions_text_icon = '1:3 Ratio';
                proportions_text_small_icon = proportions_text_icon;
                if (this.brandbook.proportions_icon === 'fibonacci') {
                    proportions_text_icon += "<br>The proportion is linked to the Fibonacci Sequence";
                }
                proportions_fibo_active_icon = [3];
            } else if (ratio_icon >= 4.8 && ratio_icon <= 5.2) {
                proportions_text_icon = '1:5 Ratio';
                proportions_text_small_icon = proportions_text_icon;
                if (this.brandbook.proportions_icon === 'fibonacci') {
                    proportions_text_icon += "<br>The proportion is linked to the Fibonacci Sequence";
                }
                proportions_fibo_active_icon = [5];
            } else if (ratio_icon >= 7.8 && ratio_icon <= 8.2) {
                proportions_text_icon = '1:8 Ratio';
                proportions_text_small_icon = proportions_text_icon;
                if (this.brandbook.proportions_icon === 'fibonacci') {
                    proportions_text_icon += "<br>The proportion is linked to the Fibonacci Sequence";
                }
                proportions_fibo_active_icon.push(8);
            } else if (ratio_icon >= 1.4 && ratio_icon <= 1.58) {
                proportions_text_icon = '2:3 Ratio';
                proportions_text_small_icon = proportions_text_icon;
                if (this.brandbook.proportions_icon === 'fibonacci') {
                    proportions_text_icon += "<br>The proportion is linked to the Fibonacci Sequence";
                }
                proportions_fibo_active_icon.push(2);
                proportions_fibo_active_icon.push(3);
            } else if (ratio_icon >= 1.641 && ratio_icon <= 1.7) {
                proportions_text_icon = '3:5 Ratio';
                proportions_text_small_icon = proportions_text_icon;
                if (this.brandbook.proportions_icon === 'fibonacci') {
                    proportions_text_icon += "<br>The proportion is linked to the Fibonacci Sequence";
                }
                proportions_fibo_active_icon.push(3);
                proportions_fibo_active_icon.push(5);
            } else if (ratio_icon >= 1.581 && ratio_icon <= 1.64) {
                proportions_text_icon = '1:1.681 Golden Ratio';
                proportions_text_small_icon = proportions_text_icon;
                if (this.brandbook.proportions_icon === 'fibonacci') {
                    proportions_text_icon += "<br>The proportion is the absolute Fibonacci Sequence";
                }
                let proportions_fibo_active_golden_icon = true;
            } else {
                let xx = parseFloat(proportions_x_icon);
                let yy = parseFloat(proportions_y_icon);
                if (isNaN(xx) || xx === 0) {
                    xx = 1;
                }
                if (isNaN(yy) || yy === 0) {
                    yy = 1;
                }

                if (proportions_x_icon.includes('/')) {
                    xx = parseFloat(proportions_x_icon.replace('x', '').replace('y', ''));
                }
                if (proportions_y_icon.includes('/')) {
                    yy = parseFloat(proportions_y_icon.replace('x', '').replace('y', ''));
                }

                if (proportions_x_icon === '&frac12;x') {
                    xx = 1;
                    yy = 2;
                }
                if (proportions_x_icon === '&frac13;x') {
                    xx = 1;
                    yy = 3;
                }
                if (proportions_x_icon === '&frac14;x') {
                    xx = 1;
                    yy = 3;
                }
                if (proportions_x_icon === '&frac15;x') {
                    xx = 1;
                    yy = 4;
                }
                if (proportions_x_icon === '&frac16;x') {
                    xx = 1;
                    yy = 5;
                }
                if (proportions_x_icon === '&frac17;x') {
                    xx = 1;
                    yy = 6;
                }
                if (proportions_x_icon === '&frac18;x') {
                    xx = 1;
                    yy = 8;
                }

                if (proportions_y_icon === '&frac12;x') {
                    xx = 1;
                    yy = 2;
                }
                if (proportions_y_icon === '&frac13;x') {
                    xx = 1;
                    yy = 3;
                }
                if (proportions_y_icon === '&frac14;x') {
                    xx = 1;
                    yy = 3;
                }
                if (proportions_y_icon === '&frac15;x') {
                    xx = 1;
                    yy = 4;
                }
                if (proportions_y_icon === '&frac16;x') {
                    xx = 1;
                    yy = 5;
                }
                if (proportions_y_icon === '&frac17;x') {
                    xx = 1;
                    yy = 6;
                }
                if (proportions_y_icon === '&frac18;x') {
                    xx = 1;
                    yy = 8;
                }

                proportions_text_icon = `${xx}:${yy} Ratio`;
                proportions_text_small_icon = `${xx}:${yy}`;
            }
            this.proportionsXIcon = proportions_x_icon;
            this.proportionsYIcon = proportions_y_icon;
            this.proportionsTextSmallIcon = proportions_text_small_icon;
        },
        async getOrderClass(slug){
            const order =  this.currentBrandTabs.findIndex(tab=>(tab.is_default && tab.slug==slug));
            this.orderClass =   order;//`order-${order}`;
        }
    },
    watch: {
        currentBrandTabs: {
            handler(newTabs) {
                this.getOrderClass("logo");
            },
            deep: true,
            immediate: true,
        }
    },
};
</script>

<style scoped>
#proportions-book {
  padding-top: 150px;
  min-height: 120vh;
}
.proportions-1 {
  width: 454px;
  height: 200px;
}
.proportions-2 {
  width: 120px;
  height: 120px;
}
.proportions-1 img,
.proportions-2 img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

@media screen and (max-width: 1200px) {
  #proportions-book {
    min-height: unset;
  }
}

@media screen and (max-width: 992px) {
  #proportions-book {
    padding-top: 100px;
  }

  .proportions-1 {
    max-width: 100%;
    max-height: 200px;
    width: 100%;
  }
}
</style>

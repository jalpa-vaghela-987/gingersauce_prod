<template>
    <div class="d-flex gap-3 logo-sizes-line" v-if="brandbook && logo_h">
        <ClearSpace :logo="brandbook.logo_b64"
                    :favicon="brandbook.icon_b64"
                    :width="freeSpaceXW"
                    :height="freeSpaceYH"
                    :widthL="longer"
                    :heightL="shorter"
                    :freeSpXText="freeSpXText"
                    :freeSpaceX="freeSpaceX"
                    :freeSpYText="freeSpYText"
                    :freeSpaceY="freeSpaceY"
                    :showClearLogo="showClearLogo"
                    dataName="Clear Space"/>
        <MinimumSize :brandbook="brandbook" dataName="Minimum Size"/>
        <Proportions dataName="Proportions" :logo="brandbook.logo_b64" :ratio="ratio"
                     :proportionsX="proportionsX"
                     :proportionsY="proportionsY"
        />

    </div>
</template>
<script>
    import ClearSpace from '../GridBlocks/LogoSizes/ClearSpace.vue';
    import MinimumSize from '../GridBlocks/LogoSizes/MinimumSize.vue';
    import Proportions from '../GridBlocks/LogoSizes/Proportions.vue';

    export default {
        components: {
            ClearSpace,
            MinimumSize,
            Proportions,
        },
        props: {
            brandbook: {
                type: Object,
                default: () => ({})
            }
        },
        data() {
            return {
                proportionsX: null,
                proportionsY: null,
                ratio: 0,
                freeSpXText: null,
                freeSpYText: null,
                freeSpaceX: null,
                freeSpaceY: null,
                freeSpaceXW:0,
                freeSpaceYH:0,
                showClearLogo: false,
                shorter: 0,
                longer: 0,
                logo_h: 0,
                logo_w: 0
            }
        },
        mounted() {
            this.logo_w = parseInt(this.brandbook.logo_w);
            this.logo_h = parseInt(this.brandbook.logo_h);
            this.calculateProportionsRatio();
            this.calculateClearSpaceLogo();
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
            },
            calculateClearSpaceLogo() {
                let freeSpaceX = '';
                let freeSpaceY = '';
                let freeSpaceXW = 0;
                let freeSpaceYH = 0;

                let shorter = 0;
                let longer = 0;
                let shorterText = 'x';
                let longerText = 'y';

                if (this.logo_w < this.logo_h) {
                    shorter = this.logo_w;
                    longer = this.logo_h;
                    if(longer>140){
                        longer = 140;
                        shorter = shorter*140/this.logo_h;
                        this.logo_h = 140;
                        this.logo_w = shorter;
                    }
                    shorterText = 'x';
                    longerText = 'y';
                } else if (this.logo_w === this.logo_h) {
                    shorter = this.logo_h;
                    longer = this.logo_h;
                    if(shorter>200){
                        shorter = 140;
                        longer = 140;
                        this.logo_h = 140;
                        this.logo_w = 140;
                    }
                    shorterText = 'x';
                    longerText = 'x';
                } else {
                    shorter = this.logo_h;
                    longer = this.logo_w;
                    if(longer>200){
                        longer = 200;
                        shorter = shorter*200/this.logo_w;
                        this.logo_w = 200;
                        this.logo_h = shorter;
                    }
                    if(longer<200){
                        longer = 200;
                        shorter = shorter*200/this.logo_w;
                        this.logo_w = 200;
                        this.logo_h = shorter;
                    }
                    shorterText = 'y';
                    longerText = 'x';
                }

                const newR = longer / shorter;
                let freeSpYText = 'y';
                let freeSpXText = 'x';
                if (shorter !== longer) {
                    freeSpYText = 'y';
                    freeSpXText = 'x';
                } else {
                    freeSpYText = 'x';
                    freeSpXText = 'x';
                }

                let freeSpCText = '';
                let clearSpaceText = '';
                let showClearIcon = false;
                switch (this.brandbook.space) {
                    case 'newton':
                        showClearIcon = false;
                        if (newR >= 1 && newR <= 1.6) {
                            freeSpaceX = `&frac13;${shorterText}`;
                            freeSpaceY = `&frac13;${shorterText}`;
                            freeSpaceXW = shorter / 3;
                            freeSpaceYH = shorter / 3;
                        }
                        if (newR > 1.6 && newR <= 10) {
                            freeSpaceX = `&frac12;${shorterText}`;
                            freeSpaceY = `&frac12;${shorterText}`;
                            freeSpaceXW = shorter / 2;
                            freeSpaceYH = shorter / 2;
                        }
                        break;
                    case 'hawkins':
                        showClearIcon = false;
                        if (newR >= 1 && newR <= 1.6) {
                            freeSpaceX = `&frac12;${shorterText}`;
                            freeSpaceY = `&frac12;${shorterText}`;
                            freeSpaceXW = shorter / 2;
                            freeSpaceYH = shorter / 2;
                        }
                        if (newR > 1.6 && newR <= 10) {
                            freeSpaceX = `${shorterText}`;
                            freeSpaceY = `${shorterText}`;
                            freeSpaceXW = shorter;
                            freeSpaceYH = shorter;
                        }
                        break;
                    case 'einstein':
                        showClearIcon = false;
                        freeSpYText = 'y';
                        freeSpXText = 'x';
                        freeSpCText = '';
                        if (newR >= 1 && newR <= 1.39) {
                            showClearIcon = true;
                            if (shorterText === 'x') {
                                freeSpaceX = `&frac23;${shorterText}`;
                                freeSpaceY = `&frac23;${longerText}`;
                                freeSpaceXW = shorter * 2 / 3;
                                freeSpaceYH = longer * 2 / 3;
                            } else {
                                freeSpaceY = `&frac23;${shorterText}`;
                                freeSpaceX = `&frac23;${longerText}`;
                                freeSpaceYH = shorter * 2 / 3;
                                freeSpaceXW = longer * 2 / 3;
                            }
                        }
                        if (newR > 1.39 && newR <= 1.99) {
                            if (shorterText === 'x') {
                                freeSpaceX = `&frac23;${shorterText}`;
                                freeSpaceY = `&frac12;${longerText}`;
                                freeSpaceXW = shorter * 2 / 3;
                                freeSpaceYH = longer / 2;
                            } else {
                                freeSpaceY = `&frac23;${shorterText}`;
                                freeSpaceX = `&frac12;${longerText}`;
                                freeSpaceYH = shorter * 2 / 3;
                                freeSpaceXW = longer / 2;
                            }
                        }
                        if (newR > 1.99 && newR <= 2.99) {
                            if (shorterText === 'x') {
                                freeSpaceX = `&frac23;${shorterText}`;
                                freeSpaceY = `&frac13;${longerText}`;
                                freeSpaceXW = shorter * 2 / 3;
                                freeSpaceYH = longer / 3;
                            } else {
                                freeSpaceY = `&frac23;${shorterText}`;
                                freeSpaceX = `&frac13;${longerText}`;
                                freeSpaceYH = shorter * 2 / 3;
                                freeSpaceXW = longer / 3;
                            }
                        }
                        if (newR > 2.99 && newR <= 3.99) {
                            if (shorterText === 'x') {
                                freeSpaceX = `&frac23;${shorterText}`;
                                freeSpaceY = `&frac14;${longerText}`;
                                freeSpaceXW = shorter * 2 / 3;
                                freeSpaceYH = longer / 4;
                            } else {
                                freeSpaceY = `&frac23;${shorterText}`;
                                freeSpaceX = `&frac14;${longerText}`;
                                freeSpaceYH = shorter * 2 / 3;
                                freeSpaceXW = longer / 4;
                            }
                        }
                        if (newR > 3.99 && newR <= 4.99) {
                            if (shorterText === 'x') {
                                freeSpaceX = `&frac23;${longerText}`;
                                freeSpaceY = `&frac15;${shorterText}`;
                                freeSpaceXW = shorter * 2 / 3;
                                freeSpaceYH = longer / 5;
                            } else {
                                freeSpaceY = `&frac23;${longerText}`;
                                freeSpaceX = `&frac15;${shorterText}`;
                                freeSpaceYH = shorter * 2 / 3;
                                freeSpaceXW = longer / 5;
                            }
                        }
                        if (newR > 4.99 && newR <= 5.99) {
                            if (shorterText === 'x') {
                                freeSpaceX = `&frac23;${shorterText}`;
                                freeSpaceY = `&frac16;${longerText}`;
                                freeSpaceXW = shorter * 2 / 3;
                                freeSpaceYH = longer / 6;
                            } else {
                                freeSpaceY = `&frac23;${shorterText}`;
                                freeSpaceX = `&frac16;${longerText}`;
                                freeSpaceYH = shorter * 2 / 3;
                                freeSpaceXW = longer / 6;
                            }
                        }
                        if (newR > 5.99 && newR <= 6.99) {
                            if (shorterText === 'x') {
                                freeSpaceX = `&frac23;${shorterText}`;
                                freeSpaceY = `&frac17;${longerText}`;
                                freeSpaceXW = shorter * 2 / 3;
                                freeSpaceYH = longer / 7;
                            } else {
                                freeSpaceY = `&frac23;${shorterText}`;
                                freeSpaceX = `&frac17;${longerText}`;
                                freeSpaceYH = shorter * 2 / 3;
                                freeSpaceXW = longer / 7;
                            }
                        }
                        if (newR > 6.99 && newR <= 7.99) {
                            if (shorterText === 'x') {
                                freeSpaceX = `&frac23;${shorterText}`;
                                freeSpaceY = `&frac18;${longerText}`;
                                freeSpaceXW = shorter * 2 / 3;
                                freeSpaceYH = longer / 8;
                            } else {
                                freeSpaceY = `&frac23;${shorterText}`;
                                freeSpaceX = `&frac18;${longerText}`;
                                freeSpaceYH = shorter * 2 / 3;
                                freeSpaceXW = longer / 8;
                            }
                        }
                        break;
                    case 'pithagoras':
                        freeSpYText = 'y';
                        freeSpCText = 'c';
                        freeSpXText = 'x';
                        showClearIcon = false;
                        clearSpaceText = 'X&sup2; + Y&sup2; = C&sup2;';
                        const diag = Math.sqrt(shorter * shorter + longer * longer);
                        if (newR >= 1 && newR <= 1.5) {
                            freeSpaceX = '&frac12;c';
                            freeSpaceY = '&frac12;c';
                            freeSpaceXW = diag / 2;
                            freeSpaceYH = diag / 2;
                        }
                        if (newR > 1.5 && newR <= 3) {
                            freeSpaceX = '&frac13;c';
                            freeSpaceY = '&frac13;c';
                            freeSpaceXW = diag / 3;
                            freeSpaceYH = diag / 3;
                        }
                        if (newR > 3 && newR <= 4) {
                            freeSpaceX = '&frac14;c';
                            freeSpaceY = '&frac14;c';
                            freeSpaceXW = diag / 4;
                            freeSpaceYH = diag / 4;
                        }
                        if (newR > 4 && newR <= 5) {
                            freeSpaceX = '&frac15;c';
                            freeSpaceY = '&frac15;c';
                            freeSpaceXW = diag / 5;
                            freeSpaceYH = diag / 5;
                        }
                        if (newR > 5 && newR <= 6) {
                            freeSpaceX = '&frac16;c';
                            freeSpaceY = '&frac16;c';
                            freeSpaceXW = diag / 6;
                            freeSpaceYH = diag / 6;
                        }
                        if (newR > 6 && newR <= 8) {
                            freeSpaceX = '&frac18;c';
                            freeSpaceY = '&frac18;c';
                            freeSpaceXW = diag / 8;
                            freeSpaceYH = diag / 8;
                        }
                        break;
                }

                this.freeSpXText = freeSpXText;
                this.freeSpYText = freeSpYText;
                this.freeSpaceX = freeSpaceX;
                this.freeSpaceY = freeSpaceY;
                this.freeSpaceXW = freeSpaceXW;
                this.freeSpaceYH = freeSpaceYH;
                this.showClearLogo = showClearIcon;
                this.longer = longer;
                this.shorter = shorter;
            },
        }
    };
</script>

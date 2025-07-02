<template>
  <section class="align-self-start col-12 section-book" id="space-book" :style="`order:${orderClass}`">
    <div class="content">
        <span v-if="isEditBook">
            <EditDefaultInput
                :value="(brandbook.space_title) ? brandbook.space_title : 'Clear Space'"
                filed="space_title"
            />
            <EditDefaultDescription
                :description="(brandbook.space_text) ? brandbook.space_text : setDefaultDescription"
                filed="space_text"
                class="mb-4"
            />
        </span>
        <span v-else>
            <h1 class="mb-4">{{ (brandbook.space_title) ? brandbook.space_title : 'Clear Space' }}</h1>
            <span v-if="brandbook.space_text" v-html="brandbook.space_text"></span>
            <span v-else v-html="setDefaultDescription"></span>
        </span>

        <WatermarkImage/>
        <div class="space-1 mx-auto" v-if="brandbook.icon!='skipped' && brandbook.icon_b64 != null">
            <ClearBlock
                :icon="brandbook.icon_b64"
                :width="freeSpaceXWIcon"
                :height="freeSpaceYHIcon"
                :widthL="longerIcon"
                :heightL="shorterIcon"
                :freeSpXText="freeSpXTextIcon"
                :freeSpaceX="freeSpaceXIcon"
                :freeSpYText="freeSpYTextIcon"
                :freeSpaceY="freeSpaceYIcon"
                :showClearIcon="showClearIcon"
            />
        </div>
        <div class="space-2 mb-50 mx-auto">
            <ClearBlock2
                :logo="brandbook.logo_b64"
                :width="freeSpaceXW"
                :height="freeSpaceYH"
                :widthL="longer"
                :heightL="shorter"
                :freeSpXText="freeSpXText"
                :freeSpaceX="freeSpaceX"
                :freeSpYText="freeSpYText"
                :freeSpaceY="freeSpaceY"
                :showClearLogo="showClearLogo"
            />
        </div>
    </div>

    <div class="bg-img">
      <svg
        width="487"
        height="381"
        viewBox="0 0 487 381"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M295.392 217.732C294.07 212.12 302.492 202.304 315.037 199.35C327.582 196.395 338.713 196.92 343.531 201.237C350.497 207.478 335.481 218.179 322.936 221.133C310.391 224.087 297.598 227.1 295.392 217.732Z"
        />
        <path
          d="M68.6604 137.323C-22.5402 234.453 33.5132 374.239 145.706 368.605C244.64 360.458 234.97 214.667 287.083 198.287C370.756 171.988 514.258 100.907 433.484 33.7957C356.608 -30.0772 142.839 58.3226 68.6604 137.323Z"
        />
      </svg>
    </div>
    <TabContents v-if="!isEditBook" :tabContents="tab.tab_contents"/>
    <SectionAdd v-else :class="`${tab.slug}-add-section`" :tabName="`${tab.slug.replace('-', '')}AddSection`" :tab="tab"/>
  </section>
</template>

<script>
import ClearBlock from './ClearBlock.vue';
import ClearBlock2 from './ClearBlock2.vue';
import EditDefaultDescription from "./EditDefaultDescription";
import EditDefaultInput from "./EditDefaultInput";
import {mapState} from "vuex";
import SectionAdd from "./SectionAdd";
import TabContents from "./TabContents";
import WatermarkImage from "./WatermarkImage";

export default {
    data() {
        return {
            freeSpXText: null,
            freeSpYText: null,
            freeSpaceX: null,
            freeSpaceY: null,
            freeSpaceXW:0,
            freeSpaceYH:0,
            showClearLogo: false,
            shorter: 0,
            longer: 0,
            freeSpXTextIcon: null,
            freeSpYTextIcon: null,
            freeSpaceXIcon: null,
            freeSpaceYIcon: null,
            freeSpaceXWIcon:0,
            freeSpaceYHIcon:0,
            showClearIcon: false,
            shorterIcon: 0,
            longerIcon: 0,
            orderClass: null
        }
    },
    props: { brandbook: Object, tab: Object },
    components: {
        ClearBlock,
        ClearBlock2,
        EditDefaultDescription,
        EditDefaultInput,
        SectionAdd,
        TabContents,
        WatermarkImage
    },
    computed: {
        ...mapState(['isEditBook','currentBrandTabs']),
        setDefaultDescription() {
            return `<p>Clear space is the area surrounding the global signature and Icon that must be kept free of any elements, including text, graphics, borders, or other logos. The minimum clear space required for the preferred global signature is equal to “x”, or the height and width of the ${this.brandbook.brand} Icon.</p>`
        }
    },
    mounted() {
        this.getOrderClass('clear-space');
        this.brandbook.logo_w = parseInt(this.brandbook.logo_w);
        this.brandbook.logo_h = parseInt(this.brandbook.logo_h);
        this.calculateClearSpaceLogo();
        this.calculateClearSpaceIcon();
    },
    methods: {
        calculateClearSpaceLogo() {
            let freeSpaceX = '';
            let freeSpaceY = '';
            let freeSpaceXW = 0;
            let freeSpaceYH = 0;

            let shorter = 0;
            let longer = 0;
            let shorterText = 'x';
            let longerText = 'y';

            if (this.brandbook.logo_w < this.brandbook.logo_h) {
                shorter = this.brandbook.logo_w;
                longer = this.brandbook.logo_h;
                if(longer>140){
                    longer = 140;
                    shorter = shorter*140/this.brandbook.logo_h;
                    this.brandbook.logo_h = 140;
                    this.brandbook.logo_w = shorter;
                }
                shorterText = 'x';
                longerText = 'y';
            } else if (this.brandbook.logo_w === this.brandbook.logo_h) {
                shorter = this.brandbook.logo_h;
                longer = this.brandbook.logo_h;
                if(shorter>200){
                    shorter = 140;
                    longer = 140;
                    this.brandbook.logo_h = 140;
                    this.brandbook.logo_w = 140;
                }
                shorterText = 'x';
                longerText = 'x';
            } else {
                shorter = this.brandbook.logo_h;
                longer = this.brandbook.logo_w;
                if(longer>200){
                    longer = 200;
                    shorter = shorter*200/this.brandbook.logo_w;
                    this.brandbook.logo_w = 200;
                    this.brandbook.logo_h = shorter;
                }
                if(longer<200){
                    longer = 200;
                    shorter = shorter*200/this.brandbook.logo_w;
                    this.brandbook.logo_w = 200;
                    this.brandbook.logo_h = shorter;
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
        calculateClearSpaceIcon() {

            let shorter = 0;
            let longer = 0;
            let shorterText = 'x';
            let longerText = 'y';

            if(this.brandbook.icon) {
                var brandbookIcon = this.brandbook.icon;
                var div = document.createElement('div');
                div.innerHTML = brandbookIcon;
                var element = div.firstElementChild;
                var icon_w = element.width.baseVal.value;
                var icon_h = element.height.baseVal.value;
            } else {
                var icon_w = 0;
                var icon_h = 0;
            }

            if (icon_w > icon_h) {
                this.brandbook.icon_w = 120;
                this.brandbook.icon_h = (icon_h * 120) / icon_w;
            } else {
                this.brandbook.icon_h = 120;
                this.brandbook.icon_w = (icon_w * 120) / icon_h;
            }

            if (this.brandbook.icon_w < this.brandbook.icon_h) {
                shorter = this.brandbook.icon_w;
                longer = this.brandbook.icon_h;
                shorterText = 'x';
                longerText = 'y';
            } else if (this.brandbook.icon_w === this.brandbook.icon_h) {
                shorter = this.brandbook.icon_h;
                longer = this.brandbook.icon_h;
                shorterText = 'x';
                longerText = 'x';
            } else {
                shorter = this.brandbook.icon_h;
                longer = this.brandbook.icon_w;
                shorterText = 'y';
                longerText = 'x';
            }

            let freeSpYText = '';
            let freeSpXText = '';
            const new_r = longer / shorter;
            if (shorter !== longer) {
                freeSpYText = 'y';
                freeSpXText = 'x';
            } else {
                freeSpYText = 'x';
                freeSpXText = 'x';
            }

            let freeSpCText = '';
            let clearSpaceText = '';
            let freeSpaceX = '';
            let freeSpaceY = '';
            let freeSpaceXW = 0;
            let freeSpaceYH = 0;
            let showClearIcon = false;
            switch (this.brandbook.space) {
                case 'newton':
                    showClearIcon = false;
                    if (new_r >= 1 && new_r <= 1.6) {
                        freeSpaceX = `&frac13;${shorterText}`;
                        freeSpaceY = `&frac13;${shorterText}`;
                        freeSpaceXW = shorter / 3;
                        freeSpaceYH = shorter / 3;
                    }
                    if (new_r > 1.6 && new_r <= 10) {
                        freeSpaceX = `&frac12;${shorterText}`;
                        freeSpaceY = `&frac12;${shorterText}`;
                        freeSpaceXW = shorter / 2;
                        freeSpaceYH = shorter / 2;
                    }
                    break;
                case 'hawkins':
                    showClearIcon = false;
                    if (new_r >= 1 && new_r <= 1.6) {
                        freeSpaceX = `&frac12;${shorterText}`;
                        freeSpaceY = `&frac12;${shorterText}`;
                        freeSpaceXW = shorter / 2;
                        freeSpaceYH = shorter / 2;
                    }
                    if (new_r > 1.6 && new_r <= 10) {
                        freeSpaceX = shorterText;
                        freeSpaceY = shorterText;
                        freeSpaceXW = shorter;
                        freeSpaceYH = shorter;
                    }
                    break;
                case 'einstein':
                    showClearIcon = false;
                    freeSpYText = 'y';
                    freeSpXText = 'x';
                    freeSpCText = '';
                    if (new_r >= 1 && new_r <= 1.39) {
                        showClearIcon = true;
                        if (shorterText === 'x') {
                            freeSpaceX = `&frac23;${shorterText}`;
                            freeSpaceY = `&frac23;${longerText}`;
                            freeSpaceXW = (shorter * 2) / 3;
                            freeSpaceYH = (longer * 2) / 3;
                        } else {
                            freeSpaceY = `&frac23;${shorterText}`;
                            freeSpaceX = `&frac23;${longerText}`;
                            freeSpaceYH = (shorter * 2) / 3;
                            freeSpaceXW = (longer * 2) / 3;
                        }
                    }
                    if (new_r > 1.39 && new_r <= 1.99) {
                        if (shorterText === 'x') {
                            freeSpaceX = `&frac23;${shorterText}`;
                            freeSpaceY = `&frac12;${longerText}`;
                            freeSpaceXW = (shorter * 2) / 3;
                            freeSpaceYH = longer / 2;
                        } else {
                            freeSpaceY = `&frac23;${shorterText}`;
                            freeSpaceX = `&frac12;${longerText}`;
                            freeSpaceYH = (shorter * 2) / 3;
                            freeSpaceXW = longer / 2;
                        }
                    }
                    if (new_r > 1.99 && new_r <= 2.99) {
                        if (shorterText === 'x') {
                            freeSpaceX = `&frac23;${shorterText}`;
                            freeSpaceY = `&frac13;${longerText}`;
                            freeSpaceXW = (shorter * 2) / 3;
                            freeSpaceYH = longer / 3;
                        } else {
                            freeSpaceY = `&frac23;${shorterText}`;
                            freeSpaceX = `&frac13;${longerText}`;
                            freeSpaceYH = (shorter * 2) / 3;
                            freeSpaceXW = longer / 3;
                        }
                    }
                    if (new_r > 2.99 && new_r <= 3.99) {
                        if (shorterText === 'x') {
                            freeSpaceX = `&frac23;${shorterText}`;
                            freeSpaceY = `&frac14;${longerText}`;
                            freeSpaceXW = (shorter * 2) / 3;
                            freeSpaceYH = longer / 4;
                        } else {
                            freeSpaceY = `&frac23;${shorterText}`;
                            freeSpaceX = `&frac14;${longerText}`;
                            freeSpaceYH = (shorter * 2) / 3;
                            freeSpaceXW = longer / 4;
                        }
                    }
                    if (new_r > 3.99 && new_r <= 4.99) {
                        if (shorterText === 'x') {
                            freeSpaceX = `&frac23;${longerText}`;
                            freeSpaceY = `&frac15;${shorterText}`;
                            freeSpaceXW = (shorter * 2) / 3;
                            freeSpaceYH = longer / 5;
                        } else {
                            freeSpaceY = `&frac23;${longerText}`;
                            freeSpaceX = `&frac15;${shorterText}`;
                            freeSpaceYH = (shorter * 2) / 3;
                            freeSpaceXW = longer / 5;
                        }
                    }
                    if (new_r > 4.99 && new_r <= 5.99) {
                        if (shorterText === 'x') {
                            freeSpaceX = `&frac23;${shorterText}`;
                            freeSpaceY = `&frac16;${longerText}`;
                            freeSpaceXW = (shorter * 2) / 3;
                            freeSpaceYH = longer / 6;
                        } else {
                            freeSpaceY = `&frac23;${shorterText}`;
                            freeSpaceX = `&frac16;${longerText}`;
                            freeSpaceYH = (shorter * 2) / 3;
                            freeSpaceXW = longer / 6;
                        }
                    }
                    if (new_r > 5.99 && new_r <= 6.99) {
                        if (shorterText === 'x') {
                            freeSpaceX = `&frac23;${shorterText}`;
                            freeSpaceY = `&frac17;${longerText}`;
                            freeSpaceXW = (shorter * 2) / 3;
                            freeSpaceYH = longer / 7;
                        } else {
                            freeSpaceY = `&frac23;${shorterText}`;
                            freeSpaceX = `&frac17;${longerText}`;
                            freeSpaceYH = (shorter * 2) / 3;
                            freeSpaceXW = longer / 7;
                        }
                    }
                    if (new_r > 6.99 && new_r <= 7.99) {
                        if (shorterText === 'x') {
                            freeSpaceX = `&frac23;${shorterText}`;
                            freeSpaceY = `&frac18;${longerText}`;
                            freeSpaceXW = (shorter * 2) / 3;
                            freeSpaceYH = longer / 8;
                        } else {
                            freeSpaceY = `&frac23;${shorterText}`;
                            freeSpaceX = `&frac18;${longerText}`;
                            freeSpaceYH = (shorter * 2) / 3;
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
                    if (new_r >= 1 && new_r <= 1.5) {
                        freeSpaceX = '&frac12;c';
                        freeSpaceY = '&frac12;c';
                        freeSpaceXW = diag / 2;
                        freeSpaceYH = diag / 2;
                    }
                    if (new_r > 1.5 && new_r <= 3) {
                        freeSpaceX = '&frac13;c';
                        freeSpaceY = '&frac13;c';
                        freeSpaceXW = diag / 3;
                        freeSpaceYH = diag / 3;
                    }
                    if (new_r > 3 && new_r <= 4) {
                        freeSpaceX = '&frac14;c';
                        freeSpaceY = '&frac14;c';
                        freeSpaceXW = diag / 4;
                        freeSpaceYH = diag / 4;
                    }
                    if (new_r > 4 && new_r <= 5) {
                        freeSpaceX = '&frac15;c';
                        freeSpaceY = '&frac15;c';
                        freeSpaceXW = diag / 5;
                        freeSpaceYH = diag / 5;
                    }
                    if (new_r > 5 && new_r <= 6) {
                        freeSpaceX = '&frac16;c';
                        freeSpaceY = '&frac16;c';
                        freeSpaceXW = diag / 6;
                        freeSpaceYH = diag / 6;
                    }
                    if (new_r > 6 && new_r <= 8) {
                        freeSpaceX = '&frac18;c';
                        freeSpaceY = '&frac18;c';
                        freeSpaceXW = diag / 8;
                        freeSpaceYH = diag / 8;
                    }
                    break;
            }

            this.freeSpXTextIcon = freeSpXText;
            this.freeSpYTextIcon = freeSpYText;
            this.freeSpaceXIcon = freeSpaceX;
            this.freeSpaceYIcon = freeSpaceY;
            this.freeSpaceXWIcon = freeSpaceXW;
            this.freeSpaceYHIcon = freeSpaceYH;
            this.showClearIcon = showClearIcon;
            this.longerIcon = longer;
            this.shorterIcon = shorter;
        },
        async getOrderClass(slug){
            const order =  this.currentBrandTabs.findIndex(tab=>(tab.is_default && tab.slug==slug));
            this.orderClass =   order;//`order-${order}`;
        }
    },
    watch: {
        currentBrandTabs: {
            handler(newTabs) {
                this.getOrderClass("clear-space");
            },
            deep: true,
            immediate: true,
        }
    },
};
</script>

<style scoped>
#space-book {
  padding-top: 220px;
  padding-bottom: 220px;
}
.bg-img {
  top: 0px;
}

.space-1 {
  width: 173px;
  height: 189px;
  margin-top: 100px;
  margin-bottom: 200px;
}
.space-2 {
  width: 542px;
  height: 295px;
}
.space-1 img,
.space-2 img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

@media screen and (max-width: 1200px) {
  #space-book {
    padding-top: 50px;
    padding-bottom: 0px;
  }
}
@media screen and (max-width: 992px) {
  #space-book {
    padding-top: 50px;
    padding-bottom: 0px;
  }

  .space-1 {
    margin-top: 50px;
    margin-bottom: 50px;
  }
  .space-2 {
    max-width: 100%;
    width: 100%;
    height: auto;
  }
}
</style>

<template>
  <section class="align-self-start col-12 section-book" id="minimum-book" :style="`order:${orderClass}`">
    <div class="content">
        <span v-if="isEditBook">
            <EditDefaultInput
                :value="(brandbook.size_title) ? brandbook.size_title : 'Minimum Size'"
                filed="size_title"
            />
            <EditDefaultDescription
                :description="(brandbook.size_text) ? brandbook.size_text : setDefaultDescription"
                filed="size_text"
            />
        </span>
        <span v-else>
            <h1 class="mb-4">{{ (brandbook.size_title) ? brandbook.size_title : 'Minimum Size' }}</h1>
            <span v-if="brandbook.size_text" v-html="brandbook.size_text"></span>
            <span v-else v-html="setDefaultDescription"></span>
        </span>
    </div>
    <div class="minimum-group">
      <div class="minimum-full-logo">
        <div :style="{ width: widthFullLogo + 'px' }" class="mx-auto">
          <img class="mb-2" :src="(brandbook.logo_b64) ? brandbook.logo_b64 : ''">
          <div class="minimum-width">
            <span class="value">{{ widthFullLogo }}</span
            >px/ <span class="value">{{ widthFullLogoInMM }}</span>mm/
            <span class="value" v-html="formatRoundedValue(widthFullLogoInInches)"></span>”
          </div>
        </div>

        <div class="explain mt-3 fs-12 text-center">
          The {{ brandbook.brand }} logo should never be smaller than {{ widthFullLogo }}px in digital or
          {{ widthFullLogoInMM }}mm in print.
        </div>
      </div>
      <div class="minimum-small-logo" v-if="brandbook.icon!='skipped' && brandbook.icon_b64 != null">
        <div :style="{ width: widthIcon + 'px' }" class="mx-auto">
          <img  class="mb-2" :src="brandbook.icon_b64"/>
          <div class="minimum-width"></div>
        </div>

        <div class="explain mt-3 fs-12 text-center">
          The {{ brandbook.brand }} icon should never be smaller than {{ widthIcon }}px in digital or
          {{ widthIconInMM }}mm /
          <span class="value" v-html="formatRoundedValue(widthIconInInches)"></span>" in print.
        </div>
      </div>
    </div>
    <div class="content">
        <WatermarkImage/>
    </div>
    <div class="bg-img">
      <svg
        width="237"
        height="226"
        viewBox="0 0 237 226"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M26.124 175.554C59.1433 219.146 139.017 245.685 183.683 207.311C228.349 168.937 247.945 113.882 230.376 62.7376C204.98 -11.1949 105.882 -13.1029 61.2159 25.2712C16.5502 63.6452 -29 102.779 26.124 175.554Z"
        />
      </svg>
    </div>
    <TabContents v-if="!isEditBook" :tabContents="tab.tab_contents"/>
    <SectionAdd v-else :class="`${tab.slug}-add-section`" :tabName="`${tab.slug.replace('-', '')}AddSection`" :tab="tab"/>
  </section>
</template>

<script>
import EditDefaultDescription from "./EditDefaultDescription";
import EditDefaultInput from "./EditDefaultInput";
import {mapState} from "vuex";
import SectionAdd from "./SectionAdd";
import TabContents from "./TabContents";
import WatermarkImage from "./WatermarkImage";

export default {
    data() {
        return {
            widthFullLogo: 0,
            widthIcon: 0,
            widthFullLogoInMM: 0,
            widthIconInMM: 0,
            orderClass: null
        };
    },
    props: { brandbook: Object, tab: Object },
    components: {
        EditDefaultDescription,
        EditDefaultInput,
        SectionAdd,
        TabContents,
        WatermarkImage
    },
    computed: {
      ...mapState(['isEditBook','defaultBrandbook','currentBrandTabs']),
      setDefaultDescription() {
          return `<p>Establishing a minimum size ensures that the impact and legibility of the logo is not compromised in application.</p>`
      },
      widthFullLogoInInches() {
        return this.widthFullLogo * 0.010417;
      },
      widthIconInInches() {
        return this.widthIcon * 0.010417;
      },
    },
    mounted() {
      this.getOrderClass('minimum-size');
        if(this.brandbook.size =='quark') {
          this.widthFullLogo = 71;
          this.widthFullLogoInMM = 20;
          this.widthIcon = 10;
          this.widthIconInMM = 2.8;
        } else if(this.brandbook.size =='neutron') {
          this.widthFullLogo = 100;
          this.widthFullLogoInMM = 28;
          this.widthIcon = 14;
          this.widthIconInMM = 3.9;
        } else if(this.brandbook.size =='atom') {
          this.widthFullLogo = 160;
          this.widthFullLogoInMM = 45;
          this.widthIcon = 22;
          this.widthIconInMM = 6.9;
        } else if(this.brandbook.size =='molecule') {
          this.widthFullLogo = 214;
          this.widthFullLogoInMM = 60;
          this.widthIcon = 30;
          this.widthIconInMM = 8.4;
        } else {
          this.widthFullLogo = 0;
          this.widthFullLogoInMM = 0;
          this.widthIcon = 0;
          this.widthIconInMM = 0;
        }
    },
    methods: {
        setActiveSection(id) {
          console.log(`Section in view: ${id}`); // Debugging line
          this.$emit('set-active-section', id);
        },
        // Method to round a value to the nearest 1/4, 1/2, 3/4, or whole number and format with span
        formatRoundedValue(value) {
          const roundedValue = Math.round(value * 4) / 4; // Round to nearest 0.25
          const wholeNumberPart = Math.floor(roundedValue);
          const fractionalPart = roundedValue % 1;

          if (fractionalPart === 0) {
            return wholeNumberPart; // No content if no fractional part
          } else {
            let fractionText;
            if (fractionalPart === 0.25) {
              fractionText = '<span class="fractionalPart">1/4</span>';
            } else if (fractionalPart === 0.5) {
              fractionText = '<span class="fractionalPart">1/2</span>';
            } else if (fractionalPart === 0.75) {
              fractionText = '<span class="fractionalPart">3/4</span>';
            } else {
              fractionText = `<span class="fractionalPart">${fractionalPart.toFixed(2)}</span>`;
            }

            if (wholeNumberPart === 0) {
              return fractionText; // Only show fractional part if whole number is 0
            } else {
              return `${wholeNumberPart}${fractionText}`;
            }
          }
        },
        async getOrderClass(slug){
            const order =  this.currentBrandTabs.findIndex(tab=>(tab.is_default && tab.slug==slug));
            this.orderClass =   order;//`order-${order}`;
        }
    },
    watch: {
        currentBrandTabs: {
            handler(newTabs) {
                this.getOrderClass("minimum-size");
            },
            deep: true,
            immediate: true,
        }
    },
};
</script>
<style>
#minimum-size .bg-img {
  top: 50px;
  left: 400px;
}
#minimum-size .content {
  max-width: 500px;
}
#minimum-size .minimum-width {
  border-top: 3px solid #999999;
  position: relative;
}
#minimum-size .minimum-width::before,
#minimum-size .minimum-width::after {
  content: '';
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg width='20' height='51' viewBox='0 0 20 51' fill='none' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M10.4395 32L18.6667 46.25H2.21221L10.4395 32Z' fill='%23999999'/%3e%3cpath d='M10.4395 2.18554e-08L10.4395 32' stroke='%23999999' stroke-width='2' stroke-dasharray='8 4'/%3e%3c/svg%3e ");
  width: 19px;
  height: 51px;
  background-size: contain;
  background-repeat: no-repeat;
  background-position: top center;
  position: absolute;
  top: -3px;
  left: -10px;
}
#minimum-size .minimum-width::after {
  left: auto;
  right: -10px;
}

#minimum-size .minimum-width {
  color: #797979;
  font-size: 12px;
  display: flex;
  justify-content: center;
  padding-top: 8px;
  min-height: 51px;
  flex-wrap: wrap;
  line-height: 1.2;
}
#minimum-size .fractionalPart {
  font-size: 10px;
}
#minimum-size .minimum-group {
  margin-top: 180px;
  padding-left: 80px;
  display: flex;
  gap: 115px;
}
#minimum-size .minimum-full-logo,
#minimum-size .minimum-small-logo {
  max-width: 210px;
}

#minimum-size .minimum-small-logo img,
#minimum-size .minimum-full-logo img {
    width: 100%;
}

#minimum-size .minimum-full-logo .mb-2,
#minimum-size .minimum-small-logo .mb-2 {
  min-height: 40px;
}

@media screen and (max-width: 992px) {
  #minimum-size .minimum-group {
    margin-top: 50px;
    padding-left: 0px;
    display: flex;
    gap: 50px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
}
</style>

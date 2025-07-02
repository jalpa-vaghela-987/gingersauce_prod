<template>
  <section class="align-self-start col-12 section-book" id="icons-book" :style="`order:${orderClass}`">
    <div class="content">
      <h1 class="mb-4">Feature Icons</h1>
      <p>
        Icons are the visual expression of our products, services or tools.<br />
        Simple, light, sophisticated and friendly, they communicate the core idea or component of
        the brand. While each icon is visually distinct, all icons should have consistent line
        weights and visual style.
      </p>
    </div>

    <div class="icons-group" v-if="brandbook.icon_family && brandbook.icon_family.length > 0">
      <IconsBlock
        v-for="(block, index) in iconsBlocks"
        :key="index"
        :img="block.img"
        :text="block.text"
      />
    </div>
    <div class="content">
       <WatermarkImage/>
    </div>
    <div class="bg-img">
      <svg
        width="558"
        height="521"
        viewBox="0 0 558 521"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M254.822 518.061C493.458 547.692 637.624 317.253 510.05 159.675C392.918 24.1022 190.65 193.306 111.327 134.754C-16.0352 40.7424 -272.337 -92.8524 -284.248 96.3094C-295.583 276.344 60.7259 493.961 254.822 518.061Z"
        />
      </svg>
    </div>
      <TabContents v-if="!isEditBook" :tabContents="tab.tab_contents"/>
      <SectionAdd v-else :class="`${tab.slug}-add-section`" :tabName="`${tab.slug.replace('-', '')}AddSection`" :tab="tab"/>
  </section>
</template>
<script>
import IconsBlock from './IconsBlock.vue';
import clientIcons from "@/utils/new-brand/client-icons.svg";
import SectionAdd from "./SectionAdd";
import TabContents from "./TabContents";
import {mapState} from "vuex";
import WatermarkImage from "./WatermarkImage";
export default {
    data() {
        return {
          iconsBlocks: [],
          orderClass: null
        };
    },
    props: { brandbook: Object, tab: Object },
    components:{
        IconsBlock,
        SectionAdd,
        TabContents,
        WatermarkImage
    },
    computed: {
      ...mapState(['isEditBook','currentBrandTabs']),
    },
    mounted() {
      this.getOrderClass('feature-icons');
      if(this.brandbook && this.brandbook.icon_family) {
        this.brandbook.icon_family.map((icon, index) => {
            this.iconsBlocks.push({
                img: icon.b64,
                text: icon.title,
            });
        });
      }
    },
    methods:{
        async getOrderClass(slug){
            const order =  this.currentBrandTabs.findIndex(tab=>(tab.is_default && tab.slug==slug));
            this.orderClass =   order;//`order-${order}`;
        }
    },
    watch: {
        currentBrandTabs: {
            handler(newTabs) {
                this.getOrderClass("feature-icons");
            },
            deep: true,
            immediate: true,
        }
    },
};
</script>
<style>
#feature-icons .bg-img {
  top: -100px;
  left: -210px;
}
.icons-group {
  margin-top: 150px;
  margin-bottom: 70px;
  display: grid;
  grid-template-columns: repeat(4, 105px);
  gap: 150px 68px;
}

@media screen and (max-width: 992px) {
  .icons-group {
    margin-top: 50px;
    margin-bottom: 0px;
    display: grid;
    gap: 50px;
  }
}

@media screen and (max-width: 768px) {
  .icons-group {
    grid-template-columns: repeat(2, auto);
  }
}
</style>

<template>
  <section class="align-self-start col-12 section-book" id="fonts-book" :style="`order:${orderClass}`">
    <div class="content">
      <h1 class="mb-4">Our Fonts</h1>
      <p>
        We use one English font and one Hebrew font. <br />
        <span v-if="brandbook.fonts_main && brandbook.fonts_main[1]">
            The primary font is {{ brandbook.fonts_main[1]?brandbook.fonts_main[1].font_face:null }}  and it has {{ (brandbook.fonts_main.length) ?  brandbook.fonts_main.length : 1 }} {{ (brandbook.fonts_main.length && brandbook.fonts_main.length > 0) ?  'weights' : 'weight' }} :
            <span v-if="brandbook.fonts_main.length && brandbook.fonts_main.length == 4">
                {{ brandbook.fonts_main[2].weight }}, {{ brandbook.fonts_main[1].weight }} & {{ brandbook.fonts_main[3].weight }}
            </span>
            <span v-if="brandbook.fonts_main.length && brandbook.fonts_main.length == 3">
                {{ brandbook.fonts_main[1].weight }} & {{ brandbook.fonts_main[2].weight }}
            </span>
            <span v-else>
                {{ brandbook.fonts_main[1].weight }}
            </span>
            .
        </span><br />
        <span v-if="brandbook.fonts_secondary && brandbook.fonts_secondary[1]">
            Our secondary font is {{ brandbook.fonts_secondary[1]?brandbook.fonts_secondary[1].font_face:null }}  and it has {{ (brandbook.fonts_secondary.length) ?  brandbook.fonts_secondary.length : 1 }} {{ (brandbook.fonts_secondary.length && brandbook.fonts_secondary.length > 0) ?  'weights' : 'weight' }} :
            <span v-if="brandbook.fonts_secondary.length && brandbook.fonts_secondary.length == 4">
                {{ brandbook.fonts_secondary[2].weight }}, {{ brandbook.fonts_secondary[1].weight }} & {{ brandbook.fonts_secondary[3].weight }}
            </span>
            <span v-if="brandbook.fonts_secondary.length && brandbook.fonts_secondary.length == 3">
                {{ brandbook.fonts_secondary[1].weight }} & {{ brandbook.fonts_secondary[2].weight }}
            </span>
            <span v-else>
                {{ brandbook.fonts_secondary[1].weight }}
            </span>
            .
        </span>
        <WatermarkImage/>
      </p>
      <FontBlock
        v-for="(block, index) in fontBlocks"
        :key="index"
        :name="block.name"
        :fonts="block.fonts"
        :text="block.text"
        :brand="brandbook.brand"
      />
    </div>

    <div class="bg" v-if="brandbook.fonts_main" :style="{ fontFamily: brandbook.fonts_main[1]?brandbook.fonts_main[1].font_face:'' }">
      {{ brandbook.fonts_main[1]?brandbook.fonts_main[1].font_face:'' }}
    </div>
      <TabContents v-if="!isEditBook" :tabContents="tab.tab_contents"/>
      <SectionAdd v-else :class="`${tab.slug}-add-section`" :tabName="`${tab.slug.replace('-', '')}AddSection`" :tab="tab"/>
  </section>
</template>
<script>
import FontBlock from './FontBlock.vue';
import SectionAdd from "./SectionAdd";
import TabContents from "./TabContents";
import {mapState} from "vuex";
import WatermarkImage from "./WatermarkImage";
export default {
    data() {
    return {
            fontBlocks: [],
            orderClass: null
        };
    },
    props: { brandbook: Object, tab: Object },
    components:{
        FontBlock,
        SectionAdd,
        TabContents,
        WatermarkImage
    },
    computed: {
        ...mapState(['currentBrandTabs', 'isEditBook']),
    },
    mounted() {
        if(this.brandbook) {
          if(this.brandbook?.fonts_main?.[1]) {
              this.fontBlocks.push({
                  name: this.brandbook.fonts_main[1]?.font_face,
                  text: 'Primary Font',
                  fonts: this.brandbook.fonts_main,
              })
          }

          if(this.brandbook?.fonts_secondary?.[1]) {
              this.fontBlocks.push({
                  name: this.brandbook.fonts_secondary[1]?.font_face,
                  text: 'Secondary Font',
                  fonts: this.brandbook.fonts_secondary
              })
          }
          this.getOrderClass('our-fonts');
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
                this.getOrderClass("our-fonts");
            },
            deep: true,
            immediate: true,
        }
    },
};
</script>
<style>
#our-fonts .bg {
  top: -30px;
  font-size: 200px;
  left: -50px;
  line-height: 1;
  font-weight: 800;
}
.fonts-group {
  margin-top: 150px;
  margin-bottom: 70px;
  display: grid;
  grid-template-columns: repeat(4, 105px);
  gap: 150px 68px;
}
#our-fonts {
  margin-bottom: 95px;
}

@media screen and (max-width: 992px) {
  #our-fonts {
    margin-bottom: 0px;
  }
  #our-fonts .bg {
    font-size: 130px;
    top: 0px;
    left: 10px;
    line-height: 1;
  }
}
</style>

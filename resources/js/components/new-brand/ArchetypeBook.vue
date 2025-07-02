<template>
  <section class="align-self-start col-12 section-book" id="archetype-book" :style="`order:${orderClass}`">
    <div class="content">
      <h1 class="mb-4">Brand Archetype</h1>
      <p>
        The brand archetype is the character of a brand: a live representation that is created
        taking into consideration all the nuances of the target audience and the brand’s concept. A
        character that the audience can relate to. Once the archetype is defined, you will now know
        how people will see, and comprehend the brand. You will know what the brand will sound,
        look, and behave in certain situations. You will understand its values, and views on life.
        Knowing an archetype allows you to create a full-fledged personality, and structure further
        brand strategy.
      </p>
    </div>
    <div class="archetype-wrapper" v-if="brandbook.voices.length > 0">
      <ArchetypeBlock
        v-for="(brandArchetype, index) in brandbook.brand_archetype"
        :key="index"
        :img="brandArchetype.image"
        :title="brandArchetype.title"
        :text="brandArchetype.description"
        :sample="brandArchetype.short_description"
      />
    </div>
    <WatermarkImage/>
    <div class="bg-img left-0 top-0">
      <svg
        width="444"
        height="553"
        viewBox="0 0 444 553"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M125.391 481.069C240.299 605.154 433.96 556.48 443.441 419.58C447.59 298.42 252.977 289.988 239.147 224.495C216.942 119.339 144.442 -64.5981 43.3309 24.12C-52.9016 108.557 31.9297 380.145 125.391 481.069Z"
        />
      </svg>
    </div>
    <div class="bg-img bg-img2 right-0 top-0">
      <svg
        width="619"
        height="624"
        viewBox="0 0 619 624"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M581.209 404.305C729.802 256.636 668.283 11.083 502.5 0.7948C355.835 -2.91839 348.266 244.58 269.204 263.004C142.261 292.586 -79.33 387.116 29.391 514.504C132.866 635.746 460.35 524.411 581.209 404.305Z"
          fill="#F2F2F2"
        />
      </svg>
    </div>
      <TabContents v-if="!isEditBook" :tabContents="tab.tab_contents"/>
      <SectionAdd v-else  :class="`${tab.slug}-add-section`" :tabName="`${tab.slug.replace('-', '')}AddSection`" :tab="tab"/>
  </section>
</template>
<script>
import ArchetypeBlock from './ArchetypeBlock.vue';
import SectionAdd from "./SectionAdd";
import TabContents from "./TabContents";
import {mapState} from "vuex";
import WatermarkImage from "./WatermarkImage";
export default {
    data() {
        return {
            orderClass: null
        }
    },
    components:{
        SectionAdd,
        TabContents,
        ArchetypeBlock,
        WatermarkImage
    },
    props: { brandbook: Object, tab: Object },
    computed: {
        ...mapState(['isEditBook','currentBrandTabs'])
    },
    mounted(){
        this.getOrderClass('brand-archetype');
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
                this.getOrderClass("brand-archetype");
            },
            deep: true,
            immediate: true,
        }
    },
}
</script>

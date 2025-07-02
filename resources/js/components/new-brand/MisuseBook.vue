<template>
  <section class="align-self-start col-12 section-book" id="misuse-book" :style="`order:${orderClass}`">
    <div class="content">
        <span v-if="isEditBook">
            <EditDefaultInput
                :value="(brandbook.misuse_title) ? brandbook.misuse_title : 'Logo Misuse'"
                filed="misuse_title"
            />
            <EditDefaultDescription
                :description="(brandbook.misuse_text) ? brandbook.misuse_text : setDefaultDescription"
                filed="misuse_text"
            />
        </span>
        <span v-else>
            <h1 class="mb-4">{{ (brandbook.misuse_title) ? brandbook.misuse_title : 'Logo Misuse' }}</h1>
            <span v-if="brandbook.misuse_text" v-html="brandbook.misuse_text"></span>
            <span v-else v-html="setDefaultDescription"></span>
        </span>
    </div>

    <TabContents v-if="!isEditBook" :tabContents="tab.tab_contents"/>
    <SectionAdd v-else :class="`${tab.slug}-add-section`" :tabName="`${tab.slug.replace('-', '')}AddSection`" :tab="tab"/>

    <div class="misuse-group">
      <misuseBlock
        v-for="(misuse, index) in brandbook.missuses"
        :key="index"
        :misuse="misuse"
      />
    </div>
    <div class="content">
        <WatermarkImage/>
    </div>
    <div class="bg">Misuse</div>
  </section>
</template>
<script>
import MisuseBlock from './MisuseBlock.vue';
import EditDefaultDescription from "./EditDefaultDescription";
import EditDefaultInput from "./EditDefaultInput";
import {mapState} from "vuex";
import SectionAdd from "./SectionAdd";
import TabContents from "./TabContents";
import WatermarkImage from "./WatermarkImage";
export default {
  data() {
    return {
            orderClass: null
        };
    },
    props: { brandbook: Object, tab: Object },
    components:{
        MisuseBlock,
        EditDefaultDescription,
        EditDefaultInput,
        SectionAdd,
        TabContents,
        WatermarkImage
    },
    computed: {
      ...mapState(['isEditBook','currentBrandTabs']),
        setDefaultDescription() {
            return `<p>It is important that the appearance of the logo remains consistent. The logo should not be misinterpreted, modified, or added to. No attempt should be made to alter the logo in any way. Its orientation, colour and composition should remain as indicated in this document there are no exceptions.</p>`
        }
    },
    mounted() {
      this.getOrderClass('logo-misuse');
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
                this.getOrderClass("logo-misuse");
            },
            deep: true,
            immediate: true,
        }
    },
};
</script>
<style>
#logo-misuse .bg {
  font-size: 273px;
  right: 200px;
  bottom: auto;
  top: 100px;
  transform: rotate(-30deg);
  line-height: 1;
  width: fit-content;
  left: auto;
}
.misuse-group {
  margin-top: 200px;
  margin-bottom: 70px;
  display: grid;
  grid-template-columns: 300px 300px;
  gap: 170px;
}

@media screen and (max-width: 992px) {
  #logo-misuse .bg {
    right: 0px;
  }
  .misuse-group {
    margin-top: 50px;
    margin-bottom: 0px;
    gap: 25px;
  }
}

@media screen and (max-width: 768px) {
  .misuse-group {
    grid-template-columns: 1fr;
  }
}
</style>

<template>
  <section class="align-self-start col-12 section-book" id="vision-book" :style="`order:${orderClass}`">
    <div class="content">
        <span v-if="isEditBook">
            <EditDefaultInput
                :value="(brandbook.vision_title) ? brandbook.vision_title : 'Vision'"
                filed="vision_title"
            />
            <EditDefaultDescription
                :description="(brandbook.vision_text) ? brandbook.vision_text : (brandbook.vision) ? brandbook.vision : ''"
                filed="vision_text"
            />
        </span>
        <span v-else>
            <h1 class="mb-4">{{ (brandbook.vision_title) ? brandbook.vision_title : 'Vision' }}</h1>
            <p class="fs-34" v-if="brandbook.vision_text" v-html="brandbook.vision_text"></p>
            <p class="fs-34 lh-sm" v-else v-html="brandbook.vision"></p>
        </span>
        <WatermarkImage/>
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
    props: { brandbook: Object, tab: Object },
    components: {TabContents,  EditDefaultDescription, EditDefaultInput, SectionAdd, WatermarkImage },
    data() {
        return {
            orderClass: null
        }
    },
    computed: {
        ...mapState(['isEditBook','currentBrandTabs'])
    },
    mounted(){
        this.getOrderClass('vision');
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
                this.getOrderClass("vision");
            },
            deep: true,
            immediate: true,
        }
    },
};
</script>

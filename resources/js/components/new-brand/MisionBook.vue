<template>
  <section class="align-self-start col-12 section-book" id="mision-book" :style="`order:${orderClass}`">
    <div class="content">
        <span v-if="isEditBook">
            <EditDefaultInput
                :value="(brandbook.mission_title) ? brandbook.mission_title : 'Mission'"
                filed="mission_title"
            />
            <EditDefaultDescription
                :description="(brandbook.mission_text) ? brandbook.mission_text : (brandbook.mission) ? brandbook.mission : '' "
                filed="mission_text"
            />
        </span>
        <span v-else>
            <h1 class="mb-4">{{ (brandbook.mission_title) ? brandbook.mission_title : 'Mission' }}</h1>
            <p class="fs-28" v-if="brandbook.mission_text" v-html="brandbook.mission_text"></p>
            <p class="fs-28 lh-sm" v-else v-html="brandbook.mission"></p>
        </span>
        <WatermarkImage/>
    </div>
    <div class="bg">M</div>
    <TabContents v-if="!isEditBook" :tabContents="tab.tab_contents"/>
    <SectionAdd v-else  :class="`${tab.slug}-add-section`" :tabName="`${tab.slug}AddSection`" :tab="tab"/>
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
    components: { EditDefaultDescription, EditDefaultInput, SectionAdd, TabContents, WatermarkImage },
    data() {
        return {
            orderClass: null
        }
    },
    computed: {
      ...mapState(['isEditBook','currentBrandTabs']),
    },
    mounted(){
        this.getOrderClass('mission');
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
                this.getOrderClass("mission");
            },
            deep: true,
            immediate: true,
        }
    },
};
</script>

<style scoped>
#mision-book {
  padding-top: 150px;
  min-height: 120vh;
}
.bg {
  font-size: 1250px;
  left: -100px;
  bottom: auto;
  top: 120px;
}
@media screen and (max-width: 992px) {
  #mision-book {
    min-height: 600px;
    padding-top: 50px;
  }
  .bg {
    font-size: 800px;
    left: -200px;
    line-height: 1;
    top: -150px;
  }
}
</style>

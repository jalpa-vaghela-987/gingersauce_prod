<template>
  <section class="align-self-start col-12 section-book" id="values-book" :style="`order:${orderClass}`">
    <div class="content">
        <span v-if="isEditBook">
            <EditDefaultInput
                :value="(brandbook.core_title) ? brandbook.core_title : 'Core Values'"
                filed="core_title"
            />
            <EditDefaultDescription
                :description="(brandbook.core_text) ? brandbook.core_text : setDefaultDescription"
                filed="core_text"
            />
        </span>
        <span v-else>
            <h1 class="mb-4">{{ (brandbook.core_title) ? brandbook.core_title : 'Core Values' }}</h1>
            <span v-if="brandbook.core_text" v-html="brandbook.core_text"></span>
            <span v-else v-html="setDefaultDescription"></span>
        </span>
        <div class="content">
            <WatermarkImage/>
        </div>
       <ul class="mt-60 mb-50">
          <li v-for="coreValue in brandbook.core_values" :key="coreValue.index" class="d-flex gap-4">
              <div class="icon flex-shrink-0 align-self-start">
                  <img :src="coreValue.image" v-if="coreValue.image">
              </div>
              <div class="text">
                  <h3 class="fs-24 fw-light mb-2" v-if="coreValue.title">{{ coreValue.title }}</h3>
                  <p class="fs-12" v-if="coreValue.description">
                      {{ coreValue.description }}
                  </p>
              </div>
          </li>
        </ul>
        <DownloadBtn v-if="isDownloadBtn"
            :type="`core-values`"
        />
    </div>
    <div class="bg-img">
      <svg
        width="469"
        height="433"
        viewBox="0 0 469 433"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M428.788 226.167C430.835 230.351 440.661 231.932 449.443 227.057C458.224 222.183 464.437 215.909 465.074 210.658C465.995 203.068 451.888 204.463 443.106 209.337C434.325 214.212 425.37 219.183 428.788 226.167Z"
        />
        <path
          d="M140.352 342.627C38.5454 331.185 1.00713 214.609 69.1108 158.136C130.761 110.306 198.3 205.814 236.841 188.11C298.722 159.685 417.887 127.033 404.571 211.789C391.897 292.455 223.157 351.933 140.352 342.627Z"
        />
      </svg>
    </div>
      <TabContents v-if="!isEditBook" :tabContents="tab.tab_contents"/>
      <SectionAdd v-else  :class="`${tab.slug}-add-section`" :tabName="`${tab.slug.replace('-', '')}AddSection`" :tab="tab"/>
  </section>
</template>
<script>
import DownloadBtn from './DownloadBtn.vue';
import EditDefaultDescription from "./EditDefaultDescription";
import EditDefaultInput from "./EditDefaultInput";
import {mapState} from "vuex";
import SectionAdd from "./SectionAdd";
import TabContents from "./TabContents";
import WatermarkImage from "./WatermarkImage";
export default {
    data() {
        return {
            orderClass: null,
            isDownloadBtn: false
        }
    },
    components:{
        DownloadBtn,
        EditDefaultDescription,
        EditDefaultInput,
        SectionAdd,
        TabContents,
        WatermarkImage
    },
    props: { brandbook: Object, tab: Object },
    computed: {
      ...mapState(['isEditBook','currentBrandTabs']),
        setDefaultDescription() {
            return `<p>Company values matter. Every successful company has a set of company values to assist their employees in achieving their goals as well as the company’s. They are the essence of the company’s identity and summarises the purpose of their existence. Company values are a guide on how the company should run and they are normally integrated in the company’s mission statement. Companies should try to establish their company values as a team instead of just the leader or management. By doing so, everyone in the company would feel belong and they would feel needed and not neglected.</p>`
        }
    },
    mounted(){
        this.getOrderClass('core-values');
        if(this.brandbook.core_values && this.brandbook.core_values.length > 0) {
            let coreValue = this.brandbook.core_values;
            for (let i = 0; i < coreValue.length; i++) {
                if(coreValue[i].image != '' && coreValue[i].image != null) {
                    this.isDownloadBtn = true;
                    break;
                }
            }
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
                this.getOrderClass("core-values");
            },
            deep: true,
            immediate: true,
        }
    },
}
</script>
<style scoped>
#core-values {
  padding-bottom: 60px;
}
ul {
  list-style: none;
  padding: 0px;
}
ul li:not(:last-child) {
  margin-bottom: 50px;
}
ul .fs-12 {
  line-height: 1.7;
  margin-bottom: 0px;
}
ul li img {
    width: 55px;
    height: 55px;
}
</style>

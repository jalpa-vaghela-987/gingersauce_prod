<template>
    <section class="align-self-start col-12 section-book" id="logo-book" :style="`order:${orderClass}`">
        <div class="content">
            <span v-if="isEditBook">
                <EditDefaultInput
                    :value="(brandbook.logo_title) ? brandbook.logo_title : 'Our Logo'"
                    filed="logo_title"
                />
                <EditDefaultDescription
                    :description="(brandbook.logo_text) ? brandbook.logo_text : setDefaultDescription"
                    filed="logo_text"
                />
            </span>
            <span v-else>
                <h1 class="mb-4">{{ (brandbook.logo_title) ? brandbook.logo_title : 'Our Logo' }}</h1>
                <span v-if="brandbook.logo_text" v-html="brandbook.logo_text"></span>
                <span v-else v-html="setDefaultDescription"></span>
            </span>

            <div class="logo-group">
                <div class="text-center">
                    <img class="logo_full" :src="brandbook.logo_b64">
                </div>
                <p class="mt-4 fs-12 mb-0 text-center">Masterbrand logo & slogan</p>
                <div class="content">
                    <WatermarkImage/>
                </div>
            </div>
            <DownloadBtn
                :type="`logo`"
            />
        </div>
        <div class="bg-img left-0 top-0">
            <svg
                width="455"
                height="317"
                viewBox="0 0 455 317"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M0.460148 313.492C122.577 119.306 302.32 20.9837 409.782 0.906004C422.403 -1.45197 447.291 0.877602 453.22 32.6117C460.183 69.8778 435.057 90.5624 422.436 92.9204C334.797 109.294 184.136 173.676 70.091 316.194C47.3123 315.294 24.0284 314.392 0.460148 313.492Z"
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
    data(){
        return {
            orderClass: null
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
            return `<p>We are very proud of our logo, and we require that you follow these guidelines to ensure it always looks its best.</p>`
        }
    },
    mounted(){
        this.getOrderClass('logo');
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
                this.getOrderClass("logo");
            },
            deep: true,
            immediate: true,
        }
    },
}
</script>
<style>
#logo .logo-group {
    margin: 105px 0 25px;
    width: fit-content;
@media screen and (max-width: 992px) {
    margin: 50px 0 25px;
}
}
#logo .logo_full {
    height: 155px;
    max-width:  346px;
@media screen and (max-width: 992px) {
    max-width: 100%;
}
}
#logo .text-center img {
    display: inline-block !important;
}
</style>

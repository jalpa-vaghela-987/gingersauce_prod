<template>
    <section class="align-self-start col-12 section-book" :style="`order:${orderClass}`">
        <div class="content">
            <span v-if="isEditBook">
                <EditDefaultInput
                    :value="(brandbook.introduction_title) ? brandbook.introduction_title : 'Introduction'"
                    filed="introduction_title" />
                <EditDefaultDescription
                    :description="(brandbook.introduction_text) ? brandbook.introduction_text : setDefaultDescription"
                    filed="introduction_text" />
            </span>
            <span v-else>
                <h1 class="mb-4">{{ (brandbook.introduction_title) ? brandbook.introduction_title : 'Introduction' }}
                </h1>
                <span v-if="brandbook.introduction_text" v-html="brandbook.introduction_text"></span>
                <span v-else v-html="setDefaultDescription"></span>
            </span>
            <WatermarkImage/>
        </div>
        <div class="bg">ntr</div>
        <TabContents v-if="!isEditBook" :tabContents="tab.tab_contents"/>
        <SectionAdd v-else :class="`${tab.slug}-add-section`" :tabName="`${tab.slug.replace('-', '')}AddSection`" :tab="tab"/>
    </section>
</template>

<script>
import { mapState } from "vuex";
import EditDefaultInput from "./EditDefaultInput";
import EditDefaultDescription from "./EditDefaultDescription";
import SectionAdd from './SectionAdd.vue';
import TabContents from "./TabContents";
import WatermarkImage from './WatermarkImage.vue'

export default {
    props: { brandbook: Object, tab: Object },
    components: {TabContents, EditDefaultDescription, EditDefaultInput, SectionAdd, WatermarkImage },
    data() {
        return {
            orderClass: null
        }
    },
    computed: {
        ...mapState(['isEditBook', 'currentBrandTabs']),
        setDefaultDescription() {
            return `<p> Welcome to the official brand guidelines of the ${this.brandbook.brand} brand and assets. This document is intended to educate anyone who is responsible for creating internal or external communications using the ${this.brandbook.brand} brand. <br /> It is important that we all share a basic understanding of how and when to use our identity. These Identity Standards are intended to introduce you to the basic usage. We want to make it easy for you to integrate ${this.brandbook.brand} in all media formats while respecting our brand and legal/licensing restrictions.</p><p>Note that by using these resources, you accept our <a href=\"#\" class=\"link\">Terms of Service</a>. Usage of these resources may also be covered by the <a href=\"#\" class=\"link\">${this.brandbook.brand} End User Agreement</a> and our <a href=\"#\" class=\"link\">Privacy Policy</a>.</p>`
        },
    },
    mounted(){
        this.getOrderClass('introduction');
    },
    methods:{
        async getOrderClass(slug){
            const order =  this.currentBrandTabs.findIndex(tab=>(tab.is_default && tab.slug==slug));
            this.orderClass =   order;
        }
    },
    watch: {
        currentBrandTabs: {
            handler(newTabs) {
                this.getOrderClass("introduction");
            },
            deep: true,
            immediate: true,
        }
    },
};
</script>

<template>
    <section class="align-self-start col-12 section-book custom-book">
        <TabContents v-if="!isEditBook" :tabContents="tab.tab_contents"/>
        <SectionAdd v-else :class="`${tab.slug}-add-section`" :tabName="`${tab.slug.replace('-', '')}AddSection`" :tab="tab"/>
        <div class="content">
            <WatermarkImage/>
        </div>
        <div class="bg">{{ bgVal }}</div>
    </section>
</template>

<script>
import SectionAdd from "./SectionAdd";
import TabContents from "./TabContents";
import {mapState} from "vuex";
import WatermarkImage from "./WatermarkImage";

export default {
    data() {
        return {
            customTabs: []
        }
    },
    props: {
        tab_contents: {
            type: Array,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        tab: Object
    },
    computed: {
        ...mapState(['isEditBook']),
        bgVal() {
            return this.title.charAt(0).toUpperCase();
        }
    },
    components:{
        SectionAdd,
        TabContents,
        WatermarkImage
    },
};
</script>

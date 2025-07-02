<template>
    <section class="align-self-start col-12 p-0 pt-4" :style="`order:${orderClass}`">
        <div class="cover-img">
            <img :src="img" alt="cover image" />
        </div>
        <WatermarkImage />
    </section>
</template>

<script>
import {mapState} from "vuex";
import WatermarkImage from "./WatermarkImage";

export default {
    data() {
        return {
            orderClass: null
        }
    },
    components: {WatermarkImage },
    props: {
        img: {
            type: String,
            required: true,
        },
        tabName: {
            type: String,
            required: true,
        }
    },
    computed: {
        ...mapState(['currentBrandTabs'])
    },
    mounted(){
        this.getOrderClass(this.tabName);
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
                this.getOrderClass(this.tabName);
            },
            deep: true,
            immediate: true,
        }
    },
};
</script>

<template>
    <section class="align-self-start col-12" id="section-new">
            <div class="content">
                <div  v-for="(tabContent, index) in tabContents"
                      :key="index"
                >
                    <h1 v-if="tabContent.title" class="mb-4">{{tabContent.title}}</h1>
                    <p v-if="tabContent.description" class="mb-2" v-html="tabContent.description"></p>
                    <img v-if="tabContent.image" :src="tabContent.image" :style="{width : tabContent.width}" class="mb-2">
                </div>
            </div>
        </section>
</template>
<script>
import WatermarkImage from "./WatermarkImage";

export default {
    name: 'TabContents',
    props: {tabContents: Array},
    data() {
        return {}
    },
    components:{
        WatermarkImage
    },
}
</script>

<template>
    <div class="d-flex gap-3 colors-line">
        <ColorBlock v-for="(color, index) in colors" :key="index" :color="color" :style="blockStyle" />
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import ColorBlock from '../GridBlocks/ColorBlock.vue';
    import FourElements from "../GridBlocks/FourElements.vue";
    import MockupBlock from "../GridBlocks/MockupBlock.vue";
    import ThreeElements from "../GridBlocks/ThreeElements.vue";

    // Define the component
    export default Vue.extend({
        components: {
            ColorBlock,
            FourElements,
            MockupBlock,
            ThreeElements,
        },
        props: {
            colors: {
                type: Array,
                default: [],
            },
        },
        data() {
            return {};
        },
        computed: {
            blockStyle() {
                const n = this.colors.length;
                return {
                    maxWidth: `calc((100% - (${n - 1} * 15px) - 7px) / ${n})`,
                };
            },
        },
    });
</script>

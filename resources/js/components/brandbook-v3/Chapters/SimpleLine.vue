<template>
    <div class="simple-line-wrapper">
        <!-- For blockIndex === 0 -->
        <template v-if="!blockIndex && blockIndex !== 0">
            <!-- First row -->
            <div class="d-flex gap-3 flex-wrap">
                <mockup-block-spaces
                    v-for="(element, index) in firstRowElements"
                    :key="`first-${index}`"
                    :img-src="element.b64"
                    grid="columns-1"
                    :elements="defaultElements"
                />
            </div>

            <!-- Second row -->
            <div class="d-flex gap-3 flex-wrap mt-3" v-if="secondRowElements.length">
                <mockup-block-spaces
                    v-for="(element, index) in secondRowElements"
                    :key="`second-${index}`"
                    :img-src="element.b64"
                    grid="columns-1"
                    :elements="defaultElements"
                />
            </div>
        </template>
        <!-- For undefined blockIndex (or not 0) -->
        <template v-else-if="blockIndex === 0">
            <div class="d-flex flex-column flex-md-row gap-3 flex-wrap">
                <mockup-block-spaces
                    v-for="(element, index) in graphicElement"
                    :key="`no-index-${index}`"
                    :img-src="element.b64"
                    grid="columns-1"
                    :elements="defaultElements"
                />
            </div>
        </template>
    </div>
</template>
<script>
    import MockupBlockSpaces from '../GridBlocks/MockupBlockSpaces.vue';

    export default {
        components: {MockupBlockSpaces},
        props: {
            blockIndex: {
                type: Number,
                default: null,
            },
            graphicElement: {
                type: Array,
                default: () => []
            },
        },
        computed: {
            defaultElements() {
                return [
                    { type: 'save', text: 'PNG' },
                    { type: 'save', text: 'SVG' },
                    { type: 'copy', text: 'PNG' },
                    { type: 'copy', text: 'SVG' }
                ];
            },
            firstRowElements() {
                const count = this.graphicElement.length;
                if (count <= 3) return this.graphicElement;
                if (count === 4) return this.graphicElement.slice(0, 2);
                return this.graphicElement.slice(0, 3);
            },
            secondRowElements() {
                const count = this.graphicElement.length;
                if (count === 4) return this.graphicElement.slice(2);
                if (count > 4) return this.graphicElement.slice(3);
                return [];
            }
        },
        data() {
            return {};
        }
    };
</script>
<style scoped>
    .simple-line-wrapper {
        display: flex;
        flex-direction: column;
    }
</style>

<template>
    <div
        class="wrapper-default-block d-flex align-items-center justify-content-center flex-grow-1 brand-archetype-line">
        <span class="data-name">Brand Archetype</span>
        <div class="default-block core-values-block-wrap w-100">
            <h3 class="fw-boldest fs-32">Brand Archetype</h3>
            <div class="archetype-wrapper justify-content-center">
                <BrandArchetype
                    v-for="archetype in archetypes"
                    :img="archetype.image"
                    :title="archetype.title"
                    :text="archetype.description"
                    :sample="archetype.short_description"
                />
            </div>
        </div>
    </div>
</template>
<script>
    import BrandArchetype from '../GridBlocks/BrandArchetype/BrandArchetype.vue';

    export default {
        components: {
            BrandArchetype
        },
        props: {
            archetypes: {
                type: Array,
                default: []
            }
        },
        data() {
            return {};
        },
    };
</script>

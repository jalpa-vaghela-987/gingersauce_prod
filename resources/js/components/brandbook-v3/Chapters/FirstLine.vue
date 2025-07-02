<template>
    <div class="d-flex gap-3 first-line">
        <FourElements :approved="approved" :logo="logo"/>
        <ThreeElements :icon_b64="icon_b64" :approved_icon="approved_icon"/>
        <MockupBlock
            v-if="mockups.length > 1"
            :imgSrc="mockups[1].image"
            :elements="[
        { type: 'save', text: 'JPG' },
        { type: 'copy', text: 'JPG' },
      ]"
            dataName="Mockup"
        />
    </div>
</template>

<template>
    <div class="d-flex gap-3 first-line">
        <template v-if="!blockIndex && blockIndex !== 0">
            <FourElements :approved="approved" :logo="logo"/>
            <ThreeElements :icon_b64="icon_b64" :approved_icon="approved_icon"/>
            <MockupBlock
                v-if="mockups.length > 1"
                :imgSrc="mockups[1].image"
                :elements="[
          { type: 'save', text: 'JPG' },
          { type: 'copy', text: 'JPG' },
        ]"
                dataName="Mockup"
            />
        </template>
        <FourElements :approved="approved" :logo="logo" v-else-if="blockIndex === 0"/>
        <ThreeElements :icon_b64="icon_b64" :approved_icon="approved_icon" v-else-if="blockIndex === 1"/>
        <MockupBlock
            v-else-if="blockIndex === 2 && mockups.length > 1"
            :imgSrc="mockups[1].image"
            :elements="[
        { type: 'save', text: 'JPG' },
        { type: 'copy', text: 'JPG' },
      ]"
            dataName="Mockup"
        />
    </div>
</template>
<script>
    import FourElements from '../GridBlocks/FourElements.vue';
    import MockupBlock from '../GridBlocks/MockupBlock.vue';
    import ThreeElements from '../GridBlocks/ThreeElements.vue';

    export default {
        components: {FourElements, MockupBlock, ThreeElements},
        props: {
            blockIndex: {
                type: Number,
                default: null,
            },
            approved: {
                type: Array,
                default: () => []
            },
            mockups: {
                type: Array,
                default: () => []
            },
            approved_icon: {
                type: Array,
                default: () => []
            },
            icon_b64: {
                type: String,
                default: () => ''
            },
            logo: {
                type: Object,
                default: () => ({})
            }
        },
        data() {
            return {};
        },
    };
</script>

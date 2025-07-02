<template>
  <div class="d-flex gap-3 icons-line">
    <IconBlock
      v-for="(icon, index) in icon_family"
      :key="index"
      :img="icon.b64"
      :text="icon.title"
      grid="columns-1"
      :elements="[
        { type: 'save', text: 'PNG' },
        { type: 'copy', text: 'PNG' },
        { type: 'save', text: 'SVG' },
        { type: 'copy', text: 'SVG' },
      ]"
    />
  </div>
</template>
<script>
    import IconBlock from '../GridBlocks/IconBlock.vue';

    export default {
        components: {
            IconBlock,
        },
        props: {
            icon_family: {
                type: Array,
                default: () => []
            },
        },
        data() {
            return {};
        },
    };
</script>

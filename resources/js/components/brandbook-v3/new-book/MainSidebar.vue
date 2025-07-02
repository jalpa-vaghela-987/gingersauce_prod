<template>
    <aside class="col-3 is_expanded fixed-top flex-shrink-0 px-0 d-none d-xl-block" v-if="brandbook">
        <ZeroLine v-if="brandbook.logo_b64" :mockups="brandbook.mockups" :logo="brandbook.logo_b64" class="d-none d-xl-flex"/>
        <BrandDesigner :user="brandbook.user"/>
    </aside>
</template>
<script>
    import ZeroLine from '../Chapters/ZeroLine.vue';
    import BrandDesigner from './sidebar/BrandDesigner.vue';

    export default {
        components: {ZeroLine, BrandDesigner},
        props:{
            brandbook: {
                type: Object,
                default: () => ({
                    mockups: [],
                    logo_b64: ''
                })
            },
        },
        data() {
            return {};
        },
    };
</script>

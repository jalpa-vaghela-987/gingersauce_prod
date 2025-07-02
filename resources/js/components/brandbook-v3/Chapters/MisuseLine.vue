<template>
    <div class="d-flex gap-3 misuse-line">
        <div class="wrapper-default-block">
            <span class="data-name">Misuse</span>
            <div class="default-block misuse-block-wrap">
                <MisuseBlock
                    v-for="(missuse, index) in missuses"
                    :key="index"
                    :img="missuse.logo_b64"
                    :text="missuse.title"
                    :customStyle="missuse.style"
                />
            </div>
        </div>
    </div>
</template>

<script>
    import MisuseBlock from '../GridBlocks/Misuse/MisuseBlock.vue';

    export default {
        components: {
            MisuseBlock
        },
        props: {
            missuses: {
                type: Array,
                default: () => []
            },
        },
        data() {
            return {};
        },
    };
</script>

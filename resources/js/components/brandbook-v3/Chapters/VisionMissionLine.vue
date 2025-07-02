<template>
    <div class="d-flex gap-3">
        <TextBlock
                v-for="(info, index) in textElements"
                :key="info.title"
                :info="info"
                :dataName="info.dataName"
        />
    </div>
</template>
<script>
    import TextBlock from '../GridBlocks/TextBlock.vue';

    export default {
        components: {
            TextBlock,
        },
        props: {
            vision: {
                type: String,
                default: ''
            },
            mission: {
                type: String,
                default: ''
            },
        },
        data() {
            return {};
        },
        computed: {
            textElements() {
                return [
                    {
                        title: 'Vision',
                        text: this.vision,
                        dataName: 'Vision',
                    },
                    {
                        title: 'Mission',
                        text: this.mission,
                        dataName: 'Mission',
                    },
                ];
            }
        }
    };
</script>

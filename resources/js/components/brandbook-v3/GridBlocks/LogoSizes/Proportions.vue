<template>
    <div class="wrapper-default-block proportions-block">
        <span v-if="dataName" class="data-name">{{ dataName }}</span>

        <div class="default-block d-flex align-items-center justify-content-center">
            <div class="proportions-block">
                <div class="proportions-left-arrow" :style="proportionsStyle">{{ proportionsY }}</div>

                <div class="proportions-wrapper">
                    <div class="proportions-top-arrow" :style="proportionsStyle">
                        {{ proportionsX }}
                    </div>
                    <div :style="proportionsStyle" class="proportions-element">
                        <img :src="logo" class="logo-proportions"></img>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            ratio: {
                type: Number,
                required: true,
            },
            proportionsX: {
                type: String,
                required: '',
            },
            proportionsY: {
                type: String,
                required: '',
            },
            logo: {
                type: String,
                default: ''
            },
            dataName: {
                type: String,
                required: false,
            },
        },
        data() {
            return {
                baseHeight: 35,
                smallScreenHeight: 50,
                windowWidth: window.innerWidth,
            };
        },
        computed: {
            proportionsStyle() {
                const height = this.windowWidth < 850 ? this.smallScreenHeight : this.baseHeight;
                return {
                    height: `${height}px`,
                    width: `${height * this.ratio}px`,
                };
            },
        },
        created() {
            window.addEventListener('resize', this.handleResize);
        },
        beforeDestroy() {
            window.removeEventListener('resize', this.handleResize);
        },
        methods: {
            handleResize() {
                this.windowWidth = window.innerWidth;
            },
        },
    };
</script>

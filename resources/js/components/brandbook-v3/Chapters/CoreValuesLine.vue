<template>
    <div class="d-flex gap-3 core-values-line">
        <div
            v-if="coreValuesIconCount > 0"
            class="wrapper-default-block magnif-glass d-flex align-items-center justify-content-center flex-grow-1"
            data-toggle="modal"
            data-target="#downloadModal"
            @click="handleDropdownClick"
        >
            <span class="data-name">Core Values</span>
            <div class="default-block core-values-block-wrap w-100">
                <h3 class="fw-boldest fs-32 mb-40">Core Values</h3>
                <div class="row gap-y-3">
                    <CoreValuesBlock v-for="(info, index) in coreValues" :key="index" :info="info"/>
                </div>
            </div>
        </div>
        <div
            v-else
            class="wrapper-default-block d-flex align-items-center justify-content-center flex-grow-1"
        >
            <span class="data-name">Core Values</span>
            <div class="default-block core-values-block-wrap w-100">
                <h3 class="fw-boldest fs-32 mb-40">Core Values</h3>
                <div class="row gap-y-3">
                    <CoreValuesBlock v-for="(info, index) in coreValues" :key="index" :info="info"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import CoreValuesBlock from '../GridBlocks/CoreValues/CoreValuesBlock.vue';
    import {EventBus} from "../../../event-bus";

    export default {
        components: {
            CoreValuesBlock
        },
        props: {
            coreValues: {
                type: Array,
                default: []
            }
        },
        data() {
            return {};
        },
        computed: {
            coreValuesIconCount() {
                let logoCount = 0;
                if (this.coreValues) {
                    this.coreValues.map(function (icon, index) {
                        if (icon.image) {
                            logoCount++;
                        }
                    });
                }
                return logoCount;
            }
        },
        methods: {
            setCoreValues() {
                let tempCoreValues = [];

                if (this.coreValues) {
                    this.coreValues.map(function (icon, index) {
                        if (!icon.image) {
                            return;
                        }
                        tempCoreValues.push({
                            colorBg: '#fff',
                            colorLogo: 'light',
                            logo: icon.image,
                        });
                    });
                }
                return tempCoreValues;
            },
            handleDropdownClick() {
                EventBus.$emit('show-modal', {
                    items: this.setCoreValues(),
                    title: 'Core Values'
                });
            },
        }
    };
</script>

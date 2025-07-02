<template>
    <div class="wrapper-default-block minimum-space-block">
        <span v-if="dataName" class="data-name">{{ dataName }}</span>

        <div class="default-block d-flex align-items-center justify-content-center">
            <div class="justify-content-xl-around minimum-group w-100">
                <div class="minimum-full-logo">
                    <div :style="{ width: widthFullLogo + 'px' }" class="mx-auto">
                        <img class="mb-2" :src="brandbook.logo_b64"/>
                        <div class="minimum-width">
              <span class="value">{{ widthFullLogo }}</span
              >px/ <span class="value" v-html="formatRoundedValue(widthFullLogoInMM)"></span>mm/
                            <span class="value" v-html="formatRoundedValue(widthFullLogoInInches)"></span>”
                        </div>
                    </div>

                    <div class="explain mt-3 fs-12 text-center">
                        The {{ brandbook.brand }} logo should never be smaller than {{ widthFullLogo }}px in digital or
                        <span v-html="formatRoundedValue(widthFullLogoInMM)"></span>mm in print.
                    </div>
                </div>
                <div class="minimum-small-logo" v-if="brandbook.icon!='skipped' && brandbook.icon_b64 != null">
                    <div :style="{ width: widthIcon + 'px' }" class="mx-auto">
                        <img v-if="brandbook.icon_b64" class="mb-2 d-flex align-content-center" :src="brandbook.icon_b64"/>
                        <div class="minimum-width"></div>
                    </div>

                    <div class="explain mt-3 fs-12 text-center">
                        The {{ brandbook.brand }} icon should never be smaller than {{ widthIcon }}px in digital or
                        <span v-html="formatRoundedValue(widthIconInMM)"></span>mm /
                        <span class="value" v-html="formatRoundedValue(widthIconInInches)"></span>" in print.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            brandbook: {
                type: Object,
                default: () => ({})
            },
            dataName: {
                type: String,
                required: false,
            },
        },
        data() {
            return {
                widthFullLogo: 160,
                widthIcon: 23,
                widthFullLogoInMM: 0,
                widthIconInMM: 0,
                windowWidth: window.innerWidth, // Store window width for reactive updates
            };
        },
        computed: {
            widthFullLogoInInches() {
                return this.widthFullLogo * 0.010417;
            },
            widthIconInInches() {
                return this.widthIcon * 0.010417;
            },
        },
        methods: {
            setActiveSection(id) {
                this.$emit('set-active-section', id);
            },
            formatRoundedValue(value) {
                const roundedValue = Math.round(value * 4) / 4; // Round to nearest 0.25
                const wholeNumberPart = Math.floor(roundedValue);
                const fractionalPart = roundedValue % 1;

                if (fractionalPart === 0) {
                    return wholeNumberPart; // No content if no fractional part
                } else {
                    let fractionText;
                    if (fractionalPart === 0.25) {
                        fractionText = '<span class="fractionalPart">1/4</span>';
                    } else if (fractionalPart === 0.5) {
                        fractionText = '<span class="fractionalPart">1/2</span>';
                    } else if (fractionalPart === 0.75) {
                        fractionText = '<span class="fractionalPart">3/4</span>';
                    } else {
                        fractionText = `<span class="fractionalPart">${fractionalPart.toFixed(2)}</span>`;
                    }

                    if (wholeNumberPart === 0) {
                        return fractionText; // Only show fractional part if whole number is 0
                    } else {
                        return `${wholeNumberPart}${fractionText}`;
                    }
                }
            },
            updateWindowWidth() {
                this.windowWidth = window.innerWidth;
            },
        },
        mounted() {
            if(this.brandbook.size =='quark') {
                this.widthFullLogo = 71;
                this.widthFullLogoInMM = 20;
                this.widthIcon = 10;
                this.widthIconInMM = 2.8;
            } else if(this.brandbook.size =='neutron') {
                this.widthFullLogo = 100;
                this.widthFullLogoInMM = 28;
                this.widthIcon = 14;
                this.widthIconInMM = 3.9;
            } else if(this.brandbook.size =='atom') {
                this.widthFullLogo = 160;
                this.widthFullLogoInMM = 45;
                this.widthIcon = 22;
                this.widthIconInMM = 6.9;
            } else if(this.brandbook.size =='molecule') {
                this.widthFullLogo = 214;
                this.widthFullLogoInMM = 60;
                this.widthIcon = 30;
                this.widthIconInMM = 8.4;
            } else {
                this.widthFullLogo = 0;
                this.widthFullLogoInMM = 0;
                this.widthIcon = 0;
                this.widthIconInMM = 0;
            }
            window.addEventListener('resize', this.updateWindowWidth);
        },
        beforeDestroy() {
            window.removeEventListener('resize', this.updateWindowWidth);
        },
    };
</script>

<template>
    <div
        v-if="logoVersions.length > 0"
        class="wrapper-default-block d-flex align-items-center justify-content-center flex-grow-1 magnif-glass"
        data-toggle="modal"
        data-target="#downloadModal"
        style="max-width: 350px;"
        @click="handleDropdownClick"
    >
        <span class="data-name">Logo versions</span>
        <div class="four-elements default-block">
            <div
                v-for="(logoVersion, index) in slicedLogoVersions"
                :key="index"
                :style="getLogoStyle(logoVersion)"
                class="d-flex align-items-center justify-content-center logo-block-v3 black-white"
            >
                <img :src="logoVersion.logo"/>
            </div>
        </div>
    </div>
</template>
<script>
    import {EventBus} from '../../../event-bus';

    export default {
        props: {
            approved: {
                type: Array,
                default: () => []
            },
            logo: {
                type: Object,
                default: () => ({})
            }
        },
        data() {
            return {
                localLogoVersionCount: 0,
                approvedLogoVersionCount: 0
            };
        },
        computed: {
            logoVersions() {
                const approvedLogoVersions = [];
                this.localLogoVersionCount = 0;
                this.approvedLogoVersionCount = 0;

                if (this.logo.logo_versions) {
                    this.logo.logo_versions.forEach((logo, index) => {
                        if (index === 0) return;
                        approvedLogoVersions.push({
                            colorBg: (logo.background === 'transparent') ? '#fff' : logo.background,
                            colorLogo: (logo.background === 'transparent') ? 'light' : 'dark',
                            logo: logo.logo_b64,
                        });
                        this.localLogoVersionCount++;
                    });
                }

                if (this.approved) {
                    this.approved.forEach(approved => {
                        approvedLogoVersions.push({
                            colorBg: (approved.background === 'transparent') ? '#fff' : approved.background,
                            colorLogo: (approved.background === 'transparent') ? 'light' : 'dark',
                            logo: approved.logo_b64,
                        });
                        this.approvedLogoVersionCount++;
                    });
                }

                return approvedLogoVersions;
            },
            slicedLogoVersions() {
                if (this.approvedLogoVersionCount > 0) {
                    return this.logoVersions.slice(this.localLogoVersionCount, this.localLogoVersionCount + 4);
                }
                return this.logoVersions.slice(0, this.localLogoVersionCount);
            }
        },
        methods: {
            getLogoStyle(logo) {
                return `background-color: ${logo.colorBg}; color: ${logo.colorLogo}; ${logo.customCss}`;
            },
            handleDropdownClick() {
                EventBus.$emit('show-modal', {
                    items: this.logoVersions,
                    title: 'Logo Versions',
                    isLogoVersions: true
                });
            }
        }

    };
</script>

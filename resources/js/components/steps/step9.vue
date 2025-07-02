<template>
    <div>
        <div v-if="!selected.length">
            <LogoVariations
                :colors="colors"
                :logo_versions="logo_versions"
                :logo="logo_versions[0].logo"
                @selectLogoVariations="selectLogoVariations"
                @saveAllLogoVariations="saveAllLogoVariations"
                @skip="skip"
            />
        </div>

        <div v-if="selected.length">
            <LogoApprovingVariations
                @approveLogoVariations="approveLogoVariations"
                :selected="selected"
                :colors="colors"
            />
        </div>
    </div>
</template>

<script>
import LogoVariations from "../logo-variations/logo-variations";
import LogoApprovingVariations from "../logo-variations/logo-approving";

export default {
    components: {
        LogoVariations,
        LogoApprovingVariations,
    },

    props: {
        logo: String,
        colors: Array,
        logo_versions: Array,
    },
    data() {
        return {
            approved: [],
            selected: [],
        };
    },
    mounted() {},

    methods: {
        skip() {
            this.$emit("forward", 10);
        },

        selectLogoVariations(variations) {
            this.selected = variations;
        },

        approveLogoVariations(data) {
            this.$emit("saveLogoVariations", data);
        },

        saveAllLogoVariations(variations) {
            this.$emit("saveAllLogoVariations", variations);
        },
    },
};
</script>

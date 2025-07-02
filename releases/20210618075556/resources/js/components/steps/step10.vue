<template>
    <div>
        <IconUploading
            :endpoints="endpoints"
            :colors="colors"
            @skip="skip"
            :icon="icon"
            :icon_b64="icon_b64"
            :icon_caption="iconCaption"
            @approveIcon="approveIcon"
            v-if="!approved"

        />

        <IconVariations
            :endpoints="endpoints"
            :colors="colors"
            :icon="icon"
            :forApproving="forApproving"
            @approveIconVariations="approveIconVariations"
            @saveAllIconVariations="saveAllIconVariations"
            @skip="skip"
            v-if="approved"
        />
    </div>
</template>

<script>
import IconVariations from "../icon-variations/icon-variations";
import IconUploading from "../icon-variations/icon-uploading.vue";
import translate from "../../utils/translate";

export default {
    components: {
        IconVariations,
        IconUploading,
    },

    props: {
        colors: Array,
        endpoints: Object,
        icon_caption: String,
        icon: String,
        icon_b64: String,
        all_icon_variations: Array,
    },
    data() {
        return {
            //uploaded: this.icon != null,
            //approved: false,
            
            //iconCaption: this.icon_caption,
            selected: [],
            //forApproving: [],
            hideFromApproving: [
                'Black & White Positive',
                'Secondary Color Positive',
                'Primary Color Positive'
            ]
        };
    },
    mounted() {
    },

    computed: {
        approved(){
            return this.uploaded && 
                this.all_icon_variations.length > 0 && 
                this.all_icon_variations != '[]';
        },

        uploaded(){
            return this.icon != null && this.icon != '[]' && this.icon != 'skipped';
        },

        iconCaption(){
            return this.icon_caption ? this.icon_caption : this.translate('Main Brand icon');
        },

        forApproving(){
            let icons = this.all_icon_variations;
            if(!Array.isArray(icons)){
                icons = JSON.parse(icons);
            }
            return icons.length ? 
                icons.filter(variation => {
                    return !this.hideFromApproving.includes(variation.title)
                }) :
                [];
        }
    },

    watch: {
        icon(){
            this.uploaded = this.icon != null;
        },
    },

    methods: {
        translate,
        skip() {
            this.$emit("forward", 12);
        },

        approveIcon(res) {
            console.log('res',res);
            this.$emit("approveIcon", res);
        },

        approveIconVariations(variations) {
            this.$emit("saveIconVariations", {
                icon: this.icon,
                icon_b64: "data:image/svg+xml;base64," + btoa(this.icon),
                icon_caption: this.icon_caption,
                approved_icon: variations,
            });
        },
        saveAllIconVariations(variations){
            this.$emit("saveAllIconVariations", variations);
        }
    },
};
</script>

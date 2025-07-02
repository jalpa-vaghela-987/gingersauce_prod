<template>
    <div class="mockup-container" v-if="params.src" @click="setSelected" :class="{ selected: selected }">
        <svg width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg"
             class="arrow-selected" v-if="selected" style="position: absolute">
            <path
                d="M21.7283 3.17453L8.5155 15.7445C8.15531 16.0871 7.57363 16.0849 7.21634 15.7395L0.266453 9.02029C-0.0908367 8.67485 -0.0885396 8.117 0.271736 7.77427L2.01103 6.11966C2.37122 5.77701 2.9529 5.77921 3.31019 6.12472L7.88766 10.5503L18.7091 0.255547C19.0693 -0.087107 19.651 -0.0849036 20.0083 0.260541L21.7335 1.92851C22.0908 2.27403 22.0885 2.83188 21.7283 3.17453Z"
                fill="#29B473"/>
        </svg>
        <div class="frame">
            <img :src="params.src" class="template" @load="img_loaded = true">
            <bags-and-glasses v-if="params.mask === 'bags-and-cups'" v-for="(covers, mask_name) in params.masks"
                              :images="images(covers)" :main_color="main_color"
                              :secondary_color="secondary_color" :key="mask_name"
                              :mask_name="mask_name" :white_logo="white_logo"
                              :isWhiteLogo="is_white_logo"></bags-and-glasses>

            <screens v-if="params.mask === 'screens'" v-for="(covers, mask_name) in params.masks"
                     :images="images(covers)" :mask_name="mask_name" :key="mask_name"
                     :main_color="main_color" :secondary_color="secondary_color" :third_color="third_color"
                     :brand="brand" :white_logo="white_logo" :isWhiteLogo="is_white_logo"></screens>

            <sign v-if="params.mask == 'sign'" :images="images(params.covers)"></sign>
            <div class="photo" v-if="typeof params.mask === 'undefined'">
                <img v-for="cover in params.covers" :src="getCover(cover)" :class="cover.name"
                     :style="{'transform': cover.transform}"/>
            </div>
        </div>
    </div>
</template>
<script>

import translate from '../../utils/translate';
import bagsAndGlasses from './svg/template-bags-cups';
import screens from './svg/screens';
import sign from './svg/sign';

export default {
    components: {
        bagsAndGlasses,
        screens,
        sign,
    },
    props     : {
        name           : String,
        logo_b64       : String,
        params         : Object,
        index          : Number,
        logo_variations: {},
        icon_variations: {},
        main_color     : String,
        secondary_color: String,
        third_color    : String,
        brand          : String,
        white_logo     : {},
        is_white_logo  : Boolean,
    },
    data() {
        return {
            selected  : false,
            img_loaded: false,
        };
    },

    mounted() {
        this.$root.$on( 'allow-select', index => {
            if ( index == this.index ) {
                this.selected = true;
            }
        } );
    },
    watch   : {},
    computed: {},
    methods : {
        translate,
        images( covers ) {
            let prepared = [];
            covers.forEach( cover => {
                prepared.push( {
                                   src : this.getCover( cover ),
                                   name: cover.name,
                               } );
            } );
            return prepared;
        },
        setSelected() {
            if ( ! this.img_loaded ) {
                return;
            }
            if ( this.selected ) {
                this.$emit( 'un_select', this.params.name );
                this.selected = false;
            } else {
                this.$emit( 'set_selected', this.index );
            }
        },
        getCover( cover ) {
            if ( cover.src === 'logo' ) {
                if ( cover.type === 'original' ) {
                    return this.logo_b64;
                }
                if ( cover.type === 'white' ) {
                    return this.white_logo.logo_b64;
                }
                return this.logo_variations[ cover.type ];
            } else if ( cover.src === 'icon' ) {
                return cover.type === 'original' ? this.icon_b64 : this.icon_variations[ cover.type ];
            }
        },
    },
};
</script>

<style lang=scss>
.step.step-18 {
    overflow: auto;

    .mockup-container.selected {
        border: 4px solid #29B473;
    }

    svg.mask {
        position: absolute;
        top: 0;
        left: 0;
    }
}

</style>

<template>
    <svg class="mask" :class="mask_name + '_mask'" xmlns="http://www.w3.org/2000/svg"
         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
         y="0px"
         viewBox="0 0 2000 1013" enable-background="new 0 0 2000 1013" xml:space="preserve">
        <defs>
            <pattern v-for="image in images" :id="image.name + '_image'" x="0%" y="0%" height="100%" width="100%"
                     viewBox="0 0 64 64">
                <image :x="image_positions[image.name].x" :y="image_positions[image.name].y"
                       :width="image_positions[image.name].width" :height="image_positions[image.name].height"
                       :xlink:href="image.src"></image>
            </pattern>
            <polygon v-if="mask_name==='background'" id="bag-small" points="1416.3,483.1 1442.4,776.5 1444.9,872.7 1454.6,946 1386,964.4 1379.3,964.4 1130.3,949.3 1136.5,888.4 1138,869.5
	1141.9,813.3 1149.1,749.9 1160.1,641.7 1166.4,566.6 1168.6,539.6 1165.9,539.2 1170.7,505.1 1170.3,490.8 1171.2,488.2
	1229.8,487 1230.8,486.2 "/>
            <polygon v-if="mask_name==='background'" id="cup-right" points="632.2,614 636.3,621.3 639.7,634.3 671.9,901 673.7,910 678.2,912.3 687.6,914 745.2,914.4 779.6,911.4
	791.8,908.3 796.3,903.9 799,891.3 831,628.5 835.4,616.9 836.6,614.3 "/>

            <polygon v-if="mask_name==='logos'" id="bag" points="864.3,227.8 1199.3,196.1 1190.1,456.6 853.1,464.7"/>
            <polygon v-if="mask_name==='logos'" id="cup-holder"
                     points="349,772.1 553,770.1 554.9,908.3 345.5,910"/>
            <polygon v-if="mask_name==='background'" id="cup-left"
                     points="481,613.2 485.4,621.3 488.9,634.3 520.9,900.1 523.9,909 529.7,912.7 544,912.7 594.4,914.4 628.8,911.4
            641,908.3 645.4,903.9 648.2,891.3 680.2,628.5 684.6,616.9 686.3,613.2"/>
        </defs>
        <use v-if="mask_name==='background'" xlink:href="#bag-small" :fill="main_color"
             style="mix-blend-mode: multiply"/>
        <use v-if="mask_name==='background'" xlink:href="#bag-small" fill="url(#bag-small_image)"
             :style="getStyles('background_bag-small_image')"/>
        <use v-if="mask_name==='background'" xlink:href="#cup-right" :fill="secondary_color"
             style="mix-blend-mode: multiply"/>
        <use v-if="mask_name==='background'" xlink:href="#cup-right" fill="url(#cup-right_image)"
             :style="getStyles('background_cup-right_image')"/>
        <use v-if="mask_name==='background'" xlink:href="#cup-left" fill="url(#cup-left_image)"/>
        <use v-if="mask_name==='logos'" xlink:href="#cup-holder" fill="url(#cup-holder_image)"/>
        <use v-if="mask_name==='logos'" xlink:href="#bag" fill="url(#bag_image)"
             :style="getStyles('logos_bag_image')"/>
    </svg>
</template>

<script>
export default {
    name : 'template-bags-cups',
    props: {
        mask_name      : String,
        images         : Array,
        main_color     : String,
        secondary_color: String,
        isWhiteLogo    : Boolean,
    },
    data() {
        return {
            image_positions: {
                'cup-holder': {
                    x     : '0%',
                    y     : '0.5%',
                    width : 64,
                    height: 50,
                },
                'cup-left'  : {
                    x     : '0.5%',
                    y     : '0%',
                    width : 40,
                    height: 40,
                },
                'bag'       : {
                    x     : '0%',
                    y     : '0.5%',
                    width : 50,
                    height: 50,
                },
                'bag-small' : {
                    x     : '0.5%',
                    y     : '1.3%',
                    width : 40,
                    height: 40,
                },
                'cup-right' : {
                    x     : '0.6%',
                    y     : '0%',
                    width : 40,
                    height: 40,
                },
            },
        };
    },
    methods: {
        getStyles( name ) {
            switch ( name ) {
                case 'logos_bag_image' :
                    return 'transform:  skewX(-3deg) translateX(-9px) rotate(-3deg) translateY(117px) skewY(-3deg) rotateY(3deg); mix-blend-mode: screen;';
                case 'background_bag-small_image' :
                    return 'transform-origin: 0 0; transform: skewX(-5deg ) translateX(53px); mix-blend-mode: multiply;';
                case 'background_cup-right_image' :
                    return 'mix-blend-mode: multiply;';
            }
        },
    },
};
</script>

<style scoped>

</style>

<template>
    <svg class="mask logos_mask" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
         x="0px" y="0px"
         viewBox="0 0 2000 1013" enable-background="new 0 0 2000 1013" xml:space="preserve">
                <defs>
            <pattern v-for="image in images" :id="image.name + '_image'" x="0%" y="0%" height="100%" width="100%"
                     viewBox="0 0 64 64">
                <image :x="image_positions[image.name].x" :y="image_positions[image.name].y"
                       :width="image_positions[image.name].width" :height="image_positions[image.name].height"
                       :xlink:href="image.src"
                       :style="{'transform': image_positions[image.name].transform}"></image>
            </pattern>
                    <polygon id="sign-logo" points="666.7,376.6 1225.9,342.9 1226.7,630.9 653.7,655.5 	"/>

                </defs>
        <use xlink:href="#sign-logo" fill="url(#sign_image)" style="mix-blend-mode: screen"/>
</svg>
</template>

<script>
export default {
    name : 'sign',
    props: {
        mask_name: String,
        images   : Array,
    },
    data() {
        return {
            image_positions: {
                sign: {
                    x        : '0%',
                    y        : '0%',
                    width    : 60,
                    height   : 55,
                    transform: 'skewX(-2deg) skewY(-2deg) translateX(0px) translateY(4px) scale(1)',
                },
            },
        };
    },
};
</script>

<style scoped>

</style>

<template>
    <div class="d-flex gap-3 first-line third-line">
        <template v-if="!blockIndex && blockIndex !== 0">
            <mockup-block
                v-if="Array.isArray(brandbook.mockups) && brandbook.mockups.length > 2"
                :img-src="brandbook.mockups[2].image"
                :elements="[
          { type: 'save', text: 'JPG' },
          { type: 'copy', text: 'JPG' },
        ]"
            />
            <mockup-block
                v-if="Array.isArray(brandbook.mockups) && brandbook.mockups.length > 3"
                :img-src="brandbook.mockups[3].image"
                :elements="[
          { type: 'save', text: 'JPG' },
          { type: 'copy', text: 'JPG' },
        ]"
            />

            <font-block :font="primaryFont" :elements="[
                { type: 'save', text: 'Font' },
                ...(primaryFont.google_font_page_url ? [{ type: 'link', text: 'Link to Font page', url: primaryFont.google_font_page_url }] : [])
            ]"/>

            <font-block
                v-if="hasSecondaryFont"
                :font="secondaryFont"
                :elements="[
                    { type: 'save', text: 'Font' },
                    ...(secondaryFont.google_font_page_url ? [{ type: 'link', text: 'Link to Font page', url: secondaryFont.google_font_page_url }] : [])
                ]"/>
        </template>
        <mockup-block
            v-else-if="blockIndex === 0 && Array.isArray(brandbook.mockups) && brandbook.mockups.length > 2"
            :img-src="brandbook.mockups[2].image"
            :elements="[
        { type: 'save', text: 'JPG' },
        { type: 'copy', text: 'JPG' },
      ]"
        />
        <mockup-block
            v-else-if="blockIndex === 1 && Array.isArray(brandbook.mockups) && brandbook.mockups.length > 3"
            :img-src="brandbook.mockups[3].image"
            :elements="[
        { type: 'save', text: 'JPG' },
        { type: 'copy', text: 'JPG' },
      ]"
        />
        <font-block
            v-else-if="blockIndex === 2"
            :font="primaryFont"
            :elements="[
                { type: 'save', text: 'Font' },
                ...(primaryFont.google_font_page_url ? [{ type: 'link', text: 'Link to Font page', url: primaryFont.google_font_page_url }] : [])
            ]"
        />
        <font-block
            v-else-if="blockIndex === 3 && hasSecondaryFont"
            :font="secondaryFont"
            :elements="[
                { type: 'save', text: 'Font' },
                ...(secondaryFont.google_font_page_url ? [{ type: 'link', text: 'Link to Font page', url: secondaryFont.google_font_page_url }] : [])
            ]"
        />
    </div>
</template>

<script>
    import FontBlock from '../GridBlocks/FontBlock.vue';
    import MockupBlock from '../GridBlocks/MockupBlock.vue';

    export default {
        components: {FontBlock, MockupBlock},
        props: {
            blockIndex: {
                type: Number,
                default: null,
            },
            brandbook: {
                type: Object,
                default: () => ({
                    fonts_main: [],
                    fonts_secondary: [],
                    mockups: [],
                    colors_used: [],
                })
            },
        },
        data() {
            return {}
        },
        computed: {
            hasSecondaryFont() {
                const fonts = this.brandbook?.fonts_secondary;
                return fonts && Object.keys(fonts).length > 0;
            },
            primaryFont() {
                const fonts = this.brandbook?.fonts_main;
                let firstFont = null;
                if (fonts) {
                    const fontValues = Object.values(fonts);
                    if (fontValues[0]) {
                        firstFont = fontValues[0];
                    } else if (fontValues[1]) {
                        firstFont = fontValues[1];
                    }
                }
                const isGoogleFont = firstFont?.file?.startsWith('https://fonts.googleapis.com');
                return {
                    type: 'Primary',
                    name: firstFont?.font_face || '',
                    url: firstFont?.file || '',
                    google_font_page_url: isGoogleFont ? this.getGoogleFontsPage(firstFont?.font_face || '') : '',
                    download: true,
                    hex: this.brandbook?.colors_list?.[1]?.id || '#ffffff',
                };
            },
            secondaryFont() {
                const fonts = this.brandbook?.fonts_secondary;
                let firstFont = null;
                if (fonts) {
                    const fontValues = Object.values(fonts);
                    if (fontValues[0]) {
                        firstFont = fontValues[0];
                    } else if (fontValues[1]) {
                        firstFont = fontValues[1];
                    }
                }
                const isGoogleFont = firstFont?.file?.startsWith('https://fonts.googleapis.com');
                let googleFontURL = isGoogleFont ? this.getGoogleFontsPage(firstFont?.font_face) : '';

                return {
                    type: 'Secondary',
                    name: firstFont?.font_face || '',
                    url: firstFont?.file || '',
                    google_font_page_url: googleFontURL,
                    download: false,
                    hex: this.brandbook?.colors_list?.[2]?.id || '#101820',
                };
            }
        },
        methods: {
            getGoogleFontsPage(fontFace) {
                const formattedName = fontFace.trim().replace(/\s+/g, '+');
                return `https://fonts.google.com/specimen/${formattedName}`;
            }
        }
    }
    ;
</script>

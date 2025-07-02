<template>
    <div
        class="account-main align-content-start d-md-flex flex-grow-1 flex-wrap justify-content-start ms-auto"
        id="main-book"
    >
        <PreviewBlock v-for="book in brandbooks" :key="book.id"
                      :src="book?.logo_b64"
                      :id="book?.id"
                      :font-name="getFontName(book)"
                      :colors="getColorList(book?.colors_list)"
                      font-url="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        />
    </div>
</template>

<script>
    import PreviewBlock from './PreviewBlock.vue';
    import Logo from '../../utils/book-v3/logo-preview.svg';

    export default {
        components: {
            PreviewBlock
        },
        props: {
            brandbooks: {
                type: Array,
                default: () => [],
                required: false
            }
        },
        data() {
            return {
                Logo: Logo
            }
        },
        mounted() {
        },
        methods: {
            getColorList(colorJson) {
                const colorList = JSON.parse(colorJson);
                const colorCodes = colorList.length ? _.map(colorList, 'id') : [];
                return colorCodes;
            },
            getFontName(book) {
                try {
                    const fonts = JSON.parse(book.fonts_main);
                    return fonts["1"]?.font_face || 'DefaultFont';
                } catch (e) {
                    console.error('Failed to parse fonts_main:', e);
                    return 'Poppins';
                }
            }
        }
    };
</script>

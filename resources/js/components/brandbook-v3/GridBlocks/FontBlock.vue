<template>
    <div class="wrapper-default-block">
        <span v-if="dataName" class="data-name">{{ dataName }}</span>
        <SubMenuDownload :elements="elements" @download="handleFontDownload"/>
        <div
            class="default-block d-flex align-items-center justify-content-between font-block flex-column"
            :style="`background-color: ${font.hex}; color: ${textColor}`">
            <div class="d-flex flex-column align-items-center">
                <div class="title">{{ font.type }} Font</div>
                <h2 :class="`font-name ${font.type.toLowerCase()}`" :style="{ fontFamily: font.name }">
                    {{ font.name }}
                </h2>
            </div>
            <h3 :class="`preview ${font.name.toLowerCase()}`" :style="{ fontFamily: font.name }">Aa</h3>
        </div>
    </div>
</template>
<script>
    import SubMenuDownload from '../new-book/SubMenuDownload.vue';

    export default {
        components: {
            SubMenuDownload,
        },
        props: {
            font: {
                type: Object,
                required: true,
                validator: function (value) {
                    return (
                        'url' in value &&
                        'google_font_page_url' in value &&
                        'name' in value &&
                        'type' in value &&
                        typeof value.url === 'string' &&
                        typeof value.google_font_page_url === 'string' &&
                        typeof value.name === 'string' &&
                        typeof value.type === 'string' &&
                        (value.hex === undefined || typeof value.hex === 'string')
                    );
                },
            },
            elements: {
                type: Array,
                required: true,
            },
            dataName: {
                type: String,
                default: '',
            },
        },
        computed: {
            textColor: function () {
                return this.font.hex ? this.getContrastColor(this.font.hex) : '#000000';
            },
        },
        methods: {
            loadFont: function (url, name) {
                // Check if it's a Google Font URL
                if (url.includes('fonts.googleapis.com')) {
                    const style = document.createElement('style');
                    style.textContent = `@import url('${url}');`;
                    document.head.appendChild(style);
                } else {
                    // For uploaded custom fonts
                    // Ensure the URL is absolute
                    const absoluteUrl = url.startsWith('http') ? url : `${window.location.origin}${url}`;

                    // Create a style element for the font
                    const style = document.createElement('style');
                    style.textContent = `
                        @font-face {
                            font-family: '${name}';
                            src: url('${absoluteUrl}') format('truetype');
                            font-weight: normal;
                            font-style: normal;
                        }
                    `;
                    document.head.appendChild(style);

                    // Also try loading with FontFace API as backup
                    const fontFace = new FontFace(name, `url(${absoluteUrl})`);
                    fontFace.load().then(face => {
                        document.fonts.add(face);
                    }).catch(error => {
                        console.error('Error loading custom font:', error);
                        // Try loading without protocol
                        const fallbackUrl = absoluteUrl.replace(/^https?:\/\//, '//');
                        const fallbackFont = new FontFace(name, `url(${fallbackUrl})`);
                        fallbackFont.load().then(face => {
                            document.fonts.add(face);
                        }).catch(error => {
                            console.error('Error loading font with fallback:', error);
                        });
                    });
                }
            },
            hexToRgb: function (hex) {
                hex = hex.replace(/^#/, '');
                if (hex.length === 3) {
                    hex = hex
                        .split('')
                        .map(c => c + c)
                        .join('');
                }
                const bigint = parseInt(hex, 16);
                return [(bigint >> 16) & 255, (bigint >> 8) & 255, bigint & 255];
            },
            getContrastColor: function (hex) {
                const [r, g, b] = this.hexToRgb(hex).map(v => v / 255);
                const gammaCorrected = function (c) {
                    return c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4);
                };
                const luminance =
                    0.2126 * gammaCorrected(r) + 0.7152 * gammaCorrected(g) + 0.0722 * gammaCorrected(b);
                return luminance > 0.5 ? '#000000' : '#FFFFFF';
            },
            async handleFontDownload(format) {
                await this.downloadFont(this.font.url);
            },
            async downloadFont(url) {
                try {
                    // For Google Fonts, we need to handle differently
                    if (url.includes('fonts.googleapis.com')) {
                        // Get the font family from the URL
                        const fontFamily = this.font.name.replace(/\s+/g, '+');
                        // Create a direct download URL for Google Font
                        const downloadUrl = `https://fonts.google.com/download?family=${fontFamily}`;
                        window.open(downloadUrl, '_blank');
                        return;
                    }

                    // For uploaded custom fonts
                    // Ensure the URL is absolute
                    const absoluteUrl = url.startsWith('http') ? url : `${window.location.origin}${url}`;

                    const response = await fetch(absoluteUrl);
                    if (!response.ok) throw new Error('Can\'t fetch data from the URL');

                    const blob = await response.blob();

                    // Guess extension from MIME
                    const extension = url.split('.').pop().split('?')[0];
                    const filename = `${this.font.name.replace(/\s+/g, '_')}.${extension}`;

                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = filename;

                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(link.href);
                } catch (err) {
                    console.error('❌ Font download failed:', err);
                    alert('Download failed. Please try again later.');
                }
            },
        },
        created() {
            // Load font when component is created
            this.loadFont(this.font.url, this.font.name);
        },
        watch: {
            // Watch for changes in font URL or name
            'font.url': function(newUrl) {
                this.loadFont(newUrl, this.font.name);
            },
            'font.name': function(newName) {
                this.loadFont(this.font.url, newName);
            }
        }
    };
</script>

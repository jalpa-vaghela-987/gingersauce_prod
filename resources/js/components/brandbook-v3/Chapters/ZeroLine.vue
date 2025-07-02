<template>
    <div class="gap-3 zero-line flex-xl-column">
        <div class="wrapper-default-block">
            <span class="data-name">Main logo</span>
            <SubMenuDownload
                grid="columns-2"
                :elements="[
          { type: 'save', text: 'PNG' },
          { type: 'save', text: 'SVG' },
          { type: 'copy', text: 'PNG' },
          { type: 'copy', text: 'SVG' },
        ]"
                @download="handleLogoDownload"
                @copy="handleLogoCopy"
            />
            <div class="logo-block-v3 default-block d-flex align-items-center justify-content-center main-white">
                <img :src="logo"/>
            </div>
        </div>
        <MockupBlock v-if="mockups.length > 0"
                     :imgSrc="mockups[0].image"
                     :elements="[
        { type: 'save', text: 'JPG' },
        { type: 'copy', text: 'JPG' },
      ]"
                     @download="handleMockupDownload"
                     @copy="handleMockupCopy"
        />
    </div>
</template>
<script>
    import MockupBlock from '../GridBlocks/MockupBlock.vue';
    import SubMenuDownload from '../new-book/SubMenuDownload.vue';

    export default {
        props: {
            logo: {
                type: String,
                required: true
            },
            mockups: {
                type: Array,
                default: []
            },
        },
        components: {
            MockupBlock,
            SubMenuDownload,
        },
        data() {
            return {};
        },
        methods: {
            async handleLogoDownload(format) {
                await this.downloadFile(this.logo, format);
            },
            async handleMockupDownload(format) {
                await this.downloadFile(this.mockups[0].image, format);
            },
            async handleLogoCopy(format) {
                await this.copyFile(this.logo, format);
            },
            async handleMockupCopy(format) {
                await this.copyFile(this.mockups[0].image, format);
            },
            async downloadFile(file, format) {
                if (format === 'SVG') {
                    let svgData = file;
                    if (file.startsWith('data:image/svg+xml;base64,')) {
                        const base64 = file.replace('data:image/svg+xml;base64,', '');
                        svgData = atob(base64); // Decode base64 to SVG markup
                    }

                    const blob = new Blob([svgData], {type: 'image/svg+xml'});
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = `image.${format.toLowerCase()}`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(link.href);
                    return;
                } else {
                    const image = new Image();
                    image.crossOrigin = 'anonymous';
                    image.onload = () => {
                        const canvas = document.createElement('canvas');
                        canvas.width = image.width;
                        canvas.height = image.height;

                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(image, 0, 0);

                        canvas.toBlob((blob) => {
                            const link = document.createElement('a');
                            link.href = URL.createObjectURL(blob);
                            link.download = `image.${format.toLowerCase()}`;
                            //link.download = 'downloaded-image.png';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                            URL.revokeObjectURL(link.href);
                        }, `image/${format.toLowerCase()}`);
                    };

                    image.src = file;
                    return;
                }
            },
            async copyFile(file, format) {
                if (format === 'SVG') {
                    try {
                        let svgData = file;

                        // Decode base64 if necessary
                        if (svgData.startsWith('data:image/svg+xml;base64,')) {
                            const base64 = svgData.replace('data:image/svg+xml;base64,', '');
                            svgData = atob(base64);
                        }

                        // Validate SVG
                        if (!svgData.includes('<svg')) {
                            console.error('❌ Invalid SVG: No <svg> tag found.');
                            return;
                        }

                        // Copy raw SVG markup as plain text
                        await navigator.clipboard.writeText(svgData);
                    } catch (err) {
                        console.error('❌ Failed to copy SVG:', err);
                    }
                } else if (['png', 'jpg', 'jpeg'].includes(format.toLowerCase())) {
                    const image = new Image();
                    image.crossOrigin = 'anonymous';
                    image.src = file;

                    image.onload = async () => {
                        const canvas = document.createElement('canvas');
                        canvas.width = image.naturalWidth;
                        canvas.height = image.naturalHeight;

                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(image, 0, 0);

                        // Always use PNG for clipboard due to compatibility
                        const mimeType = 'image/png';

                        canvas.toBlob(async (blob) => {
                            if (!blob) {
                                console.error('❌ Failed to create PNG blob');
                                return;
                            }

                            try {
                                const clipboardItem = new ClipboardItem({ [mimeType]: blob });
                                await navigator.clipboard.write([clipboardItem]);
                                //console.log(`✅ Image copied to clipboard as PNG (original format: ${format})`);
                            } catch (err) {
                                console.error('❌ Clipboard write failed:', err);
                            }
                        }, mimeType);
                    };

                    image.onerror = () => {
                        console.error(`❌ Failed to load image`);
                    };
                }
            }
        }
    };
</script>

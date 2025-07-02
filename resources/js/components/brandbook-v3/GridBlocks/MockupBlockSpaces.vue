<template>
    <div class="wrapper-default-block">
        <span v-if="dataName" class="data-name">{{ dataName }}</span>
        <SubMenuDownload :elements="elements" grid="columns-2"
                         @download="handleGraphicElementDownload"
                         @copy="handleGraphicElementCopy"/>
        <div
            class="image-wrapper default-block d-flex align-items-center justify-content-center mockup-block mockup-block-spaces">
            <img :src="imgSrc" alt="Mockup Image" :style="`width: ${percent}%;height: ${percent}%`"/>
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
            elements: {
                type: Array,
                required: true,
            },
            imgSrc: {
                type: String,
                required: true,
            },
            dataName: {
                type: String,
                default: '',
            },
            percent: {
                type: String,
                default: '',
            },
            grid: {
                type: String,
                default: '',
            },
        },
        methods: {
            async handleGraphicElementDownload(format) {
                await this.downloadFile(this.imgSrc, format);
            },
            async handleGraphicElementCopy(format) {
                await this.copyFile(this.imgSrc, format);
            },
            async downloadFile(file, format) {
                if (format === 'SVG') {
                    let svgData = file;
                    if (file.startsWith('data:image/svg+xml;base64,')) {
                        const base64 = file.replace('data:image/svg+xml;base64,', '');
                        svgData = atob(base64); // Decode base64 to SVG markup
                    }

                    const blob = new Blob([svgData], { type: 'image/svg+xml' });
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = `image.${format.toLowerCase()}`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(link.href);
                    return;
                }else{
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
<style>
    .image-wrapper {
        width: 100%;
        height: 250px !important; /* or whatever height you want */
        display: flex !important;;
        align-items: center !important;;
        justify-content: center !important;;
        overflow: hidden !important;;
        background-color: #fff !important;; /* optional */
        border-radius: 8px !important;; /* optional for rounded corners */
    }

    .image-wrapper img {
        max-width: 100% !important;;
        max-height: 100% !important;;
        height: auto !important;;
        width: auto !important;;
        object-fit: contain !important;;
    }
</style>

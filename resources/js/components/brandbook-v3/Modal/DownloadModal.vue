<template>
    <div
        class="modal fade"
        id="downloadModal"
        tabindex="-1"
        aria-labelledby="downloadModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header position-relative">
                    <h3 class="modal-title fw-bold text-center sec-font fs-18">{{ this.title }}</h3>

                    <button
                        type="button"
                        class="btn-close position-absolute"
                        data-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div :class="['container-fluid', title === 'Icon & Favicon' ? 'icon-favicon' : '']">
                        <DownloadBlock v-for="item in items"
                                       :logo-details="{
                                            logo: item.logo || '',
                                            colorLogo: item.colorLogo || '',
                                            colorBg: item.colorBg || '',
                                            customCss: item.customCss || '',
                                            border_radius: item.border_radius || '0%'
                                          }"
                                       :elements="[
                                            { type: 'save', text: 'PNG' },
                                            { type: 'copy', text: 'PNG' },
                                            { type: 'save', text: 'SVG' },
                                            { type: 'copy', text: 'SVG' },
                                          ]"
                                       @download="handleDownload"
                                       @copy="handleCopy"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import DownloadBlock from './DownloadBlock.vue';

    export default {
        components: {
            DownloadBlock,
        },
        props: {
            title: {
                type: String,
                default: '',
            },
            items: {
                type: Array,
                default: () => []
            },
            isLogoVersions: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                currentLogoDetails: null
            };
        },
        methods:{
            handleDownload({ format, file, logoDetails }) {
                this.currentLogoDetails = logoDetails || {};
                this.downloadFile(file, format);
            },
            handleCopy({ format, file, logoDetails }) {
                this.currentLogoDetails = logoDetails || {};
                this.copyFile(file, format);
            },
            downloadFile(file, format) {
                if (format === 'SVG') {
                    try {
                        let svgData = file;

                        // Handle base64 encoded SVG
                        if (svgData.startsWith('data:image/svg+xml;base64,')) {
                            const base64Content = svgData.split(',')[1];
                            svgData = atob(base64Content);
                        } else if (svgData.startsWith('data:')) {
                            // Handle other data URLs
                            const base64Content = svgData.split(',')[1];
                            svgData = atob(base64Content);
                        }

                        // Validate SVG content
                        if (!svgData.includes('<svg')) {
                            console.error('❌ Invalid SVG: No <svg> tag found');
                            return;
                        }

                        const parser = new DOMParser();
                        const doc = parser.parseFromString(svgData, 'image/svg+xml');
                        const originalSvgElement = doc.querySelector('svg');

                        if (originalSvgElement) {
                             // Create a new SVG element with desired dimensions and viewBox
                            const newSvgElement = doc.createElementNS('http://www.w3.org/2000/svg', 'svg');
                            newSvgElement.setAttribute('xmlns', 'http://www.w3.org/2000/svg');

                            if (!this.isLogoVersions) {
                                // Apply fixed size for non-logo versions
                                newSvgElement.setAttribute('width', '1024');
                                newSvgElement.setAttribute('height', '1024');
                                newSvgElement.setAttribute('viewBox', '0 0 1024 1024');
                            } else {
                                // Preserve original dimensions for logo versions
                                const originalWidth = originalSvgElement.getAttribute('width') || '512';
                                const originalHeight = originalSvgElement.getAttribute('height') || '512';
                                const originalViewBox = originalSvgElement.getAttribute('viewBox') || `0 0 ${originalWidth} ${originalHeight}`;

                                newSvgElement.setAttribute('width', originalWidth);
                                newSvgElement.setAttribute('height', originalHeight);
                                newSvgElement.setAttribute('viewBox', originalViewBox);
                            }

                             // Add background rect with border radius if applicable
                            if (!this.isLogoVersions && this.currentLogoDetails.colorBg && this.currentLogoDetails.colorBg !== 'transparent') {
                                 const rect = doc.createElementNS('http://www.w3.org/2000/svg', 'rect');
                                 rect.setAttribute('width', '100%'); // Covers the 1024x1024 viewBox
                                 rect.setAttribute('height', '100%'); // Covers the 1024x1024 viewBox
                                 rect.setAttribute('fill', this.currentLogoDetails.colorBg);
                                  // Apply border radius to the background rect
                                 if (this.currentLogoDetails.border_radius && this.currentLogoDetails.border_radius !== '0%') {
                                     rect.setAttribute('rx', this.currentLogoDetails.border_radius);
                                     rect.setAttribute('ry', this.currentLogoDetails.border_radius);
                                 }
                                 newSvgElement.appendChild(rect);
                            }

                            // Create a group element for the original logo content
                            const logoGroup = doc.createElementNS('http://www.w3.org/2000/svg', 'g');

                            // Move all children from the original SVG to the new group
                            while (originalSvgElement.firstChild) {
                                // No need to exclude here, we are creating a new structure
                                logoGroup.appendChild(originalSvgElement.firstChild);
                            }

                             // Calculate original dimensions from viewBox or attributes
                            const originalViewBox = originalSvgElement.getAttribute('viewBox');
                            let originalWidth = 512; // Default fallback
                            let originalHeight = 512; // Default fallback

                            if (originalViewBox) {
                                const viewBoxValues = originalViewBox.split(' ');
                                if (viewBoxValues.length === 4) {
                                    originalWidth = parseFloat(viewBoxValues[2]);
                                    originalHeight = parseFloat(viewBoxValues[3]);
                                }
                            } else {
                                // Fallback to width/height attributes if no viewBox
                                originalWidth = parseFloat(originalSvgElement.getAttribute('width')) || originalWidth;
                                originalHeight = parseFloat(originalSvgElement.getAttribute('height')) || originalHeight;
                            }

                            if (!this.isLogoVersions) {
                                // Target size for the graphic is half of the canvas size (512x512)
                                const targetGraphicSize = 512;
                                const scale = targetGraphicSize / Math.max(originalWidth, originalHeight);

                                const scaledWidth = originalWidth * scale;
                                const scaledHeight = originalHeight * scale;

                                // Calculate translation to center the scaled logo in the 1024x1024 viewBox
                                const canvasSize = 1024;
                                const translateX = (canvasSize - scaledWidth) / 2;
                                const translateY = (canvasSize - scaledHeight) / 2;

                                // Apply transform (translate then scale)
                                logoGroup.setAttribute('transform', `translate(${translateX}, ${translateY}) scale(${scale})`);
                            } else {
                                // For logo versions, keep original size and position
                                logoGroup.setAttribute('transform', 'translate(0, 0) scale(1)');
                            }

                            // Append the logo group to the new SVG
                            newSvgElement.appendChild(logoGroup);

                            const updatedSvg = new XMLSerializer().serializeToString(newSvgElement);

                            const blob = new Blob([updatedSvg], { type: 'image/svg+xml' });
                            const link = document.createElement('a');
                            link.href = URL.createObjectURL(blob);
                            link.download = 'image.svg';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                            URL.revokeObjectURL(link.href);
                        } else {
                            console.error('❌ Failed to parse SVG properly: No SVG element found');
                        }
                    } catch (err) {
                        console.error('❌ Failed to save SVG:', err);
                    }
                    return;
                }

                // PNG or other raster formats
                else if (['png', 'jpg', 'jpeg'].includes(format.toLowerCase())) {
                    const image = new Image();
                    image.crossOrigin = 'anonymous';
                    // Ensure the file is a data URL before setting src
                    image.src = file.startsWith('data:') ? file : `data:image/${format.toLowerCase()};base64,${file}`;

                    image.onload = async () => {
                        const canvasSize = this.isLogoVersions ? Math.max(image.width, image.height) : 1024;
                        console.log(image.width, image.height);
                        const canvas = document.createElement('canvas');
                        canvas.width = this.isLogoVersions ? image.width : canvasSize;
                        canvas.height = this.isLogoVersions ? image.height : canvasSize;

                        const ctx = canvas.getContext('2d');
                         // Clear canvas initially (for transparency)
                        ctx.clearRect(0, 0, this.isLogoVersions ? image.width : canvasSize, this.isLogoVersions ? image.height : canvasSize);

                         // Add background color and border radius if applicable
                        if (!this.isLogoVersions && this.currentLogoDetails.colorBg && this.currentLogoDetails.colorBg !== 'transparent') {
                            const backgroundColor = this.currentLogoDetails.colorBg;
                            const border_radius = this.currentLogoDetails.border_radius;

                            ctx.fillStyle = backgroundColor;
                            if (border_radius && border_radius !== '0%') {
                                 const radius = border_radius === '50%' ? 512 : parseInt(border_radius) || 0;
                                 ctx.beginPath();
                                 ctx.arc(canvas.width/2, canvas.height/2, radius, 0, Math.PI * 2);
                                 ctx.closePath();
                                 ctx.fill();
                            } else {
                                ctx.fillRect(0, 0, canvas.width, canvas.height);
                            }
                        }

                        if (!this.isLogoVersions) {
                            // Calculate scale to fit the image within a 512x512 area
                            const targetGraphicSize = 512;
                            const scale = Math.min(targetGraphicSize / image.width, targetGraphicSize / image.height);

                            const drawWidth = image.width * scale;
                            const drawHeight = image.height * scale;
                            const offsetX = (canvasSize - drawWidth) / 2;
                            const offsetY = (canvasSize - drawHeight) / 2;

                            // Draw the scaled and centered image
                            ctx.drawImage(image, offsetX, offsetY, drawWidth, drawHeight);
                        } else {
                            // For logo versions, draw at original size and position
                            ctx.drawImage(image, 0, 0, image.width, image.height);
                        }

                        canvas.toBlob((blob) => {
                            if (!blob) {
                                console.error('❌ Failed to create blob');
                                return;
                            }

                            const link = document.createElement('a');
                            link.href = URL.createObjectURL(blob);
                            link.download = `image.${format.toLowerCase()}`;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                            URL.revokeObjectURL(link.href);
                        }, `image/${format.toLowerCase()}`);
                    };

                    image.onerror = () => {
                        console.error('❌ Failed to load image');
                    };
                }
            },
            async copyFile(file, format) {
                try {
                    if (!file || !format) {
                        console.error('❌ Missing file or format for copy');
                        return;
                    }

                    if (format === 'SVG') {
                        let svgData = file;

                        // Handle different SVG data sources
                        if (svgData.startsWith('data:image/svg+xml;base64,')) {
                            const base64Content = svgData.split(',')[1];
                            svgData = atob(base64Content);
                        } else if (svgData.startsWith('data:image/svg+xml,')) {
                             svgData = decodeURIComponent(svgData.split(',')[1]);
                        } else if (svgData.startsWith('data:')) {
                             // Assuming other data URLs are base64 if not explicitly svg+xml
                            const base64Content = svgData.split(',')[1];
                            svgData = atob(base64Content);
                        } else {
                            // Handle regular URL
                            const response = await axios.get(file);
                            svgData = response.data;
                        }

                        // Validate SVG content
                        if (!svgData.includes('<svg')) {
                            console.error('❌ Invalid SVG: No <svg> tag found for copy');
                            return;
                        }

                        const parser = new DOMParser();
                        const doc = parser.parseFromString(svgData, 'image/svg+xml');
                        const originalSvgElement = doc.querySelector('svg');

                        if (originalSvgElement) {
                             // Create a new SVG element with desired dimensions and viewBox
                            const newSvgElement = doc.createElementNS('http://www.w3.org/2000/svg', 'svg'); // Corrected namespace
                            newSvgElement.setAttribute('xmlns', 'http://www.w3.org/2000/svg');

                            if (!this.isLogoVersions) {
                                // Apply fixed size for non-logo versions
                                newSvgElement.setAttribute('width', '1024');
                                newSvgElement.setAttribute('height', '1024');
                                newSvgElement.setAttribute('viewBox', '0 0 1024 1024');
                            } else {
                                // Preserve original dimensions for logo versions
                                const originalWidth = originalSvgElement.getAttribute('width') || '512';
                                const originalHeight = originalSvgElement.getAttribute('height') || '512';
                                const originalViewBox = originalSvgElement.getAttribute('viewBox') || `0 0 ${originalWidth} ${originalHeight}`;

                                newSvgElement.setAttribute('width', originalWidth);
                                newSvgElement.setAttribute('height', originalHeight);
                                newSvgElement.setAttribute('viewBox', originalViewBox);
                            }

                             // Add background rect with border radius if applicable
                            if (!this.isLogoVersions && this.currentLogoDetails.colorBg && this.currentLogoDetails.colorBg !== 'transparent') {
                                 const rect = doc.createElementNS('http://www.w3.org/2000/svg', 'rect');
                                 rect.setAttribute('width', '100%'); // Covers the 1024x1024 viewBox
                                 rect.setAttribute('height', '100%'); // Covers the 1024x1024 viewBox
                                 rect.setAttribute('fill', this.currentLogoDetails.colorBg);
                                  // Apply border radius to the background rect
                                 if (this.currentLogoDetails.border_radius && this.currentLogoDetails.border_radius !== '0%') {
                                     rect.setAttribute('rx', this.currentLogoDetails.border_radius);
                                     rect.setAttribute('ry', this.currentLogoDetails.border_radius);
                                 }
                                 newSvgElement.appendChild(rect);
                            }

                            // Create a group element for the original logo content
                            const logoGroup = doc.createElementNS('http://www.w3.org/2000/svg', 'g');

                            // Move all children from the original SVG to the new group
                            // Use a static array of children as originalSvgElement.firstChild changes during removal
                            const originalChildren = [...originalSvgElement.children];
                            originalChildren.forEach(child => {
                                // Optional: Exclude any potential existing background rect from the original SVG
                                // This might be needed if some original SVGs already have a background rect that shouldn't be moved
                                // if (! (child.tagName.toLowerCase() === 'rect' && child === originalSvgElement.firstElementChild) ) {
                                //     logoGroup.appendChild(child.cloneNode(true)); // Clone to avoid removing from original DOM if it exists there
                                // }
                                // Appending directly will move the element from the original SVG
                                logoGroup.appendChild(child);
                            });

                            // Calculate original dimensions from viewBox or attributes
                            const originalViewBox = originalSvgElement.getAttribute('viewBox');
                            let originalWidth = 512; // Default fallback
                            let originalHeight = 512; // Default fallback

                            if (originalViewBox) {
                                const viewBoxValues = originalViewBox.split(' ');
                                if (viewBoxValues.length === 4) {
                                    originalWidth = parseFloat(viewBoxValues[2]);
                                    originalHeight = parseFloat(viewBoxValues[3]);
                                }
                            } else {
                                // Fallback to width/height attributes if no viewBox
                                originalWidth = parseFloat(originalSvgElement.getAttribute('width')) || originalWidth;
                                originalHeight = parseFloat(originalSvgElement.getAttribute('height')) || originalHeight;
                            }

                            if (!this.isLogoVersions) {
                                // Target size for the graphic is half of the canvas size (512x512)
                                const targetGraphicSize = 512;
                                const scale = targetGraphicSize / Math.max(originalWidth, originalHeight);

                                const scaledWidth = originalWidth * scale;
                                const scaledHeight = originalHeight * scale;

                                // Calculate translation to center the scaled logo in the 1024x1024 viewBox
                                const canvasSize = 1024;
                                const translateX = (canvasSize - scaledWidth) / 2;
                                const translateY = (canvasSize - scaledHeight) / 2;

                                // Apply transform (translate then scale)
                                logoGroup.setAttribute('transform', `translate(${translateX}, ${translateY}) scale(${scale})`);
                            } else {
                                // For logo versions, keep original size and position
                                logoGroup.setAttribute('transform', 'translate(0, 0) scale(1)');
                            }

                            // Append the logo group to the new SVG
                            newSvgElement.appendChild(logoGroup);

                            const updatedSvg = new XMLSerializer().serializeToString(newSvgElement);

                            await navigator.clipboard.writeText(updatedSvg);
                            console.log('✅ SVG copied to clipboard');
                        } else {
                            console.error('❌ Failed to parse SVG properly: No SVG element found for copy');
                        }
                    }

                    // PNG or other raster formats
                    else if (['png', 'jpg', 'jpeg'].includes(format.toLowerCase())) {
                        const image = new Image();
                        image.crossOrigin = 'anonymous';
                        image.src = file.startsWith('data:') ? file : `data:image/png;base64,${file}`;

                        image.onload = async () => {
                            const canvasSize = this.isLogoVersions ? Math.max(image.width, image.height) : 1024;
                            const canvas = document.createElement('canvas');
                            canvas.width = this.isLogoVersions ? image.width : canvasSize;
                            canvas.height = this.isLogoVersions ? image.height : canvasSize;

                            const ctx = canvas.getContext('2d');
                             // Clear canvas initially (for transparency)
                            ctx.clearRect(0, 0, this.isLogoVersions ? image.width : canvasSize, this.isLogoVersions ? image.height : canvasSize);

                             // Add background color and border radius if applicable
                            if (!this.isLogoVersions && this.currentLogoDetails.colorBg && this.currentLogoDetails.colorBg !== 'transparent') {
                                const backgroundColor = this.currentLogoDetails.colorBg;
                                const border_radius = this.currentLogoDetails.border_radius;

                                ctx.fillStyle = backgroundColor;
                                if (border_radius && border_radius !== '0%') {
                                     const radius = border_radius === '50%' ? 512 : parseInt(border_radius) || 0;
                                     ctx.beginPath();
                                     ctx.arc(canvas.width/2, canvas.height/2, radius, 0, Math.PI * 2);
                                     ctx.closePath();
                                     ctx.fill();
                                } else {
                                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                                }
                            }

                            if (!this.isLogoVersions) {
                                // Calculate scale to fit the image within a 512x512 area
                                const targetGraphicSize = 512;
                                const scale = Math.min(targetGraphicSize / image.width, targetGraphicSize / image.height);

                                const drawWidth = image.width * scale;
                                const drawHeight = image.height * scale;
                                const offsetX = (canvasSize - drawWidth) / 2;
                                const offsetY = (canvasSize - drawHeight) / 2;

                                // Draw the scaled and centered image
                                ctx.drawImage(image, offsetX, offsetY, drawWidth, drawHeight);
                            } else {
                                // For logo versions, draw at original size and position
                                ctx.drawImage(image, 0, 0, image.width, image.height);
                            }

                            canvas.toBlob((blob) => {
                                if (!blob) {
                                    console.error('❌ Failed to create PNG blob');
                                    return;
                                }

                                const reader = new FileReader();
                                reader.onloadend = () => {
                                    navigator.clipboard.write([
                                        new ClipboardItem({
                                            'image/png': blob
                                        })
                                    ]).then(() => {
                                        console.log('✅ PNG copied to clipboard');
                                    }).catch(err => {
                                        console.error('❌ Failed to copy PNG:', err);
                                    });
                                };
                                reader.readAsArrayBuffer(blob);
                            }, 'image/png');
                        };

                        image.onerror = () => {
                            console.error('❌ Failed to load image');
                        };
                    }
                } catch (error) {
                    console.error('Error copying icon:', error);
                }
            }
        }
    };
</script>
<style>
    .modal .modal-content .modal-body {
        margin-top: 0px !important;
    }
</style>

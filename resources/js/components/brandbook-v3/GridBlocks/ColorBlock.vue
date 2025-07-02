<template>
    <div class="wrapper-default-block tooltip-wrapper">
        <div
            class="default-block d-flex justify-content-between colors-block"
            :style="`background-color: ${color}; color: ${textColor}`"
        >
            <div class="title d-flex justify-content-between align-items-center w-100">
                <span>{{ pantoneColor.name ? pantoneColor.name.replace('-', ' ') : '' }}</span>
                <button class="btn copy-color-btn" @click="copyColorValues">
                    <transition name="fade" mode="out-in">
                        <svg
                            viewBox="0 0 21 22"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            v-if="!isCopied"
                        >
                            <path
                                d="M4.7701 20.1666H12.7288C14.2588 20.1666 15.5133 18.9641 15.7094 17.4166H16.2288C17.8943 17.4166 19.2495 15.9969 19.2495 14.2522V4.99768C19.2495 3.25299 17.8943 1.83325 16.2289 1.83325H8.2701C6.60471 1.83325 5.24951 3.25299 5.24951 4.99768V5.49992H4.7701C3.10471 5.49992 1.74951 6.91965 1.74951 8.66434V17.0021C1.74951 18.7469 3.10471 20.1666 4.7701 20.1666ZM6.99951 4.99768C6.99951 4.2637 7.56949 3.66659 8.2701 3.66659H16.2288C16.9295 3.66659 17.4995 4.2637 17.4995 4.99768V14.2521C17.4995 14.9861 16.9295 15.5833 16.2289 15.5833H15.7495V8.66434C15.7495 6.91965 14.3943 5.49992 12.7289 5.49992H6.99951V4.99768ZM3.49951 8.66434C3.49951 7.93037 4.06949 7.33325 4.7701 7.33325H12.7288C13.4295 7.33325 13.9995 7.93037 13.9995 8.66434V17.0021C13.9995 17.7361 13.4295 18.3333 12.7289 18.3333H4.7701C4.06949 18.3333 3.49951 17.7361 3.49951 17.0022V8.66434Z"
                            />
                        </svg>
                        <svg
                            v-else
                            key="checkmark"
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="currentColor"
                            class="bi bi-check-lg"
                            viewBox="0 0 16 16"
                        >
                            <path
                                d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"
                            />
                        </svg>
                    </transition>
                </button>
            </div>
            <div class="color-value">
                <div class="name">Hex</div>
                <div class="value">{{ color }}</div>
                <div class="name">RGB</div>
                <div class="value">{{ rgbColor }}</div>
                <div class="name">CMYK</div>
                <div class="value">{{ cmykColor }}</div>
                <div v-if="pantoneColor?.pantone" class="name">Pantone</div>
                <div v-if="pantoneColor?.pantone" class="value">{{ pantoneColor.pantone ? pantoneColor.pantone : 'Not found' }}</div>
            </div>
        </div>
    </div>
</template>

<script>
    const simpleColorConverter = require('simple-color-converter');
    import {hexToRgb, rgbToCmyk, hexToPantone} from '../../../colorUtils';

    export default {
        data() {
            return {
                isCopied: false,
            };
        },
        props: {
            color: {
                type: String,
                default: '',
            },
        },
        computed: {
            rgbColor() {
                const {r, g, b} = hexToRgb(this.color);
                return `${r} ${g} ${b}`;
            },
            cmykColor() {
                const {r, g, b} = hexToRgb(this.color);
                const {c, m, y, k} = rgbToCmyk(r, g, b);
                return `${c} ${m} ${y} ${k}`;
            },
            pantoneColor() {
                const detailedPantone = hexToPantone(this.color);
                const convertedPantone = simpleColorConverter({
                    hex3: this.color,
                    to: 'pantone'
                });

                let finalPantone;

                if (typeof detailedPantone === 'object' && detailedPantone !== null) {
                    finalPantone = {
                        ...detailedPantone,
                        pantone: convertedPantone
                    };
                } else {
                    finalPantone = {
                        pantone: convertedPantone,
                        name: null,
                        hex: this.color
                    };
                }

                return finalPantone;
            },
            textColor() {
                return this.getContrastColor(this.color);
            },
        },
        methods: {
            hexToRgb(hex) {
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
            getContrastColor(hex) {
                const [r, g, b] = this.hexToRgb(hex).map(v => v / 255);
                const gammaCorrected = c => (c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4));
                const luminance =
                    0.2126 * gammaCorrected(r) + 0.7152 * gammaCorrected(g) + 0.0722 * gammaCorrected(b);
                return luminance > 0.5 ? '#000000' : '#FFFFFF';
            },
            copyColorValues() {
                const colorText = `${this.color}`.trim();

                navigator.clipboard
                    .writeText(colorText)
                    .then(() => {
                        this.toggleIcon();
                    })
                    .catch(err => {
                        console.error('Failed to copy: ', err);
                    });
            },
            toggleIcon() {
                this.isCopied = true;
                setTimeout(() => {
                    this.isCopied = false;
                }, 2000);
            },
        },
    };
</script>

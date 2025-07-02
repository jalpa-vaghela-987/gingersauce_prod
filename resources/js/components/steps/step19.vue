<template>
    <div class="">
        <div class="mockup-title">{{ translate( 'Choose upto 4 Mockups' ) }}<span
            v-tooltip.bottom="translate('A mockup illustrates the logo in the real world. On paper, online, store sign, merchandising, etc. You can also add a pattern, background or illustration to support your brand. Visualize your brand')"><svg
            width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path
            d="M23.625 12C23.625 18.4217 18.4199 23.625 12 23.625C5.58014 23.625 0.375 18.4217 0.375 12C0.375 5.58202 5.58014 0.375 12 0.375C18.4199 0.375 23.625 5.58202 23.625 12ZM12.312 4.21875C9.75741 4.21875 8.12813 5.29486 6.84872 7.20741C6.68297 7.45519 6.73842 7.78936 6.97598 7.9695L8.6025 9.20278C8.84648 9.3878 9.19411 9.34378 9.38367 9.10331C10.221 8.04122 10.7952 7.42533 12.0697 7.42533C13.0274 7.42533 14.2118 8.04164 14.2118 8.97023C14.2118 9.67223 13.6323 10.0328 12.6868 10.5629C11.5841 11.181 10.125 11.9504 10.125 13.875V14.0625C10.125 14.3731 10.3769 14.625 10.6875 14.625H13.3125C13.6231 14.625 13.875 14.3731 13.875 14.0625V14C13.875 12.6659 17.7743 12.6103 17.7743 9C17.7743 6.28116 14.9541 4.21875 12.312 4.21875ZM12 15.8438C10.811 15.8438 9.84375 16.811 9.84375 18C9.84375 19.1889 10.811 20.1562 12 20.1562C13.189 20.1562 14.1562 19.1889 14.1562 18C14.1562 16.811 13.189 15.8438 12 15.8438Z"
            :fill="main_color"/></svg></span></div>
        <div class="mockup-container-wrapper">
            <div class="mockup mobile-steps-mockup mockup-container">
                <UploadMockup :main_color="main_color" @new_cover="newCover"></UploadMockup>
            </div>
            <div class="">
                <MockupVariation v-for="(params, index) in covers" :key="params.name" :index="index"
                                 :main_color="main_color" :secondary_color="secondary_color" :third_color="third_color"
                                 @set_selected="setSelected" @un_select="unSelect"
                                 :logo_b64="logo_b64" :params="params" :logo_variations="allLogoVaitionsMaped"
                                 :icon_variations="allIconVaitionsMaped" :brand="brand" :white_logo="white_logo"
                                 :is_white_logo="isWhiteLogo"/>
            </div>
            <div class="clear"></div>
        </div>
        <div class="upload-footer">
            <span style="margin-right: 20px">{{ translate( 'selected' ) }} {{ this.selected.length }} {{
                    translate( 'of' )
                }} 4</span>
            <button class="btn btn-outline-success" @click="forward"
                    :disabled="selected.length == 0">
                <svg width="28" height="21" viewBox="0 0 28 21" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M27.2417 4.13797L10.6762 20.5227C10.2246 20.9694 9.49537 20.9665 9.04742 20.5162L0.334063 11.7579C-0.113886 11.3076 -0.111006 10.5804 0.340686 10.1337L2.5213 7.97691C2.9729 7.53027 3.70217 7.53314 4.15012 7.98351L9.88908 13.7522L23.4564 0.333103C23.9079 -0.113543 24.6372 -0.110671 25.0852 0.339612L27.2482 2.5138C27.6962 2.96417 27.6933 3.69133 27.2417 4.13797Z"/>
                </svg>
                {{ translate( 'Next' ) }}
            </button>
            <div class="skip" @click="skip">
                {{ translate( 'or skip' ) }}
                <svg width="9" height="16" viewBox="0 0 9 16" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.00006 15L7.00006 8L1.00006 1" stroke="black" stroke-width="2"/>
                </svg>
            </div>
        </div>
    </div>
</template>

<script>

import MockupVariation from '../mockups/mockupVariation.vue';
import UploadMockup from '../mockups/uploadMockup';
import domtoimage from 'dom-to-image';
import htmlToCanvas from 'html2canvas';
import translate from '../../utils/translate';

export default {
    components: {
        MockupVariation,
        UploadMockup,
    },

    props: {
        previous_mockups   : Array,
        id                 : Number,
        icon_b64           : String,
        logo_b64           : String,
        all_logo_variations: Array,
        all_icon_variations: Array,
        brand              : String,
        main_color         : String,
        secondary_color    : String,
        third_color        : String,
        white_logo         : {},
        bb_version         : Number,
    },
    data() {
        return {
            mockups  : [],
            selected : [],
            endpoints: endpoints,
            save_data: [],
        };
    },
    mounted() {
        this.mockups = [
            {
                name  : 'black-sign',
                src   : '/img/mockup-templates/sign.jpg',
                mask  : 'sign',
                covers: [
                    {
                        name: 'sign',
                        src : 'logo',
                        type: '0_White & Colors',
                    },
                ],
            },
            {
                name : 'bags-and-glasses',
                src  : '/img/mockup-templates/glass.jpg',
                mask : 'bags-and-cups',
                masks: {
                    background: [ // background should be first due to mix-blend-mode. dont know why but styles transform affected it.
                        {
                            name: 'cup-right',
                            src : 'logo',
                            type: this.isWhiteLogo ? '0_Black & White Positive' : '0_Black & White Positive',
                        },
                        {
                            name: 'bag-small',
                            src : 'logo',
                            type: this.isWhiteLogo ? '0_Black & White Positive' : '0_Black & White Positive',
                        },
                        {
                            name: 'cup-left',
                            src : 'logo',
                            type: this.isWhiteLogo ? 'white' : 'original',
                        },
                    ],
                    logos     :
                        [
                            {
                                name: 'bag',
                                src : 'logo',
                                type: this.isWhiteLogo ? 'original' : '0_White Negative',
                            },
                            {
                                name: 'cup-holder',
                                src : 'logo',
                                type: '0_White & Colors',
                            },
                        ],

                },
            },
            {
                name : 'laptop',
                src  : '/img/mockup-templates/laptop.jpg',
                mask : 'screens',
                masks: {
                    background  : [
                        {
                            name: 'logo-tablet-top',
                            src : 'logo',
                            type: '0_White Negative',
                        },
                    ],
                    logos: [
                        {
                            name: 'logo-laptop-top',
                            src : 'logo',
                            type: this.isWhiteLogo ? 'white' : 'original',
                        },
                        {
                            name: 'icon-tablet-center',
                            src : 'icon',
                            type: 'White Negative on Secondary in Square',
                        },
                        {
                            name: 'icon-tablet-bottom',
                            src : 'icon',
                            type: 'White Negative on Secondary in Circle',
                        },
                        {
                            name: 'icon-mobile-top',
                            src : 'icon',
                            type: 'White Negative on Secondary in Circle',
                        },
                        {
                            name: 'icon-mobile-bottom',
                            src : 'icon',
                            type: 'White Negative on Secondary in Circle',
                        },
                    ],
                },
            }
        ];

        // Add previous mockups after initializing the array
        if (this.previous_mockups && this.previous_mockups.length > 0) {
            this.previous_mockups.forEach((mockup) => {
                if (mockup.isMockupUploaded) {
                    var mockupSrc = {
                        src: mockup.image,
                        b_64: undefined,
                    }
                    this.mockups.unshift(mockupSrc);
                    console.log('mockup', mockup);
                    console.log('mockupSrc', mockupSrc);
                }
            });
        }

        console.log('this.mockups', this.mockups);
    },
    watch   : {
        save_data: function( value ) {
            if ( value.length === this.selected.length ) {
                // this.save();
                $( '.download-image' ).remove();
                this.$emit( 'forward', value );
            }
        },
    },
    methods : {
        translate,
        domToImage(element) {
            return new Promise((resolve, reject) => {
                const options = {
                    quality: 1,
                    bgcolor: '#ffffff',
                    style: {
                        transform: 'scale(1)',
                        'transform-origin': 'top left',
                    },
                    filter: (node) => {
                        return node.tagName !== 'svg' || node.classList.contains('mask');
                    }
                };

                domtoimage.toJpeg(element, options)
                    .then(dataUrl => {
                        resolve({
                            image: dataUrl,
                            isMockupUploaded: false
                        });
                    })
                    .catch(error => {
                        console.error('domToImage error:', error);
                        reject(error);
                    })
                    .finally(() => {
                        if (document.body.contains(element)) {
                            document.body.removeChild(element);
                        }
                    });
            });
        },
        async forward() {
            if (this.selected.length === 0) return;

            // Clear any previous save data
            this.save_data = [];

            // Process mockups sequentially to avoid memory overload
            for (let i = 0; i < this.selected.length; i++) {
                const element = document.getElementsByClassName('mockup-container selected')[i];
                if (!element) continue;

                try {
                    const mockupData = await this.generateMockupImage(element, i);

                    // Create the mockup object with the correct structure
                    const mockup = {
                        index: i,
                        image: mockupData.image,
                        isMockupUploaded: mockupData.isMockupUploaded,
                        title: ""
                    };

                    this.save_data.push(mockup);
                } catch (error) {
                    console.error(`Error generating mockup ${i}:`, error);
                    // Continue with next mockup even if one fails
                }
            }

            // Proceed when all mockups are processed
            if (this.save_data.length > 0) {
                this.$emit('forward', this.save_data);
            }
        },
        async generateMockupImage(element, index) {
            return new Promise((resolve, reject) => {
                const mockup = this.selected[index];
                const isUploadedMockup = mockup.hasOwnProperty('b_64');

                // Create and style the container
                const wrap = document.createElement('div');
                wrap.id = `download-image-${index}`;
                wrap.classList.add('download-image');

                if (isUploadedMockup) {
                    wrap.style.position = 'fixed';
                    wrap.style.top = '-9999px';
                    wrap.style.left = '-9999px';
                    wrap.style.overflow = 'hidden';

                    const tempImg = new Image();
                    tempImg.onload = () => {
                        wrap.style.width = `${tempImg.naturalWidth}px`;
                        wrap.style.height = `${tempImg.naturalHeight}px`;
                        tempImg.style.width = '100%';
                        tempImg.style.height = '100%';
                        tempImg.style.display = 'block';
                        wrap.appendChild(tempImg);

                        document.body.appendChild(wrap);

                        htmlToCanvas(wrap, {
                            backgroundColor: null,
                            useCORS: true,
                            allowTaint: true,
                            logging: false,
                            scale: 1
                        })
                        .then(canvas => {
                            resolve({
                                image: canvas.toDataURL('image/png'),
                                isMockupUploaded: true
                            });
                        })
                        .catch(reject)
                        .finally(() => {
                            if (document.body.contains(wrap)) document.body.removeChild(wrap);
                            URL.revokeObjectURL(tempImg.src);
                        });
                    };
                    tempImg.onerror = () => {
                        reject(new Error('Failed to load mockup image'));
                        URL.revokeObjectURL(tempImg.src);
                    };
                    tempImg.src = mockup.src;
                    
                    return;
                } else {
                    wrap.style.position = 'relative';
                    wrap.style.width = '2000px';
                    wrap.style.height = '1013px';
                    wrap.style.backgroundColor = '#ffffff';
                }

                const template = element.querySelector('.template').cloneNode(true);

                if (this.bb_version < 3 && !isUploadedMockup) {
                    template.style.width = '2000px';
                    template.style.height = '1013px';
                }

                wrap.appendChild(template);

                // Process mask SVGs
                const mask_svgs = element.getElementsByClassName('mask');
                if (mask_svgs.length) {
                    Array.from(mask_svgs).forEach(svgEl => {
                        const svgString = svgEl.outerHTML;
                        const encodedSvg = btoa(unescape(encodeURIComponent(svgString)));

                        const mask_image = new Image();
                        mask_image.src = `data:image/svg+xml;base64,${encodedSvg}`;
                        mask_image.style.position = 'absolute';
                        mask_image.style.top = 0;
                        mask_image.style.left = 0;
                        mask_image.style.width = '100%';
                        mask_image.style.height = '100%';

                        if (svgEl.classList.contains('background_mask')) {
                            mask_image.style.mixBlendMode = 'multiply';
                        } else if (svgEl.classList.contains('logos_mask')) {
                            mask_image.style.mixBlendMode = 'screen';
                        }

                        if (this.bb_version < 3) {
                            mask_image.style.width = '2000px';
                            mask_image.style.height = '1013px';
                        }

                        wrap.appendChild(mask_image);
                    });
                }

                document.body.appendChild(wrap);

                const node = document.getElementById(`download-image-${index}`);

                if (!isUploadedMockup) {
                    // Update the template image src to match the selected mockup
                    const templateImg = node.querySelector('img.template');
                    if (templateImg) {
                        if (mockup.src === 'logo') {
                            templateImg.src = this.logo_b64;
                        } else if (mockup.src === 'icon') {
                            templateImg.src = this.icon_b64;
                        } else {
                            templateImg.src = mockup.src;
                        }
                    }

                    // Wait for the image to load before processing
                    const imageEl = node.querySelector('img.template');

                    if (imageEl) {
                        if (!imageEl.complete) {
                            imageEl.onload = () => this.domToImage(node).then(resolve).catch(reject);
                            imageEl.onerror = reject;
                            return;
                        } else {
                            // If image is already loaded, process immediately
                            this.domToImage(node).then(resolve).catch(reject);
                            return;
                        }
                    } else {
                        reject(new Error('No template image found'));
                    }
                }
            });
        },
        skip() {
            this.$emit( 'forward' );
        },
        save() {
            axios.post( this.endpoints.ajax.post.brandbook.save, {
                mockups: this.save_data,
                id     : this.id,
            } );
        },
        newCover: function( image ) {
            this.mockups.unshift( {
                                      name: 'mockup-' + this.mockups.length,
                                      src : image.image,
                                      b_64: image.b_64,
                                  } );
        },
        setSelected( index ) {
            if ( this.selected.length < 4 ) {
                this.selected.push( this.mockups[ index ] );
                this.$root.$emit( 'allow-select', index );
            }
        },
        unSelect( name ) {
            this.selected.forEach( ( value, index ) => {
                if ( value.name == name ) {
                    this.selected.splice( index, 1 );
                }
            } );
        },
    },
    computed: {
        covers() {
            return this.mockups;
        },
        allLogoVaitionsMaped() {
            var maped = {};
            this.all_logo_variations.forEach( value => {
                maped[ value.id ] = 'data:image/svg+xml;base64,' + btoa( value.logo );
            } );
            return maped;
        },
        allIconVaitionsMaped() {
            var maped = {};
            this.all_icon_variations.forEach( value => {
                maped[ value.id ] = value.icon_b64;
            } );
            return maped;
        },
        isWhiteLogo() {
            return typeof this.white_logo.logo_b64 !== 'undefined';
        },
    },
};
</script>

<style lang="scss">

.mockup-container-wrapper {
    border: 1px solid #999999;
    width: 90%;
    margin: auto;
    height: 350px;
    overflow-y: scroll;
    margin-bottom: 10px;
}

.format svg {
    float: left;
    margin-top: 10px;
    margin-right: 10px;
}

.clear {
    clear: both;
}

.mockup-title {
    text-align: center;
    padding: 30px;
    font-size: 28px;
    font-style: normal;
    font-weight: 400;
    line-height: 42px;
    letter-spacing: 0em;
}

.mockup-container {
    position: relative;
    float: left;
    width: 50%;

    .photo {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        img {
            position: absolute;
        }

        .sign {
            top: -24%;
            width: 85%;
            left: -44%;
        }

        .bag {
            left: -64%;
            top: -32%;
        }

        .cup-holder {
            top: -62%;
            left: -56%;
        }

        .cup-left {
            left: -60%;
            top: -58%;
        }

        .cup-right {
            top: -58%;
            left: -52%;
        }

        .bag-small {
            position: absolute;
            left: -72.2%;
            top: -56%;
        }
    }

    .transform {
        transform-origin: 0px 0px;
    }

    .frame img {
        width: 100%;
        max-height: 100%;
    }

}


</style>

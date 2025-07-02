<template>
    <div class="upload-mockup-wrap">
        <div
            :style="{'--percents': upload_progress+'%', '--color': main_color, '--display': (upload_progress>0)?'block':'none'}">
            <div class="upload-loading" v-if="upload_progress>0">
                <svg width="30" height="30" viewBox="0 0 120 30" style="margin-top: 15px"
                     xmlns="http://www.w3.org/2000/svg" :fill="main_color">
                    <circle cx="15" cy="15" r="15">
                        <animate attributeName="r" from="15" to="15"
                                 begin="0s" dur="0.8s"
                                 values="15;9;15" calcMode="linear"
                                 repeatCount="indefinite"/>
                        <animate attributeName="fill-opacity" from="1" to="1"
                                 begin="0s" dur="0.8s"
                                 values="1;.5;1" calcMode="linear"
                                 repeatCount="indefinite"/>
                    </circle>
                    <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                        <animate attributeName="r" from="9" to="9"
                                 begin="0s" dur="0.8s"
                                 values="9;15;9" calcMode="linear"
                                 repeatCount="indefinite"/>
                        <animate attributeName="fill-opacity" from="0.5" to="0.5"
                                 begin="0s" dur="0.8s"
                                 values=".5;1;.5" calcMode="linear"
                                 repeatCount="indefinite"/>
                    </circle>
                    <circle cx="105" cy="15" r="15">
                        <animate attributeName="r" from="15" to="15"
                                 begin="0s" dur="0.8s"
                                 values="15;9;15" calcMode="linear"
                                 repeatCount="indefinite"/>
                        <animate attributeName="fill-opacity" from="1" to="1"
                                 begin="0s" dur="0.8s"
                                 values="1;.5;1" calcMode="linear"
                                 repeatCount="indefinite"/>
                    </circle>
                </svg>
            </div>
            <div class="upload-section">
                <div class="format">
                    <svg width="37" height="28" viewBox="0 0 37 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M33.5312 0H3.46875C1.55299 0 0 1.55454 0 3.47222V24.3056C0 26.2232 1.55299 27.7778 3.46875 27.7778H33.5312C35.447 27.7778 37 26.2232 37 24.3056V3.47222C37 1.55454 35.447 0 33.5312 0ZM33.0977 24.3056H3.90234C3.78735 24.3056 3.67706 24.2598 3.59575 24.1784C3.51443 24.097 3.46875 23.9866 3.46875 23.8715V3.90625C3.46875 3.79114 3.51443 3.68074 3.59575 3.59935C3.67706 3.51795 3.78735 3.47222 3.90234 3.47222H33.0977C33.2127 3.47222 33.3229 3.51795 33.4043 3.59935C33.4856 3.68074 33.5312 3.79114 33.5312 3.90625V23.8715C33.5312 23.9866 33.4856 24.097 33.4043 24.1784C33.3229 24.2598 33.2127 24.3056 33.0977 24.3056ZM9.25 6.36574C7.65358 6.36574 6.35938 7.66124 6.35938 9.25926C6.35938 10.8573 7.65358 12.1528 9.25 12.1528C10.8464 12.1528 12.1406 10.8573 12.1406 9.25926C12.1406 7.66124 10.8464 6.36574 9.25 6.36574ZM6.9375 20.8333H30.0625V15.0463L23.7382 8.71564C23.3995 8.37666 22.8505 8.37666 22.5118 8.71564L13.875 17.3611L11.0194 14.5027C10.6808 14.1637 10.1317 14.1637 9.793 14.5027L6.9375 17.3611V20.8333Z"
                            fill="#CFCFCF"/>
                    </svg>
                    <div class="text">
                        <b>{{ translate( 'Raster image' ) }}</b>
                        <div>{{ translate( 'JPG or PNG' ) }}</div>
                    </div>
                </div>
                <div class="drag-drop text-center">{{ translate( 'Upload a file' ) }}</div>
                <div class="w-100 text-center">
                    <file-upload class="upload-link" accept="image/svg+xml,image/jpeg,image/png"
                                 extensions="svg,jpg,jpeg,png" :post-action="endpoints.ajax.post.upload_mockup"
                                 :multiple=false @input-file="input_file" :drop=true
                                 :drop-directory=false v-model="image" auto ref="upload_mockup"
                                 :data="post_data"
                                 :headers="headers">
                    </file-upload>
                </div>
                <div class="w-100 text-center"><small>{{ translate( '(file size up to 3 MB)' ) }}</small></div>
            </div>
            <button class="btn upload-mobile-btn" :style="{'background': main_color}"
                    @click="document.getElementById('file').click()">
                {{ translate( 'Upload a SVG file' ) }}
            </button>
        </div>
    </div>
</template>
<script>
import translate from '../../utils/translate';
import FileUpload from 'vue-upload-component';

export default {
    components: {
        FileUpload,
    },
    props     : {
        main_color   : String,
        max_file_size: Number,
    },
    data() {
        return {
            image          : [],
            upload_progress: 0,
            endpoints      : endpoints,
            post_data      : {},
            cover          : {},
        };
    },
    computed: {
        headers() {
            return {
                'X-CSRF-TOKEN': document.querySelector( 'meta[name="csrf-token"]' ).content,
            };
        },
    },
    mounted() {
    },
    watch  : {
        cover: function( image ) {
            this.$emit( 'new_cover', image );
        },
    },
    methods: {
        translate,
        input_file( newFile, oldFile ) {

            if ( newFile && ! oldFile ) {
                // Add file
                this.$refs.upload_mockup.active = true;
                this.upload_progress = 1;
                if ( newFile.size > this.max_file_size && newFile != oldFile ) {
                    this.upload_progress = 0;
                    this.showErrorModal( {
                                             title  : this.translate( 'Your file is more then 3Mb size.' ),
                                             article: this.translate( 'Please try another file.' ),
                                         } );
                    this.$refs.upload_mockup.active = false;
                    return;
                }
            }

            if ( newFile && oldFile ) {
                // Update file

                // Start upload
                if ( newFile.size > this.max_file_size && newFile != oldFile ) {
                    this.upload_progress = 0;
                    this.showErrorModal( {
                                             title  : this.translate( 'Your file is more then 3Mb size.' ),
                                             article: this.translate( 'Please try another file.' ),
                                         } );
                    this.$refs.upload_mockup.active = false;
                    return;
                }
                // Upload progress
                if ( newFile.progress !== oldFile.progress ) {
                    this.upload_progress = newFile.progress - 30;
                }

                // Upload error
                if ( newFile.error !== oldFile.error ) {
                    var message = {
                        title  : '',
                        article: '',
                    };
                    switch ( newFile.error ) {
                        case 'extension':
                            message.title = this.translate( 'We support only SVG files.' );
                            message.article = this.translate(
                                'got an .AI or PDF file? open it in Adobe illustrator and save as .SVG - simple :)' );
                            break;

                        default:
                            message.article = newFile.response.error;
                            message.title = this.translate( 'Error' );
                            break;
                    }
                    this.showErrorModal( message );
                    this.upload_progress = 0;
                }

                // Uploaded successfully
                if ( newFile.success !== oldFile.success ) {
                    this.cover = newFile.response;
                    this.upload_progress = 0;
                }
            }

            // Automatic upload
            if ( Boolean( newFile ) !== Boolean( oldFile ) || oldFile.error !== newFile.error ) {
                if ( ! this.$refs.upload_mockup.active ) {
                    this.upload_progress = 1;
                    this.$refs.upload_mockup.active = true;
                }
            }
        },
    },
};
</script>
<style lang=scss>
.upload-mockup-wrap {
    width: 100%;
    height: 100%;
    padding: 20px;

    .drag-drop.text-center {
        font-weight: bold;
        font-size: 18px;
        margin-top: 25px;
    }

    .file-uploads {
        display: inline !important;
    }
}

</style>

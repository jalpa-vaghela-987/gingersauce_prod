<template>
    <div>
        <div class="step-title less-top px-0 pt-5 mb-4" v-if="!icon_uploaded">
            {{ translate("Add Brand Icon") }}
            <small class="pt-0 w-100 d-block text-center">
                {{ translate("or designated Favicon in SVG format") }}
            </small>
        </div>
        <div class="step-title less-top px-0 pt-5 mb-4" v-if="icon_uploaded">
            {{ 
                has_white ? 
                translate("Approve main version for white background") :
                translate("Approve Brand Icon") 
            }}
            <small class="pt-0 w-100 d-block text-center">
                {{ translate("or drag & drop another one instead") }}
            </small>
        </div>

        <div
            :class="['upload', icon_uploaded ? 'uploaded' : '']"
            :style="{
                '--percents': upload_progress + '%',
                '--color': colors[0],
                '--display': upload_progress > 0 ? 'block' : 'none'
            }"
        >
            <div class="format" v-if="!icon_uploaded">
                <span v-html="vectorIcon()"></span>
                <div class="text">
                    <b>{{ translate("Vector image") }}</b>
                    <div>{{ translate("SVG Only") }}</div>
                </div>
            </div>

            <div class="upload-section">
                <div class="drag-drop text-center">
                    {{ translate("Upload a file") }}
                </div>

                <div class="w-100 text-center">
                    <file-upload
                        class="upload-link"
                        accept="image/svg+xml"
                        extensions="svg"
                        :post-action="upload_icon_endpoint"
                        :multiple="false"
                        @input-file="input_icon_file"
                        :drop="true"
                        :drop-directory="false"
                        v-model="icon_file"
                        auto
                        ref="upload_icon"
                        :headers="headers()"
                    >
                    </file-upload>
                </div>

                <div class="w-100 text-center">
                    <small>
                        {{ translate("(file size up to 3 MB)") }}
                    </small>
                </div>
            </div>
            <button
                class="btn upload-mobile-btn"
                :style="{ background: colors[0] }"
                @click="chooseFiles()"
            >
                {{ translate("Upload a SVG file") }}
            </button>

            <img
                :src="icon_b64"
                alt=""
                class="icon_uploaded"
                v-if="icon_uploaded && !has_white"
            />




            <div class="logo_select" v-if="icon_uploaded && has_white">
                <div
                    @click="white_bg_icon_type = 'original'"
                    class="logo_option"
                    :class="white_bg_icon_type == 'original' ? 'selected' : ''">
                    <img :src="icon_b64" class="icon_uploaded">
                </div>
                <div
                    @click="white_bg_icon_type = 'white'"
                    class="logo_option"
                    :class="white_bg_icon_type == 'white' ? 'selected' : ''">
                    <img :src="white_bg_icon_b64()" class="icon_uploaded">

                </div>
            </div>
            <div class="logo_select" v-if="icon_uploaded && !has_white">
                <div
                    class="logo_one_option"
                    :class="white_bg_icon_type == 'original' ? 'selected' : ''">
                    <img :src="icon_b64" class="icon_uploaded">
                </div>
            </div>








            <div :class="['icon-title-block']" v-if="icon_uploaded">
                <div class="icon-title-block-name">
                    {{ translate("Name") }}
                </div>
                <input
                    type="text"
                    class="icon-title-input"
                    v-model="icon_caption"
                />
                <svg
                    width="19"
                    height="18"
                    viewBox="0 0 19 18"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M13.4539 11.7409L14.4623 10.6783C14.6199 10.5123 14.8939 10.6285 14.8939 10.8676V15.6953C14.8939 16.5751 14.2165 17.2891 13.3813 17.2891H2.28897C1.45393 17.2891 0.776367 16.5753 0.776367 15.6953V4.00786C0.776367 3.12801 1.45385 2.41409 2.28897 2.41409H10.9076C11.1313 2.41409 11.2447 2.69961 11.0872 2.86894L10.0788 3.93148C10.0315 3.98132 9.96849 4.00786 9.89915 4.00786H2.28897V15.6954H13.3813V11.9269C13.3813 11.857 13.4065 11.7906 13.4539 11.7409ZM18.3886 5.04046L10.1135 13.7596L7.26478 14.0916C6.43926 14.188 5.73643 13.4541 5.82781 12.5775L6.14294 9.57606L14.4182 0.856888C15.1397 0.0965321 16.3056 0.0965321 17.0241 0.856888L18.3855 2.29127C19.1071 3.05163 19.1071 4.28343 18.3886 5.04046ZM15.2752 6.06643L13.4443 4.13731L7.5892 10.3098L7.35915 12.478L9.41693 12.2355L15.2752 6.06643ZM17.3173 3.42016L15.956 1.98577C15.8266 1.84961 15.6156 1.84961 15.4895 1.98577L14.5158 3.01174L16.3467 4.94087L17.3204 3.9149C17.4464 3.77542 17.4464 3.55624 17.3173 3.42016Z"
                        fill="#6C6B6B"
                    />
                </svg>
            </div>
        </div>

        <div class="upload-footer">
            <button
                :disabled="!icon_uploaded || !white_bg_icon_type"
                class="btn btn-outline-success"
                @click="approveIcon"
            >
                <svg
                    width="28"
                    height="21"
                    viewBox="0 0 28 21"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M27.2417 4.13797L10.6762 20.5227C10.2246 20.9694 9.49537 20.9665 9.04742 20.5162L0.334063 11.7579C-0.113886 11.3076 -0.111006 10.5804 0.340686 10.1337L2.5213 7.97691C2.9729 7.53027 3.70217 7.53314 4.15012 7.98351L9.88908 13.7522L23.4564 0.333103C23.9079 -0.113543 24.6372 -0.110671 25.0852 0.339612L27.2482 2.5138C27.6962 2.96417 27.6933 3.69133 27.2417 4.13797Z"
                    />
                </svg>
                {{ translate("Approve") }}
            </button>

            <div class="skip" @click="$emit('skip', 12)">
                {{ translate("or skip") }}
                <svg
                    width="9"
                    height="16"
                    viewBox="0 0 9 16"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M1.00006 15L7.00006 8L1.00006 1"
                        stroke="black"
                        stroke-width="2"
                    />
                </svg>
            </div>
        </div>
    </div>
</template>

<script>
import FileUpload from "vue-upload-component";
import { generateVariation } from '../logo-variations/methods.js';
import {
    edit,
    skip,
    spinner,
    vectorIcon,
    approve
} from "../../utils/svg/icons";
import { headers, prepareToBtoa } from "../../utils/svg/file";
import Schemas from "./schemas";
import translate from "../../utils/translate";
import { applyStyles } from '../../utils/svg/style';

export default {
    components: {
        FileUpload
    },

    props: {
        selected: Array,
        colors: Array,
        endpoints: String,
        icon_caption: String,
        icon: String,
        icon_b64: String,
    },
    data() {
        return {
            upload_progress: 0,
            icon_file: [],
            renders: [],
            white_bg_icon_type: 'original',
            white_bg_icon: {},
            icon_version: {},
            hideFromApproving: [
                "Black & White Positive",
                "Secondary Color Positive",
                "Primary Color Positive"
            ],
            white_bg_icon_type: null
        };
    },
    mounted() {
    },

    computed: {
        upload_icon_endpoint() {
            return endpoints.ajax.post.upload_icon;
        },

        icon_uploaded() {
            return this.icon == null ||
                this.icon == "[]" ||
                this.icon == "skipped"
                ? false
                : true;
        }
    },

    methods: {
        translate,
        spinner,
        approve,
        vectorIcon,
        headers,
        prepareToBtoa,

        chooseFiles() {
            document.getElementById("file").click();
        },

        white_bg_icon_b64(){
            var icon_data = this.icon_version.white_bg_icon;
            if(!icon_data){
                var icon_data = this.processIconVersion(this.icon);
            }

            return icon_data.icon_b64;
        },

        input_icon_file(newFile, oldFile) {
            if (newFile && !oldFile) {
                // Add file
                this.$refs.upload_icon.active = true;
                this.upload_progress = 1;
                if (newFile.size > 1000000 && newFile != oldFile) {
                    this.upload_progress = 0;
                    this.showErrorModal(message);
                    this.$refs.upload_icon.active = false;
                    return;
                }
            }

            if (newFile && oldFile) {
                // Update file

                // Start upload
                if (newFile.size > 1000000 && newFile != oldFile) {
                    this.upload_progress = 0;
                    this.showErrorModal({
                        title: "Your file is more then 1Mb size.",
                        article: "Please try another file. "
                    });
                    this.$refs.upload_icon.active = false;
                    return;
                }
                // Upload progress
                if (newFile.progress !== oldFile.progress) {
                    this.upload_progress = newFile.progress - 30;
                }

                // Upload error
                if (newFile.error !== oldFile.error) {
                    var message = {
                        title: "",
                        article: ""
                    };
                    switch (newFile.error) {
                        case "extension":
                            message.title = this.translate(
                                "We support only SVG files."
                            );
                            message.article = this.translate(
                                "got an .AI or PDF file? open it in Adobe illustrator and save as .SVG - simple :)"
                            );
                            break;

                        default:
                            message.article = newFile.response.error;
                            message.title = "Error";
                            break;
                    }
                    this.showErrorModal(message);
                    this.upload_progress = 0;
                }

                // Uploaded successfully
                if (newFile.success !== oldFile.success) {
                    this.upload_progress = 90;
                    //this.icon = prepareToBtoa(newFile.response.icon);

                    try {
                        //this.upload_progress = 0;
                        //this.icon_b64 =
                        //    "data:image/svg+xml;base64," + btoa(this.icon);
                        //this.icon_uploaded = true;
                        ///this.icon_uploaded = true;
                        var icon_body = newFile.response.icon;
                        icon_body = icon_body.replace(
                            "currentColor",
                            "#000000"
                        );

                        this.processIconVersion(icon_body);
                    
                    } catch (e) {
                        this.upload_progress = 0;
                        this.showErrorModal({
                            title:
                                "Sorry! We've faced an error, processing your file.",
                            article:
                                "Please try again with another file, or try to open and save this file in another SVG editor"
                        });
                    }
                }
            }

            // Automatic upload
            if (
                Boolean(newFile) !== Boolean(oldFile) ||
                oldFile.error !== newFile.error
            ) {
                if (!this.$refs.upload_icon.active) {
                    this.upload_progress = 1;
                    this.$refs.upload_icon.active = true;
                }
            }
        },
        approveIcon() {
            this.generateIconVariations();

            this.$emit("approveIcon", {
                icon_caption: this.icon_caption,
                all_icon_variations: this.renders,
                icon: this.white_bg_icon_type == 'white' ? 
                    this.icon_version.white_bg_icon.icon : 
                    this.icon,
                icon_b64: this.white_bg_icon_type == 'white' ? 
                    this.icon_version.white_bg_icon.icon_b64 : 
                    this.icon_b64,
            });
        },

        generateIconVariations() {
            var source_icon = this.white_bg_icon_type == 'white' ?
                this.icon_version.white_bg_icon.icon :
                this.icon;

            this.schemas = new Schemas(
                [this.colors[0], this.colors[1], this.colors[2]],
                source_icon
            );

            this.renders = this.schemas.renders();
        },

        processIconVersion(icon_svg)
        {
            var white_bg_icon = this.get_white_icon_variation(icon_svg);
            this.icon_version = {
                icon: icon_svg,
                icon_b64: "data:image/svg+xml;base64," + btoa(icon_svg),
                white_bg_icon: white_bg_icon,
                white_bg_icon_type: 'original'
            }
            this.icon = this.icon_version.icon;
            this.icon_b64 = this.icon_version.icon_b64;
            return {
                icon: this.icon_version.icon,
                icon_b64: this.icon_version.icon_b64
            }
        },

        get_white_icon_variation( icon ) {
            if ( icon && icon.includes( 'requiredExtensions' ) ) {
                this.showErrorModal( {
                    title  : this.translate('The file cannot be processed. Please check out these instructions' ),
                    article: this.translate(`
<a target="_blank" href="https://gingersauce.co/how-to-use-gingersauce-create-a-brand-book-online/">
    How to use the Gingersauce
</a><br>
Search for the part "Don’t know how to save your logo in SVG? Here’s a little guide"
` ),
                } );

            }

            icon = applyStyles( icon );
            // "White & Colors" scheme
            var params = {
                fill      : {
                    dark : '#FFFFFF',
                    light: '#000000',
                },
                background: '#000000',
            };

            var variation = generateVariation( icon, params );

            var icon_variation = {
                icon: variation.logo,
                icon_b64: variation.logo_b64,
            }

            return icon_variation;
        },
        showErrorModal( message = {
            title  : this.translate( 'Error' ),
            article: this.translate( 'We have some error' ),
        } ) {
            // this.IsModal = true;
            // this.modalMessage = message;
            console.log('showErrorModal');
            console.log(message);
        },

        has_white(){
            logo = this.icon.replace(', ', ',');
            return (
                logo.includes('white') ||
                logo.includes('#FFFFFF') ||
                logo.includes('#ffffff') ||
                logo.includes('rgb(255,255,255)') ||
                logo.includes('rgba(255,255,255')
            );
        },
    }
};
</script>

<style lang="scss" scoped></style>

<template>
    <div class="col-4 font-upload font-block-container" :class="[(!previous_uploaded) ? 'font-block-dis' : '', (mobile_index == index) ? 'mobile-show' : '']">
        <div :class="['font', font_file_uploaded!=''?'uploaded':'']" :style="{'--color': background_color}">
            <div class="remover" v-if="font_file_uploaded!='' || gfont_selected" @click="clearFont">
                <svg width="19" height="21" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M9.16254 13.8857H9.92946C10.0312 13.8857 10.1287 13.8462 10.2006 13.7759C10.2725 13.7056 10.3129 13.6102 10.3129 13.5107V6.76074C10.3129 6.66129 10.2725 6.5659 10.2006 6.49558C10.1287 6.42525 10.0312 6.38574 9.92946 6.38574H9.16254C9.06084 6.38574 8.96331 6.42525 8.8914 6.49558C8.81948 6.5659 8.77908 6.66129 8.77908 6.76074V13.5107C8.77908 13.6102 8.81948 13.7056 8.8914 13.7759C8.96331 13.8462 9.06084 13.8857 9.16254 13.8857ZM14.4031 3.38574H11.7697L10.6833 1.61387C10.5469 1.39168 10.354 1.20783 10.1234 1.08023C9.89282 0.952624 9.63234 0.885619 9.36737 0.885742H6.14568C5.88082 0.885727 5.62047 0.952783 5.38998 1.08038C5.15949 1.20798 4.96671 1.39178 4.83042 1.61387L3.74331 3.38574H1.10991C0.974312 3.38574 0.844266 3.43842 0.748383 3.53219C0.652499 3.62596 0.598633 3.75313 0.598633 3.88574L0.598633 4.38574C0.598633 4.51835 0.652499 4.64553 0.748383 4.7393C0.844266 4.83306 0.974312 4.88574 1.10991 4.88574H1.62119V15.3857C1.62119 15.7836 1.78279 16.1651 2.07044 16.4464C2.35809 16.7277 2.74823 16.8857 3.15502 16.8857H12.358C12.7648 16.8857 13.155 16.7277 13.4426 16.4464C13.7303 16.1651 13.8919 15.7836 13.8919 15.3857V4.88574H14.4031C14.5387 4.88574 14.6688 4.83306 14.7647 4.7393C14.8606 4.64553 14.9144 4.51835 14.9144 4.38574V3.88574C14.9144 3.75313 14.8606 3.62596 14.7647 3.53219C14.6688 3.43842 14.5387 3.38574 14.4031 3.38574ZM6.08976 2.47668C6.10685 2.44886 6.13103 2.42586 6.15993 2.40992C6.18883 2.39398 6.22147 2.38565 6.25465 2.38574H9.25841C9.29153 2.38571 9.32411 2.39406 9.35295 2.41C9.38179 2.42594 9.40591 2.44891 9.42297 2.47668L9.98091 3.38574H5.53215L6.08976 2.47668ZM12.358 15.3857H3.15502V4.88574H12.358V15.3857ZM5.5836 13.8857H6.35051C6.45221 13.8857 6.54975 13.8462 6.62166 13.7759C6.69357 13.7056 6.73397 13.6102 6.73397 13.5107V6.76074C6.73397 6.66129 6.69357 6.5659 6.62166 6.49558C6.54975 6.42525 6.45221 6.38574 6.35051 6.38574H5.5836C5.4819 6.38574 5.38436 6.42525 5.31245 6.49558C5.24054 6.5659 5.20014 6.66129 5.20014 6.76074V13.5107C5.20014 13.6102 5.24054 13.7056 5.31245 13.7759C5.38436 13.8462 5.4819 13.8857 5.5836 13.8857Z"
                        v-bind:fill="(gfont_fin_selected) ? 'white' : 'black'"/>
                </svg>
            </div>
            <div v-if="font_file_uploaded=='' && !gfont_selected" class="informer">
                <svg width="127" height="32" viewBox="0 0 127 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M43.94 3.16V5.38H47.828V6.94H43.94V10H41.996V1.6H48.344V3.16H43.94ZM52.436 10.096C51.756 10.096 51.144 9.956 50.6 9.676C50.064 9.388 49.644 8.992 49.34 8.488C49.036 7.984 48.884 7.412 48.884 6.772C48.884 6.132 49.036 5.56 49.34 5.056C49.644 4.552 50.064 4.16 50.6 3.88C51.144 3.592 51.756 3.448 52.436 3.448C53.116 3.448 53.724 3.592 54.26 3.88C54.796 4.16 55.216 4.552 55.52 5.056C55.824 5.56 55.976 6.132 55.976 6.772C55.976 7.412 55.824 7.984 55.52 8.488C55.216 8.992 54.796 9.388 54.26 9.676C53.724 9.956 53.116 10.096 52.436 10.096ZM52.436 8.56C52.916 8.56 53.308 8.4 53.612 8.08C53.924 7.752 54.08 7.316 54.08 6.772C54.08 6.228 53.924 5.796 53.612 5.476C53.308 5.148 52.916 4.984 52.436 4.984C51.956 4.984 51.56 5.148 51.248 5.476C50.936 5.796 50.78 6.228 50.78 6.772C50.78 7.316 50.936 7.752 51.248 8.08C51.56 8.4 51.956 8.56 52.436 8.56ZM61.1513 3.448C61.9513 3.448 62.5953 3.688 63.0833 4.168C63.5793 4.648 63.8273 5.36 63.8273 6.304V10H61.9553V6.592C61.9553 6.08 61.8433 5.7 61.6193 5.452C61.3953 5.196 61.0713 5.068 60.6473 5.068C60.1753 5.068 59.7993 5.216 59.5193 5.512C59.2393 5.8 59.0993 6.232 59.0993 6.808V10H57.2273V3.544H59.0153V4.3C59.2633 4.028 59.5713 3.82 59.9393 3.676C60.3073 3.524 60.7113 3.448 61.1513 3.448ZM69.6882 9.688C69.5042 9.824 69.2762 9.928 69.0042 10C68.7402 10.064 68.4602 10.096 68.1642 10.096C67.3962 10.096 66.8002 9.9 66.3762 9.508C65.9602 9.116 65.7522 8.54 65.7522 7.78V5.128H64.7562V3.688H65.7522V2.116H67.6242V3.688H69.2322V5.128H67.6242V7.756C67.6242 8.028 67.6922 8.24 67.8282 8.392C67.9722 8.536 68.1722 8.608 68.4282 8.608C68.7242 8.608 68.9762 8.528 69.1842 8.368L69.6882 9.688ZM76.2134 3.16V5.38H80.1014V6.94H76.2134V10H74.2694V1.6H80.6174V3.16H76.2134ZM81.6843 3.544H83.5563V10H81.6843V3.544ZM82.6203 2.644C82.2763 2.644 81.9963 2.544 81.7803 2.344C81.5643 2.144 81.4563 1.896 81.4563 1.6C81.4563 1.304 81.5643 1.056 81.7803 0.856C81.9963 0.655999 82.2763 0.555999 82.6203 0.555999C82.9643 0.555999 83.2443 0.651999 83.4603 0.844C83.6763 1.036 83.7843 1.276 83.7843 1.564C83.7843 1.876 83.6763 2.136 83.4603 2.344C83.2443 2.544 82.9643 2.644 82.6203 2.644ZM85.2937 1.096H87.1657V10H85.2937V1.096ZM95.2271 6.796C95.2271 6.82 95.2151 6.988 95.1911 7.3H90.3071C90.3951 7.7 90.6031 8.016 90.9311 8.248C91.2591 8.48 91.6671 8.596 92.1551 8.596C92.4911 8.596 92.7871 8.548 93.0431 8.452C93.3071 8.348 93.5511 8.188 93.7751 7.972L94.7711 9.052C94.1631 9.748 93.2751 10.096 92.1071 10.096C91.3791 10.096 90.7351 9.956 90.1751 9.676C89.6151 9.388 89.1831 8.992 88.8791 8.488C88.5751 7.984 88.4231 7.412 88.4231 6.772C88.4231 6.14 88.5711 5.572 88.8671 5.068C89.1711 4.556 89.5831 4.16 90.1031 3.88C90.6311 3.592 91.2191 3.448 91.8671 3.448C92.4991 3.448 93.0711 3.584 93.5831 3.856C94.0951 4.128 94.4951 4.52 94.7831 5.032C95.0791 5.536 95.2271 6.124 95.2271 6.796ZM91.8791 4.864C91.4551 4.864 91.0991 4.984 90.8111 5.224C90.5231 5.464 90.3471 5.792 90.2831 6.208H93.4631C93.3991 5.8 93.2231 5.476 92.9351 5.236C92.6471 4.988 92.2951 4.864 91.8791 4.864ZM47.72 31.096C46.6107 31.096 45.6027 30.8507 44.696 30.36C43.8 29.8587 43.096 29.176 42.584 28.312C42.0827 27.448 41.832 26.4773 41.832 25.4C41.832 24.3227 42.0827 23.352 42.584 22.488C43.096 21.624 43.8 20.9467 44.696 20.456C45.6027 19.9547 46.6107 19.704 47.72 19.704C48.8293 19.704 49.8267 19.9493 50.712 20.44C51.608 20.9307 52.312 21.6133 52.824 22.488C53.336 23.352 53.592 24.3227 53.592 25.4C53.592 26.4773 53.336 27.4533 52.824 28.328C52.312 29.192 51.608 29.8693 50.712 30.36C49.8267 30.8507 48.8293 31.096 47.72 31.096ZM47.72 30.04C48.6053 30.04 49.4053 29.8427 50.12 29.448C50.8347 29.0427 51.3947 28.488 51.8 27.784C52.2053 27.0693 52.408 26.2747 52.408 25.4C52.408 24.5253 52.2053 23.736 51.8 23.032C51.3947 22.3173 50.8347 21.7627 50.12 21.368C49.4053 20.9627 48.6053 20.76 47.72 20.76C46.8347 20.76 46.0293 20.9627 45.304 21.368C44.5893 21.7627 44.024 22.3173 43.608 23.032C43.2027 23.736 43 24.5253 43 25.4C43 26.2747 43.2027 27.0693 43.608 27.784C44.024 28.488 44.5893 29.0427 45.304 29.448C46.0293 29.8427 46.8347 30.04 47.72 30.04ZM58.2656 20.824H54.3296V19.8H63.3856V20.824H59.4496V31H58.2656V20.824ZM66.4611 20.824V25.224H72.2531V26.248H66.4611V31H65.2771V19.8H72.9571V20.824H66.4611ZM82.7896 31.08C81.979 31.08 81.2483 30.8987 80.5976 30.536C79.947 30.1627 79.435 29.6507 79.0616 29C78.6883 28.3493 78.5016 27.6133 78.5016 26.792C78.5016 25.9707 78.6883 25.2347 79.0616 24.584C79.435 23.9333 79.947 23.4267 80.5976 23.064C81.2483 22.7013 81.979 22.52 82.7896 22.52C83.6003 22.52 84.331 22.7013 84.9816 23.064C85.6323 23.4267 86.139 23.9333 86.5016 24.584C86.875 25.2347 87.0616 25.9707 87.0616 26.792C87.0616 27.6133 86.875 28.3493 86.5016 29C86.139 29.6507 85.6323 30.1627 84.9816 30.536C84.331 30.8987 83.6003 31.08 82.7896 31.08ZM82.7896 30.072C83.387 30.072 83.9203 29.9387 84.3896 29.672C84.8696 29.3947 85.243 29.0053 85.5096 28.504C85.7763 28.0027 85.9096 27.432 85.9096 26.792C85.9096 26.152 85.7763 25.5813 85.5096 25.08C85.243 24.5787 84.8696 24.1947 84.3896 23.928C83.9203 23.6507 83.387 23.512 82.7896 23.512C82.1923 23.512 81.6536 23.6507 81.1736 23.928C80.7043 24.1947 80.331 24.5787 80.0536 25.08C79.787 25.5813 79.6536 26.152 79.6536 26.792C79.6536 27.432 79.787 28.0027 80.0536 28.504C80.331 29.0053 80.7043 29.3947 81.1736 29.672C81.6536 29.9387 82.1923 30.072 82.7896 30.072ZM90.4689 24.232C90.7355 23.6667 91.1302 23.24 91.6529 22.952C92.1862 22.664 92.8422 22.52 93.6209 22.52V23.624L93.3489 23.608C92.4635 23.608 91.7702 23.88 91.2689 24.424C90.7675 24.968 90.5169 25.7307 90.5169 26.712V31H89.3809V22.584H90.4689V24.232ZM102.406 20.824H98.4703V19.8H107.526V20.824H103.59V31H102.406V20.824ZM111.75 20.824H107.814V19.8H116.87V20.824H112.934V31H111.75V20.824ZM119.946 20.824V25.224H125.738V26.248H119.946V31H118.762V19.8H126.442V20.824H119.946Z"
                        fill="black"/>
                    <path
                        d="M27.9643 25.8125H26.4489L17.9878 2.46049C17.8484 2.05272 17.5843 1.69863 17.2325 1.44791C16.8808 1.19719 16.459 1.06241 16.0264 1.0625H12.9736C12.541 1.06241 12.1192 1.19719 11.7675 1.44791C11.4157 1.69863 11.1516 2.05272 11.0122 2.46049L2.55109 25.8125H1.03571C0.761026 25.8125 0.497588 25.9211 0.303354 26.1145C0.10912 26.3079 0 26.5702 0 26.8438L0 28.9062C0 29.1798 0.10912 29.4421 0.303354 29.6355C0.497588 29.8289 0.761026 29.9375 1.03571 29.9375H9.32143C9.59612 29.9375 9.85955 29.8289 10.0538 29.6355C10.248 29.4421 10.3571 29.1798 10.3571 28.9062V26.8438C10.3571 26.5702 10.248 26.3079 10.0538 26.1145C9.85955 25.9211 9.59612 25.8125 9.32143 25.8125H8.05397L9.56223 21.6875H19.4378L20.946 25.8125H19.6786C19.4039 25.8125 19.1404 25.9211 18.9462 26.1145C18.752 26.3079 18.6429 26.5702 18.6429 26.8438V28.9062C18.6429 29.1798 18.752 29.4421 18.9462 29.6355C19.1404 29.8289 19.4039 29.9375 19.6786 29.9375H27.9643C28.239 29.9375 28.5024 29.8289 28.6966 29.6355C28.8909 29.4421 29 29.1798 29 28.9062V26.8438C29 26.5702 28.8909 26.3079 28.6966 26.1145C28.5024 25.9211 28.239 25.8125 27.9643 25.8125ZM11.4479 16.5312L14.5 8.18521L17.5521 16.5312H11.4479Z"
                        fill="#CFCFCF"/>
                </svg>
            </div>
            <div v-if="(index==1 && font_file_uploaded=='' && !gfont_selected) || (index!=1 && !gfont_selected && font_file_uploaded=='')" class="text">{{text}}</div>
            <file-upload v-if="((index!==1 && !gfont_selected))" :input-id=the_ref class="upload-link" accept="font/*" extensions="otf,ttf" :post-action="upload_font_endpoint"
                         :multiple=false @input-file="input_file" :drop=true :drop-directory=false v-model="font_file" auto :ref="the_ref" :headers="headers">
            </file-upload>
            <button v-if="((index!==1 && !gfont_selected))" class="btn upload-mobile-font-btn" @click="chooseFiles()">
                Upload a font
            </button>
            <div v-if="font_file_uploaded=='' && index==1 && !gfont_selected" class="g-font-block first-font" @click.stop.prevent=toggleFontDropDown>
                <button class="font-selector"><span v-if="!gfont_selected">
                {{ translate('Google font') }}
                </span><span v-else>{{gfont.family}}</span></button>
            </div>
            <div class="font-dropdown-wrapper" v-bind:class="{ opened: show_font_dropdown }">
                <div class="search">
                    <input type="text" v-model="gfont_search" placeholder="search"/>
                    <span class="search-btn" @click="searchFont()">
                    <svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="9.1875" cy="9.1875" r="8.1875" stroke="black" stroke-width="2"/>
                        <line x1="15.5821" y1="15.0429" x2="21.7071" y2="21.1679" stroke="black" stroke-width="2"/>
                    </svg>
                    </span>
                    <span class="close-btn" @click="toggleFontDropDown()">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="7.00684" y="8.56348" width="2.20205" height="22.0205" transform="rotate(-45 7.00684 8.56348)" fill="black"/>
                            <rect x="22.5771" y="7.00684" width="2.20205" height="22.0205" transform="rotate(45 22.5771 7.00684)" fill="black"/>
                        </svg>
                    </span>
                </div>
                <div class="font-dropdown" id="secondary-font-dropdown">
                    <gfont-item v-for="(item, index) in google_fonts" :font=item :family="item.family" :index=index v-bind:key="index"></gfont-item>
                </div>
            </div>
            <!--div v-if="font_file_uploaded=='' && index==1 && gfont_selected" class="g-font-block second" @click.stop.prevent="toggleFontDropDownWeight()">
                <button class="font-selector">Weight</button>
                <div class="font-dropdown-wrapper" v-if="show_font_dropdown_weight" :style="{height: (gfont.variants.length*28)+'px'}">
                    <div class="font-dropdown">
                        <div v-for="weight in gfont.variants" @click="selectGfontWeight(weight)">{{weight}}</div>
                    </div>
                </div>
            </div-->
            <div v-if="(font_file_uploaded=='' && index!=1 && gfont_selected) || (index==1 && gfont_selected && !gfont_fin_selected)" class="g-font-block second fin dis">
                <button class="font-selector disabled">{{gfont.family}}</button>
            </div>
            <div v-if="(font_file_uploaded=='' && index!=1 && gfont_fin_selected) || (font_file_uploaded=='' && index==1 && gfont_selected)" class="g-font-block second fin"
                 @click.prevent.stop=toggleFontDropDownWeight>
                <button class="font-selector font-selector-weight">
                {{ translate('Weight') }}
                </button>
                <div class="font-dropdown-wrapper font-weight-wrapper" v-bind:class="{ opened: show_font_dropdown_weight }" :style="{height: (gfont.variants.length*28)+'px'}">
                    <div class="font-dropdown">
                        <div v-for="weight in gfont.variants" @click="selectGfontWeight(weight)">{{weight}}</div>
                    </div>
                </div>
            </div>
            <div v-if="font_file_uploaded!=''" class="loaded_font_title">{{font_face_name}}</div>
            <div v-if="font_file_uploaded!=''" class="preview-text" :style="{'--font-name': this.font_title}">
                {{ translate('Aa') }}
        <small>{{project_title}}</small></div>
            <div class="optional" v-if="optional && font_face_weight == ''">
            {{ translate('Optional') }}</div>
        </div>
        <div class="font-block-title" v-if="font_file_uploaded==''">
                {{ translate('Font Weight') }}
                {{ translate(index)}}
        </div>
        <div class="font-block-title" v-if="font_file_uploaded!=''">{{translate(font_face_weight)}}</div>
    </div>
</template>
<script>
        import FileUpload from 'vue-upload-component'
        import translate from "../utils/translate";
        var opentype = require('opentype.js');
        export default {
                components : {
                        FileUpload
                },
                props      : {
                        'index'             : String,
                        'type'              : String,
                        'text'              : String,
                        'optional'          : Boolean,
                        'previous_uploaded' : Boolean,
                        'background'        : String,
                        'project_title'     : String,
                        fontdata            : Object,
                        mobile_index        : String
                },
                data()
                {
                        return {
                                visibles : [],

                                font_file          : [],
                                font_file_uploaded : '',
                                font_title         : '',
                                font_face_name     : '',
                                font_face_weight   : '',

                                apikey                    : '',
                                google_fonts              : [],
                                show_font_dropdown        : false,
                                gfont_selected            : false,
                                show_font_dropdown_weight : false,
                                gfont                     : {},
                                gfont_fin_selected        : false,
                                gfont_search              : ''
                        }
                },
                mounted()
                {
                        this.$root.$on('close-dropdowns', () => {
                                this.show_font_dropdown = false
                                this.show_font_dropdown_weight = false
                        })
                        this.font_title = 'font_' + Date.now() * this.index + '_' + this.type
                        this.apikey = document.querySelector('meta[name=google-fonts-key]').content
                        if (!this.isEmpty(this.fontdata))
                        {
                                // this.font_file = this.fontdata.file
                                this.font_face_name = this.fontdata.font_face
                                this.font_face_weight = this.fontdata.weight
                                this.font_file_uploaded = this.fontdata.file
                                if (this.fontdata.file.indexOf('gstatic.com') > -1)
                                {
                                        axios.get('https://www.googleapis.com/webfonts/v1/webfonts?key=' + this.apikey).then(response => {
                                                this.google_fonts = response.data.items
                                                this.gfont = _.find(this.google_fonts, (o) => {
                                                        return o.family == this.fontdata.font_face
                                                })
                                                this.google_fonts.forEach(item => {
                                                        if (item.family == this.fontdata.font_face)
                                                        {
                                                                this.gfont = item
                                                                this.$root.$emit('gfont-fin-mounted', {
                                                                        gfont  : this.gfont,
                                                                        weight : this.fontdata.weight
                                                                })
                                                        }
                                                })
                                        })
                                }
                        }
                        else
                        {
                                this.load()
                        }
                        this.$root.$on('gfont-fin-mounted', data => {
                                this.gfont_fin = data.gfont
                                this.gfont = data.gfont
                                this.gfont_fin_selected = true
                                this.gfont_fin_w = data.weight
                                this.show_font_dropdown_weight = false
                                this.show_font_dropdown = false
                                this.gfont_selected = true
                        })
                        this.$root.$on('gfont-selected', (data) => {
                                this.upload_progress = 100
                                this.font_file_uploaded = ''
                                this.gfont = data.font
                                this.gfont_selected = true
                                this.show_font_dropdown = false
                                this.show_font_dropdown_weight = false

                                this.$root.$emit('gfont-font-selected', {
                                        index : this.index,
                                        type  : this.type
                                })
                        })
                        this.$root.$on('gfont-fin', (data) => {
                                this.gfont_fin = data.gfont
                                this.gfont_fin_selected = true
                                this.gfont_fin_w = data.weight
                                this.show_font_dropdown_weight = false
                                this.show_font_dropdown = false
                        })
                        this.$root.$on('font.clear', data => {
                                if (data.index == 1)
                                {
                                        this.clearFont(false)
                                        if (this.index > 1)
                                        {
                                                this.gfont = {}
                                                this.gfont_selected = false
                                                this.gfont_fin_selected = false
                                        }
                                }
                        })
                },
                computed   : {

                        background_color()
                        {
                                var rgb = this.hexToRgb(this.background)
                                var opac = 1 - this.index * .2
                                return 'rgba(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ',' + opac + ')'
                        },
                        upload_label()
                        {
                                if (this.font_file_uploaded == '')
                                {
                                        return this.translate('or browse to choose one')
                                }
                                else
                                {
                                        return ''
                                }
                        },
                        the_ref()
                        {
                                return 'upload_font_' + this.font_title
                        },
                        upload_font_endpoint()
                        {
                                return endpoints.ajax.post.upload_font + '?type=' + this.type + '&index=' + this.index
                        },
                        headers()
                        {
                                return {
                                        'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content
                                }
                        },
                        info()
                        {
                                return {
                                        type  : this.type,
                                        index : this.index
                                }
                        },

                },
                watch      : {
                        font_file_uploaded()
                        {
                                if (this.font_file_uploaded != '')
                                {
                                        this.font_file_uploaded = this.font_file_uploaded.replace('http://', 'https://')
                                        var new_font = new FontFace(this.font_title, 'url(' + this.font_file_uploaded + ')')
                                        new_font.load().then((face) => {
                                                document.fonts.add(face)
                                        })
                                        opentype.load(this.font_file_uploaded, (e, f) => {
                                                if (e)
                                                {
                                                        console.error(e)
                                                }
                                                else
                                                {
                                                        if (f.names.preferredFamily != undefined)
                                                        {
                                                                this.font_face_name = f.names.preferredFamily.en
                                                        }
                                                        else
                                                        {
                                                                this.font_face_name = f.names.fontFamily.en
                                                        }
                                                        if (f.names.preferredSubfamily != undefined)
                                                        {
                                                                this.font_face_weight = f.names.preferredSubfamily.en
                                                        }
                                                        else
                                                        {
                                                                this.font_face_weight = f.names.fontSubfamily.en
                                                        }
                                                        this.$root.$emit('font.load', {
                                                                type      : this.type,
                                                                index     : this.index,
                                                                file      : this.font_file_uploaded,
                                                                font_face : this.font_face_name,
                                                                weight    : this.font_face_weight
                                                        })
                                                }
                                        })
                                }
                        }
                },
                methods    : {
                        translate,
                        chooseFiles() {
                                $("input[type=file]").eq(0).click()
                        },
                        clearFont(emit)
                        {
                                this.font_file_uploaded = ''
                                if (this.index == 1)
                                {
                                        this.gfont = {}
                                        this.gfont_fin_selected = false
                                        this.gfont_selected = false
                                }
                                if (emit !== false)
                                {
                                        this.$root.$emit('font.clear', {
                                                index : this.index,
                                                type  : this.type
                                        })
                                }
                        },
                        selectGfontWeight(w)
                        {
                                this.font_file_uploaded = this.gfont.files[w]
                                this.$root.$emit('gfont-fin', {
                                        gfont  : this.gfont,
                                        weight : w
                                })
                                // console.log(w)
                        },
                        toggleFontDropDownWeight()
                        {
                                this.show_font_dropdown_weight = !this.show_font_dropdown_weight
                        },
                        toggleFontDropDown()
                        {
                                this.show_font_dropdown = !this.show_font_dropdown
                        },
                        load()
                        {
                                axios.get('https://www.googleapis.com/webfonts/v1/webfonts?key=' + this.apikey).then(response => {
                                        this.google_fonts = response.data.items
                                        this.visibles = this.google_fonts.slice(0, 100)
                                })
                        },
                        searchFont()
                        {
                                var val = this.gfont_search.toLowerCase();
                                if (val == '')
                                {
                                        $('#secondary-font-dropdown div').show();
                                        return;
                                }
                                $('#secondary-font-dropdown div').each(function () {
                                        if ($(this).html().toLowerCase().includes(val))
                                        {
                                                $(this).show();
                                        }
                                        else
                                        {
                                                $(this).hide();
                                        }
                                });
                        },
                        isEmpty(obj)
                        {
                                for (var key in obj)
                                {
                                        if (obj.hasOwnProperty(key))
                                        {
                                                return false;
                                        }
                                }
                                return true;
                        },
                        hexToRgb(hex)
                        {
                                var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
                                return result
                                       ? {
                                                r : parseInt(result[1], 16),
                                                g : parseInt(result[2], 16),
                                                b : parseInt(result[3], 16)
                                        }
                                       : null;
                        },
                        input_file(newFile, oldFile)
                        {

                                if (newFile && !oldFile)
                                {
                                        // Add file
                                        this.$refs[this.the_ref].active = true
                                        this.upload_progress = 1
                                        if (newFile.size > 3000000 && newFile != oldFile)
                                        {
                                                this.upload_progress = 0
                                                new Noty({
                                                        type    : 'error',
                                                        text    : this.translate('Your file is more then 3Mb size. Please try another file.'),
                                                        timeout : 5000,
                                                }).show();
                                                this.$refs[this.the_ref].active = false
                                                return;
                                        }
                                }

                                if (newFile && oldFile)
                                {
                                        // Update file

                                        // Start upload
                                        if (newFile.size > 3000000 && newFile != oldFile)
                                        {
                                                this.upload_progress = 0
                                                new Noty({
                                                        type    : 'error',
                                                        text    : this.translate('Your file is more then 3Mb size. Please try another file.'),
                                                        timeout : 5000,
                                                }).show();
                                                this.$refs[this.the_ref].active = false
                                                return;
                                        }
                                        // Upload progress
                                        if (newFile.progress !== oldFile.progress)
                                        {
                                                this.upload_progress = newFile.progress - 30
                                        }

                                        // Upload error
                                        if (newFile.error !== oldFile.error)
                                        {
                                                var message = ''
                                                switch (newFile.error)
                                                {
                                                        case 'extension':
                                                                message = this.translate('We support only TTF and OTF files. Please select font file and try again.')
                                                                break;

                                                        default:
                                                                message = newFile.error;
                                                                break;
                                                }
                                                new Noty({
                                                        type    : 'error',
                                                        text    : message,
                                                        timeout : 5000,
                                                }).show();
                                                this.upload_progress = 0
                                        }

                                        // Uploaded successfully
                                        if (newFile.success !== oldFile.success)
                                        {
                                                this.upload_progress = 100
                                                this.font_file_uploaded = newFile.response.font
                                        }
                                }

                                // Automatic upload
                                if (Boolean(newFile) !== Boolean(oldFile) || oldFile.error !== newFile.error)
                                {
                                        if (!this.$refs[this.the_ref].active)
                                        {
                                                this.upload_progress = 1
                                                this.$refs[this.the_ref].active = true
                                        }
                                }
                        },
                }
        }
</script>
<style lang="scss">

    .font-upload {
        width: 30%;

        .font {
            width: 100%;
            height: 309px;
            border: 1px dashed #999999;
            position: relative;

            .remover {
                width: 20px;
                position: absolute;
                left: 10px;
                top: 10px;
                cursor: pointer;
                z-index: 123123;
            }

            &.uploaded {
                background: var(--color);
                border-color: transparent;
            }

            .informer {
                position: absolute;
                left: 22px;
                top: 22px;
            }

            .text {
                font-style: normal;
                font-weight: bold;
                font-size: 22px;
                width: 100%;
                line-height: 135%;
                /* or 30px */
                position: absolute;
                top: 112px;
                text-align: center;
                // padding: 0 22px;
                padding: 0;
                color: #000000;
                padding: 0 20px !important;
            }

            .optional {
                position: absolute;
                font-style: normal;
                font-weight: normal;
                font-size: 16px;
                line-height: 135%;
                /* or 22px */

                text-align: center;

                color: #797979;
                bottom: 6px;
                left: 0;
                right: 0;
            }

            .file-uploads-drop {
                display: block;
                width: 100%;
                height: 100%;
                position: absolute;
                padding: 170px 60px 0 60px;
                color: #797979;

                u {
                    color: #000;
                    text-decoration: none;
                }

                &:hover {
                    background: rgba(0, 0, 0, 0.05);
                    border-color: #777;
                }
            }

            .preview-text {
                font-family: var(--font-name);
                font-weight: 400;

                position: absolute;
                left: 34px;
                right: 34px;
                top: 93px;
                text-align: center;
                color: #fff;
                font-size: 70px;
                text-align: center;

                small {
                    display: block;
                    font-size: 14px;

                }

            }

            .loaded_font_title {
                color: #fff;
                font-style: normal;
                font-weight: normal;
                font-size: 22px;
                line-height: 135%;
                top: 14px;
                position: absolute;
                left: 0;
                right: 0;
                /* or 30px */

                padding: 0 30px;

                text-align: center;
            }
        }

        .font-block-title {
            text-align: center;
            font-style: normal;
            font-weight: 500;
            font-size: 16px;
            line-height: 150%;
            margin-top: 5px;
            /* or 24px */

            text-align: center;

            color: #000000;
        }
    }

    .g-font-block {
        position: absolute;
        z-index: 123123;
        top: 215px;
        width: 100%;
        text-align: center;
        z-index: 123;

        &.first-font {
            z-index: 123123;
        }

        &.second {
            top: 265px;
        }

        &.fin {
            top: 175px;

            &.dis {
                top: 145px;

                button.disabled {
                    color: white;

                    &:after {
                        display: none !important;
                    }
                }
            }

            .font-selector {
                &:after {
                    content: "";
                    display: inline-block;
                    width: 12px;
                    height: 8px;
                    /*background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA0AAAAHCAYAAADTcMcaAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAABoSURBVHgBlY5RDYAwEEMbFJyESUACEpCAA3AADsDJJCCBoAAJIIGOlISf5dhL3rJk1+4AoKYjfAKN1CoeF23p7ARWumv+wdQSdf+SNjnokGtc6KbmRKNAB4dJgz099dMv3mBAIZZ7uAH1oBB3TTzyeQAAAABJRU5ErkJggg==) no-repeat center center;*/
                    background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA0AAAAHCAYAAADTcMcaAAAAj0lEQVQoU32PUQ3CUAxFz3GABCTgAFBAUEAmAQebAkABoAAJIAEJk4CDkpK35DEW+tU299z2GhELYKN2/KmImAMHoLEMN+Ch7qe4orkDV7U1RRExA84FaNTXAJdP0vSkHnP/gSpBLpfAVu0jYlXMOvUy6L6gcrUFdkAaZL9Wn7X5DzQCE+jHOSehIWedrQbfQEg1Fd27q6cAAAAASUVORK5CYII=) no-repeat center center;
                    margin-left: 10px;
                    position: absolute;
                    right: 6px;
                    top: 7px;
                }
            }
        }

        .font-selector {
            font-family: Montserrat;
            font-style: normal;
            font-weight: 500;
            font-size: 14px;
            height: 25px;
            line-height: 135%;
            /* or 19px */
            display: inline;
            padding: 2px 20px;
            background: #EE6636;
            border: 1.5px solid #EE6636;
            color: #FFFFFF;

            cursor: pointer;
            width: 155px;
            position: relative;

            box-sizing: border-box;
            border-radius: 12px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;

            &:hover, &.font-selector-weight {
                background: var(--color);
                border: 1.5px solid var(--color);
                color: #FFFFFF;
            }

            &:focus {
                outline: none;
            }
        }
    }

    .font-dropdown-wrapper {
        position: absolute;
        border: none;
        background: #fff;
        width: 155px;
        left: 50%;
        margin-left: -77px;
        height: 0px;
        max-height: 100%;
        border-radius: 12px;
        visibility: hidden;
        opacity: 0;
        overflow: hidden;
        transition: height 0.8s ease, opacity 0.8s ease-out 0.5s;
        width: 100%;
        margin: 0;
        left: 0;
        bottom: 0;
        z-index: 300000;

        .search {
            height: 56px;
            line-height: 56px;
            text-align: center;
            border-bottom: 2px solid #999999;

            input[type=text] {
                display: inline-block;
                vertical-align: middle;
                padding: 0 10px;
                border-radius: 13px;
                margin: 0 10px 0 0;
                text-align: left;
                width: 160px;
                height: 26px;
                border: 1px solid #000000;

                &:focus {
                    outline: none;
                }
            }

            .search-btn {
                display: inline-block;
                vertical-align: middle;
                cursor: pointer;
            }

            .close-btn {
                display: inline-block;
                vertical-align: middle;
                cursor: pointer;
            }
        }

        &.opened {
            visibility: visible;
            opacity: 1;
            height: 100%;
        }
    }

    .font-dropdown {

        width: 100%;
        height: 250px;
        margin-top: 2px;
        overflow-y: auto;

        /* padding: 10px; */
        /* box-sizing: border-box; */
        overflow-x: hidden;

        &::-webkit-scrollbar {
            width: 10px;
            background: transparent;
            border-radius: 15px;
            /* or add it to the track */
        }

        /* Add a thumb */
        &::-webkit-scrollbar-thumb {
            width: 10px;
            background: var(--color);
            // margin-right: 5px;
            border: 2px solid transparent;
            box-sizing: border-box;
            border-radius: 15px;
        }

        div {
            // background: #fff;
            text-align: left;
            padding-left: 10px;
            cursor: pointer;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            border-bottom: 1px solid #999999;
            font-size: 18px;

            &:hover {
                background: rgba(0, 0, 0, 0.2);
            }

            &:last-child {
                border: none;
            }
        }
    }

    .font-weight-wrapper {
        .font-dropdown {
            div {
                font-size: 14px;
                border: none;
            }
        }
    }
</style>

<template>
    <div class="custom-edit-block">

        <form enctype="multipart/form-data" id="customize-book-form" @submit.prevent="submit" autocomplete="off">
            <input type="hidden" name="id" :value="_id">
            <div class="row justify-content-between no-gutters">
                <div class="button-on-mobile-block mt-3">
                    <a class="btn btn-sm preview-buttons customize-remove-watermark" data-toggle="modal"
                       data-target="#modal-confirm-download" v-if="!_public && can_remove_wm">
                        {{ translate( 'Remove Watermark' ) }}
                    </a>
                    <a v-else-if="!_public" @click="packages_modal" class="btn btn-sm preview-buttons customize-remove-watermark">{{
                            translate( 'Remove Watermark' )
                        }}</a>
                    <a target="_blank" class="btn btn-sm preview-buttons download-button"
                       :href="logo">
                        {{ translate( 'Download' ) }}
                    </a>
                    <a class="btn btn-sm preview-buttons customize-share-button" @click="share">
                        {{ translate( 'Share' ) }}
                    </a>

                </div>
                <div class="expiry-field">
                    <span class="expiry-text">
                    {{ translate( 'Expiration date:' ) }} </span><span class="expiry-date"> {{
                        expires_at
                    }} </span>
                </div>
            </div>
            <div class="customize-book" v-if="is_editable && can_edit">
                <div class="row no-gutters"><span class="title">
                    {{ translate( 'Customize Brand book' ) }}
                </span></div>
                <div class="row no-gutters">
                    <div class="col-xl-4 no-gutters line-right">
                        <div class="row no-gutters" style="margin-bottom: 10px">
                            <div class="col-xl-7 no-gutters">
                                <router-link
                                    :to="{name: 'Wizard', params: {'id': $route.params.id, 'page': 25, 'pdf_links': pdf_links}}">
                                    <svg style="fill:none" width="16" height="13" viewBox="0 0 16 13" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.75" y="0.75" width="14.5" height="11.5" stroke="white"
                                              stroke-width="1.5"></rect>
                                        <line x1="1" y1="4.25" x2="15" y2="4.25" stroke="white"
                                              stroke-width="1.5"></line>
                                        <line x1="6.75" y1="1" x2="6.75" y2="4" stroke="white"
                                              stroke-width="1.5"></line>
                                        <line x1="10.75" y1="4" x2="10.75" y2="13" stroke="white"
                                              stroke-width="1.5"></line>
                                    </svg>
                                    {{ translate( 'Change template' ) }}
                                </router-link>
                            </div>
                            <div class="col-xl-5 no-gutters" v-if="can_edit">
                                <a :href="edit_url">
                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16.531 4.71567L15.0004 6.24634C14.8443 6.40239 14.592 6.40239 14.4359 6.24634L10.7504 2.56079C10.5943 2.40474 10.5943 2.15239 10.7504 1.99634L12.281 0.465674C12.9019 -0.155225 13.9113 -0.155225 14.5355 0.465674L16.531 2.46118C17.1553 3.08208 17.1553 4.09145 16.531 4.71567ZM9.43554 3.31118L0.716401 12.0303L0.0124945 16.0645C-0.0837946 16.609 0.39101 17.0805 0.935541 16.9875L4.96972 16.2803L13.6889 7.56118C13.8449 7.40513 13.8449 7.15278 13.6889 6.99673L10.0033 3.31118C9.84394 3.15513 9.5916 3.15513 9.43554 3.31118ZM4.11972 11.2832C3.9371 11.1006 3.9371 10.8084 4.11972 10.6258L9.233 5.51255C9.41562 5.32993 9.70781 5.32993 9.89042 5.51255C10.073 5.69517 10.073 5.98735 9.89042 6.16997L4.77714 11.2832C4.59453 11.4659 4.30234 11.4659 4.11972 11.2832ZM2.92109 14.0756H4.51484V15.2809L2.37324 15.6561L1.34062 14.6235L1.71581 12.4819H2.92109V14.0756Z"
                                        />
                                    </svg>
                                    {{ translate( 'Edit texts' ) }}
                                </a>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-xl-7 no-gutters">
                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.625 4.6875H0.375C0.16875 4.6875 0 4.5293 0 4.33594V3.28125C0 2.50488 0.671875 1.875 1.5 1.875H3V0.351562C3 0.158203 3.16875 0 3.375 0H4.625C4.83125 0 5 0.158203 5 0.351562V1.875H9V0.351562C9 0.158203 9.16875 0 9.375 0H10.625C10.8313 0 11 0.158203 11 0.351562V1.875H12.5C13.3281 1.875 14 2.50488 14 3.28125V4.33594C14 4.5293 13.8313 4.6875 13.625 4.6875ZM0.375 5.625H13.625C13.8313 5.625 14 5.7832 14 5.97656V13.5938C14 14.3701 13.3281 15 12.5 15H1.5C0.671875 15 0 14.3701 0 13.5938V5.97656C0 5.7832 0.16875 5.625 0.375 5.625ZM10.25 9.72656C10.25 9.5332 10.0813 9.375 9.875 9.375H8V7.61719C8 7.42383 7.83125 7.26562 7.625 7.26562H6.375C6.16875 7.26562 6 7.42383 6 7.61719V9.375H4.125C3.91875 9.375 3.75 9.5332 3.75 9.72656V10.8984C3.75 11.0918 3.91875 11.25 4.125 11.25H6V13.0078C6 13.2012 6.16875 13.3594 6.375 13.3594H7.625C7.83125 13.3594 8 13.2012 8 13.0078V11.25H9.875C10.0813 11.25 10.25 11.0918 10.25 10.8984V9.72656Z"
                                    />
                                </svg>
                                {{ translate( 'Extend date' ) }}
                            </div>
                            <div class="col-xl-5 no-gutters" v-if="can_edit">
                                <a :href="wizard_url">
                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.4375 3.18756L7.96875 2.12504L9.03125 1.59378L7.96875 1.06252L7.4375 0L6.90625 1.06252L5.84375 1.59378L6.90625 2.12504L7.4375 3.18756ZM2.65625 5.3126L3.54145 3.54185L5.3125 2.6563L3.54145 1.77076L2.65625 0L1.77105 1.77076L0 2.6563L1.77105 3.54185L2.65625 5.3126ZM14.3438 9.56269L13.4586 11.3334L11.6875 12.219L13.4586 13.1045L14.3438 14.8753L15.2289 13.1045L17 12.219L15.2289 11.3334L14.3438 9.56269ZM16.6886 3.12879L13.8713 0.311451C13.6641 0.103596 13.3921 0 13.1202 0C12.8483 0 12.5763 0.103596 12.3688 0.311451L0.311445 12.3691C-0.103594 12.7841 -0.103594 13.4568 0.311445 13.8715L3.12873 16.6889C3.33625 16.8964 3.60818 17 3.87979 17C4.15172 17 4.42365 16.8964 4.63117 16.6889L16.6886 4.63093C17.1036 4.21655 17.1036 3.54351 16.6886 3.12879ZM11.9349 6.75564L10.2445 5.06524L13.1199 2.18979L14.8103 3.88019L11.9349 6.75564Z"
                                        />
                                    </svg>
                                    {{ translate( 'Edit Wizard' ) }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 no-gutters">
                        <div class="row no-gutters" style="height: 100%">
                            <div class="col-xl-8 no-gutters">
                                <svg width="17" height="19" viewBox="0 0 17 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17 13.3594V0.890625C17 0.39707 16.594 0 16.0893 0H3.64286C1.6317 0 0 1.5957 0 3.5625V15.4375C0 17.4043 1.6317 19 3.64286 19H16.0893C16.594 19 17 18.6029 17 18.1094V17.5156C17 17.2373 16.8672 16.985 16.6623 16.8217C16.5029 16.2502 16.5029 14.6211 16.6623 14.0496C16.8672 13.89 17 13.6377 17 13.3594ZM4.85714 4.97266C4.85714 4.8502 4.9596 4.75 5.08482 4.75H13.1295C13.2547 4.75 13.3571 4.8502 13.3571 4.97266V5.71484C13.3571 5.8373 13.2547 5.9375 13.1295 5.9375H5.08482C4.9596 5.9375 4.85714 5.8373 4.85714 5.71484V4.97266ZM4.85714 7.34766C4.85714 7.2252 4.9596 7.125 5.08482 7.125H13.1295C13.2547 7.125 13.3571 7.2252 13.3571 7.34766V8.08984C13.3571 8.21231 13.2547 8.3125 13.1295 8.3125H5.08482C4.9596 8.3125 4.85714 8.21231 4.85714 8.08984V7.34766ZM14.4728 16.625H3.64286C2.97121 16.625 2.42857 16.0943 2.42857 15.4375C2.42857 14.7844 2.975 14.25 3.64286 14.25H14.4728C14.4007 14.8846 14.4007 15.9904 14.4728 16.625Z"
                                    />
                                </svg>
                                {{ translate( 'Custom cover:' ) }}
                            </div>
                            <div class="col-xl-4 no-gutters">
                                <label for="file-upload" class="upload-block"
                                       :style="{'background-image': 'url(' + img_src + ')' }"><span v-if="img_src==''">
                                       {{ translate( 'Upload' ) }}
                                       </span></label>
                                <input id="file-upload" type="file" name="custom-cover-image" @change="showImg($event)"
                                       accept="image/png, image/jpeg"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 no-gutters">
                        <div class="row no-gutters">
                            <div class="col-xl-9 no-gutters">
                                <font-select
                                    :title="translate('change title font')"
                                    :type="'title'"
                                    :font="custom_font_title"
                                ></font-select>
                                <font-select
                                    :title="translate('change body font')"
                                    :type="'body'"
                                    :font="custom_font_body"
                                ></font-select>
                            </div>
                            <div class="col-xl-3 no-gutters" style="padding-left: 5px">
                                <button class="submit-custom" type="submit">
                                    {{ translate( 'Approve' ) }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</template>

<script>
import translate from '../utils/translate';

export default {
    name : 'customize-book',
    props: {
        can_export   : Boolean,
        pdf_url      : String,
        logo         : String,
        expires_at   : String,
        pdf_links    : {},
        edit_url     : String,
        can_edit     : Boolean,
        can_download : Boolean,
        status       : String,
        wizard_url   : String,
        embed        : String,
        is_editable  : Boolean,
        custom       : {},
        is_public    : Boolean,
        main_color   : String,
        can_remove_wm: Boolean,
    },
    data() {
        return {
            img_src          : '',
            custom_font_title: {},
            custom_font_body : {},
            public           : Boolean,
            loading          : false,
            endpoints        : endpoints,
        };
    },
    mounted() {
        var self = this;
        if ( this.custom.title_family ) {
            this.custom_font_title.family = this.custom.title_family;
            this.custom_font_title.weight = this.translate( this.custom.title_weight );
            this.custom_font_title.category = this.custom.title_category;
        }
        if ( this.custom.body_family ) {
            this.custom_font_body.family = this.custom.body_family;
            this.custom_font_body.weight = this.translate( this.custom.body_weight );
            this.custom_font_body.category = this.custom.body_category;
        }

        this.public = this.is_public;

        $( '.feedback-modal' ).on( 'click', function() {
            $( this ).closest( '.modal' ).modal( 'hide' );
            $( '#modal-feedback' ).modal( 'show' );
        } );

        $( '#close-packages-modal' ).on( 'click', function() {
            $( this ).closest( '.modal' ).modal( 'hide' );
            $( '#modal-feedback' ).modal( 'show' );
        } );

        $( '#confirm-share' ).on( 'click', function( e ) {
            e.preventDefault();
            $( '#modal-confirm-share' ).modal( 'hide' );
            self.share();
        } );

        $( '#confirm-download' ).off( 'click' ).on( 'click', function( e ) {
            e.preventDefault();
            $( '#modal-confirm-download' ).modal( 'hide' );
            self.$emit('loading');
            self.removeWatermark();
        } );
    },
    methods : {
        translate,
        showImg( event ) {
            if ( event.target.files && event.target.files[ 0 ] ) {
                var reader = new FileReader();

                reader.onload = ( e ) => {
                    this.img_src = e.target.result;
                };

                reader.readAsDataURL( event.target.files[ 0 ] ); // convert to base64 string
            }
        },
        removeWatermark() {
            axios.post( this.endpoints.ajax.post.remove_watermark, { id: this._id } ).then( response => {
                location.reload();
            } ).catch( error => {
                this.$emit('loading');
                if ( error.response.status === 402 ) {
                    this.packages_modal();
                } else {
                    new Noty( {
                                  type   : 'error',
                                  text   : this.translate( error.response.data.message ),
                                  timeout: 5000,
                              } ).show();
                }
            } );
        },
        setPublic() {
            this.public = true;
        },
        share() {
            $( '#modal-share' ).modal( 'show' );
            this.$root.$emit( 'share', { id: this._id, data: { id: this._id } } );
        },
        submit( event ) {

            this.$root.$emit( 'loading' );
            axios.post( this.endpoints.ajax.post.brandbook.save_custom, new FormData( event.target ) ).
                then( ( response ) => {
                    location.reload();
                } ).
                catch( error => {
                    console.log( error );
                } );
        },
        packages_modal() {
            this.$root.$emit('fill-value', this._id);
            $( '#modal-choose-plan' ).modal( { backdrop: 'static', keyboard: false }, 'show' );
        },
    },
    computed: {
        _id() {
            if ( this.is_embed )
                return this.embed;
            else
                return this.$route.params[ 'id' ];
        },
        _public: {
            cache: false,
            get() {
                return this.public;
            },
        },

    },
};
</script>

<style lang="scss">

@import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');


.custom-edit-block {
    font-family: Montserrat;
    font-style: normal;
    font-weight: normal;
    font-size: 14px;
    line-height: 28px;


}

.expiry-field {
    padding-top: 14px;
}


.dark {
    .customize-book {
        border-color: white;
    }

    .line-right:after {
        background: white;
    }

    svg {
        fill: white;
    }

    .dropdown-input, .dropdown-selected {
        color: white;
    }

    .pdf-progress .pdf-progress-bar {
        background: white;
    }

    .next svg {
        fill: none;
    }

    .next svg path {
        stroke: white;
    }

    .prev svg {
        fill: none;
    }

    .prev svg path {
        stroke: white;
    }

    .upload-block {
        border-color: white;
    }

    .close-book:before, .close-book:after {
        background: white;
    }

    .logo {
        svg path {
            fill: white;
        }

    }


}


.light {

    .logo {
        svg path {
            fill: black;
        }

    }

    .close-book:before, .close-book:after {
        background: black;
    }

    .upload-block {
        border-color: black;
    }

    .next svg {
        fill: none;
    }

    .next svg path {
        stroke: black;
    }

    .prev svg {
        fill: none;
    }

    .prev svg path {
        stroke: black;
    }

    .pdf-progress .pdf-progress-bar {
        background: black;
    }

    .customize-book {
        border-color: black;
    }

    .preview-buttons {
        border-color: black;
    }

    .line-right:after {
        background: black;
    }

    svg {
        fill: black;
    }

    .dropdown-input, .dropdown-selected {
        color: black;
    }

    svg line {
        stroke: black;
    }

    svg rect {
        stroke: black;
    }
}


.customize-book {
    border-bottom: 2px solid;
    border-top: 2px solid;
    padding: 5px 5px 10px 5px;

    input[type="file"] {
        display: none;
    }

    .preview-buttons {
        padding-left: 20px;
        padding-right: 20px;
    }


    a {
        color: white;
        cursor: pointer;
    }

    .line-right:after {
        display: block;
        width: 2px;
        height: 100%;
        content: "";
        position: absolute;
        left: 95%;
        top: 0;
    }


    button.submit-custom {
        font-size: 18px;
        line-height: 150%;
        align-items: center;
        text-align: center;
        display: block;
        width: 100%;
        height: 91%;
        border-radius: 8px;
        border: none;
        /* padding-left: 31px; */
    }

    svg {
        margin-right: 2px;
    }

    .custom-edit-block .row {
        margin: 0;
    }


    .expiry-field {
        padding-top: 14px;
    }


    span.title {
        font-style: normal;
        font-weight: 500;
        font-size: 20px;
        line-height: 24px;
        letter-spacing: 0.1em;
        padding: 10px 0;
    }

    .upload-block {
        width: 100%;
        height: 90%;
        border: 1px solid;
        font-weight: 600;
        font-size: 12px;
        line-height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }


}

/* Expiration date: 29.10.2020 */
.expiry-text, .expiry-date {
    font-family: Montserrat;
    font-style: normal;
    font-weight: bold;
    font-size: 13px;
    line-height: 150%;
}

.expiry-date {
    font-size: 19px;
}


.button-on-mobile-block {
    padding: 5px 10px;
    border-radius: 5px;
    margin-bottom: 10px;
    margin-top: 10px;

    .preview-buttons.download-button {
        color: white;
        background: var(--main_color);
        margin-right: 10px;
        border: 1px solid white;
    }

    .customize-remove-watermark {
        color: white;
        background: #29B473;
        margin-right: 10px;
        border: 1px solid white;
    }

    .preview-buttons.customize-share-button {
        color: white;
        background: var(--main_color);
        border: 1px solid white;
    }
}

.light {
    .preview-buttons.download-button, .customize-remove-watermark, .preview-buttons.customize-share-button {
        color: black;
        border-color: black;
    }
}

</style>

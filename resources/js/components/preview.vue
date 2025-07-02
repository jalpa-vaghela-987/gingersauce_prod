<template>
    <div id="brandbook-preview" @click="clickEvent" :class="color_class">
        <a href="/my" class="close-book"></a>
        <div class="logo" v-if=!is_embed>
            <svg width="31" height="57" viewBox="0 0 31 57" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.0219727 48.3018C8.67625 55.5646 19.7069 58.1697 30.0578 56.4067L30.0569 44.7635C22.3563 46.6897 13.8742 45.0587 7.34129 39.5762L0.0219727 48.3018ZM23.8134 11.4059C26.28 11.4059 28.4973 12.4613 30.0578 14.1373V1.03209C28.0906 0.380194 25.9955 0.0161133 23.8134 0.0161133C12.8238 0.0161133 3.88253 8.95657 3.88253 19.9454C3.88253 30.9367 12.8238 39.8771 23.8134 39.8771C25.9955 39.8771 28.0914 39.5131 30.0578 38.8612V25.7567C28.4965 27.4328 26.2792 28.489 23.8134 28.489C19.1026 28.489 15.2715 24.6563 15.2715 19.9462C15.2715 15.2378 19.1034 11.4059 23.8134 11.4059Z" fill=""/>
            </svg>
        </div>
        <div class="background" :style="{'--main_color': main_color}">
        </div>
        <div v-if="loading" :style="{'--main_color': main_color}" class="loading-main-background"><div class="loading-main"></div></div>
        <div :class="['form', is_embed?'embed':'']" v-show="!loading" @mousemove="progressTickM">
            <div class="logo-in-mobile-preview" style="margin-top: -5px;" v-if="is_mobile(false)">
                <svg width="51" height="51" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="51" height="51" :fill="main_color"/>
                    <rect x="4.5" y="3" width="43" height="44" fill="white"/>
                    <path
                        d="M0 0V51H51V0H0ZM29.3775 42.8706C22.9398 43.9671 16.0793 42.3468 10.6967 37.8298L15.249 32.4029C19.3122 35.8127 24.5876 36.8271 29.377 35.6291L29.3775 42.8706ZM29.3775 16.5811C28.407 15.5387 27.028 14.8823 25.4939 14.8823C22.5644 14.8823 20.1812 17.2655 20.1812 20.194C20.1812 23.1234 22.5639 25.5071 25.4939 25.5071C27.0274 25.5071 28.4065 24.8503 29.3775 23.8078V31.9581C28.1546 32.3636 26.851 32.59 25.4939 32.59C18.6589 32.59 13.0978 27.0295 13.0978 20.1935C13.0978 13.3589 18.6589 7.79841 25.4939 7.79841C26.851 7.79841 28.154 8.02485 29.3775 8.4303V16.5811Z"
                        :fill="main_color"/>
                </svg>
            </div>
            <div class="close-button-mobile" v-if="is_mobile(false)" @click="closeBook">
                <svg width="49" height="49" viewBox="0 0 49 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.1571 12.2673L36.9551 37.3178M36.2739 12.8933L13.1571 36.6917" stroke="white"
                          stroke-width="2"/>
                </svg>
            </div>
            <h1 class="text-center mb-5 mt-4" v-if=!is_embed>{{ title }}</h1>
            <div :class="['prev', show_spreads?'spreaded':'']" @click=prev>
                <svg width="24" height="46" viewBox="0 0 24 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 2L3 23L22 44" stroke-width="4"/>
                </svg>
            </div>
            <div :class="['next', show_spreads?'spreaded':'']" @click=next>
                <svg width="24" height="46" viewBox="0 0 24 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 44L21 23L2 2" stroke-width="4"/>
                </svg>
            </div>
            <div :class="['pages', 'data-page-'+page, (page==number_of_pages?'data-page-last':'')]" id="flipbook">
                <div v-for="p in range(1, number_of_pages)">
                    <canvas :id="'canvas_page'+p"></canvas>
                </div>

            </div>
            <div class="pdf-progress">
                <div class="pdf-progress-bar" @mouseup.stop='progressClick'>
                    <div class="pdf-progress-track"
                         :style="{'--left': is_drag?track_x+'px':left_track,'--main_color': main_color}"
                         @mousedown.stop.prevent="progressTickMD" @mouseup.stop.prevent="progressTickMU"></div>
                </div>
            </div>
            <customize v-if="!this.loading"
                       :can_export="can_export"
                       :pdf_url="pdf_url"
                       :logo="logo"
                       :expires_at="expires_at"
                       :pdf_links="pdf_links"
                       :edit_url="edit_url"
                       :can_edit="can_edit"
                       :is_editable="is_editable"
                       :can_download="can_download"
                       :wizard_url="wizard_url"
                       :embed="embed"
                       :custom="custom"
                       :status="status"
                       :is_public="is_public"
                       :main_color="main_color"
                       :can_remove_wm="can_remove_wm"
                       @loading="loading = !loading"
            ></customize>
        </div>
    </div>
</template>
<script>
// import $ from "jquery";
// import "turn.js";
import isMobile from 'ismobilejs';
import pdfjsLib from 'pdfjs-dist/build/pdf'
import Customize from './customize-book';
import translate from '../utils/translate';
export default {
    components: {
        Customize
    },
    props: {
        embed: String,
        is_embed: Boolean
    },
    data() {
        return {
            main_color: '1413EE6636',
            color_class: String,
            secondary_color: '#29B473',
            third_color: '#FFD459',
            title: '',
            can_export: false,
            can_download: false,
            can_duplicate: false,
            is_editable: false,
            is_public : false,
            status : 'draft',
            can_edit: false,
            custom: {},
            expires_at : '',
            pdf: '',
            pdf_links: [],
            token: '',
            logo: '',

            loading: false,

            page: 1,

            is_drag: false,
            track_x: 0,
            drag_to: null,

            number_of_pages: 1,

            show_spreads: false,
            is_landscape: false,
            can_remove_wm : null
        }
    },
    computed: {
        _id() {
            if (this.is_embed)
                return this.embed
            else
                return this.$route.params['id']
        },
        duplicate_url() {
            return '/my/duplicate/' + this._id
        },
        edit_url() {
            return '/my/edit/' + this._id
        },
        wizard_url() {
            return '/my/wizard/' + this._id
        },
        pdf_url() {
            return '/my/pdf/' + this._id
        },
        left_track() {
            return ((this.page - 1) / this.number_of_pages * 100) + '%'
        }
    },
    methods: {
        translate,
        repositionArrows() {
            setTimeout(() => {
                let height = document.getElementById('flipbook').offsetHeight
                let top = document.getElementById('flipbook').offsetTop
                let theight = document.querySelector('.prev').offsetHeight
                console.log(height, top, theight, top + (height + theight) / 2 - theight)
                document.querySelectorAll('.prev,.next').forEach(e => {
                    e.style.top = (top + (height - theight) / 2) + 'px'
                })
            }, 200)
        },
        changeSpreads() {
            this.show_spreads = !this.show_spreads
            var flipbookEL = document.getElementById('flipbook');
            if (this.is_mobile()) {
                if (this.is_landscape) {
                    $(flipbookEL).turn('size', (window.outerHeight - 181) * 2, (window.outerHeight - 181)).turn('display', 'double');
                } else if (this.show_spreads) {
                    $(flipbookEL).turn('size', (window.outerWidth / 2 - 29) * 2, (window.outerWidth / 2 - 29)).turn('display', 'double');
                } else {
                    $(flipbookEL).turn('size', (window.outerWidth - 58), (window.outerWidth - 58)).turn('display', 'single');
                }
            } else {
                $(flipbookEL).turn('size', window.outerWidth * .31 * 2, window.outerWidth * .31 * 2).turn('display', 'double');
            }
            this.repositionArrows()
        },
        closeBook() {
            window.location = '/my/'
        },
        range(i, y) {
            var t = []
            for (var k = i; k <= y; k++)
                t.push(k)
            return t
        },
        progressClick(e) {
            var tx = (e.clientX - $('.pdf-progress-bar').offset().left) - 10;
            if (tx >= 0 && tx <= ($('.pdf-progress-bar').width() - 14)) {
                this.track_x = tx;
            }
            this.page = Math.ceil(this.track_x / $('.pdf-progress-bar').width() * this.number_of_pages)
            $("#flipbook").turn('page', this.page)
        },
        progressTickMU(e) {
            this.is_drag = false
            this.page = Math.ceil(this.track_x / $('.pdf-progress-bar').width() * this.number_of_pages)
            $("#flipbook").turn('page', this.page)
        },
        progressTickMD(e) {
            this.is_drag = true
            var tx = (e.clientX - $('.pdf-progress-bar').offset().left) - 10;
            if (tx >= 0 && tx <= ($('.pdf-progress-bar').width() - 14)) {
                this.track_x = tx;
            }
        },
        progressTickM(e) {
            if (this.is_drag) {
                var tx = (e.clientX - $('.pdf-progress-bar').offset().left) - 10;
                if (tx >= 0 && tx <= ($('.pdf-progress-bar').width() - 14)) {
                    this.track_x = tx;
                }
                this.drag_to = setTimeout(() => {
                    clearTimeout(this.drag_to)
                    this.page = Math.ceil(this.track_x / $('.pdf-progress-bar').width() * this.number_of_pages)
                    $("#flipbook").turn('page', this.page)
                }, 500)
            }
        },
        clickEvent() {
            this.is_drag = false
        },
        lightOrDark(color) {
            // Check the format of the color, HEX or RGB?
            var r,g,b;
            if (color.match(/^rgb/)) {
                // If HEX --> store the red, green, blue values in separate variables
                color = color.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/);

                r = color[1];
                g = color[2];
                b = color[3];
            } else {
                // If RGB --> Convert it to HEX: http://gist.github.com/983661
                color = +("0x" + color.slice(1).replace(
                        color.length < 5 && /./g, '$&$&'
                    )
                );
                r = color >> 16;
                g = color >> 8 & 255;
                b = color & 255;
            }

            // HSP (Highly Sensitive Poo) equation from http://alienryderflex.com/hsp.html
            let hsp = Math.sqrt(
                0.299 * (r * r) +
                0.587 * (g * g) +
                0.114 * (b * b)
            );

            console.log(hsp);
            // Using the HSP value, determine whether the color is light or dark
            if (hsp > 170) {

                return 'light';
            } else {

                return 'dark';
            }
        },
        process_load(response) {
            this.main_color = response.data.colors[0].id
            if(this.main_color.indexOf('#') == -1){
                this.main_color = "#" + this.main_color;
            }
            this.color_class = this.lightOrDark(this.main_color);
            this.secondary_color = response.data.colors[1].id
            this.third_color = response.data.colors[2].id
            this.title = response.data.title
            this.pdf = response.data.pdf
            this.pdf_links = response.data.pdf_links
            this.logo = response.data.logo
            this.can_export = response.data.can_export
            this.can_edit = response.data.can_edit
            this.is_editable = response.data.is_editable
            this.can_download = response.data.can_download
            this.can_duplicate = response.data.can_duplicate
            this.expires_at = response.data.expires_at
            this.custom = response.data.custom
            this.status = response.data.status
            this.is_public = response.data.status == 'public';
            this.can_remove_wm = response.data.can_remove_wm;
            let pdf_promise = pdfjsLib.getDocument(response.data.pdf)
            pdf_promise.promise.then((pdf) => {

                this.number_of_pages = pdf.numPages

                setTimeout(() => {
                    try {
                        $("#flipbook").turn({
                            width: this.is_mobile() ? this.is_landscape ? (window.outerHeight - 181) * 2 : (window.outerWidth - 58) : window.outerWidth * .31 * 2,
                            height: this.is_mobile() ? this.is_landscape ? (window.outerHeight - 181) : (window.outerWidth - 58) : window.outerWidth * .31,
                            elevation: 50,
                            display: (this.is_mobile() && !this.is_landscape) ? 'single' : 'double',
                            // gradients: false,
                            autoCenter: true,
                            acceleration: true,
                        }).bind("turned", function (event, page, view) {
                            el.page = page
                        });
                        if (this.is_mobile()) {
                            this.repositionArrows()
                            this.changeSpreads()
                        }

                        $('.form-background, .form').css({
                            height: window.outerWidth * .31 + 240
                        })
                        this.loading = false
                    } catch (e) {
                        $("#flipbook").turn({
                            width: this.is_mobile() ? this.is_landscape ? (window.outerHeight - 181) * 2 : (window.outerWidth - 58) : window.outerWidth * .31 * 2,
                            height: this.is_mobile() ? this.is_landscape ? (window.outerHeight - 181) : (window.outerWidth - 58) : window.outerWidth * .31,
                            elevation: 50,
                            display: (this.is_mobile() && !this.is_landscape) ? 'single' : 'double',
                            // gradients: false,
                            autoCenter: true,
                            acceleration: true,
                        }).bind("turned", function (event, page, view) {
                            el.page = page
                        });
                        if (this.is_mobile()) {
                            this.repositionArrows()
                            this.changeSpreads()
                        }
                        $('.form-background, .form').css({
                            height: window.outerWidth * .31 + 240
                        })
                    }
                }, 1400)

                for (var page_index = 1; page_index <= this.number_of_pages; page_index++)
                    this.renderPage(pdf, page_index)
            })
            let el = this
            // console.log($().turn)


        },
        load() {
            this.loading = true
            this.token = document.querySelector('meta[name="csrf-token"]').content
            axios.post((this.is_embed ? endpoints.ajax.post.brandbook.load_embed : endpoints.ajax.post.brandbook.load), {id: this._id}).then(response => {
                if (response.data.pdf == null) {
                    axios.post(endpoints.ajax.post.brandbook.generate, {
                        id: this._id,
                        //theme: this.theme
                    }).then((resp) => {
                        // response.data.pdf = resp.data.url
                        axios.post((this.is_embed ? endpoints.ajax.post.brandbook.load_embed : endpoints.ajax.post.brandbook.load), {id: this._id}).then(response => {
                            this.process_load(response)
                        })
                    })
                } else {
                    this.process_load(response)
                }


            }).catch((e) => {
                console.error(e)
                new Noty({
                    type: 'error',
                    text: this.translate('Failed loading brandbook. Please ensure, that brandbook is completed and try again later.'),
                    timeout: 5000,
                }).show();
            })
            var flipbookEL = document.getElementById('flipbook');

            window.addEventListener('resize', (e) => {
                setTimeout(() => {
                    flipbookEL.style.width = '';
                    flipbookEL.style.height = '';
                    $(flipbookEL).turn('size', this.is_mobile()
                        ? this.is_landscape
                            ? (window.outerHeight - 181) * 2
                            : (window.outerWidth - 58)
                        : window.outerWidth * .31 * 2,
                        this.is_mobile()
                            ? this.is_landscape
                            ? (window.outerHeight - 181)
                            : (window.outerWidth - 58)
                            : window.outerWidth * .31).turn('display', this.is_mobile() && !this.is_landscape ? 'single' : 'double');
                    $('.form-background, .form').css({
                        height: window.outerWidth * .31 + 240
                    })
                    this.repositionArrows()
                }, 200)
            });
            this.is_landscape = window.matchMedia("(orientation: landscape)").matches
            window.addEventListener("orientationchange", () => {
                setTimeout(() => {
                    this.is_landscape = window.matchMedia("(orientation: landscape)").matches
                    this.repositionArrows()
                }, 100)
            });

            //window.onresize = ()=>{
            //this.loading = true
            //window.location.reload()
            //}
        },
        prev() {
            $("#flipbook").turn('previous')
        },
        next() {
            $("#flipbook").turn('next')
        },
        renderPage(pdf, page_index) {
            pdf.getPage(page_index).then((page) => {
                var scale = 2;
                var viewport = page.getViewport({scale: scale,});
                var canvas = document.getElementById('canvas_page' + page_index);
                var context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                var renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext);
            })
        },
        is_mobile() {
            return isMobile(window.navigator).any
        },
        // is_landscape(){
        // 	return window.matchMedia("(orientation: landscape)").matches
        // }
    },
    mounted() {
        this.load()
        setTimeout(() => {
            if (this.is_mobile()) {
                FB.CustomerChat.hide();
            }
        }, 500);

        this.$root.$on('loading', ()=>{
            this.loading = true;
        })
    }
}
</script>
<style lang="scss">
$main_color: #EE6636;
$secondary_color: #29B473;
$third_color: #FFD459;
$grey_color: #C7C7C7;
canvas {
    width: 31vw;
    height: 31vw;
}


// div[id^="page"]{
// 	transform: scale(.5);
// }
//
//

@keyframes loader-rotate {
    0% {
        transform: rotate(0);
    }
    100% {
        transform: rotate(360deg);
    }
}

// .loading {
//     width: 56px;
//     height: 56px;
//     border: 8px solid rgba(0, 82, 236, 0.25);
//     border-top-color: #0052ec;
//     border-radius: 50%;
//     position: absolute;
//     left: 50%;
//     top: 50%;
//     margin-left: -28px;
//     margin-top: -28px;
//     z-index: 100;
//     animation: loader-rotate 1s linear infinite;
//     top: 50%;
//     margin: -28px auto 0 auto;
//     text-shadow: 0 0 black;
// }
.custom-edit-block {
    width: 62vw;
    margin: auto;
}

.loading-main {
    width: 280px;
    height: 274px;
    // border: 8px solid rgba(0, 82, 236, 0.25);
    // border-top-color: #0052ec;
    // border-radius: 50%;

    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -140px;
    margin-top: -137px;
    z-index: 100;
    // animation: loader-rotate 1s linear infinite;
    top: 50%;
    // margin: -28px auto 0 auto;
    text-shadow: 0 0 black;
}

.close-book {
    position: absolute;
    right: 32px;
    top: 32px;
    width: 32px;
    height: 32px;
    opacity: 0.3;
    z-index: 3000;
}
.close-book:hover {
    opacity: 1;
}
.close-book:before, .close-book:after {
    position: absolute;
    left: 15px;
    content: ' ';
    height: 33px;
    width: 3px;
}
.close-book:before {
    transform: rotate(45deg);
}
.close-book:after {
    transform: rotate(-45deg);
}







.pdf-progress {

    margin: auto;
    margin-top: 20px;

    .pdf-progress-bar {
        position: relative;
        width: 62vw;
        height: 10px;
        border-radius: 15px;
        margin-left: auto;
        margin-right: auto;

        .pdf-progress-track {
            position: absolute;
            transition: left .5s;
            width: 1.667vw;
            height: 10px;
            left: var(--left);
            top: 0;

            border: 2px solid #C4C4C4;
            box-sizing: border-box;
            border-radius: 15px;
            background: var(--main_color);
        }
    }


}

div#flipbook.data-page-1 {
    margin-right: 34% !important;
}

.buttons {
    position: absolute;
    top: 109px;
    right: 0;
    z-index: 50;
    width: calc(17vw - 40px);
}

.buttons-bottom {
    position: absolute;
    right: 0;
    // top: calc(229px + 31vw);
    width: calc(17vw - 40px);
    z-index: 50;
    bottom: 30px !important;
    // bottom: 100px !important;
}

.form {
    position: relative;

    .prev, .next {
        position: absolute;
        top: 331px;
        z-index: 50;
        cursor: pointer;
    }

    .prev {
        left: 13vw;
    }

    .next {
        right: 13vw;
    }
}

#flipbook {
    position: relative;
    margin: auto !important;

    &:after {
        content: "";
        background: linear-gradient(90deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.3883928571428571) 49%, rgba(0, 0, 0, 0.500437675070028) 50%, rgba(0, 0, 0, 0.39) 51%, rgba(0, 0, 0, 0) 100%);

        height: 31vw;
        position: absolute;
        left: 29vw;
        width: 4vw;
        z-index: 50;
        top: 0;
        opacity: .3;
    }

    &:before {
        content: "";
        position: absolute;
        left: 31vw;
        width: 1px;
        height: 31vw;
        z-index: 50;
        opacity: .1;
        background: rgba(0, 0, 0, 0.9);
    }

    &.data-page-1, &.data-page-36, &.data-page-last {
        &:after, &:before {
            display: none;
        }
    }
}

#brandbook-preview.light {
    color: black;
    a {
        color: black;
    }
}

#brandbook-preview.dark {
    color: white;
    a {
        color: white;
    }
}

#brandbook-preview {
    position: fixed;
    z-index: 3;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    overflow: auto;


    .logo {
        position: absolute;
        left: 29px;
        top: 29px;
        z-index: 4;
    }

    .form-background {
        width: 65vw;
        height: 520px;
        background: #fff;
        position: absolute;
        z-index: 5;
        box-shadow: 0 0 10px rgba(0, 0, 0, .5);
        left: 50%;
        top: 50%;
        margin-left: -32.5vw;
        margin-top: -260px;
        z-index: 6;

        &.extra {
            width: 82vw;
            margin-left: -41vw;
            height: 625px;
            margin-top: -312px;
        }
    }

    .form {
        width: auto;
        height: 620px;
        left: 29px;
        right: 29px;
        position: absolute;
        z-index: 7;
        margin-left: 0;
        margin-top: 0;

        &.embed {
            top: 25px;
        }

        &.extra {
            width: 82vw;
            margin-left: -41vw;
            height: 625px;
            margin-top: -312px;
        }

        h1 {
            margin-bottom: 10px !important;
        }

        .form-progress {
            position: absolute;
            top: -5px;
            height: 5px;
            width: 65vw;

            .progress-bar {
                width: var(--width);
                background-color: $secondary_color; //var(--color);
                position: absolute;
                left: 0;
                top: 0;
                height: 5px;
            }
        }

        .form-group {
            padding: 80px 125px 80px 125px;
            display: flex;
            align-items: flex-end;

            label {
                font-family: Montserrat;
                font-style: normal;
                font-weight: normal;
                font-size: 14px;
                line-height: 150%;
                /* or 21px */


                color: #000000;
            }

            .form-control-underline, .autocomplete-input {
                border: 0px;
                border-radius: 0;
                border-bottom: 1px solid #797979;
                background: transparent;

                font-family: Montserrat;
                font-style: normal;
                font-weight: 500;
                font-size: 28px;
                line-height: 34px;

                color: #000000;

                outline: none !important;
                box-shadow: none !important;
            }

            p.form-control-underline {
                width: 100%;
                padding-bottom: 8px;
                padding-left: 35px;
                cursor: pointer;
            }

            .autocomplete-result-list {
                list-style: none;
                background: #fff;
                box-shadow: 0 0 5px rgba(0, 0, 0, .2);
                padding-left: 0;

                li {
                    font-size: 14px;
                    line-height: 45px;
                    padding-left: 33px;
                    border-left: 2px solid transparent;

                    &[aria-selected="true"], &:hover {
                        background: rgba(0, 0, 0, .02);
                        border-left: 2px solid #EE6636;
                    }

                    &:hover {
                        border-left: 2px solid #FFD459;
                    }
                }
            }

            &.serach-field {
                align-items: center;
                padding-top: 60px;
                padding-bottom: 0px;

                label {
                    margin-right: -23px;
                    margin-top: 10px;
                }

                input {
                    line-height: 44px;
                    padding-left: 35px;
                    width: 100%;
                }

                div {
                    width: 100%;
                }

                .autocomplete-loading {
                    width: 0;
                    position: relative;

                    svg {
                        position: absolute;
                        right: 0;
                    }
                }
            }
        }

        .related-results {
            padding: 0 125px;

            .related-results-title {
                font-style: normal;
                font-weight: bold;
                font-size: 14px;
                line-height: 150%;
                /* or 21px */
                color: #999999;
            }

            .results {
                ul {
                    list-style: none;
                    padding: 0;
                    margin: 0;

                    li {
                        font-style: normal;
                        font-weight: normal;
                        font-size: 16px;
                        line-height: 200%;
                        /* or 32px */
                        color: #000000;

                    }
                }
            }
        }

        .approve-block {
            display: flex;
            justify-content: space-between;
            padding: 14px 30px 26px;

            .main-block {
                height: 309px;
                width: 100%;
                border: 1px solid #DADADA;
                display: flex;
                justify-content: center;
                align-items: center;
                position: relative;

                .title-approval {
                    position: absolute;
                    bottom: 10px;
                    text-align: center;
                    z-index: 4;
                    font-size: 16px;

                    small {
                        display: block;
                        text-align: center;
                        color: #93989B;
                    }
                }

                img {
                    max-width: 50%;
                    max-height: 50%;
                }
            }

            .approve-block-title {
                font-style: normal;
                font-weight: 900;
                font-size: 28px;
                line-height: 150%;
                /* or 42px */
                text-align: center;
                text-transform: uppercase;

                color: #797979;
                border-bottom: 2px solid #C7C7C7;
            }

            .approved, .rejected {
                flex-basis: 192px;
                flex-grow: 0;
                flex-shrink: 0;
                margin: 0 30px;

                div {
                    padding: 5px;
                    text-align: center;

                    img {
                        max-height: 35px;
                    }
                }

                &.rejected {
                    margin-left: 0;
                }

                &.approved {
                    margin-right: 0;

                    .approve-block-title {
                        color: $secondary_color;
                    }
                }
            }

        }

        .upload {
            position: relative;
            margin: 10px 54px 26px 54px;
            border: 1px dashed #999999;
            height: 309px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            color: #999;
            transition: all .5s;

            &.uploaded {
                background: #FFFFFF;
                border: 1px solid #DADADA;
                box-sizing: border-box;

                .upload-section {
                    opacity: 0;
                }
            }

            // &:after{
            // 	transition: width .5s;
            // 	background: var(--color);
            // 	content: "";
            // 	position: absolute;
            // 	left: 0;
            // 	top: 0;
            // 	bottom: 0;
            // 	opacity: .3;
            // 	display: var(--display);
            // 	z-index: 12342134;
            // 	width: var(--percents);
            // }
            img {
                position: absolute;
                max-height: 60%;
                max-width: 50%;

                &.icon_uploaded {
                    max-height: 20%;
                    max-width: 20%
                }
            }

            .upload-loading {
                position: absolute;
                right: 20px;
                top: 0;
                z-index: 1230000;
            }

            &:hover {
                background: rgba(0, 0, 0, 0.05);
                border-color: #777;
            }

            &.uploaded {
                &:hover {
                    background: #fff;
                }
            }

            .file-uploads {
                display: inline;
                color: #000;
            }

            .upload-link {
                transition: color .5s;

                &:hover {
                    text-decoration: underline;
                    color: #999;
                }
            }

            label {
                margin-bottom: 0;
            }

            .drag-drop {
                flex-basis: 100%;
                color: #000;
            }

            .drag-drop {
                font-size: 22px;
                font-weight: bold;
            }

            .format {
                display: flex;
                position: absolute;
                left: 20px;
                top: 20px;

                .text {
                    font-style: normal;
                    font-size: 12px;
                    line-height: 133.5%;
                    margin-left: 11px;
                    /* or 16px */


                    color: #000000;
                }
            }
        }

        .upload-footer {
            display: flex;
            justify-content: center;
            align-items: center;

            .skip {
                margin-left: 10px;
                cursor: pointer;
            }

            .btn {
                font-style: normal;
                font-weight: normal;
                font-size: 28px;
                line-height: 28px;
                color: $secondary_color;
                border-color: $secondary_color;

                svg {
                    fill: $secondary_color;
                }

                &:hover {
                    color: #fff;
                    // border-color: #fff;

                    svg {
                        fill: #fff;
                    }
                }

                &[disabled] {
                    color: $grey_color;
                    border-color: $grey_color;

                    svg {
                        fill: $grey_color;
                    }
                }

                &.btn-outline-secondary {
                    margin-right: 10px;
                    color: #797979;
                    border-color: #797979;

                    svg {
                        fill: #797979;
                    }

                    &:hover {
                        color: #fff;

                        svg {
                            fill: #fff;
                        }
                    }
                }


            }
        }

        .proportions {
            display: flex;
            flex-grow: 0;
            flex-shrink: 0;
            height: 100%;
            background: #fff;

            .right-block {
                flex-basis: 68.22%;

                .view-block {
                    height: 339px
                }

                .step-title.less-top {
                    padding-top: 32px;
                    text-align: center;
                }

                .step-subtitle {
                    font-style: normal;
                    font-weight: normal;
                    font-size: 16px;
                    line-height: 25px;
                    padding-left: 24px;
                    padding-right: 24px;
                    /* or 156% */

                    text-align: center;
                    margin-top: 7px;
                    color: #797979;
                }
            }

            .left-block {
                flex-basis: 31.78%;
                height: 100%;
                border-right: 1px solid #999999;
                max-width: 31.78%;

                .menu-item {
                    border-bottom: 1px solid #999999;
                    height: 25%;
                    display: flex;
                    padding: 25px;
                    align-items: center;
                    overflow: hidden;
                    justify-content: space-between;

                    .title {
                        font-family: Montserrat;
                        font-style: normal;
                        font-weight: 500;
                        font-size: 18px;
                        line-height: 133%;
                        /* or 24px */

                        text-align: center;

                        color: #797979;
                    }

                    svg {
                        fill: var(--color);

                        .untifill {
                            fill: none;
                            stroke: var(--color);
                        }
                    }

                    &.active, &:hover {
                        background: $secondary_color;

                        .title {
                            color: #fff;
                        }

                        svg {
                            fill: #fff;

                            .untifill {
                                fill: none;
                                stroke: #fff;
                            }
                        }
                    }

                    &:last-of-type {
                        border-bottom: 0;
                    }
                }
            }
        }

        .form-title {
            position: absolute;
            font-family: Montserrat;
            font-style: normal;
            font-weight: 500;
            font-size: 38px;
            line-height: 46px;
            text-align: center;
            display: flex;
            justify-content: center;
            color: #000000;

            top: -79px;
            width: 65vw;

            .second-part {
                color: var(--color);
                font-size: 32px;
                font-style: italic;

                &:before {
                    content: "|";
                    margin-right: .2em;
                    margin-left: .2em;
                    font-size: 38px;
                    color: #000;
                    font-style: normal;
                }
            }
        }

        .sub-view-block {
            display: flex;
            justify-content: center;

            .menu-item {
                // border-bottom: 1px solid #999999;
                // height: 25%;
                display: block;
                flex-basis: 164px;
                padding: 15px;
                text-align: center;
                margin-bottom: 10px;
                margin-top: 10px;

                .icon {
                    height: 75px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    margin-bottom: 22px;
                }

                .title {
                    font-family: Montserrat;
                    font-style: normal;
                    font-weight: 500;
                    font-size: 18px;
                    margin-top: 50px;
                    line-height: 133%;
                    /* or 24px */

                    text-align: center;

                    color: #797979;
                }

                svg {
                    fill: var(--color);

                    .untifill {
                        fill: none;
                        stroke: var(--color);
                    }
                }

                &.active, &:hover {
                    background: transparent;
                    background: transparent;
                    position: relative;

                    &:after {
                        content: "";
                        display: block;
                        bottom: 45px;
                        height: 6px;
                        left: 15px;
                        right: 15px;
                        position: absolute;
                        background: $secondary_color;
                    }

                    .title {
                        color: #797979;
                    }

                    svg {
                        fill: var(--color);

                        .untifill {
                            fill: none;
                            stroke: var(--color);
                        }
                    }
                }

                &:last-of-type {
                    border-bottom: 0;
                }
            }
        }

        .step {
            height: 100%;

            .step-title {
                font-style: normal;
                font-weight: normal;
                font-size: 28px;
                line-height: 150%;
                /* or 42px */

                text-align: center;

                color: #000000;
                text-align: center;
                width: 100%;
                padding: 89px 0 0 0;

                small {
                    font-weight: 400;
                    font-size: 14px;
                    position: absolute;
                    padding-left: 10px;
                    padding-top: 17px;
                    line-height: 138%;
                    /* or 19px */

                    text-align: center;

                    color: #999999;
                }

                &.less-top {
                    padding-top: 62px;
                }
            }

            &.step4, &.step5 {
                .serach-field {
                    padding-right: 18vw;
                }
            }

            &.step-10 {
                .proportions {
                    .right-block {
                        .view-block {
                            height: 289px;
                        }
                    }
                }
            }

            &.step-11 {
                .proportions {
                    .right-block {
                        flex-basis: 100%;

                        .view-block {
                            height: 153px;
                        }
                    }
                }
            }

            &.step12 {
                .approve-block {
                    display: flex;
                    justify-content: space-between;
                    padding: 14px 30px 26px;

                    .main-block {
                        height: 309px;
                        width: 100%;
                        border: 1px solid #DADADA;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        position: relative;

                        .title-approval {
                            position: absolute;
                            bottom: 10px;
                            text-align: center;
                            z-index: 4;
                            font-size: 16px;

                            small {
                                display: block;
                                text-align: center;
                                color: #93989B;
                            }
                        }

                        img {
                            max-width: 50%;
                            max-height: 50%;
                            padding: 20px;
                        }
                    }

                    .approve-block-title {
                        font-style: normal;
                        font-weight: 900;
                        font-size: 28px;
                        line-height: 150%;
                        /* or 42px */
                        text-align: center;
                        text-transform: uppercase;

                        color: #797979;
                        border-bottom: 2px solid #C7C7C7;
                    }

                    .approved, .rejected {
                        flex-basis: 192px;
                        flex-grow: 0;
                        flex-shrink: 0;
                        margin: 0 30px;

                        div {
                            padding: 5px;
                            text-align: center;

                            img {
                                max-height: 35px;
                                max-width: 35px;
                                padding: 5px;
                            }
                        }

                        &.rejected {
                            margin-left: 0;
                        }

                        &.approved {
                            margin-right: 0;

                            .approve-block-title {
                                color: $secondary_color;
                            }
                        }
                    }

                }
            }

            &.step-13 {
                .right-block {
                    flex-basis: 100%;

                    .view-block {
                        height: 279px !important;
                    }

                    .scroll-block {
                        width: 76vw;
                        overflow: hidden;
                        margin-left: 3vw;
                    }

                    .btn-slider-scroll {
                        position: absolute;
                        top: 220px;
                        background: transparent;
                        border: none;
                        outline: none;
                        opacity: .4;

                        &:hover {
                            opacity: .6;
                        }

                        &.arrow-left {
                            left: 1vw;
                        }

                        &.arrow-right {
                            right: 1vw;
                        }
                    }
                }

            }

            .add-new-color {
                min-width: 170px;
                height: 180px;
                border: 2px dashed #999999;
                box-sizing: border-box;
                margin-top: 34px;
                margin-right: 18px;

                .icon {
                    margin-bottom: 10px;
                }

                .text {
                    font-family: Montserrat;
                    font-style: normal;
                    font-weight: 600;
                    font-size: 14px;
                    line-height: 150%;
                    /* or 21px */

                    text-align: center;

                    color: #999999;
                }
            }

            .options {
                margin-top: 66px;
                justify-content: center;

                .click-option {
                    margin: 0 33px;
                    cursor: pointer;
                    border-radius: 10px;
                    transition: background .5s;
                    box-sizing: border-box;
                    padding: 15px 30px;
                    text-align: center;

                    &:hover {
                        background: rgba(0, 0, 0, .02);
                    }

                    .option-title {
                        font-family: Montserrat;
                        font-style: normal;
                        margin-top: 30px;
                        font-weight: 500;
                        font-size: 18px;
                        line-height: 150%;
                        /* or 27px */

                        text-align: center;

                        color: #93989B;

                        small {
                            display: block;
                            font-size: 12px;
                            margin-top: -10px;
                        }

                    }
                }
            }
        }

        .view-block.vertical {
            overflow: auto;
            height: 249px;
            margin-bottom: 2rem;

            &::-webkit-scrollbar {
                background: #EEEEEE;
                border-radius: 3px;
                width: 6px !important;
            }

            &::-webkit-scrollbar-thumb {
                background: #999999;
                border-radius: 3px;
            }
        }

        .back-button {
            position: absolute;
            width: 63px;
            height: 23px;
            left: 15px;
            top: 487px;
            cursor: pointer;
            border: none;
            background: transparent;
            outline: none;

            &.step8, &.step9 {
                left: 35.1%;
            }

            &.step13 {
                top: 592px;
            }
        }

        .forward-button {
            position: absolute;
            width: 19px;
            height: 42px;
            right: 84px;
            bottom: 98px;
            cursor: pointer;
            border: none;
            background: transparent;
            outline: none;

            &.step4, &.step5 {
                right: 400px;
            }
        }
    }

    .foreground {
        width: 65vw;
        height: 520px;
        position: absolute;
        z-index: 6;
        left: 50vw;
        top: 50vh;
        margin-left: -32.5vw;
        margin-top: -260px;
        // background: rgba(255,0,0,.5);
        overflow: hidden;

        &.extra {
            width: 82vw;
            margin-left: -41vw;
            height: 625px;
            margin-top: -312px;
        }

        #bottom-right-over {
            // background: rgba(0,255,0,.5);
            position: absolute;
            z-index: 6;
            width: 129vw;
            left: -17.5vw;
            left: -12.45vw;
            bottom: calc(calc(-1 * calc(50vh - 260px)) - 10px);
            // bottom: -260px;
        }

        .industry-bg {
            background-image: url('/images/industry.png');
            background-position: right bottom;
            height: 100%;
            background-repeat: no-repeat;
        }
    }

    .background {
        width: 100%;
        position: fixed;
        z-index: 3;
        height: 100%;
        background: var(--main_color);
        overflow: hidden;

        #white-circle {
            width: 129vw;
            left: 5.05vw;
            // top: -23vw;
            bottom: 0;
            position: absolute;
        }

        #main-circle {
            position: absolute;
            z-index: 5;
            bottom: 0;
            left: 5.05vw;
            width: 129vw;
        }

        #bottom-right {
            position: absolute;
            z-index: 5;
            width: 129vw;
            left: 5.05vw;
            bottom: -10px;
        }

    }

    .save-and-exit {
        position: absolute;
        right: 15px;
        top: 18px;
        z-index: 123123123;
        cursor: pointer;

        font-family: Montserrat;
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 150%;
        color: #000000;

        &:hover {
            text-decoration: underline;
        }
    }

    .extra20 {
        width: auto !important;
        left: 29px !important;
        margin-left: 0 !important;
        right: 29px !important;
        margin-top: 0 !important;
        top: 139px !important;
        height: 630px; //calc(100vh - 139px - 29px) !important;
        overflow: hidden;
        margin-bottom: 30px;
    }
}
</style>

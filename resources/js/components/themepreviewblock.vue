<template>
    <div class="theme-block" @click="click" :ref="'md'+themeid">
        <div class="theme-container">
            <div class="theme-info">
                <div class="theme-details">
                    <span class="theme-label">
                        {{ translate('Template') }}
                    </span>
                    <h3 class="theme-title">
                        {{ translate("title_"+theme.name) }}
                    </h3>
                    <div class="theme-description">
                        {{ translate("description_"+theme.name) }}
                    </div>
                </div>
                <button 
                    class="theme-select-button" 
                    :style="{'background-color': first}"
                    @click="click">
                    {{ translate('Have a try') }}
                </button>
            </div>
            <div class="theme-pages"> 
                <div :ref="'main'+themeid" :class="['main-image', type]"
                    :style="{'--first': first, '--second': second, '--third': third}">
                    <div class="loading-main" style="transform: scale(.5)" v-if="loading<4"></div>
                    <canvas :id="'page1'+themeid"></canvas>
                    <!--<div class="logo" v-html="logo"></div>
                    <div class="small-title">
                        {{brand}} Brand Book
                    </div>
                    <div class="logo-gingersauce"><svg width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.7229 0.8125V5.56588H5.47628V0.8125H0.7229ZM3.46099 4.80819C2.86097 4.91039 2.22155 4.75937 1.71987 4.33837L2.14416 3.83256C2.52286 4.15037 3.01455 4.24491 3.46094 4.13326L3.46099 4.80819ZM3.46099 2.35792C3.37053 2.26076 3.242 2.19958 3.09902 2.19958C2.82599 2.19958 2.60386 2.42171 2.60386 2.69465C2.60386 2.96768 2.82594 3.18985 3.09902 3.18985C3.24195 3.18985 3.37048 3.12863 3.46099 3.03147V3.79111C3.347 3.8289 3.22551 3.85 3.09902 3.85C2.46197 3.85 1.94366 3.33174 1.94366 2.6946C1.94366 2.0576 2.46197 1.53934 3.09902 1.53934C3.22551 1.53934 3.34696 1.56044 3.46099 1.59823V2.35792Z"/></svg> Powered by gingersauce</div>-->
                </div>
                <div class="small-preview">
                    <div class="second-third row">
                        <canvas :id="'page2'+themeid"></canvas>
                        <canvas :id="'page3'+themeid"></canvas>
                    </div>
                    <div class="forth-fifth row">
                        <canvas :id="'page4'+themeid"></canvas>
                        <canvas :id="'page5'+themeid"></canvas>
                    </div>
                </div>
            </div>
            
        </div>
        <!--<div class="second-third">
            <div class="second"  :style="{'--first': first, '--second': second, '--third': third}">
                <div class="qaa">QUALITY<br>ABOVE<br>ALL</div>
                <div class="pshr">Precisely<br>Selected<br>Human<br>Resources</div>
                <div class="owif">Outsourcing<br>with<br>an<br>In-house<br>Feeling</div>
            </div>
            <div class="third"  :style="{'--first': first, '--second': second, '--third': third}">
                <div class="of">Our Fonts</div>
                <div class="text">We use one English font and one Hebrew font. The primary font is Open Sans and it has 3 weights: Regular, Bold & ExtraBold. Our Hebrew font is Open Sans Hebrew and it also has 3 weights: Regular, Bold & ExtraBold.</div>
            </div>
        </div>-->
    </div>
</template>
<script>
// import html2canvas from 'html2canvas'
import pdfjsLib from 'pdfjs-dist/build/pdf'
import translate from "../utils/translate";

export default {
    props: ['brand', 'type', 'first', 'second', 'third', 'logo', 'themeid', 'bbid', 'pdf_link', 'fonts_page', 'colors_page', 'theme'],
    methods: {
        translate,
        click() {
            this.$emit('click')
            this.$root.$emit('theme.selected', {type: this.themeid})
        },
        renderPage(pdf, page_index, canvas_index) {
            pdf.getPage(page_index).then((page) => {
                var scale = 2;
                var viewport = page.getViewport({scale: scale,});
                var canvas = document.getElementById('page' + canvas_index + this.themeid);
                var context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                var renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext).then(() => {
                    this.loading++
                })
            })
        }
    },
    data() {
        return {
            html: '',
            loading: 0,
        }
    },
    mounted() {
        let pdf_promise = pdfjsLib.getDocument(this.pdf_link)
        pdf_promise.promise.then((pdf) => {
            var pages = [1, this.fonts_page, this.fonts_page + 1, this.colors_page, this.colors_page + 1]
            for (var page_index in pages) {
                this.renderPage(pdf, pages[page_index], parseInt(page_index) + 1)
            }
        })
        // axios.get(endpoints.ajax.get.theme+'?theme='+this.themeid+'&id='+this.bbid).then(response=>{
        // 	var div = document.createElement('div')
        // 	div.id="md"+this.themeid
        // 	div.style.width = "200mm"
        // 	div.style.height = "200mm"
        // 	// div.style.visibilit = "hidden"
        // 	div.style.position = "absolute"
        // 	// div.style.left = "-200mm"
        // 	$(this.$refs['md'+this.themeid]).append(div)
        // 	var el = div.insertAdjacentHTML('beforeend', response.data.html)
        // 	var w = $(this.$refs['main'+this.themeid]).width()
        // 	var h = $(this.$refs['main'+this.themeid]).height()
        // 	$(this.$refs['main'+this.themeid]).height(w)
        // 	var ww = $('#md'+this.themeid).width()
        // 	var hh = $('#md'+this.themeid).height()
        // 	var x = $(this.$refs['main'+this.themeid]).position().left
        // 	var y = $(this.$refs['main'+this.themeid]).position().top
        // 	var scaleX = w/ww
        // 	var scaleY = h/hh

        // 	div.style.transform = "scale("+scaleX+")"
        // 	div.style.left = x+'px'
        // 	div.style.top = y+'px'
        // 	div.style.transformOrigin = 'top left'
        // 	div.style.zIndex = 12341
        // 	div.style.overflow='hidden'
        // 	// html2canvas(div).then(canvas=>{
        // 		// document.body.appendChild(canvas)
        // 		// document.body.removeChild(document.getElementById('md'+this.theme))
        // 	// })
        // })
    }

	}
</script>

<style lang="scss">
.theme-selector-block {
    height: 100%;
    overflow: auto;
}

.theme-block {
    flex-basis: 15vw;
    margin-top: 20px;

    .theme-info{
        width: 21vw;
        float: left;
        .template-label{
            font-size: 18px;
            font-weight: 300;
            line-height: 22px;
        }
    }

    .theme-pages{
        display: flex;
    }

    .main-image {
        width: 21vw;
        height: 21vw;
        position: relative;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
        float: left;
        margin-right: 1vw;

        canvas {
            width: 21vw;
            height: 21vw;
        }
    }

    .small-preview {
        width: 20vw;
    }

    .second-third, .forth-fifth {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
        width: 20vw;
        height: 10vw;
        margin-left: 0;

        canvas {
            width: 10vw;
            height: 10vw;
            float: left;
        }
    }

    .forth-fifth {
        margin-top: 1vw;
    }
    .clear{
        clear: both;
    }

    .theme-container {
        margin-bottom: 20px;
        //padding-bottom: 20px;
        padding: 20px;
        border: 2px solid #959595;
        /* margin: 0 auto; */
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-direction: row;
        width: 100%;
    }

    .theme-info{
        display: flex;
        flex-direction: column;
        height: 100%;
        justify-content: flex-end;


        .theme-details{
            margin-bottom: 100px;

            .theme-label{                
                font-size: 18px;
                font-weight: 300;
                line-height: 22px;
            }

            .theme-title{
                font-size: 32px;
                font-weight: 900;
                line-height: 39px;
                text-align: left;
                margin: 0;
            }

            .theme-description{
                font-size: 18px;
                font-weight: 500;
                line-height: 22px;
                color: #999;
            }
        }

        .theme-select-button{
            padding: 15px 30px;
            color: white;
            font-size: 20px;
            font-weight: 500;
            line-height: 24px;
            max-width: 200px;
            border: none;
            border-radius: 6px;
        }


    }
    
}
</style>
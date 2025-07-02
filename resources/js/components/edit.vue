<template>
	<div class="edit-form">
		<div class="loading" v-if="loading"></div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-2 aside">
					<div class="icon" v-if="!loading"><img :src="icon" class="img-fluid mx-auto d-block my-2"></div>
					<div class="logo mb-3" v-if="!loading"><img :src="logo" class="img-fluid mx-auto d-block my-2"></div>
					<div class="title text-center font-weight-boldic" v-if="!loading">{{brand}}</div>
					<div class="industry text-muted text-center mb-4" v-if="!loading">{{industry}}</div>
					<div class="pdf-pages" ref="pdf-pages" @mousewheel="con" v-if="!loading">
						<div><a href="#page1"><canvas id="canvas_page1"></canvas></a></div>
						<div><a href="#page2"><canvas id="canvas_page2"></canvas></a></div>
						<div><a href="#page3"><canvas id="canvas_page3"></canvas></a></div>
						<div><a href="#page4"><canvas id="canvas_page4"></canvas></a></div>
						<div><a href="#page5"><canvas id="canvas_page5"></canvas></a></div>
						<div><a href="#page6"><canvas id="canvas_page6"></canvas></a></div>
						<div><a href="#page7"><canvas id="canvas_page7"></canvas></a></div>
						<div><a href="#page8"><canvas id="canvas_page8"></canvas></a></div>
						<div><a href="#page9"><canvas id="canvas_page9"></canvas></a></div>
						<div><a href="#page10"><canvas id="canvas_page10"></canvas></a></div>
						<div><a href="#page11"><canvas id="canvas_page11"></canvas></a></div>
						<div><a href="#page12"><canvas id="canvas_page12"></canvas></a></div>
						<div><a href="#page13"><canvas id="canvas_page13"></canvas></a></div>
						<div><a href="#page14"><canvas id="canvas_page14"></canvas></a></div>
						<div><a href="#page15"><canvas id="canvas_page15"></canvas></a></div>
						<div><a href="#page16"><canvas id="canvas_page16"></canvas></a></div>
						<div><a href="#page17"><canvas id="canvas_page17"></canvas></a></div>
						<div><a href="#page18"><canvas id="canvas_page18"></canvas></a></div>
						<div><a href="#page19"><canvas id="canvas_page19"></canvas></a></div>
						<div><a href="#page20"><canvas id="canvas_page20"></canvas></a></div>
						<div><a href="#page21"><canvas id="canvas_page21"></canvas></a></div>
						<div><a href="#page22"><canvas id="canvas_page22"></canvas></a></div>
						<div><a href="#page23"><canvas id="canvas_page23"></canvas></a></div>
						<div><a href="#page24"><canvas id="canvas_page24"></canvas></a></div>
						<div><a href="#page25"><canvas id="canvas_page25"></canvas></a></div>
						<div><a href="#page26"><canvas id="canvas_page26"></canvas></a></div>
						<div><a href="#page27"><canvas id="canvas_page27"></canvas></a></div>
						<div><a href="#page28"><canvas id="canvas_page28"></canvas></a></div>
						<div><a href="#page29"><canvas id="canvas_page29"></canvas></a></div>
						<div><a href="#page30"><canvas id="canvas_page30"></canvas></a></div>
						<div><a href="#page31"><canvas id="canvas_page31"></canvas></a></div>
						<div><a href="#page32"><canvas id="canvas_page32"></canvas></a></div>
						<div><a href="#page33"><canvas id="canvas_page33"></canvas></a></div>
						<div><a href="#page34"><canvas id="canvas_page34"></canvas></a></div>
						<div><a href="#page35"><canvas id="canvas_page35"></canvas></a></div>
						<div><a href="#page36"><canvas id="canvas_page36"></canvas></a></div>
					</div>
				</div>
				<div class="col-8">
					<div class="html-content" v-html=html id="editorjs"></div>
				</div>
				<div class="col-2 aside bg-transparent shadow-none">
					<div class="buttons" v-show="!loading">
						<div>
							<a href="/my" class="btn btn-sm btn-default text-muted">
								<i class="fas fa-times"></i>
								{{ translate('Close Book') }}
							</a>
						</div>
						<div><router-link :to="{name: 'Wizard', params: {'id': $route.params.id, 'page': 25}}" class="btn btn-sm btn-default text-muted">
								<i class="fas fa-pencil-alt"></i>
								{{ translate('Change Template') }}
								</router-link></div>
						<form :action="duplicate_url" method="post" v-if="can_duplicate">
							<input type="hidden" name="_token" :value="token">
							<input type="hidden" name="_method" value="PUT">
							<button class="btn btn-sm btn-default text-muted"><i class="far fa-copy"></i>
								{{ translate('Duplicate') }}
							</button>
						</form>

						<div><button class="btn btn-sm btn-default text-muted" @click="share"><i class="fas fa-share-square"></i>
						{{ translate('Share') }}
						</button></div>
						<div><a v-if="can_export && is_saved" :href="pdf_url" target="_blank" class="btn btn-sm btn-success"><i class="far fa-file-pdf"></i>
						{{ translate('Export') }}
						</a></div>
						<div class="mb-1"><a v-if="can_export && !is_saved" @click.prevent.stop="save_pdf" target="_blank" class="btn btn-sm btn-success"><i class="far fa-save"></i>
						{{ translate('Save') }}
						</a></div>
						<a v-if="can_export" target=_blank class="btn btn-sm btn-danger text-white" :href="logo"><i class="fas fa-file-download"></i>
						{{ translate('Download brand assets') }}</a>
					</div>
					<!--<div class="buttons-bottom" v-show="!loading">

					</div>-->
				</div>
			</div>
		</div>
	</div>
</template>
<script>
    import pdfjsLib from 'pdfjs-dist/build/pdf'
	import Quill from 'quill'
	import BubbleTooltip from 'quill/themes/bubble.js'
	import BubbleTheme from 'quill/themes/bubble.js'
	// import 'quill/dist/quill.core.css'
	import 'quill/dist/quill.bubble.css'
	import translate from "../utils/translate";
	export default {
		mounted(){
			this.load()
		},
		data(){
			return {
				html: '',
				pdf_link: '',
				icon: '',
				logo: '',
				brand: '',
				industry: '',
				theme: '',

				loading: false,

				editors: [],

				can_export: false,
				can_duplicate: false,

				is_saved: true,
			}
		},
		computed: {
			duplicate_url(){
				return '/my/duplicate/'+this.$route.params['id']
			},
			edit_url(){
				return '/my/edit/'+this.$route.params['id']
			},
			pdf_url(){
				return '/my/pdf/'+this.$route.params['id']
			},
			left_track(){
				return ((this.page-1)/36*100)+'%'
			}
		},
		methods: {
			translate,
			con(e){
				console.log(e, this.$refs['pdf-pages'].scrollTop)
				this.$refs['pdf-pages'].scrollTop+=e.deltaY
				//style scrollbar
				//show which page is selected on the left bar
				//include editor
			},
			save(field, text){
				this.is_saved = false
				axios.post(endpoints.ajax.post.brandbook.save_field, {
					id: this.$route.params.id,
					field: field,
					text: text,
				})
			},
			save_pdf(){
				this.loading = true
				axios.post(endpoints.ajax.post.brandbook.generate, {
					id: this.$route.params.id,
					theme: this.theme
				}).then(response=>{
					this.is_saved = true
					this.loading = false
					this.pdf_link = response.data.url
				})
			},
			share(){
				$('#modal-share').modal('show')
				this.$root.$emit('share', {id: this.$route.params['id'], data: {id: this.$route.params['id']}})
			},
			load(){
				this.loading = true
				axios.post(endpoints.ajax.post.brandbook.edit, {id: this.$route.params.id}).
				then(response=>{
					this.loading = false
					this.html = response.data.html
					this.pdf_link = response.data.pdf_link
					this.icon = response.data.icon
					this.logo = response.data.logo
					this.brand = response.data.brand
					this.industry = response.data.industry
					this.can_export = response.data.can_export
					this.theme = response.data.theme
					this.can_duplicate = response.data.can_duplicate
					let pdf_promise = pdfjsLib.getDocument(response.data.pdf_link)
					pdf_promise.promise.then((pdf)=>{
						for(var page_index=1;page_index<=36;page_index++)
							this.renderPage(pdf, page_index)
					})
					var _this = this
					// var editor =
					setTimeout(()=>{
						document.querySelectorAll('.text').forEach((item, index)=>{
								this.editors.push(new Quill(item, {
									 modules: {
									    toolbar: [
										  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
										  ['blockquote', 'code-block'],

										  [{ 'header': 1 }, { 'header': 2 }],               // custom button values
										  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
										  [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
										  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
										  [{ 'direction': 'rtl' }],                         // text direction

										  [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
										  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

										  [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
										  [{ 'font': [] }],
										  [{ 'align': [] }],

										  ['clean']                                         // remove formatting button
										]
									  },
									  theme: 'bubble'
								})
							)
						})
						this.editors.forEach(editor => {
							editor.on('editor-change', function(n,a,s,o,k){
									// console.log(editor, n,a,s,o,k)
									if(editor.container!=undefined){
										_this.save(editor.container.dataset.field, editor.root.innerHTML)
									}
								})
						})
						document.querySelectorAll("[contenteditable=true]").forEach((item)=>{
							item.addEventListener('blur', ()=>{
								_this.save(item.dataset['titleField'], item.innerHTML)
							})
						})
					}
					, 1000)
				})
			},
			renderPage(pdf, page_index){
				pdf.getPage(page_index).then((page)=>{
					var scale = .5;
					var viewport = page.getViewport({ scale: scale, });
					var canvas = document.getElementById('canvas_page'+page_index);
					var context = canvas.getContext('2d');
					canvas.height = viewport.height;
					canvas.width = viewport.width;

					var renderContext = {
					  canvasContext: context,
					  viewport: viewport
					};
					page.render(renderContext);
				})
			}
		}
	}
</script>
<style lang="scss">
	.buttons-bottom{
		top: unset;
		bottom: 10px;
	}
	[contenteditable=true]{
		outline: none;
	}
	.aside .btn{
		color: #999999 !important;
	}
	.aside .btn.btn-success, .aside .btn.btn-danger{
		color: #fff !important;
	}
	div[id^='page']{
		//background: #fff;
		margin: 0 auto !important;
	}
	body{
		overflow: hidden;
	}
	.html-content{
		overflow-y: scroll;
		height: calc(100vh - 50px);

		/* Demonstrate a "mostly customized" scrollbar
		 * (won't be visible otherwise if width/height is specified) */
		&::-webkit-scrollbar {
		  width: 10px;
		  background: #C4C4C4;
		  border-radius: 15px;
		  /* or add it to the track */
		}

		/* Add a thumb */
		&::-webkit-scrollbar-thumb {
			width: 10px;
			background: #A2224C;
			border: 2px solid #C4C4C4;
			box-sizing: border-box;
			border-radius: 15px;
		}
	}
	.edit-form{
	    width: 100%;
	    height: calc(100vh - 50px);
	    position: absolute;
	    z-index: 50;
	    left: 0;
	    right: 0;
	    background: #E5E5E5;

	    .aside{
	    	box-shadow: 0px 4px 20px #FCB89F;
	    	background: #FFFFFF;

			.icon{
				img{
					width: 32px;
					height: auto;
				}
			}
	    	.logo{
	    		img{
					width: 32px;
					height: 32px;
	    		}
	    	}
	    	.pdf-pages{
	    		height: calc(100vh - 240px);
	    		overflow: hidden;

	    		div{
	    			width: 100%;

	    			canvas{
	    				width: 180px;
	    				height: 180px;
	    				display: block;
	    				margin: 0 auto !important;
	    			}
	    		}
	    	}
	    }
	}
	.ql-editor{
		padding: 0;
	    font-size: 14px;
	    line-height: 150%;
	    p{
	    	margin-bottom: 1em;
	    }
	}

	@keyframes loader-rotate {
  0% {
    transform: rotate(0); }
  100% {
    transform: rotate(360deg); } }

	.loading {
	    width: 56px;
	    height: 56px;
	    border: 8px solid rgba(0, 82, 236, 0.25);
	    border-top-color: #0052ec;
	    border-radius: 50%;
	    position: absolute;
	    left: 50%;
	    top: 50%;
	    margin-left: -28px;
	    margin-top: -28px;
	    z-index: 100;
	    animation: loader-rotate 1s linear infinite;
	    top: 50%;
	    margin: -28px auto 0 auto;
	    text-shadow: 0 0 black;
	}
</style>

<template>
	<div :class="['color-box', is_primary?'primary':'']" :style="{zIndex: (is_gradient?123123:1)}">
		<div class="title">
			<!--{{_title}}&nbsp;-->
			{{titlus}}&nbsp;
		</div>
					<div class="icons" v-if="!is_primary">
						<button v-if="is_pinned" @click.stop="unpin"><!--pinned--><svg width="11" height="15" viewBox="0 0 11 15" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M7.77486 6.53631C7.80203 6.79892 7.96527 7.02791 8.20468 7.13922C9.39993 7.69495 10.1704 8.59944 10.2046 9.61003H6.42428C6.01006 9.61003 5.67428 9.94582 5.67428 10.36V13.1822L5.51795 13.4948L5.36163 13.1822V10.36C5.36163 9.94582 5.02584 9.61003 4.61163 9.61003H0.831272C0.865312 8.60878 1.62518 7.69995 2.83119 7.13922C3.0706 7.02791 3.23384 6.79892 3.26101 6.53631L3.60753 3.18673C3.62938 2.97552 3.56068 2.76494 3.41846 2.60725C3.27625 2.44957 3.07386 2.35955 2.86151 2.35955H1.73639V1.14062H9.29949V2.35955H8.17436C7.96202 2.35955 7.75962 2.44957 7.61741 2.60725C7.4752 2.76494 7.40649 2.97552 7.42834 3.18673L7.77486 6.53631Z" stroke="#797979" fill="#797979" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg></button>
						<button v-if="!is_pinned" @click.stop="pin"><!--unpined-->
							<svg width="11" height="15" viewBox="0 0 11 15" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M7.77486 6.53631C7.80203 6.79892 7.96527 7.02791 8.20468 7.13922C9.39993 7.69495 10.1704 8.59944 10.2046 9.61003H6.42428C6.01006 9.61003 5.67428 9.94582 5.67428 10.36V13.1822L5.51795 13.4948L5.36163 13.1822V10.36C5.36163 9.94582 5.02584 9.61003 4.61163 9.61003H0.831272C0.865312 8.60878 1.62518 7.69995 2.83119 7.13922C3.0706 7.02791 3.23384 6.79892 3.26101 6.53631L3.60753 3.18673C3.62938 2.97552 3.56068 2.76494 3.41846 2.60725C3.27625 2.44957 3.07386 2.35955 2.86151 2.35955H1.73639V1.14062H9.29949V2.35955H8.17436C7.96202 2.35955 7.75962 2.44957 7.61741 2.60725C7.4752 2.76494 7.40649 2.97552 7.42834 3.18673L7.77486 6.53631Z" stroke="#797979" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</button>
						<!--<button  :disabled="is_pinned" @click.stop="gradient"><svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg"><line y1="12.75" x2="12" y2="12.75" stroke="white" stroke-width="0.5"/><line x1="-1.58951e-09" y1="10.4" x2="12" y2="10.4" stroke="white" stroke-width="0.8"/><line x1="-1.98688e-09" y1="8.1001" x2="12" y2="8.1001" stroke="white"/><line x1="-2.98033e-09" y1="5.6499" x2="12" y2="5.6499" stroke="white" stroke-width="1.5"/><line x1="-3.57639e-09" y1="3.29995" x2="12" y2="3.29995" stroke="white" stroke-width="1.8"/><line x1="-3.97377e-09" y1="1" x2="12" y2="1" stroke="white" stroke-width="2"/></svg></button>-->
						<button 
							class="color_shades_button"
							:disabled="is_pinned" @click="toggleShades()">
							<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect x="1.12266" y="1.49473" width="5.24572" height="5.24572" stroke="#797979" stroke-width="1.3"/>
								<rect x="1.12266" y="8.04062" width="5.24572" height="5.24572" stroke="#797979" stroke-width="1.3"/>
								<rect x="7.66758" y="1.49473" width="5.24572" height="5.24572" stroke="#797979" stroke-width="1.3"/>
								<rect x="7.66758" y="8.04062" width="5.24572" height="5.24572" stroke="#797979" stroke-width="1.3"/>
								</svg>
						</button>
						<button
							class="color_trash_button" 
							:disabled="is_pinned" 
							@click.stop="trash"><!--trash--><svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M7.86566 12.2091H8.56287C8.65533 12.2091 8.744 12.1732 8.80937 12.1093C8.87475 12.0453 8.91148 11.9586 8.91148 11.8682V5.73167C8.91148 5.64126 8.87475 5.55454 8.80937 5.49061C8.744 5.42667 8.65533 5.39076 8.56287 5.39076H7.86566C7.7732 5.39076 7.68453 5.42667 7.61915 5.49061C7.55378 5.55454 7.51705 5.64126 7.51705 5.73167V11.8682C7.51705 11.9586 7.55378 12.0453 7.61915 12.1093C7.68453 12.1732 7.7732 12.2091 7.86566 12.2091ZM12.63 2.66341H10.2359L9.24818 1.05257C9.12422 0.850585 8.94887 0.683443 8.73922 0.567436C8.52956 0.451428 8.29276 0.390513 8.05187 0.390625H5.12298C4.88219 0.390611 4.64551 0.451573 4.43596 0.567576C4.22642 0.683578 4.05116 0.850667 3.92726 1.05257L2.93895 2.66341H0.544889C0.421613 2.66341 0.303387 2.7113 0.216218 2.79655C0.129049 2.8818 0.0800781 2.99741 0.0800781 3.11797L0.0800781 3.57253C0.0800781 3.69308 0.129049 3.8087 0.216218 3.89395C0.303387 3.97919 0.421613 4.02708 0.544889 4.02708H1.0097V13.5728C1.0097 13.9345 1.15661 14.2813 1.41812 14.5371C1.67963 14.7928 2.0343 14.9365 2.40413 14.9365H10.7707C11.1405 14.9365 11.4952 14.7928 11.7567 14.5371C12.0182 14.2813 12.1652 13.9345 12.1652 13.5728V4.02708H12.63C12.7532 4.02708 12.8715 3.97919 12.9586 3.89395C13.0458 3.8087 13.0948 3.69308 13.0948 3.57253V3.11797C13.0948 2.99741 13.0458 2.8818 12.9586 2.79655C12.8715 2.7113 12.7532 2.66341 12.63 2.66341ZM5.07214 1.83697C5.08768 1.81168 5.10966 1.79077 5.13593 1.77628C5.16221 1.76179 5.19188 1.75421 5.22205 1.7543H7.95281C7.98292 1.75426 8.01254 1.76186 8.03875 1.77635C8.06497 1.79084 8.08691 1.81172 8.10242 1.83697L8.60964 2.66341H4.56521L5.07214 1.83697ZM10.7707 13.5728H2.40413V4.02708H10.7707V13.5728ZM4.61198 12.2091H5.3092C5.40165 12.2091 5.49032 12.1732 5.5557 12.1093C5.62108 12.0453 5.65781 11.9586 5.65781 11.8682V5.73167C5.65781 5.64126 5.62108 5.55454 5.5557 5.49061C5.49032 5.42667 5.40165 5.39076 5.3092 5.39076H4.61198C4.51953 5.39076 4.43086 5.42667 4.36548 5.49061C4.3001 5.55454 4.26337 5.64126 4.26337 5.73167V11.8682C4.26337 11.9586 4.3001 12.0453 4.36548 12.1093C4.43086 12.1732 4.51953 12.2091 4.61198 12.2091Z" fill="#797979"/>
							</svg>


						</button>
					</div>
		<div class="widget">
			<div :id="'gp_'+_id" class="gradient-picker" v-show="is_gradient">
				<div></div>
				</div>
			<div class="depict">
				<div class="main-section" :style="{background: gradient_code==''?_hex:gradient_code}" @click="color_activation">

				</div>
				<div :class="['additional-section', !show_shades?'hid':'']">
					<div class="color" :style="{background: _hex, opacity: .8}"></div>
					<div class="color" :style="{background: _hex, opacity: .6}"></div>
					<div class="color" :style="{background: _hex, opacity: .4}"></div>
					<div class="color" :style="{background: _hex, opacity: .2}"></div>
				</div>
			</div>
			<div class="detext">
				<div class="key-value">
					<div class="key">{{ translate('Hex') }}</div>
					<div class="value"><input  :disabled="is_pinned" type="text" :id="_id" :value="_hex" class="color-input"></div>
				</div>
				<div class="key-value">
					<div class="key">{{ translate('RGB') }}</div>
					<div class="value">{{_rgb}}</div>
				</div>
				<div class="key-value">
					<div class="key">{{ translate('CMYK') }}</div>
					<div class="value"><input  :disabled="is_pinned" type="text"  @keypress="cmyk_updated" :id="_id" :value="_cmyk" class="color-input"></div>
				</div>
				<div class="key-value">
					<div class="key">
						{{ translate('Pantone') }}
					</div>
					<div class="value"><input  :disabled="is_pinned" type="text" style="width: 60%;" @keypress="pantone_updated" :id="_id" :value="pantone" class="color-input"></div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	const simpleColorConverter = require('simple-color-converter')
	import translate from "../utils/translate";
	export default {
		props: {
			title: String,
			color: Object,
			index: Number,
			is_primary: Boolean,
			is_new: Boolean,
			pinned: Boolean,
			shades: Boolean
		},
		components: {
			// GradientPicker: GradientPicker
		},
		data(){
			return {
				loaded: false,
				is_pinned: false,
				is_gradient: false,
				gradient_code: '',

				show_shades: true,

				load_to: null,
				currentFocus: null,
                selectorCreated: false,
      			nodeColor: ""
			}
		},
		mounted(){
			if(this.pinned)
				this.is_pinned = true
			if(this.color.loaded===false){
				this.load(this.color.hex.value)
			}
			this.$root.$on('colors.redraw', ()=>{
				// if(this.color.loaded===false){
					this.load(this.color.hex.value)
				// }
			})
			setTimeout(()=>{
				// gradX("#gp_"+this._id);
				// const gp = new Grapick({el: '#gp_'+this._id});

				// gp.addHandler(0, this._hex);
				// gp.addHandler(100, '#fff');

				// // Do stuff on change of the gradient
				// gp.on('change', complete => {
				// 	document.body.style.background = gp.getSafeValue();
				// })
				const gpickr = new GPickr({
				    el: "#gp_"+this._id+' div',
				    stops: [
				        [this._hex, 0],
				        ['#fff', 1]
				    ]
				}).on('change', instance => {
					clearTimeout(this.toto)
					this.toto = setTimeout(()=>{
						this.gradient_code = instance.getGradient()
						this.$root.$emit('color.gradient', {data: this.gradient_code, id: this.index})
						this.is_gradient = false
					}, 4000)
				});
				this.bindSelector()
			}, 1000)
			this.bindSelector()

		},
		methods:{
			translate,
			toggleShades(){
				this.show_shades = !this.show_shades
				this.$root.$emit('color.shades', {shades: this.show_shades, id: this.index})
			},
			pantone_updated(e){
				this.$root.$emit('color.update', {type: 'pantone', color: e.target.value, id: this.index})
			},
			cmyk_updated(e){
				this.$root.$emit('color.update', {type: 'cmyk', color: e.target.value, id: this.index})
			},
			pantone_func(e, r){
				console.log(r)
			},
			load(color){
				if(color.search('rgb')>-1){
					color = color.replace('rgba','').replace('rgb', '').replace('(','').replace(')','').split(',')
					var rgb = {
				  		r: color[0],
				  		g: color[1],
				  		b: color[2]
				  	}
				  	color = simpleColorConverter({
				  		rgb: rgb,
				  		to: 'hex6'
				  	})
				}
				var _this = this;
				axios.get('https://www.thecolorapi.com/id?hex='+color.replace('#','')+'&format=json')
				.then(response => {
					this.loaded = response.data
					this.$root.$emit('color.load', {data: this.loaded, id: this.index, index: this.index, new_index: color})

					this.bindSelector()
				})
			},
			bindSelector(){
				var _this = this
				setTimeout(()=>{
					$('#'+this._id).chromoselector({
						update: ()=>{
                                if(_this._hex.length == 7)
                                {

                                        var color = $('#' + this._id).chromoselector('getColor').getHexString()
                                        clearTimeout(this.load_to)
                                        this.load_to = setTimeout(() => {

                                                _this.load(color)
                                        }, 2000)
                                }
							// $('.ui-cs-chromoselector').hide()
						},
                        create: ()=>{
                                _this.selectorCreated = true;
						        console.log('create!');
                                console.log($('#'+this._id).chromoselector('getColor').getHexString());
                        }
					})
					if(this.is_new){
						$('#'+this._id).focus()
					}
				}, 2000)
			},
			pin(){
				this.is_pinned = true
				this.$root.$emit('color.pinned', {id: this.index})
			},
			unpin(){
				this.is_pinned = false
				this.$root.$emit('color.unpinned', {id: this.index})
			},
			gradient(){
				this.is_gradient = true

			},
			trash(){
				this.$root.$emit('color.trashed', {id: this.index})
				// this.$root.$emit('color.trashed', {id: this._hex})
			},
			color_activation(){
				if(!this.is_pinned && this.selectorCreated)
					$('#'+this._id).trigger('focus')
			}
		},
		watch: {
			shades(){
				this.show_shades = this.shades
			}
		},
		computed:{
			pantone(){
				if(this._color!=undefined && this._color.hex!=undefined){
					var color = simpleColorConverter({
						hex3: this._color.hex.value,
						to: 'pantone'
					})
					return color
				}
			},
			_color(){
				if(this.loaded!==false)
					return this.loaded
				return this.color
			},
			_title(){
				if(this.title=='' || this.title==undefined)
					if (this._color	!= undefined && this._color.name!=undefined) {
						return this._color.name.value
					}
				return this.title
			},
			_hex(){
				if(this._color!=undefined && this._color.hex!==undefined)
					return this._color.hex.value
			},
			_rgb(){
				if(this._color!=undefined && this._color.rgb!==undefined)
					return this._color.rgb.value
			},
			_cmyk(){
				if(this._color!=undefined && this._color.cmyk!==undefined)
					return this._color.cmyk.value
			},
			_id(){
				return 'color-'+this._uid
			},
			titlus(){
				switch(this.index){
					case 0: return this.translate("Primary Color"); break
					case 1: return this.translate("Secondary Color"); break
					case 2: return this.translate("Tertiary Color"); break
					default: return " "
				}
			}
		}
	}
</script>
<style lang="scss">
	@media screen and (max-width: 976px){
		.color_shades_button, .color_trash_button{
			z-index: 2;
			svg{
				width: 24px;
				height: 24px;
			}
		}
	}
	.color-input{
		text-align: right;
	    padding: 0;
	    border: 0;
	    outline: none;
	    cursor: pointer;

	    &:hover{
	    	background: #ccc;
	    }
	}
	.color-box{
		margin-right: 18px;
		cursor: move;
		user-select: none;

		.icons{
			display: flex;
			margin-bottom: 5px;
			button{
				display: flex;
				align-items: center;
				background: transparent;
				border: 0;
				&[disabled]{
					opacity: .5;
				}
			}
		}
		&.primary{
			cursor: default;
		}
		.title{
			font-style: normal;
			font-weight: 500;
			text-align: center;
			font-size: 16px;
			line-height: 150%;
			margin-bottom: 9px;
		}
		.widget{
			padding: 7px;
			background: #FFFFFF;
			box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.25);
			width: 170px;
			height: 180px;

			.depict{
				display: flex;
				flex-grow: 0;
				flex-shrink: 0;
				margin-bottom: 7px;

				.main-section{
					flex-basis: 100%;
					height: 80px;

					.icons{
						button{
							background: transparent;
							border: 0;
							padding: 2px;
							outline: none;
						}
					}
				}
				.additional-section{
					flex-basis: 50%;
					transition: all .5s;

					&.hid{
						flex-basis: 0;
					}
					.color{
						height: 20px;
						width: 100%;
					}
				}
			}
			.detext{
				.key-value{
					display: flex;
					justify-content: space-between;

					.key{
						font-style: normal;
						font-weight: normal;
						font-size: 10px;
						line-height: 20px;
						/* or 200% */


						color: #999999;
					}
					.value{
						font-family: Montserrat;
						font-style: normal;
						font-weight: normal;
						font-size: 12px;
						line-height: 20px;
						/* or 167% */

						text-align: right;

						color: #000000;

						input{
							width: 100% !important;
						}
					}
				}
			}
		}
	}
.grp-wrapper{background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAIAAADZF8uwAAAAGUlEQVQYV2M4gwH+YwCGIasIUwhT25BVBADtzYNYrHvv4gAAAABJRU5ErkJggg==")}.grp-preview{position:absolute;top:0;left:0;width:100%;height:100%;cursor:crosshair}.grp-handler{width:4px;margin-left:-2px;user-select:none;-webkit-user-select:none;-moz-user-select:none;height:100%}.grp-handler-close{color:rgba(0,0,0,0.4);border-radius:100%;box-shadow:0 2px 10px rgba(0,0,0,0.25);background-color:#fff;text-align:center;width:15px;height:15px;margin-left:-5px;line-height:10px;font-size:21px;cursor:pointer}.grp-handler-close-c{position:absolute;top:-17px}.grp-handler-drag{background-color:rgba(0,0,0,0.5);cursor:col-resize;width:100%;height:100%}.grp-handler-selected .grp-handler-drag{background-color:rgba(255,255,255,0.5)}.grp-handler-cp-c{display:none}.grp-handler-selected .grp-handler-cp-c{display:block}.grp-handler-cp-wrap{width:15px;height:15px;margin-left:-8px;border:3px solid #fff;box-shadow:0 2px 10px rgba(0,0,0,0.25);overflow:hidden;border-radius:100%;cursor:pointer}.grp-handler-cp-wrap input[type=color]{opacity:0;cursor:pointer}
.pickr{position:relative;overflow:visible;transform:translateY(0)}.pickr *{box-sizing:border-box;outline:none;border:none;-webkit-appearance:none}.pickr .pcr-button{position:relative;height:2em;width:2em;padding:0.5em;cursor:pointer;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI","Roboto","Helvetica Neue",Arial,sans-serif;border-radius:.15em;background:url('data:image/svg+xml;utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" stroke="%2342445A" stroke-width="5px" stroke-linecap="round"><path d="M45,45L5,5"></path><path d="M45,5L5,45"></path></svg>') no-repeat center;background-size:0;transition:all 0.3s}.pickr .pcr-button::before{position:absolute;content:'';top:0;left:0;width:100%;height:100%;background:url('data:image/svg+xml;utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2 2"><path fill="white" d="M1,0H2V1H1V0ZM0,1H1V2H0V1Z"/><path fill="gray" d="M0,0H1V1H0V0ZM1,1H2V2H1V1Z"/></svg>');background-size:.5em;border-radius:.15em;z-index:-1}.pickr .pcr-button::before{z-index:initial}.pickr .pcr-button::after{position:absolute;content:'';top:0;left:0;height:100%;width:100%;transition:background 0.3s;background:currentColor;border-radius:.15em}.pickr .pcr-button.clear{background-size:70%}.pickr .pcr-button.clear::before{opacity:0}.pickr .pcr-button.clear:focus{box-shadow:0 0 0 1px rgba(255,255,255,0.85),0 0 0 3px currentColor}.pickr .pcr-button.disabled{cursor:not-allowed}.pickr *,.pcr-app *{box-sizing:border-box;outline:none;border:none;-webkit-appearance:none}.pickr input:focus,.pickr input.pcr-active,.pickr button:focus,.pickr button.pcr-active,.pcr-app input:focus,.pcr-app input.pcr-active,.pcr-app button:focus,.pcr-app button.pcr-active{box-shadow:0 0 0 1px rgba(255,255,255,0.85),0 0 0 3px currentColor}.pickr .pcr-palette,.pickr .pcr-slider,.pcr-app .pcr-palette,.pcr-app .pcr-slider{transition:box-shadow 0.3s}.pickr .pcr-palette:focus,.pickr .pcr-slider:focus,.pcr-app .pcr-palette:focus,.pcr-app .pcr-slider:focus{box-shadow:0 0 0 1px rgba(255,255,255,0.85),0 0 0 3px rgba(0,0,0,0.25)}.pcr-app{position:fixed;display:flex;flex-direction:column;z-index:10000;border-radius:0.1em;background:#fff;opacity:0;visibility:hidden;transition:opacity 0.3s, visibility 0s 0.3s;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI","Roboto","Helvetica Neue",Arial,sans-serif;box-shadow:0 0.15em 1.5em 0 rgba(0,0,0,0.1),0 0 1em 0 rgba(0,0,0,0.03);left:0;top:0}.pcr-app.visible{transition:opacity 0.3s;visibility:visible;opacity:1}.pcr-app .pcr-swatches{display:flex;flex-wrap:wrap;margin-top:0.75em}.pcr-app .pcr-swatches.pcr-last{margin:0}@supports (display: grid){.pcr-app .pcr-swatches{display:grid;align-items:center;grid-template-columns:repeat(auto-fit, 1.75em)}}.pcr-app .pcr-swatches>button{font-size:1em;position:relative;width:calc(1.75em - 5px);height:calc(1.75em - 5px);border-radius:0.15em;cursor:pointer;margin:2.5px;flex-shrink:0;justify-self:center;transition:all 0.15s;overflow:hidden;background:transparent;z-index:1}.pcr-app .pcr-swatches>button::before{position:absolute;content:'';top:0;left:0;width:100%;height:100%;background:url('data:image/svg+xml;utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2 2"><path fill="white" d="M1,0H2V1H1V0ZM0,1H1V2H0V1Z"/><path fill="gray" d="M0,0H1V1H0V0ZM1,1H2V2H1V1Z"/></svg>');background-size:6px;border-radius:.15em;z-index:-1}.pcr-app .pcr-swatches>button::after{content:'';position:absolute;top:0;left:0;width:100%;height:100%;background:currentColor;border:1px solid rgba(0,0,0,0.05);border-radius:0.15em;box-sizing:border-box}.pcr-app .pcr-swatches>button:hover{filter:brightness(1.05)}.pcr-app .pcr-interaction{display:flex;flex-wrap:wrap;align-items:center;margin:0 -0.2em 0 -0.2em}.pcr-app .pcr-interaction>*{margin:0 0.2em}.pcr-app .pcr-interaction input{letter-spacing:0.07em;font-size:0.75em;text-align:center;cursor:pointer;color:#75797e;background:#f1f3f4;border-radius:.15em;transition:all 0.15s;padding:0.45em 0.5em;margin-top:0.75em}.pcr-app .pcr-interaction input:hover{filter:brightness(0.975)}.pcr-app .pcr-interaction input:focus{box-shadow:0 0 0 1px rgba(255,255,255,0.85),0 0 0 3px rgba(66,133,244,0.75)}.pcr-app .pcr-interaction .pcr-result{color:#75797e;text-align:left;flex:1 1 8em;min-width:8em;transition:all 0.2s;border-radius:.15em;background:#f1f3f4;cursor:text}.pcr-app .pcr-interaction .pcr-result::selection{background:#4285f4;color:#fff}.pcr-app .pcr-interaction .pcr-type.active{color:#fff;background:#4285f4}.pcr-app .pcr-interaction .pcr-save,.pcr-app .pcr-interaction .pcr-cancel,.pcr-app .pcr-interaction .pcr-clear{color:#fff;width:auto}.pcr-app .pcr-interaction .pcr-save,.pcr-app .pcr-interaction .pcr-cancel,.pcr-app .pcr-interaction .pcr-clear{color:#fff}.pcr-app .pcr-interaction .pcr-save:hover,.pcr-app .pcr-interaction .pcr-cancel:hover,.pcr-app .pcr-interaction .pcr-clear:hover{filter:brightness(0.925)}.pcr-app .pcr-interaction .pcr-save{background:#4285f4}.pcr-app .pcr-interaction .pcr-clear,.pcr-app .pcr-interaction .pcr-cancel{background:#f44250}.pcr-app .pcr-interaction .pcr-clear:focus,.pcr-app .pcr-interaction .pcr-cancel:focus{box-shadow:0 0 0 1px rgba(255,255,255,0.85),0 0 0 3px rgba(244,66,80,0.75)}.pcr-app .pcr-selection .pcr-picker{position:absolute;height:18px;width:18px;border:2px solid #fff;border-radius:100%;user-select:none}.pcr-app .pcr-selection .pcr-color-palette,.pcr-app .pcr-selection .pcr-color-chooser,.pcr-app .pcr-selection .pcr-color-opacity{position:relative;user-select:none;display:flex;flex-direction:column;cursor:grab;cursor:-moz-grab;cursor:-webkit-grab}.pcr-app .pcr-selection .pcr-color-palette:active,.pcr-app .pcr-selection .pcr-color-chooser:active,.pcr-app .pcr-selection .pcr-color-opacity:active{cursor:grabbing;cursor:-moz-grabbing;cursor:-webkit-grabbing}.pcr-app[data-theme='nano']{width:14.25em;max-width:95vw}.pcr-app[data-theme='nano'] .pcr-swatches{margin-top:.6em;padding:0 .6em}.pcr-app[data-theme='nano'] .pcr-interaction{padding:0 .6em .6em .6em}.pcr-app[data-theme='nano'] .pcr-selection{display:grid;grid-gap:.6em;grid-template-columns:1fr 4fr;grid-template-rows:5fr auto auto;align-items:center;height:10.5em;width:100%;align-self:flex-start}.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-preview{grid-area:2 / 1 / 4 / 1;height:100%;width:100%;display:flex;flex-direction:row;justify-content:center;margin-left:.6em}.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-preview .pcr-last-color{display:none}.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-preview .pcr-current-color{position:relative;background:currentColor;width:2em;height:2em;border-radius:50em;overflow:hidden}.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-preview .pcr-current-color::before{position:absolute;content:'';top:0;left:0;width:100%;height:100%;background:url('data:image/svg+xml;utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2 2"><path fill="white" d="M1,0H2V1H1V0ZM0,1H1V2H0V1Z"/><path fill="gray" d="M0,0H1V1H0V0ZM1,1H2V2H1V1Z"/></svg>');background-size:.5em;border-radius:.15em;z-index:-1}.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-palette{grid-area:1 / 1 / 2 / 3;width:100%;height:100%;z-index:1}.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-palette .pcr-palette{border-radius:.15em;width:100%;height:100%}.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-palette .pcr-palette::before{position:absolute;content:'';top:0;left:0;width:100%;height:100%;background:url('data:image/svg+xml;utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2 2"><path fill="white" d="M1,0H2V1H1V0ZM0,1H1V2H0V1Z"/><path fill="gray" d="M0,0H1V1H0V0ZM1,1H2V2H1V1Z"/></svg>');background-size:.5em;border-radius:.15em;z-index:-1}.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-chooser{grid-area:2 / 2 / 2 / 2}.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-opacity{grid-area:3 / 2 / 3 / 2}.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-chooser,.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-opacity{height:0.5em;margin:0 .6em}.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-chooser .pcr-picker,.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-opacity .pcr-picker{top:50%;transform:translateY(-50%)}.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-chooser .pcr-slider,.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-opacity .pcr-slider{flex-grow:1;border-radius:50em}.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-chooser .pcr-slider{background:linear-gradient(to right, red, #ff0, lime, cyan, blue, #f0f, red)}.pcr-app[data-theme='nano'] .pcr-selection .pcr-color-opacity .pcr-slider{background:linear-gradient(to right, transparent, black),url('data:image/svg+xml;utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2 2"><path fill="white" d="M1,0H2V1H1V0ZM0,1H1V2H0V1Z"/><path fill="gray" d="M0,0H1V1H0V0ZM1,1H2V2H1V1Z"/></svg>');background-size:100%, 0.25em}.pcr-app.pcr-app{box-shadow:none}.pcr-app.pcr-app .pcr-selection .pcr-picker{height:18px;width:18px}.pcr-app.pcr-app .pcr-selection .pcr-color-preview{margin-left:0}.pcr-app.pcr-app .pcr-selection .pcr-color-preview .pcr-current-color{border-radius:0.15em;width:100%}.pcr-app.pcr-app .pcr-selection .pcr-color-chooser,.pcr-app.pcr-app .pcr-selection .pcr-color-opacity{margin-left:0}.pcr-app.pcr-app .pcr-interaction{padding:0;margin-bottom:0}.gpickr{flex-direction:row;display:inline-flex;box-shadow:0 0.15em 1.5em 0 rgba(0,0,0,0.1),0 0 1em 0 rgba(0,0,0,0.03);border-radius:0.15em;overflow:hidden;padding:0.5em;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI","Roboto","Helvetica Neue",Arial,sans-serif;user-select:none;max-width:100vw}.gpickr *{box-sizing:border-box;margin:0;padding:0}.gpickr button{border:none;outline:none;background:initial;cursor:pointer}.gpickr .gpcr-interaction{flex-direction:column;display:flex;margin-left:0.5em;width:12.5em;z-index:1}.gpickr .gpcr-interaction .gpcr-result{height:7.9em;width:100%;position:relative;border-radius:0.15em;margin-bottom:0.5em;flex-grow:1}.gpickr .gpcr-interaction .gpcr-result::before{position:absolute;content:'';top:0;left:0;width:100%;height:100%;background:url('data:image/svg+xml;utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2 2"><path fill="white" d="M1,0H2V1H1V0ZM0,1H1V2H0V1Z"/><path fill="gray" d="M0,0H1V1H0V0ZM1,1H2V2H1V1Z"/></svg>');background-size:8px;border-radius:.15em;z-index:-1}.gpickr .gpcr-interaction .gpcr-result .gpcr-pos,.gpickr .gpcr-interaction .gpcr-result .gpcr-angle{top:0;right:0;bottom:0;left:0;transition:all 0.3s;position:absolute;margin:auto;opacity:0.25}.gpickr .gpcr-interaction .gpcr-result .gpcr-angle{height:.35em;width:.35em;background:white;border-radius:100%}.gpickr .gpcr-interaction .gpcr-result .gpcr-angle>div{height:2px;width:2em;top:0;right:0;bottom:0;left:50%;position:absolute;background:white;border-radius:1em;margin:auto 0;transform-origin:left}.gpickr .gpcr-interaction .gpcr-result .gpcr-angle.gpcr-active{opacity:1}.gpickr .gpcr-interaction .gpcr-result .gpcr-pos{height:5em;width:5em;display:grid;grid-template-columns:1fr 1fr 1fr;grid-template-rows:1fr 1fr 1fr;opacity:1}.gpickr .gpcr-interaction .gpcr-result .gpcr-pos>div{height:15px;width:15px;border:2px solid transparent;position:relative;margin:auto;transition:all 0.3s}.gpickr .gpcr-interaction .gpcr-result .gpcr-pos>div:not(.gpcr-active){cursor:pointer}.gpickr .gpcr-interaction .gpcr-result .gpcr-pos>div::before{position:absolute;content:"";top:0;right:0;bottom:0;left:0;height:5px;width:5px;border-radius:100%;background:white;transition:all 0.3s;opacity:0.25;margin:auto}.gpickr .gpcr-interaction .gpcr-result .gpcr-pos>div:hover::before{opacity:1}.gpickr .gpcr-interaction .gpcr-result .gpcr-pos>div.gpcr-active{border-color:white;border-radius:100%}.gpickr .gpcr-interaction .gpcr-result .gpcr-pos>div.gpcr-active::before{opacity:1}.gpickr .gpcr-interaction .gpcr-result:hover .gpcr-angle{opacity:1}.gpickr .gpcr-interaction .gpcr-mode{height:1.5em;width:1.5em;position:relative;top:0.15em;left:0.15em;border:2px solid white;border-radius:0.15em;cursor:pointer;opacity:0.25;transition:all 0.3s}.gpickr .gpcr-interaction .gpcr-mode::before{position:absolute;content:"";top:0;right:0;bottom:0;left:0;margin:auto;transition:all 0.3s}.gpickr .gpcr-interaction .gpcr-mode[data-mode=linear]::before{height:2px;width:70%;background:white;transform:rotate(45deg);border-radius:50em}.gpickr .gpcr-interaction .gpcr-mode[data-mode=radial]::before{height:50%;width:50%;border-radius:100%;border:2px solid white}.gpickr .gpcr-interaction .gpcr-mode[data-mode=conic]::before{height:0;width:0;border:5px solid transparent;border-color:white white transparent transparent}.gpickr .gpcr-interaction .gpcr-mode:hover{opacity:1}.gpickr .gpcr-stops{margin-bottom:0.75em}.gpickr .gpcr-stops .gpcr-stop-preview{height:2em;width:100%;position:relative;border-radius:0.15em;overflow:hidden;cursor:pointer}.gpickr .gpcr-stops .gpcr-stop-preview::before{position:absolute;content:'';top:0;left:0;width:100%;height:100%;background:url('data:image/svg+xml;utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2 2"><path fill="white" d="M1,0H2V1H1V0ZM0,1H1V2H0V1Z"/><path fill="gray" d="M0,0H1V1H0V0ZM1,1H2V2H1V1Z"/></svg>');background-size:8px;border-radius:.15em;z-index:-1}.gpickr .gpcr-stops .gpcr-stop-marker{position:relative;z-index:1}.gpickr .gpcr-stops .gpcr-stop-marker .gpcr-marker{height:12px;width:12px;position:absolute;background:currentColor;margin:0.15em 0 0 -5px;border-radius:100%;border:2px solid white;box-shadow:0 0.05em 0.2em rgba(0,0,0,0.15);transition:opacity 0.15s;cursor:grab;cursor:webkit-grab}.gpickr .gpcr-stops .gpcr-stop-marker .gpcr-marker::before{position:absolute;content:'';top:0;left:0;width:100%;height:100%;background:url('data:image/svg+xml;utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2 2"><path fill="white" d="M1,0H2V1H1V0ZM0,1H1V2H0V1Z"/><path fill="gray" d="M0,0H1V1H0V0ZM1,1H2V2H1V1Z"/></svg>');background-size:4px;border-radius:.15em;z-index:-1}.gpickr .gpcr-stops .gpcr-stop-marker .gpcr-marker::before{border-radius:100%}
	.gradient-picker{
		position: absolute;
		z-index: 123123;
		background: #fff;
	}
</style>

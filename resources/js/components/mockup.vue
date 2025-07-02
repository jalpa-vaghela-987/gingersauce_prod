<template>
	<div class="core-value mockup mobile-steps-mockup" :data-index="index">
		<div class="img-title">
			<div :class="['img', image!=''?'uploaded':'']" @mouseover="show_remover=true" @mouseleave="show_remover=false">
                <div class="format" v-if="!misuse_uploaded">
                    <svg width="33" height="25" viewBox="0 0 33 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.975 0.6875H14.025C13.1139 0.6875 12.375 1.44318 12.375 2.375V7.4375C12.375 8.36932 13.1139 9.125 14.025 9.125H18.975C19.8861 9.125 20.625 8.36932 20.625 7.4375V2.375C20.625 1.44318 19.8861 0.6875 18.975 0.6875ZM10.725 3.64062H6.35508C5.86523 2.40453 4.68394 1.53125 3.3 1.53125C1.47778 1.53125 0 3.04209 0 4.90625C0 6.77041 1.47778 8.28125 3.3 8.28125C4.68394 8.28125 5.86523 7.40797 6.35508 6.17188H10.4662C7.61114 7.8868 5.52338 10.7766 4.818 14.1875H7.36519C7.94784 11.9932 9.26114 10.1159 11.0282 8.8318C10.8374 8.4057 10.725 7.93584 10.725 7.4375V3.64062ZM8.25 15.875H3.3C2.38889 15.875 1.65 16.6307 1.65 17.5625V22.625C1.65 23.5568 2.38889 24.3125 3.3 24.3125H8.25C9.16111 24.3125 9.9 23.5568 9.9 22.625V17.5625C9.9 16.6307 9.16111 15.875 8.25 15.875ZM29.7 1.53125C28.3161 1.53125 27.1348 2.40453 26.6449 3.64062H22.275V7.4375C22.275 7.93584 22.1621 8.4057 21.9718 8.8318C23.7389 10.1159 25.0522 11.9932 25.6348 14.1875H28.182C27.4766 10.7766 25.3889 7.8868 22.5338 6.17188H26.6449C27.1348 7.40797 28.3161 8.28125 29.7 8.28125C31.5222 8.28125 33 6.77041 33 4.90625C33 3.04209 31.5222 1.53125 29.7 1.53125ZM29.7 15.875H24.75C23.8389 15.875 23.1 16.6307 23.1 17.5625V22.625C23.1 23.5568 23.8389 24.3125 24.75 24.3125H29.7C30.6111 24.3125 31.35 23.5568 31.35 22.625V17.5625C31.35 16.6307 30.6111 15.875 29.7 15.875Z" fill="#C7C7C7" fill-opacity="0.85"/>
                    </svg>
                    <div class="text">
                        <b>{{ translate('Raster image') }}</b>
                        <div>{{ translate('JPG or PNG') }}</div>
                    </div>
                </div>
                <button class="btn upload-mobile-btn"  :style="{'background': background}">
                    {{ translate('Upload image') }}
                </button>
				<file-upload v-if="image==''" :input-id="id" class="upload-link-icon" accept="image/png,image/jpeg" extensions="png,jpg,jpeg"  :post-action="upload_icon_endpoint" :multiple=false @input-file="input_file" :drop=true :drop-directory=false v-model="icon_file" auto :ref="id" :headers="headers"></file-upload>
				<div class="hover-remover" v-if="show_remover && image!=''" @click="removeIcon">
                    <svg width="15" height="17" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.16254 13.8857H9.92946C10.0312 13.8857 10.1287 13.8462 10.2006 13.7759C10.2725 13.7056 10.3129 13.6102 10.3129 13.5107V6.76074C10.3129 6.66129 10.2725 6.5659 10.2006 6.49558C10.1287 6.42525 10.0312 6.38574 9.92946 6.38574H9.16254C9.06084 6.38574 8.96331 6.42525 8.8914 6.49558C8.81948 6.5659 8.77908 6.66129 8.77908 6.76074V13.5107C8.77908 13.6102 8.81948 13.7056 8.8914 13.7759C8.96331 13.8462 9.06084 13.8857 9.16254 13.8857ZM14.4031 3.38574H11.7697L10.6833 1.61387C10.5469 1.39168 10.354 1.20783 10.1234 1.08023C9.89282 0.952624 9.63234 0.885619 9.36737 0.885742H6.14568C5.88082 0.885727 5.62047 0.952783 5.38998 1.08038C5.15949 1.20798 4.96671 1.39178 4.83042 1.61387L3.74331 3.38574H1.10991C0.974312 3.38574 0.844266 3.43842 0.748383 3.53219C0.652499 3.62596 0.598633 3.75313 0.598633 3.88574L0.598633 4.38574C0.598633 4.51835 0.652499 4.64553 0.748383 4.7393C0.844266 4.83306 0.974312 4.88574 1.10991 4.88574H1.62119V15.3857C1.62119 15.7836 1.78279 16.1651 2.07044 16.4464C2.35809 16.7277 2.74823 16.8857 3.15502 16.8857H12.358C12.7648 16.8857 13.155 16.7277 13.4426 16.4464C13.7303 16.1651 13.8919 15.7836 13.8919 15.3857V4.88574H14.4031C14.5387 4.88574 14.6688 4.83306 14.7647 4.7393C14.8606 4.64553 14.9144 4.51835 14.9144 4.38574V3.88574C14.9144 3.75313 14.8606 3.62596 14.7647 3.53219C14.6688 3.43842 14.5387 3.38574 14.4031 3.38574ZM6.08976 2.47668C6.10685 2.44886 6.13103 2.42586 6.15993 2.40992C6.18883 2.39398 6.22147 2.38565 6.25465 2.38574H9.25841C9.29153 2.38571 9.32411 2.39406 9.35295 2.41C9.38179 2.42594 9.40591 2.44891 9.42297 2.47668L9.98091 3.38574H5.53215L6.08976 2.47668ZM12.358 15.3857H3.15502V4.88574H12.358V15.3857ZM5.5836 13.8857H6.35051C6.45221 13.8857 6.54975 13.8462 6.62166 13.7759C6.69357 13.7056 6.73397 13.6102 6.73397 13.5107V6.76074C6.73397 6.66129 6.69357 6.5659 6.62166 6.49558C6.54975 6.42525 6.45221 6.38574 6.35051 6.38574H5.5836C5.4819 6.38574 5.38436 6.42525 5.31245 6.49558C5.24054 6.5659 5.20014 6.66129 5.20014 6.76074V13.5107C5.20014 13.6102 5.24054 13.7056 5.31245 13.7759C5.38436 13.8462 5.4819 13.8857 5.5836 13.8857Z" fill="white"/></svg>
                </div>
				<img :src="img_src" alt="">
				<svg v-if="image==''" class="position-absolute" width="44" height="34" viewBox="0 0 44 34" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M39.875 0.268555H4.125C1.8468 0.268555 0 2.11535 0 4.39355V29.1436C0 31.4218 1.8468 33.2686 4.125 33.2686H39.875C42.1532 33.2686 44 31.4218 44 29.1436V4.39355C44 2.11535 42.1532 0.268555 39.875 0.268555ZM39.3594 29.1436H4.64062C4.50387 29.1436 4.37272 29.0892 4.27602 28.9925C4.17932 28.8958 4.125 28.7647 4.125 28.6279V4.90918C4.125 4.77243 4.17932 4.64128 4.27602 4.54458C4.37272 4.44788 4.50387 4.39355 4.64062 4.39355H39.3594C39.4961 4.39355 39.6273 4.44788 39.724 4.54458C39.8207 4.64128 39.875 4.77243 39.875 4.90918V28.6279C39.875 28.7647 39.8207 28.8958 39.724 28.9925C39.6273 29.0892 39.4961 29.1436 39.3594 29.1436ZM11 7.83105C9.10155 7.83105 7.5625 9.37011 7.5625 11.2686C7.5625 13.167 9.10155 14.7061 11 14.7061C12.8984 14.7061 14.4375 13.167 14.4375 11.2686C14.4375 9.37011 12.8984 7.83105 11 7.83105ZM8.25 25.0186H35.75V18.1436L28.2292 10.6227C27.8265 10.22 27.1735 10.22 26.7707 10.6227L16.5 20.8936L13.1042 17.4977C12.7015 17.095 12.0485 17.095 11.6457 17.4977L8.25 20.8936V25.0186Z" fill="white"/>
				</svg>

			</div>
			<div class="title">
				<textarea v-model="title" class="textarea-style" :placeholder="translate('Add Title')"></textarea>
			</div>
		</div>
	</div>
</template>
<script>
	import translate from "../utils/translate";
	import FileUpload from 'vue-upload-component'
	export default {
		components: {
			FileUpload
		},
		props:{
			'index': Number,
			'coredata': Object,
            'background'        : String
		},
		data(){
			return {
				image: '',
				title: '',
				description: '',
				url: '',
				id: '',
				icon_file: [],

				show_remover: false
			}
		},
		computed:{
			headers(){
				return {
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
				}
			},
			upload_icon_endpoint(){
				return endpoints.ajax.post.upload_mockup
			},
			img_src(){
				if(this.image.length>0)
					return this.image
				return ''
				//'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEYAAABGCAAAAABURb1YAAABBklEQVRYw+3WbWvCMBSGYf//n5uaWmwFQXG2lcFmlURh5vZDYUst5sUWNjHP18JFz8nbGeWDZJS/DZDIRCYykfkzJt2UlTPlJrUzFZ6pbMwa76wsjPJnpIXRQP3hTA1oCwMwcy/MDODpmMnufN5NejM1QN2XyZs1NT9NV9NgZt3ZYUIiRe+/ERIMx7c3e4B9WzEcX2ZcKFWMb5Rf56F9k5x+DtIpeZgxFFBJIDMvRLsioy5/JvtGia4CXyHM4tJ0olURAIcAZnFpOpp1lCDmcP/We3kmze4mfdq7uCejgeOnM0fHcyeHeXwDRoGlbTAptR+it64x6d0jrjEpTqKRiUxk/j8zSK4n2iPF2KVx2QAAAABJRU5ErkJggg=='
			}
		},
		mounted(){
			this.id = "i"+this._uid
			if(!this.isEmpty(this.coredata)){
				this.image = this.coredata.image
				this.title = this.coredata.title
				this.url = this.coredata.url
				this.description = this.coredata.description
			}
		},
		watch:{
			title(){
				this.send_event()
			},
			description(){
				this.send_event()
			}
		},
		methods:{
			translate,
			removeIcon(){
				this.image = ''
				this.url = ''
				this.icon_file = []
			},
			translate(str){
				return str
			},
			isEmpty(obj) {
			    for(var key in obj) {
			        if(obj.hasOwnProperty(key))
			            return false;
			    }
			    return true;
			},
			send_event(){
				this.$root.$emit('mockup_changed', {
					index: this.index,
					image: this.image,
					url: this.url,
					title: this.title,
				})
			},
			input_file(newFile, oldFile){

				if (newFile && !oldFile) {
			        // Add file
			        this.$refs[this.id].active = true
			        this.upload_progress = 1
			        if(newFile.size>3000000 && newFile!=oldFile){
			        	this.upload_progress = 0
			        	new Noty({
			        		type: 'error',
						    text: this.translate('Your file is more then 3Mb size. Please try another file.'),
						    timeout: 5000,
						}).show();
						this.$refs[this.id].active = false
						return;
			        }
			      }

			      if (newFile && oldFile) {
			        // Update file

			        // Start upload
			        if(newFile.size>3000000 && newFile!=oldFile){
			        	this.upload_progress = 0
			        	new Noty({
			        		type: 'error',
						    text: this.translate('Your file is more then 3Mb size. Please try another file.'),
						    timeout: 5000,
						}).show();
						this.$refs[this.id].active = false
						return;
			        }
			        // Upload progress
			        if (newFile.progress !== oldFile.progress) {
			        	this.upload_progress = newFile.progress - 30
			        }
			        // Upload error
			        if (newFile.error !== oldFile.error) {
			        	var message = ''
			        	switch(newFile.error){
			        		case 'extension':
			        			message = this.translate('We support only SVG files. Please select SVG file and try again.')
			        			break;

			        		default:
			        			message = newFile.error;
			        			break;
			        	}
			        	new Noty({
			        		type: 'error',
						    text: message,
						    timeout: 5000,
						}).show();
						this.upload_progress = 0
			        }

			        // Uploaded successfully
			        if (newFile.success !== oldFile.success) {
			        	this.image = newFile.response.image
			        	this.url = newFile.response.url
			        	this.send_event()
			        }
			      }

			      // Automatic upload
			      if (Boolean(newFile) !== Boolean(oldFile) || oldFile.error !== newFile.error) {
			        if (!this.$refs[this.id].active) {
			        	this.upload_progress = 1
			          this.$refs[this.id].active = true
			        }
			      }
			},
		}

	}
</script>
<style lang=scss>
	.hover-remover{
		position: absolute;
		left: 0;
		top: 0;
		bottom: 0;
		right: 0;
		display: flex;
		justify-content: center;
		align-items: center;
		background: rgba(0,0,0,.4);
	}
	.core-value.mockup{
		flex-basis: 100%;
		width: 100%;
		margin-bottom: 17px;

		.img-title{
			display: flex;

			.img{
				width: 204px;
				height: 124px;
				flex-basis: 204px;
				flex-shrink: 0;
				position: relative;
				overflow: hidden;
				display: flex;
				align-items: center;
				justify-content: center;
				background: #CFCFCF;

				&.uploaded{
					background: #fff;
				}
				&:hover{
					box-shadow: 0 0 5px rgba(0,0,0,.2);
				}

				img{
					max-height: 100%;
					max-width: 100%;
					display: block;
					margin: 0 auto;
				}

				.upload-link-icon{
					position: absolute;
				    z-index: 2;
				    left: 0;
				    right: 0;
				    text-align: 0;
				    bottom: 0;
				    top: 0;
				}
			}
			.title{
				flex-basis: 100%;
				box-sizing: border-box;
				padding-left: 3px;
			}
		}
		.textarea-style{
			background: #FFFFFF;
			border: 1px solid #DADADA;
			width: 100%;
			height: 124px;
			box-sizing: border-box;

			&.desc{
				margin-left: 0;
				height: 115px;
				margin-top: -4px;
			}
		}
	}
</style>

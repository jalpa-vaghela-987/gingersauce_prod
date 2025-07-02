<template>
	<div class="image-upload-component">
		<div class="preview">
			<div :class="['image']">
				<img  v-if="image" :src="image" alt="" :class="image_class_name">
			</div>
		</div>
		<div class="uploader" v-if="!view_new">
			<div class="d-flex">
				<div class="btn btn-warning btn-sm mr-1 text-white font-weight-bold">{{button_text}}</div>
				<file-upload :input-id=the_ref class="upload-link" :accept="upload_accept" :extensions="upload_extension" :post-action="upload_endpoint" :multiple=false @input-file="input_file" :drop=true :drop-directory=false v-model="file" auto :ref="the_ref" :headers="headers"><div class="btn btn-muted btn-sm">{{choose_file_text}}</div></file-upload>
			</div>
			<div class="description small" v-html=description_text></div>
		</div>
		<div class="uploader other" v-else>
			<div class="d-block">
				<file-upload :input-id=the_ref class="upload-link" :accept="upload_accept" :extensions="upload_extension" :post-action="upload_endpoint" :multiple=false @input-file="input_file" :drop=true :drop-directory=false v-model="file" auto :ref="the_ref" :headers="headers"><div class="btn btn-muted btn-sm"><span>{{choose_file_text}}</span><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0 6.75V20.25C0 21.4922 1.00781 22.5 2.25 22.5H21.75C22.9922 22.5 24 21.4922 24 20.25V6.75C24 5.50781 22.9922 4.5 21.75 4.5H17.625L17.0484 2.95781C16.7203 2.08125 15.8813 1.5 14.9438 1.5H9.06094C8.12344 1.5 7.28437 2.08125 6.95625 2.95781L6.375 4.5H2.25C1.00781 4.5 0 5.50781 0 6.75ZM6.375 13.5C6.375 10.3969 8.89688 7.875 12 7.875C15.1031 7.875 17.625 10.3969 17.625 13.5C17.625 16.6031 15.1031 19.125 12 19.125C8.89688 19.125 6.375 16.6031 6.375 13.5ZM7.875 13.5C7.875 15.7734 9.72656 17.625 12 17.625C14.2734 17.625 16.125 15.7734 16.125 13.5C16.125 11.2266 14.2734 9.375 12 9.375C9.72656 9.375 7.875 11.2266 7.875 13.5Z" fill="white"/>
</svg>
</div></file-upload>
				<div class="description small my-2" v-html=description_text></div>
				<div class="btn btn-warning btn-sm mr-1 text-white font-weight-bold">{{button_text}}</div>
			</div>
		</div>
	</div>
</template>
<script>
	import FileUpload from 'vue-upload-component'
	export default {
		props: {
			image_class_name: String,
			button_text: String,
			choose_file_text: String, upload_endpoint: String,
			upload_accept: String,
			upload_extension: String,
			description_text: String,
			default_image: String,
			max_size: String,
			supported_error: String,
			view_new: {
				type: Boolean,
				default: false,
			}
		},
		components: {
			FileUpload
		},
		data(){
			return {
				file: [],
				file_uploaded: '',
				image_src: false,
			}
		},
		computed: {
			image(){
				if(this.image_src!==false)
					return this.image_src
				else
					return this.default_image
			},
			the_ref(){
				return 'iu'+this._uid
			},
			headers(){
				return {
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
				}
			},
		},
		methods: {
			input_file(newFile, oldFile){

				if (newFile && !oldFile) {
			        // Add file
			        this.$refs[this.the_ref].active = true
			        this.upload_progress = 1
			        if(newFile.size>this.max_size*1000 && newFile!=oldFile){
			        	this.upload_progress = 0
			        	new Noty({
			        		type: 'error',
						    text: this.translate('Your file is more then 1Mb size. Please try another file.'),
						    timeout: 5000,
						}).show();
						this.$refs[this.the_ref].active = false
						return;
			        }
			      }

			      if (newFile && oldFile) {
			        // Update file

			        // Start upload
			        if(newFile.size>1000*this.max_size && newFile!=oldFile){
			        	this.upload_progress = 0
			        	new Noty({
			        		type: 'error',
						    text: this.translate('Your file is more then :max_sizeKb size. Please try another file.').replace(':max_size', this.max_size),
						    timeout: 5000,
						}).show();
						this.$refs[this.the_ref].active = false
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
			        			message = this.supported_error
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
			        	this.upload_progress = 100
			        	this.image_src = newFile.response.file

			        	if(newFile.response.avatar == true)
			        		document.querySelector('.avatar').src = this.image_src
			        	// this.font_file_uploaded = newFile.response.font
			        }
			      }

			      // Automatic upload
			      if (Boolean(newFile) !== Boolean(oldFile) || oldFile.error !== newFile.error) {
			        if (!this.$refs[this.the_ref].active) {
			        	this.upload_progress = 1
			          this.$refs[this.the_ref].active = true
			        }
			      }
			},
		}
	}
</script>

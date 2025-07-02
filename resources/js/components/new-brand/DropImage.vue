<template>
    <div class="drop-wrapper is-invalid">
        <form class="row col-12 p-0 m-0">
            <label class="drop-area" :class="file ? 'full' : ''" ref="dropArea">
        <span class="icon-circle">
          <svg class="icon icon-imagesmode" width="30" height="30">
            <use href="/src/assets/icons/symbol-defs.svg#icon-imagesmode"></use>
          </svg>
        </span>
                <input
                    :disabled="disabled"
                    type="file"
                    class="fileElem d-none"
                    id="fileElem"
                    ref="uploadedFile"
                    :accept="typeF"
                />
                <span class="gallery">
          <img :src="file" data-url="" />
        </span>
            </label>
            <div v-if="file" class="icons-options">
                <a href="#" :disabled="disabled" @click="upload">
                    <svg class="icon icon-upload" width="24" height="24">
                        <use xlink:href="../../src/assets/img/icons.svg#icon-upload"></use>
                    </svg>
                </a>
                <a
                    id="deleteImage"
                    @keydown="$emit('keydown', $event)"
                    href="#"
                    :data-bs-target="`#${modalId}`"
                    :data-bs-toggle="!disabled ? 'modal' : ''"
                    data-bs-dismiss="modal"
                >
                    <svg class="icon icon-delete" width="24" height="24">
                        <use xlink:href="../../src/assets/img/icons.svg#icon-delete"></use>
                    </svg>
                </a>
            </div>
        </form>

        <div class="modal fade" :id="modalId" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content deleteModalContent">
                    <div class="modal-body row">
                        <div class="row col-12 p-0 mt-0 mx-0 d-flex align-items-center mb-32">
                            <h5 class="col fw-bold m-0">Delete {{ nameM }}</h5>
                            <button
                                type="button"
                                class="rounded btn-close opacity-1 align-top align-self-start ms-auto col-auto me-2"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <form class="row col-12 p-0 m-0">
                            <div class="col-12 d-flex justify-content-end gap-4">
                                <button
                                    type="button"
                                    class="btn main-btn d-block fs-20 px-3 col sec-btn h-44"
                                    data-bs-dismiss="modal"
                                >
                                    Cancel
                                </button>
                                <button class="main-btn col fs-20 h-44" href="#" @click="deleteImg">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        name: 'DropImage',
        props: ['typeF', 'modalId', 'nameM', 'file', 'disabled'],
        data() {
            return {
                dragImage: null,
                currentUpload: null,
            };
        },
        mounted() {
            const dropArea = this.$refs.dropArea;
            this.dragsDocument(dropArea);
        },
        computed: {
            ...mapGetters(['user']),
        },
        methods: {
            dragsDocument(element) {
                const selfImage = this;
                const dropArea = element;
                // Prevent default drag behaviors
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, preventDefaults, false);
                    document.body.addEventListener(eventName, preventDefaults, false);
                });
                // Highlight drop area when item is dragged over it
                ['dragenter', 'dragover', 'mouseover'].forEach(eventName => {
                    dropArea.addEventListener(eventName, highlight, false);
                });
                ['dragleave', 'drop', 'mouseout'].forEach(eventName => {
                    dropArea.addEventListener(eventName, unhighlight, false);
                });
                // Handle dropped files
                dropArea.addEventListener('drop', handleDrop, false);
                element.getElementsByClassName('fileElem')[0].addEventListener('change', handleFiles, false);
                let url;

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                function highlight(e) {
                    dropArea.classList.add('highlight');
                }

                function unhighlight(e) {
                    dropArea.classList.remove('highlight');
                }

                function handleFiles(files) {
                    if (files.target) {
                        files = files.target.files;
                    }
                    files = [...files];
                    files.forEach(uploadFile);
                }

                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    handleFiles(files);
                }

                function previewFile(file, url) {
                    if (file.type.startsWith('image')) {
                        selfImage.uploadFile(file, 'image');
                        const reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onloadend = function () {
                            const img = document.createElement('img');
                            img.src = reader.result;
                            dropArea.classList.add('full');
                            element.querySelector(
                                '.gallery'
                            ).innerHTML = `<img src="${img.src}" data-url="${url}">`;
                        };
                    } else if (file.type.startsWith('video')) {
                        selfImage.uploadFile(file, 'video');
                        dropArea.classList.add('full');
                        let blobURL = URL.createObjectURL(file);
                        element.querySelector('.gallery').innerHTML = `
                  <video  src='${blobURL}' controls >
                    Your browser does not support the video tag.
                  </video>`;
                    }
                }

                function uploadFile(file, i) {
                    let maxSize;
                    let size = 0;
                    if (file.type.startsWith('image')) {
                        maxSize = 10 * 1024 * 1024;
                        size = 10;
                    } else if (file.type.startsWith('video')) {
                        maxSize = 20 * 1024 * 1024;
                        size = 20;
                    } else {
                        return;
                    }

                    if (file.size <= maxSize) {
                        previewFile(file);
                    } else {
                        alert('File size exceeds the maximum limit. File Must be less than ' + size + ' Mb');
                    }
                }
            },

            upload: function (event) {
                event.preventDefault();
                event.target.closest('.drop-wrapper').querySelector('.drop-area').click();
            },
            deleteImg: function (event) {
                event.preventDefault();
                event.target.closest('.modal').querySelector('.btn-close').click();
                let wrapper = event.target.closest('.drop-wrapper');
                wrapper.querySelector('.drop-area').classList.toggle('full');
                wrapper.querySelector('img, video').remove();
                wrapper.querySelector('input').value = '';
                this.onFileChange();
            },
            onFileChange() {
                let file = this.$refs.uploadedFile.files.item(0);
                this.$emit('image-selected', file);
                this.$emit('video-selected', file);
            },
            deleteAllFiles() {
                _.map(document.querySelectorAll('.drop-area.full'), i => {
                    i.classList.remove('full');
                    i.querySelector('img, video').remove();
                    i.querySelector('input').value = '';
                });
            },
            previewFile(type, data) {
                if (type == 'image' && data && data.path) {
                    const url = data.path;
                    let dropArea = document.querySelector('.project-image .drop-area');
                    dropArea.classList.add('full');
                    dropArea.querySelector('.gallery').innerHTML = `<img src="${url}" data-url="${url}">`;
                } else if (type == 'video' && data && data.path) {
                    const url = data.path;
                    let dropArea = document.querySelector('.project-video .drop-area');
                    dropArea.classList.add('full');
                    dropArea.querySelector('.gallery').innerHTML = `
                      <video  src='${url}' controls >
                        Your browser does not support the video tag.
                      </video>`;
                }
            },
            async uploadFile(file, type) {
                //   this.$emit('loader', true);
                //   this.currentUpload = type;
                //   try {
                //     const formData = new FormData();
                //     formData.append('document', file);
                //     const headers = {
                //       Authorization: `Bearer ${this.user.token}`,
                //       'Content-Type': 'multipart/form-data',
                //     };
                //     const response = await axios.post(process.env.VUE_APP_API_URL + '/upload', formData, {
                //       headers,
                //     });
                //     const { data } = response.data;
                //     if (!_.isArray(data)) {
                //       if (data && data.path) {
                //         if (type == 'image') {
                //           this.$emit('image-selected', data);
                //           this.$snotify.success('Project image updated successfully');
                //         } else {
                //           this.$emit('video-selected', data);
                //           this.$snotify.success('Project video updated successfully');
                //         }
                //       } else {
                //         if (type == 'image') {
                //           this.$snotify.success('Project image updated successfully');
                //           this.$emit(
                //             'image-selected',
                //             _.map(data, i => i)
                //           );
                //         } else {
                //           this.$snotify.success('Project video updated successfully');
                //           this.$emit(
                //             'video-selected',
                //             _.map(data, i => i)
                //           );
                //         }
                //       }
                //     }
                //     this.$emit('loader', false);
                //   } catch (error) {
                //     this.$emit('loader', false);
                //     this.$snotify.error('Something went wrong');
                //   }
            },
            removeUploadItems() {
                this.$refs;
            },
        },
    };
</script>

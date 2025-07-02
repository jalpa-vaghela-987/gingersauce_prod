<template>
    <section>
        <ckeditor
            id="description"
            ref="description"
            :editor="editor"
            :config="editorConfig"
            v-model="descriptionText"
            @input="handleChangeInput"
        ></ckeditor>
    </section>
</template>

<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import CKEditor from "@ckeditor/ckeditor5-vue2";
import {mapActions, mapState} from "vuex";

export default {
    props: { description: String, filed: String  },
    components: {
        ckeditor: CKEditor.component
    },
    data() {
        return {
            editor: ClassicEditor,
            editorConfig: {
                toolbar: {
                    items: [
                        'heading',
                        'numberedList',
                        'bulletedList',
                        'bold',
                        'italic',
                        'link',
                        'undo',
                        'redo',
                    ],
                },
            },
            descriptionText: ''
        }
    },
    mounted() {
        this.descriptionText = this.description
    },
    computed: {
        ...mapState(['defaultBrandbook'])
    },
    methods: {
        ...mapActions([
            'setDefaultBrandbook'
        ]),
        handleChangeInput(event) {
            this.setDefaultBrandbook({
                ...this.defaultBrandbook,
                [this.filed]: event
            });
        }
    }
}
</script>

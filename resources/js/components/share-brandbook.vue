<template>
    <div class="modal" id="share-brandbook-modal" ref="modal">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0 p-2 justify-content-end">
                    <a href="#" style="z-index:10" @click.prevent="showHideModal">
                        <svg id="closeIcon" width="20" height="20" viewBox="0 0 49 49" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.1837 12.2347L36.9573 37.2595M36.2768 12.8601L13.1837 36.6341" stroke="black"
                                stroke-width="3"/>
                        </svg>
                    </a>
                </div>
                <share></share>
            </div>
        </div>
    </div>
</template>
<script>
import share from "./share.vue";
import { mapActions, mapState } from "vuex";
export default {
    data() {
        return {
            showModal:false
        };
    },
    components:{
        share
    },
    mounted(){
        const modalElem = this.$refs.modal;
        this.modal = new window.bootstrap.Modal(modalElem,{
            backdrop: 'static',
            keyboard: false
        });
    },
    methods:{
        showHideModal(){
            !this.showModal ? this.modal.show() : this.modal.hide();
            this.showModal = !this.showModal;
        },
        ...mapActions([
                'setLoading'
            ]),
    },
    computed: {
        _id() {
            return this.$route.params[ 'id' ];
        },
        ...mapState(['canExport','canEdit','canDownload','canDuplicate','canRemoveWm','brandBookStatus','getLoading','downLoadAssetUrl','expirationDate'])
    },
};
</script>
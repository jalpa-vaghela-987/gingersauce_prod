<template>
    <!-- Not in use right now -->
    <div class="modal" id="remove-watermark-modal" ref="modal">
        <div class="modal-dialog">
            <div class="modal-content rounded-1">
                <div class="modal-header">
                    <a href="#" style="z-index:10" @click.prevent="showHideModal">
                        <svg id="closeIcon" width="49" height="49" viewBox="0 0 49 49" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.1837 12.2347L36.9573 37.2595M36.2768 12.8601L13.1837 36.6341" stroke="black"
                                stroke-width="3"/>
                        </svg>
                    </a>
                    <h1>
                        {{ translate('general.remove_watermark') }}
                    </h1>
                </div>
                <div class="modal-body">
                    {{translate('general.remove_wm_message')}}
                </div>
                <div class="modal-footer justify-content-center">
                    <a type="button" class="btn btn-danger btn-confirm btn-block" id="confirm-remove-watermark" @click.prevent="confirmRemove">
                        {{translate('general.yes')}}
                    </a>
                    <button type="button"
                            class="btn btn-outline-secondary btn-block feedback-modal" 
                            @click.prevent="showHideModal">{{translate('general.not_yet')}}</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import translate from "@/utils/translate.js";
export default {
    data() {
        return {
            showModal:false
        };
    },
    mounted() {
        const modalElem = this.$refs.modal;
        this.modal = new window.bootstrap.Modal(modalElem);
    },
    components:{
    },
    methods:{
        translate,
        confirmRemove(flag){
            this.showHideModal();
            this.$emit("actionClicked",flag);
        },
        showHideModal(){
            !this.showModal ? this.modal.show() : this.modal.hide();
            this.showModal = !this.showModal;
        },
    }
};
</script>
<template>
  <div class="d-flex justify-content-between gap-2 align-content-center">
    <button class="btn main-btn" @click="copyCurrentUrl">Copy link</button>
    <button class="btn sec-btn" @click="redirectLogin" v-if="!loggedIn">Login</button>
    <ErrorModal
      v-bind:is-open="IsModal"
      v-bind:message="modalMessage"
      v-on:modal-answer="IsModal = !IsModal"
    >
    </ErrorModal>
  </div>
</template>
<script>
  import ErrorModal from "../NotifyModal.vue";
  import translate from '../../../utils/translate';
  import { mapState } from 'vuex';
    export default{
      data(){
        return {
          loggedIn:false,
          IsModal: false,
          modalMessage: {
            title: this.translate("Error"),
            article: "",
          },
        }
      },
      components:{
        ErrorModal
      },
      mounted(){
        if (this.getUser) {
         this.loggedIn = true; 
        }
      },
      methods:{
        translate,
        async copyCurrentUrl(){
          const url = window.location.href;
          navigator.clipboard.writeText(url).then(()=>{
            this.showErrorModal({
              title: this.translate("Success:"),
              article: this.translate("URL copied successfully."),
            });
          });
        },
        showErrorModal(
          message = {
            title: this.translate("Error"),
            article: this.translate("We have some error"),
          }
        ) {
          this.IsModal = true;
          this.modalMessage = message;
        },
        redirectLogin(){
          window.location.href = '/';
        }
      },
      computed:{
        ...mapState(['getUser'])
      }
    }
</script>

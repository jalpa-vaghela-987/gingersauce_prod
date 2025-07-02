<template>
  <div class="d-flex justify-content-between flex-grow-1 align-content-center">
    <div class="d-none d-xl-flex gap-2 flex-grow-0" v-if="getUser && !isEditBook">
      <button class="btn main-btn" data-toggle="modal"
          v-if="!is_public && canRemoveWm"
          @click="showRemoveWatermarkModal"
      >Remove watermark</button>
      <button v-else-if="!is_public"
        @click="packages_modal"
        class="btn main-btn preview-buttons customize-remove-watermark"
        >Remove watermark</button>
      <button class="btn third-btn" @click.prevent="downloadAllAsset">{{"Download"}}</button>
      <button class="btn sec-btn" @click="copyUrl" v-if="getUser">Copy link</button>
      <button class="btn sec-btn" @click.prevent="showShareModal">Share</button>
    </div>
    <div class="d-xl-flex gap-2 flex-grow-0" v-else-if="!getUser && !isEditBook">
      <button class="btn third-btn" @click.prevent="downloadAllAsset">{{"Download All Asset"}}</button>
    </div>

    <div class="d-flex gap-2 flex-grow-0 ms-auto" v-if="getUser">
      <CustomizePart/>
      <div class="expir-date d-none d-md-flex flex-column align-self-center">
        <div class="title">Expiration date</div>
        <div class="date">{{ formattedDate }}</div>
      </div>
      <!-- <MyBrandbooks /> -->
      <SubMenu :user="getUser"
               @copyUrl="copyUrl"
               @downloadAllAsset="downloadAllAsset"
               @showShareModal="showShareModal"
               @showRemoveWatermarkModal="showRemoveWatermarkModal"
               @packageModal="packages_modal"
               :is_public="is_public"
      />
    </div>
    <div class="d-flex gap-2 flex-grow-0 ms-auto" v-else>
      <GuestSubMenu :user="getUser"/>
    </div>
    <RemoveWaterMarkModal @actionClicked="confirmRemove" :ref="`removeWaterMarkModal`"/>
    <shareBrandbook ref="shareBB"/>
  </div>
</template>
<script>
import CustomizePart from './CustomizePart.vue';
import RemoveWaterMarkModal from './RemoveWaterMarkModal';
import SubMenu from './SubMenu.vue';
import GuestSubMenu from './GuestSubMenu.vue';
import { mapState,mapActions } from "vuex";
import translate from "@/utils/translate.js";
import { dateFormat } from "@/utils/helpers.js";
import shareBrandbook from '../share-brandbook.vue';
export default {
	data() {
		return {
      endpoints  : endpoints,
		};
	},
  components:{
    CustomizePart,
    SubMenu,
    RemoveWaterMarkModal,
    shareBrandbook,
    GuestSubMenu
  },
  mounted(){
    const self  = this
    $( '.feedback-modal' ).on( 'click', function() {
        $( this ).closest( '.modal' ).modal( 'hide' );
        $( '#modal-feedback' ).modal( 'show' );
    } );
    $( '#confirm-download' ).off( 'click' ).on( 'click', function( e ) {
        e.preventDefault();
        $( '#modal-confirm-download' ).modal( 'hide' );
        self.removeWatermark();
    } );
  },
  methods:{
    translate,
    confirmRemove(){
      console.log("hurray ");
    },
    packages_modal() {
        this.$root.$emit('fill-value', this._id);
        $( '#modal-choose-plan' ).modal( { backdrop: 'static', keyboard: false }, 'show' );
    },
    showRemoveWatermarkModal() {
        $( '#modal-confirm-download' ).modal( { backdrop: 'static', keyboard: false }, 'show' );
    },
    removeWatermark() {
      this.setLoading(true);
        axios.post( this.endpoints.ajax.post.remove_watermark, { id: this._id } ).then( response => {
          this.setLoading(false);
            location.reload();
        } ).catch( error => {
            if ( error.response.status === 402 ) {
                this.packages_modal();
            } else {
                new Noty( {
                              type   : 'error',
                              text   : this.translate( error.response.data.message ),
                              timeout: 5000,
                          } ).show();
            }
            this.setLoading(false);
        } );
    },
    ...mapActions([
			'setLoading'
		]),
    downloadAllAsset(){
      if(this.downLoadAssetUrl){
        window.location.href  = this.downLoadAssetUrl;
      }
    },
    showShareModal(){
      this.$refs.shareBB.showHideModal();
      this.$root.$emit( 'share', { id: this._id, data: { id: this._id } } );
    },
    copyUrl(){
      const currentUrl = window.location.href;
      navigator.clipboard.writeText(currentUrl).then(() => {
        new Noty({
            type   : 'success',
            text   : "URL copied successfully",
            timeout: 5000,
        }).show();
      }).catch(err => {
        console.error('Failed to copy: ', err);
      });
    }
  },
  computed: {
    formattedDate(){
      return dateFormat(this.expirationDate);
    },
    _id() {
      return this.$route.params[ 'id' ];
    },
		...mapState(['canExport','canEdit','canDownload','canDuplicate','canRemoveWm','brandBookStatus','getLoading','downLoadAssetUrl','expirationDate','getUser', 'isEditBook']),
    is_public(){
      return this.brandBookStatus == "public";
    },
	},
};
</script>
<style scoped>
.expir-date .title {
  font-size: 10px;
  font-weight: calc(var(--secFontWeight) + 300);
  line-height: 1.1;
  text-align: left;
}
.expir-date .date {
  font-size: 18px;
  font-weight: calc(var(--secFontWeight) + 300);
  line-height: 1.1;
  text-align: left;
}
</style>

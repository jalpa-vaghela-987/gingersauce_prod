<template>
  <div class="d-flex gap-3 align-items-center">
    <button type="button" class="btn third-btn" @click="downloadFiles(type)">
      <svg class="icon icon-download2" width="16" height="14">
        <use href="@/utils/new-brand/icons/symbol-defs.svg#icon-download2"></use>
      </svg>
      Download
    </button>
    <div class="add-info fs-14">JPG, PNG, AI, SVG, PDF</div>
  </div>
</template>
<script>
import {mapActions, mapState} from "vuex";

export default {
    data(){
        return {
            endpoints  : endpoints,
        }
    },
    props: {
        type: String,
        url: String
    },
    computed: {
        ...mapState(['downLoadSeparateAssetUrl']),
    },
    methods: {
        ...mapActions([
            'setIsEditBookLoader'
        ]),
        downloadFiles(type) {
            this.setIsEditBookLoader(true);
            if(this.downLoadSeparateAssetUrl){
                window.location.href  = this.downLoadSeparateAssetUrl + '/' + type;
                this.setIsEditBookLoader(false);
            }
        }
    }
}
</script>
<style scoped>
.add-info {
  color: #797979;

  @media screen and (max-width: 992px) {
    font-size: 10px;
  }
}
</style>

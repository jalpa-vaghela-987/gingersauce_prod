<template>
  <section class="align-self-start col-12 p-0" id="versions-book" :style="`order:${orderClass}`">
    <div class="main-content">
        <span v-if="isEditBook">
            <EditDefaultInput
                :value="(brandbook.versions_title) ? brandbook.versions_title : 'Logo Versions'"
                filed="versions_title"
            />
            <EditDefaultDescription
                :description="(brandbook.versions_text) ? brandbook.versions_text : setDefaultDescription"
                filed="versions_text"
            />
        </span>
        <span v-else>
            <h1 class="mb-4">{{ (brandbook.versions_title) ? brandbook.versions_title : 'Logo Versions' }}</h1>
            <span v-if="brandbook.versions_text" v-html="brandbook.versions_text"></span>
            <span class="mb-50" v-else v-html="setDefaultDescription"></span>
        </span>
    </div>
    <div class="group-img d-flex flex-wrap mb-50">
      <LogoBlock
        v-for="(block, index) in logoBlocks"
        :key="index"
        :bg-color="block.bgColor"
        :theme="block.theme"
        :logo="block.logo"
        :width="block.width"
        :text="block.text"
      />
      <WatermarkImage/>
    </div>

    <div class="main-content pt-0">
      <DownloadBtn
          :type="`logo-versions`"
      />
    </div>
  </section>
</template>
<script>
import LogoBlock from './LogoBlock.vue';
import DownloadBtn from './DownloadBtn.vue';
import EditDefaultDescription from "./EditDefaultDescription";
import EditDefaultInput from "./EditDefaultInput";
import {mapState} from "vuex";
import WatermarkImage from "./WatermarkImage";
export default {
  data() {
    return {
          logoBlocks: [],
          orderClass: null
        };
      },
      components:{
        LogoBlock,
        DownloadBtn,
        EditDefaultDescription,
        EditDefaultInput,
        WatermarkImage
      },
      props: { brandbook: Object },
      computed: {
        ...mapState(['isEditBook', 'defaultBrandbook','currentBrandTabs']),
        setDefaultDescription() {
            return `<p>The ${this.brandbook.brand} Logo should be used mostly with the ${(this.brandbook.colors_list && this.brandbook.colors_list[0]) ? this.brandbook.colors_list[0].color.name.value : '' } and ${(this.brandbook.colors_list && this.brandbook.colors_list[1]) ? this.brandbook.colors_list[1].color.name.value : '' } colors. The negative ${this.brandbook.brand} Logo can be used on dark image backgounds with high contrast between them. <br /> The Monochrome version logo should be used on documents that are printed in black & white.</p>`
        }
      },
      mounted() {
        this.getOrderClass('logo');
        this.logoVersions();
      },
      methods : {
        logoVersions() {
            if(this.defaultBrandbook && this.defaultBrandbook.approved) {
                let approvedLogoVersions = [];
                let logoVersionLength = this.defaultBrandbook.approved.length;
                this.defaultBrandbook.approved.map(function(approved, index) {
                    approvedLogoVersions.push({
                        bgColor: (approved.background == 'transparent') ? '#fff' : approved.background,
                        theme: (approved.background == 'transparent') ? 'light' : 'dark',
                        logo: approved.logo_b64,
                        width: ((logoVersionLength - 1) == index && logoVersionLength % 2 == 1) ? 100 : 50,
                        text: approved.title,
                    });
                });
                this.logoBlocks = approvedLogoVersions;
            }
        },
        async getOrderClass(slug){
            const order =  this.currentBrandTabs.findIndex(tab=>(tab.is_default && tab.slug==slug));
            this.orderClass =   order;//`order-${order}`;
        }
      },
    watch: {
        'defaultBrandbook.approved' : function (newVal, oldVal){
            if(newVal != null) {
                this.logoVersions();
            }
        },
        currentBrandTabs: {
            handler(newTabs) {
                this.getOrderClass("logo");
            },
            deep: true,
            immediate: true,
        }
    },
};
</script>
<style scoped>
#versions .main-content {
  padding: 88px 0px 60px 98px;
  max-width: 760px;
}
@media screen and (max-width: 992px) {
  #versions .main-content {
    padding: 60px 20px 40px 80px;
    min-height: unset;
  }
}
@media screen and (max-width: 992px) {
  .group-img {
    padding-left: 60px;
  }
}
</style>

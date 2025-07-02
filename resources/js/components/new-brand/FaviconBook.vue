<template>
  <section class="align-self-start col-12 section-book" id="favicon-book" :style="`order:${orderClass}`">
    <div class="content">
        <span v-if="isEditBook">
            <EditDefaultInput
                :value="(brandbook.icon_title) ? brandbook.icon_title : 'Our Icon & Favicon'"
                filed="icon_title"
            />
            <EditDefaultDescription
                :description="(brandbook.icon_text) ? brandbook.icon_text : setDefaultDescription"
                filed="icon_text"
            />
        </span>
        <span v-else>
            <h1 class="mb-4">{{ (brandbook.icon_title) ? brandbook.icon_title : 'Our Icon & Favicon' }}</h1>
            <span v-if="brandbook.icon_text" v-html="brandbook.icon_text"></span>
            <span v-else v-html="setDefaultDescription"></span>
        </span>

      <div class="main-favicon-group" v-if="brandbook.icon_b64">
          <img :src="brandbook.icon_b64" class="main-favicon"/>
          <span class="fs-12 text-center mt-2 d-block">{{ (brandbook.approved_icon.length > 0 && brandbook.approved_icon[0].title) ? brandbook.approved_icon[0].title : '' }}</span>
          <div class="content">
              <WatermarkImage/>
          </div>
      </div>
        <DownloadBtn
            :type="`main-icon`"
        />
    </div>

    <div class="favicon-group">
      <FaviconBlock
        v-for="(block, index) in faviconBlocks"
        :key="index"
        :bg-color="block.bgColor"
        :type="block.type"
        :text="block.text"
        :icon="block.icon"
      />
    </div>
    <div class="content">
        <WatermarkImage/>
      <DownloadBtn
          :type="`approved-icons`"
      />
    </div>
    <div class="bg">O</div>
  </section>
</template>
<script>
import DownloadBtn from './DownloadBtn.vue';
import FaviconBlock from './FaviconBlock.vue';
import EditDefaultDescription from "./EditDefaultDescription";
import EditDefaultInput from "./EditDefaultInput";
import {mapState} from "vuex";
import WatermarkImage from "./WatermarkImage";
export default {
  data() {
        return {
          faviconBlocks: [],
          orderClass: null
        };
    },
    props: { brandbook: Object },
    components:{
        DownloadBtn,
        FaviconBlock,
        EditDefaultDescription,
        EditDefaultInput,
        WatermarkImage
    },
    computed: {
        ...mapState(['isEditBook', 'defaultBrandbook','currentBrandTabs', 'waterMarkImage']),
        setDefaultDescription() {
            return `<p>The ${this.brandbook.brand} icon should be used as the official Favicon only in ${this.brandbook.brand} ${(this.brandbook.colors_list && this.brandbook.colors_list[0]) ? this.brandbook.colors_list[0].color.name.value : '' }. The negative icon should be used for social as user/company image such as Whatsapp, Facebook, LinkedIn etc'.</p>`
        }
    },
    mounted() {
      this.getOrderClass('logo');
      this.approvedIcons();
    },
    methods : {
      approvedIcons() {
          if(this.defaultBrandbook && this.defaultBrandbook.approved_icon) {
              let approvedIcons = [];
              this.defaultBrandbook.approved_icon.map(function(approvedIcon) {
                  approvedIcons.push({
                      type: (approvedIcon.border_radius == 0) ? 'square' : 'circle',
                      bgColor: (approvedIcon.background == 'transparent') ? '#fff' : approvedIcon.background,
                      text: approvedIcon.title,
                      icon: approvedIcon.icon_b64
                  });
              });
              this.faviconBlocks = approvedIcons;
          }
      },
      async getOrderClass(slug){
          const order =  this.currentBrandTabs.findIndex(tab=>(tab.is_default && tab.slug==slug));
          this.orderClass =   order;//`order-${order}`;
      }
    },
    watch: {
        'defaultBrandbook.approved_icon' : function (newVal, oldVal){
            if(newVal != null) {
                this.approvedIcons();
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
<style>
#favicon {
  padding-top: 350px;
  min-height: 120vh;
}
#favicon .main-favicon-group {
  margin-top: 200px;
  margin-left: 77px;
  margin-bottom: 50px;
  width: fit-content;
}
#favicon .main-favicon {
  width: 150px;
  height: 155px;
  margin: 0 auto;
}
#favicon .main-favicon svg,
#favicon .main-favicon img{
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}
#favicon .favicon-group {
  margin-left: 80px;
  margin-top: 156px;
  margin-bottom: 70px;
  display: grid;
  grid-template-columns: 200px 200px;
  gap: 170px;
}
#favicon .bg {
  font-size: 932px;
  left: -150px;
  bottom: auto;
  top: 90px;
}

@media screen and (max-width: 992px) {
  #favicon {
    padding-top: 120px;
    min-height: 120vh;
  }
  #favicon .bg {
    font-size: 732px;
    left: -150px;
    bottom: auto;
    top: 0px;
  }
  #favicon .favicon-group {
    margin-left: 0px;
    margin-top: 60px;
    margin-bottom: 60px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px 20px;
  }
}
</style>

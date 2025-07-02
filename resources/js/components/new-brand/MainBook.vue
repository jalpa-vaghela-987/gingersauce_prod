<template>
  <div class="d-flex flex-column flex-grow-1" v-if="brandbook">
    <TitleBook id="title-book" :brandbook="brandbook"/>
    <IntroductionBook v-if="isTab('introduction') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'introduction') : true)"
        id="introduction"
        :brandbook="brandbook"
        :tab="tab('introduction')"
        v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }"/>
    <SectionImage v-if="brandbook.mockups && brandbook.mockups.length > 0 && brandbook.mockups[0]" :img="brandbook.mockups[0].image" tabName="introduction"/>
    <VisionBook v-if="isTab('vision') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'vision') : true)" id="vision" :brandbook="brandbook" :tab="tab('vision')" v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }"/>
    <MisionBook v-if="isTab('mission') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'mission') : true)"
        id="mission" :brandbook="brandbook"
        :tab="tab('mission')"
        v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }"/>
    <ValuesBook v-if="isTab('core-values') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'core-values') : true)" id="core-values" :brandbook="brandbook" :tab="tab('core-values')" v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }" />
    <ArchetypeBook v-if="isTab('brand-archetype') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'brand-archetype') : true)" id="brand-archetype" :brandbook="brandbook" :tab="tab('brand-archetype')" v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }" />
    <LogoBook v-if="isTab('logo') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'logo') : true)" id="logo" :brandbook="brandbook" :tab="tab('logo')" v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }" />
    <VersionsBook v-if="isTab('logo') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'logo') : true) && brandbook.approved && brandbook.approved.length > 0" id="versions" :brandbook="brandbook" v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }"/>
    <SectionImage v-if="brandbook.mockups && brandbook.mockups.length > 0 && brandbook.mockups[1]" :img="brandbook.mockups[1].image" tabName="logo"/>
    <FaviconBook v-if="isTab('logo') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'logo') : true) && brandbook.icon != 'skipped' && brandbook.icon!= null" id="favicon" :brandbook="brandbook"/>
    <ProportionsBook v-if="isTab('logo') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'logo') : true)" id="proportions" :brandbook="brandbook" />
    <SpaceBook v-if="isTab('clear-space') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'clear-space') : true)" id="clear-space" :brandbook="brandbook" :tab="tab('clear-space')" v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }" />
    <MinimumBook v-if="isTab('minimum-size') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'minimum-size') : true)" id="minimum-size" :brandbook="brandbook" :tab="tab('minimum-size')" v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }" />
    <SectionImage v-if="brandbook.mockups && brandbook.mockups.length > 0 && brandbook.mockups[2]" :img="brandbook.mockups[2].image" tabName="minimum-size"/>
    <MisuseBook v-if="isTab('logo-misuse') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'logo-misuse') : true)" id="logo-misuse" :brandbook="brandbook" :tab="tab('logo-misuse')" v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }" />
    <IconsBook v-if="isTab('feature-icons') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'feature-icons') : true)" id="feature-icons" :brandbook="brandbook" :tab="tab('feature-icons')" v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }" />
    <PaletteBook v-if="isTab('color-palette') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'color-palette') : true)" id="color-palette" :brandbook="brandbook" :tab="tab('color-palette')" v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }"/>
      <SectionImage v-if="brandbook.mockups && brandbook.mockups.length > 0 && brandbook.mockups[3]" :img="brandbook.mockups[3].image" tabName="color-palette"/>
      <FontsBook v-if="isTab('our-fonts') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'mission') : true)" id="our-fonts" :brandbook="brandbook" :tab="tab('our-fonts')" v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }" />
    <BrandDesigner v-if="isTab('brand-designer') && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( tab => tab.slug == 'brand-designer') : true)" id="brand-designer" :brandbook="brandbook" v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }" />
    <CustomTabContents :id="tab.slug" :title="tab.title" :tab_contents="tab.tab_contents" v-for="tab in customTabs"
      v-if="customTabs.length && isTab(tab.slug) && ((defaultBrandbook && defaultBrandbook.delete_tabs.length > 0) ? !defaultBrandbook.delete_tabs.some( deleteTab => deleteTab.slug == tab.slug) : true)"  :style="`order:${tab.order}`" :tab="tab" v-observe-visibility="{
        callback: visibilityChanged,
        intersection: {
          rootMargin: '-100px 0px 0px 0px',
          threshold: 0.1
        }
      }" />
    <EditModals />
    <DeleteModal />
  </div>
</template>
<script>
import TitleBook from './TitleBook.vue';
import IntroductionBook from './IntroductionBook.vue';
import VisionBook from './VisionBook.vue';
import MisionBook from './MisionBook.vue';
import ValuesBook from './ValuesBook.vue';
import ArchetypeBook from './ArchetypeBook';
import LogoBook from './LogoBook.vue';
import VersionsBook from './VersionsBook.vue';
import FaviconBook from './FaviconBook.vue';
import ProportionsBook from './ProportionsBook.vue';
import SpaceBook from './SpaceBook.vue';
import MinimumBook from './MinimumBook.vue';
import MisuseBook from './MisuseBook.vue';
import IconsBook from './IconsBook.vue';
import PaletteBook from './PaletteBook.vue';
import FontsBook from './FontsBook.vue';
import BrandDesigner from './BrandDesigner.vue';
import CustomTabContents from './CustomTabContents.vue';
import EditModals from "./EditElements/EditModals";
import DeleteModal from "./EditElements/DeleteModal";
import SectionImage from './SectionImage.vue';
import {mapState} from "vuex";
export default {
  data() {
    return {
      endpoints: endpoints,
      customTabs: [],
      // mainTabs:[]
    }
  },
  props: {
    brandbook: {
      type: Object,
      default: {}
    },
    tabs: {
      type: Array,
      default: []
    },
  },
  components: {
    TitleBook,
    IntroductionBook,
    VisionBook,
    MisionBook,
    ValuesBook,
    LogoBook,
    VersionsBook,
    FaviconBook,
    ProportionsBook,
    SpaceBook,
    MinimumBook,
    MisuseBook,
    IconsBook,
    PaletteBook,
    FontsBook,
    BrandDesigner,
    CustomTabContents,
    EditModals,
    DeleteModal,
    ArchetypeBook,
    SectionImage
  },
  methods: {
    visibilityChanged(isVisible, entry) {
      this.isVisible = isVisible;
      if (isVisible) {
        this.$emit('set-active-section', entry.target.id);
      }
    },
    tab(tabSlug) {
      if(this.tabs) {
          let tab = this.tabs.find( tab => tab.slug == tabSlug );
          return tab;
      }
    },
    filterTabs() {
      this.customTabs = this.tabs.filter((tab) => {
        return !tab.is_default && tab.tab_contents.length > 0;
      });
    },
    fetchMainTabPosition(tabSlug){
      const mainTab  =  this.tabs.find(tab=>(tab.is_default && tab.slug==tabSlug));
      return mainTab?.order;
    },
    isTab(tabSlug) {
      if(this.tabs) {
          return this.tabs.some( tab => tab.slug == tabSlug );
      }
    }
  },
  computed: {
    ...mapState(['defaultBrandbook']),
  },
  mounted() {
    this.filterTabs();
  },
  watch:{
    tabs(){
      this.filterTabs();
    }
  },
};
</script>

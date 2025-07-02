<template>
  <div>
    <aside :class="{ is_expanded }" class="sticky-xl-top flex-shrink-0">
      <div class="menu drag-menu">
        <ul class="px-0">
          <draggable v-model="localTabs" handle=".draggable-div" @end="storeTabOrders" :move="checkEditMode">
            <li v-for="tab in localTabs" :key="tab.id" class="draggable-div d-flex">
              <span class="icon-move d-flex align-items-center me-1" v-if="isEditBook">
                <svg class="icon icon-move" width="11" height="11">
                  <use :href="`${icons}#icon-move`"></use>
                </svg>
              </span>
              <a
                :href="`#${tab.slug}`"
                :class="['menu-item flex-grow-1', { active: activeSection === tab.slug }]"
                @click.prevent="handleClick(tab.slug)">
                <span class="menu-icon" v-if="tab.is_default">
                  <svg :class="`icon ${tab.icon}`" width="25" height="25">
                    <use :href="`${icons}#${tab.icon}`"></use>
                  </svg>
                </span>

                <span class="menu-icon" v-else-if="checkIsSVG(tab.icon)" v-html="tab.icon">
                </span>

                <span class="menu-icon" v-else>
                  <img :src="tab.icon" width="18" />
                </span>
                <span class="text">{{ tab.title }}</span>
              </a>
              <span
                v-if="isEditBook"
                class="icon-delete d-flex align-items-center ms-auto"
                @click="removeItem(tab.slug, tab.id)"
              >
                <svg class="icon icon-delete" width="18" height="18">
                  <use :href="`${icons}#icon-delete`"></use>
                </svg>
              </span>
            </li>
            <li class="d-flex add-item mt-2" v-if="getUser && isEditBook">
              <span
                class="menu-icon d-flex align-items-center"
                :class="{ error: imgError }"
                @click="openImageUploadModal"
              >
                <svg class="icon icon-plus" width="16" height="16" id="new-section-image">
                  <use :href="`${icons}#icon-plus`"></use>
                </svg>
              </span>
              <input
                type="text"
                name="new-item"
                :class="{ error: inputError }"
                v-model="newItemText"
                placeholder="Add section"
                @input="removeError"
                @keydown.enter.prevent="addItem"
              />
              <span class="d-flex align-items-center ms-2 menu-icon" @click="addItem">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 448 512"
                  width="16"
                  height="16"
                >
                  <path
                    d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"
                  />
                </svg>
              </span>
            </li>
          </draggable>
        </ul>
      </div>

      <div class="powered mt-auto d-flex justify-content-center align-items-center">
        <svg class="icon icon-gingersauce_square" width="8" height="8">
          <use :href="`${icons}#icon-gingersauce_square`"></use>
        </svg>
        Powered by gingersauce
      </div>
      <div class="footer menu">
        <ul class="m-0">
          <li>
            <a href="#" class="menu-item">
              <span class="menu-icon">
                <svg class="icon icon-menu-help" width="25" height="25">
                  <use :href="`${icons}#icon-menu-help`"></use>
                </svg>
              </span>
              <span class="text">Help</span>
            </a>
          </li>
        </ul>
      </div>
    </aside>
    <AddIconModal @save-image="handleSaveImage" ref="ImageUploadModal"/>
  </div>
</template>

<script>
import AddIconModal from './AddIconModal.vue';
import draggable from 'vuedraggable';
import icons from "@/utils/new-brand/icons/symbol-defs.svg";
import { mapActions, mapState } from 'vuex';
import { isSVG } from "@/utils/helpers.js";

export default {
  components: {
    draggable,
    AddIconModal
  },
  data() {
    return {
      icons: icons,
      newItemText: '',
      inputError: false,
      imgError:false,
      newItemImg:null,
      localTabs: [],
      deleteTabs: []
    };
  },
  created() {
      if(this.currentBrandTabs) {
          this.localTabs = [...this.currentBrandTabs];
      }
  },
  props: { is_expanded: Boolean, activeSection: String },
  computed: {
    ...mapState(['getUser','currentBrandTabs','isEditBook', 'defaultBrandbook']),
  },
  methods: {
    handleClick(slug) {
      this.$emit('set-active-section', slug);
      const element = document.getElementById(slug);
      if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
      }
    },
    removeItem(slug, id) {
        let tabIndex = this.defaultBrandbook.tabs.findIndex( tab => tab.id == id );
        this.defaultBrandbook.tabs.splice(tabIndex, 1);

        this.deleteTabs.push({
            'id' : id,
            'slug' : slug
        });
        this.setDefaultBrandbook({
            ...this.defaultBrandbook,
            'delete_tabs' :  this.deleteTabs
        });
      this.localTabs = this.localTabs.filter(item => item.slug !== slug);
    },
    async addItem() {
      let checkTabIndex = this.defaultBrandbook.tabs.findIndex(item => item.title == this.newItemText);
      if (this.newItemText.trim() && this.newItemImg && checkTabIndex == '-1') {
        let bookOrder = this.defaultBrandbook.tabs.length - 1;
        let brandbookTabData = {
          id:this.newItemText+bookOrder,
          book_id: this.$route.params.id,
          slug: this.newItemText.replace(' ', '-'),
          title: this.newItemText,
          icon: this.newItemImg,
          order: this.defaultBrandbook.tabs[bookOrder].order + 1,
          is_new: true,
          tab_contents: [
              {
                  tab_id : '',
                  title: this.newItemText,
                  description: '',
                  image: '',
                  width: '',
                  height: ''
              }
          ]
        }
        this.defaultBrandbook.tabs.push(brandbookTabData);
        this.localTabs.push(brandbookTabData);
        this.setDefaultBrandbook({
          ...this.defaultBrandbook,
          'tabs' :  this.defaultBrandbook.tabs
        });
        this.newItemText = '';
        this.newItemImg = null;
        this.inputError = false;
        this.imgError = false;
        this.handleSaveImage();
        this.$refs.ImageUploadModal.removeIconModelFiles();
      } else {
        this.imgError = this.newItemImg?false:true;
        this.inputError = true;
      }
    },
    removeError() {
      this.inputError = false;
    },
    async handleSaveImage(imageBase64) {
      var newImg = document.createElement('img');
      if (!imageBase64) {
        const svgElement = document.createElementNS('http://www.w3.org/2000/svg', 'svg');

        svgElement.setAttribute('class', 'icon icon-plus');
        svgElement.setAttribute('width', '16');
        svgElement.setAttribute('height', '16');
        svgElement.setAttribute('id', 'new-section-image');
        const useElement = document.createElementNS('http://www.w3.org/2000/svg', 'use');
        useElement.setAttributeNS(
          'http://www.w3.org/1999/xlink',
          'href',
          `${this.icons}#icon-plus`
        );
        svgElement.appendChild(useElement);
        newImg = svgElement;
      } else {
        newImg.src  = imageBase64;
        newImg.classList.add('new-image');
        newImg.classList.add('mb-2');
        newImg.classList.add('editable-content');
        newImg.id = 'new-section-image';
        newImg.setAttribute('width', '16');
        this.newItemImg = imageBase64;
      }
      this.imgError = false;
      const element = document.getElementById('new-section-image');
      if(element){
        element.replaceWith(newImg);
      }
    },
    ...mapActions(["setLoading", "setDefaultBrandbook"]),
    checkIsSVG(str){
      return isSVG(str);
    },
    openImageUploadModal(){
      this.$refs.ImageUploadModal.showHideModal();
    },
    storeTabOrders(){
      if(this.isEditBook){
        this.$emit('set-new-tab-order', this.localTabs);
      }
    },
    checkEditMode(evt,orignal){
      return this.isEditBook;
    }
  },
  watch: {
    currentBrandTabs(newTabs) {
      this.localTabs = [...newTabs];
    },
    'isEditBook' : function(newVal, oldVal) {
        if(newVal == false) {
            this.newItemImg = '';
            this.newItemText = '';
            this.removeError();
            this.$refs.ImageUploadModal.removeIconModelFiles();
        }
    }
  },
};
</script>
<style>
span.error{
  border: 1px solid red;
  padding: 1px;
}
</style>

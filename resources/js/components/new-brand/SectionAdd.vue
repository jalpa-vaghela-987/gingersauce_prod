<template>
  <div>
    <section class="align-self-start col-12" id="section-new">
      <div class="content">
        <div

          class="add-line"
          @mouseenter="handleMouseEnter('addIcon')"
          @mouseleave="handleMouseLeave('addIcon')"
        >
          <div
            class="add-icon"
            type="button"
            data-toggle="dropdown"
            aria-expanded="false"
            :class="tabName"
            :ref="tabName"
          >
            <svg class="icon icon-plus" width="16" height="16">
              <use :href="`${icons}#icon-plus`"></use>
            </svg>
          </div>

          <div
            class="dropdown-menu block-add dropdown-menu-center"
            :class="{ show: isDropdownVisible }"
            @mouseenter="handleMouseEnter('dropdown')"
            @mouseleave="handleMouseLeave('dropdown')"
            ref="dropdownMenu"
          >
            <a class="dropdown-item" type="button" data-toggle="modal" :data-target="`#${tabName}HeadingModal`">
              <svg class="icon icon-heading" width="42" height="42">
                <use :href="`${icons}#icon-heading`"></use>
              </svg>
              <span>Heading</span>
            </a>
            <a class="dropdown-item" type="button" data-toggle="modal" :data-target="`#${tabName}TextModal`">
              <svg class="icon icon-text-editor" width="42" height="42">
                <use :href="`${icons}#icon-text-editor`"></use>
              </svg>
              <span>Text Editor</span></a>
            <a class="dropdown-item" type="button" data-toggle="modal" :data-target="`#${tabName}ImageModal`">
              <svg class="icon icon-image" width="42" height="42">
                <use :href="`${icons}#icon-image`"></use>
              </svg>
              <span>Image</span></a>
          </div>
        </div>
      </div>
    </section>
    <HeadingModal @save-heading-modal="handleSaveHeadingModal" :modalId="`${tabName}HeadingModal`"/>
    <TextModal @save-description-modal="handleSaveDescriptionModal" :modalId="`${tabName}TextModal`"/>
    <ImageModal @save-image-modal="handleSaveImageModal" :modalId="`${tabName}ImageModal`"/>
  </div>
</template>
<script>
import HeadingModal from "./AddSection/HeadingModal";
import TextModal from "./AddSection/TextModal";
import ImageModal from "./AddSection/ImageModal";
import icons from "@/utils/new-brand/icons/symbol-defs.svg";
import {mapActions, mapState} from "vuex";

export default {
    name: 'SectionAdd',
    props: { tabName: String, tab: Object },
    data() {
        return {
          isDropdownVisible: false,
          hoverAddIcon: false,
          hoverDropdown: false,
          icons: icons,
          tabContents : [],
          tabIndex: '',
        };
      },
    components: { HeadingModal, TextModal, ImageModal },
    computed: {
        ...mapState([
            'isEditBook',
            'defaultBrandbook'
        ])
    },
    mounted() {
        this.setTabContentsData();
    },
    methods: {
        ...mapActions([
            'setDefaultBrandbook',
        ]),
        setTabContentsData() {
            if(this.defaultBrandbook && this.defaultBrandbook.tabs) {
                this.tabIndex = this.defaultBrandbook.tabs.findIndex( tab => tab.id == this.tab.id );
                this.tabContents = this.defaultBrandbook.tabs[this.tabIndex].tab_contents;
                this.tabContents.map((tabContent, index) => {
                    if(tabContent.title != '' && tabContent.title) {
                        this.handleSaveHeader(tabContent.title, index );
                    } else if(tabContent.description != '' && tabContent.description) {
                        this.handleSaveText(tabContent.description, index )
                    } else {
                        if(tabContent.image != '' && tabContent.image) {
                            let image = {
                                'src' : tabContent.image,
                                'width' : tabContent.width
                            }
                            this.handleSaveImage(image, index );
                        }
                    }
                })
            }
        },
        handleMouseEnter(element) {
          if (element ===  this.tabName) {
            this.hoverAddIcon = true;
          } else if (element === 'dropdown') {
            this.hoverDropdown = true;
          }
          this.updateDropdownVisibility();
        },
        handleMouseLeave(element) {
          if (element === this.tabName) {
            this.hoverAddIcon = false;
          } else if (element === 'dropdown') {
            this.hoverDropdown = false;
          }
          this.isDropdownVisible = this.hoverAddIcon || this.hoverDropdown;
        },
        updateDropdownVisibility() {
            let tabName = this.tabName;
            this.$refs[tabName].click();
        },
        handleSaveHeadingModal(headerText) {
            this.handleSaveHeader(headerText, this.tabContents.length);
            this.tabContents.push({
                tab_id : this.tab.id,
                title: headerText,
                description: '',
                image: '',
                width: '',
                height: ''
            });

            this.defaultBrandbook.tabs[this.tabIndex].tab_contents = this.tabContents;
            this.setDefaultBrandbook({
                ...this.defaultBrandbook,
                'tabs' :  this.defaultBrandbook.tabs
            });
        },
        handleSaveDescriptionModal(simpleText) {
            this.handleSaveText(simpleText, this.tabContents.length);
            this.tabContents.push({
                tab_id : this.tab.id,
                title: '',
                description: simpleText,
                image: '',
                width: '',
                height: ''
            });

            this.defaultBrandbook.tabs[this.tabIndex].tab_contents = this.tabContents;
            this.setDefaultBrandbook({
                ...this.defaultBrandbook,
                'tabs' :  this.defaultBrandbook.tabs
            });
        },
        handleSaveImageModal(imagePaste) {
            this.handleSaveImage(imagePaste, this.tabContents.length)
              this.tabContents.push({
                  tab_id : this.tab.id,
                  title: '',
                  description: '',
                  image: imagePaste.src,
                  width: imagePaste.width,
                  height: ''
              });

            this.defaultBrandbook.tabs[this.tabIndex].tab_contents = this.tabContents;
            this.setDefaultBrandbook({
                ...this.defaultBrandbook,
                'tabs' :  this.defaultBrandbook.tabs
            });
        },
        handleSaveHeader(headerText, tabContentId = '') {
          let tabName = this.tabName;
          const addLine = this.$refs[tabName].closest('.add-line');
          const newHeader = document.createElement('h1');
          newHeader.classList.add('mb-4');
          newHeader.classList.add('editable-content');
          newHeader.setAttribute('id', tabContentId);
          newHeader.setAttribute('data-id', this.tab.id);
          newHeader.textContent = headerText;
          addLine.parentNode.insertBefore(newHeader, addLine);

          this.$applyEditableContent(newHeader);
        },

        handleSaveText(simpleText, tabContentId = '') {
          let tabName = this.tabName;
          const addLine = this.$refs[tabName].closest('.add-line');
          const newText = document.createElement('div');
          newText.classList.add('mb-2');
          newText.classList.add('editable-content');
          newText.setAttribute('id', tabContentId);
          newText.setAttribute('data-id', this.tab.id);
          newText.innerHTML = simpleText;
          addLine.parentNode.insertBefore(newText, addLine);

          this.$applyEditableContent(newText);
        },

        handleSaveImage(imagePaste, tabContentId = '') {
          let tabName = this.tabName;
          const addLine = this.$refs[tabName].closest('.add-line');
          const newImg = document.createElement('img');
          newImg.src = imagePaste.src;
          newImg.classList.add('new-image');
          newImg.classList.add('mb-2');
          newImg.classList.add('editable-content');
          newImg.style.cssText = `width: ${imagePaste.width}px`;
          newImg.setAttribute('id', tabContentId);
          newImg.setAttribute('data-id', this.tab.id);
          addLine.parentNode.insertBefore(newImg, addLine);

          this.$applyEditableContent(newImg);
        },
      },
};
</script>

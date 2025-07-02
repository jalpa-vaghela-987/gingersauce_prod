<template>
	<div class="parentClass">
		<div v-if="getLoading || isEditBookLoader" :style="{ '--main_color': mainColor }" class="loading-main-background">
			<div class="loading-main"></div>
		</div>
		<MainHeader :brandbook="brandbook"/>
		<div class="container-fluid px-0" v-if="!getLoading">
			<div class="wrapper d-flex align-items-stretch flex-md-row">
				<SideBarEdit
				:is_expanded="is_expanded"
				:active-section="activeSection"
				@set-active-section="setActiveSection"
				@set-new-tab-order="setNewTabOrder"/>
				<MainBook class="main-book" @set-active-section="setActiveSection" :brandbook="brandbook" :tabs="tabs" />
			</div>
		</div>
		<CustomizeModal @saveThemeData="saveThemeData" />
	</div>
</template>
<script>

// import MainSidebar from './new-brand/MainSidebar.vue';
import SideBarEdit from './new-brand/SideBarEdit.vue';
import MainHeader from './new-brand/MainHeader.vue';
import CustomizeModal from './new-brand/CustomizeModal.vue';
import updateCSSVariablesSaveBtn from '@/utils/new-brand/updateModal';
import MainBook from './new-brand/MainBook.vue';
import { mapState, mapActions } from "vuex";
import { EventBus } from '@/event-bus';

export default {
	data() {
		return {
			activeSection: '',
			endpoints: endpoints,
			tabs: [],
			brandbook: {}
		};
	},
	mounted() {
		if (window.user) {
			this.setLoggedInUser(JSON.parse(new TextDecoder().decode(Uint8Array.from(atob(window.user), char => char.charCodeAt(0)))));
		} else {
			this.setLoggedInUser(null);
		}
        this.getBrandbook()
        EventBus.$on('getBrandbookList', this.getBrandbook);
    },
    computed: {
		...mapState(['is_expanded',
			'getLoading',
			"getUser",
            "mainColor",
			"mainColorBook",
			"mainFont",
			"secFont",
			"mainFontWeight",
			"secFontWeight",
			"mainFontCategory",
			"secFontCategory",
            "defaultBrandbook",
			"currentBrandTabs",
            "localeUrls",
            "isEditBookLoader",
            "secondColor"
		])
	},
	components: {
		// MainSidebar,
		MainHeader,
		CustomizeModal,
		MainBook,
		SideBarEdit,
	},
	methods: {
		async getBrandbook() {
            this.setIsEditBookLoader(true);
            let bookId = this.$route.params.id;
            await axios.get( this.endpoints.ajax.get.new_view_page + '/' + bookId ).then( response => {
                if(response.data) {
					this.setCurrentBrandTabs(response.data.tabs);
                    this.tabs		=	response.data.tabs;
                    this.brandbook	=	response.data.brandbook;
					/**Update custom options */

                    if(this.brandbook.custom?.title_family) {
                        this.changeMainFont(this.brandbook.custom?.title_family);
                    }

                    if(this.brandbook.custom?.title_weight) {
                        this.changeMainFontWeight(this.brandbook.custom?.title_weight);
                    }

                    if(this.brandbook.custom?.title_category) {
                        this.changeMainFontCategory(this.brandbook.custom?.title_category);
                    }

                    if(this.brandbook.custom?.body_family) {
                        this.changeSecFont(this.brandbook.custom?.body_family);
                    }

                    if(this.brandbook.custom?.body_category) {
                        this.changeSecFontCategory(this.brandbook.custom?.body_category);
                    }

                    if(this.brandbook.custom?.body_weight) {
                        this.changeSecFontWeight(this.brandbook.custom?.body_weight);
                    }

                    this.changeMainColorBook(this.brandbook.custom_theme_color?this.brandbook.custom_theme_color : this.brandbook.main_color_hex);
                    this.changeMainColor(this.brandbook.main_color_hex);
                    this.changeSecondColor(this.brandbook.secondary_color_hex);
					/**Update custom options */
					this.setCanExport(response.data.can_export);
					this.setCanEdit(response.data.can_edit);
					this.setCanDownload(response.data.can_download);
					this.setCanDuplicate(response.data.can_duplicate);
					this.setCanRemoveWm(response.data.can_remove_wm);
					this.setBrandBookStatus(response.data.brandbook.status);
					this.setDownloadAssetUrl(response.data.download_asset_url);
					this.setExpirationDate(this.brandbook.expires_at);
					this.setDownloadSeparateAssetUrl(response.data.download_separate_asset_url);
                    this.setLocaleUrls(response.data.locale_urls);
                    this.setWaterMarkImage(response.data.watermark_image);
                    this.setDefaultBrandbook({
                        ...this.defaultBrandbook,
                        'colors_list' : this.brandbook.colors_list,
                        'approved' : this.brandbook.approved,
                        'approved_icon' : this.brandbook.approved_icon,
                        'tabs' : this.tabs,
                        'delete_tabs' : [],
                        'watermark' : this.brandbook.watermark
                    });

					this.updateCssForTheme();
                    this.setIsEditBookLoader(false);
				}
                this.setIsEditBookLoader(false);
			}).catch(error=>{
                this.setIsEditBookLoader(false);
				if(error.request && error.request.status==403){
					new Noty( {
								type   : 'error',
								text   : "Failed loading brandbook. Please ensure, that brandbook is completed and try again later.",
								timeout: 5000,
							} ).show();
                    setTimeout(() => {window.location.href	=	(this.getUser && this.getUser.role_id == 2) ? '/my' : '/restricted/brandbooks'}, 2000);
				}
			});
		},
		setActiveSection(slug) {
			if (slug) {
				let res = this.tabs.find(element => element.slug == slug);
				if (res != undefined) {
					this.activeSection = slug;
				}
			}
		},
		...mapActions([
			'toggleExpand',
			'setLoading',
			'setCanExport',
			'setCanEdit',
			'setCanDownload',
			'setCanDuplicate',
			'setCanRemoveWm',
			'setBrandBookStatus',
			'setDownloadAssetUrl',
			'setDownloadSeparateAssetUrl',
			'setExpirationDate',
			'setLoggedInUser',
			'changeMainFont',
			'changeMainFontWeight',
			'changeMainFontCategory',
			'changeSecFont',
			'changeSecFontCategory',
			'changeSecFontWeight',
            'changeMainColorBook',
            'changeMainColor',
            'setDefaultBrandbook',
			'setCurrentBrandTabs',
            'setLocaleUrls',
            'setIsEditBookLoader',
            'setWaterMarkImage',
            'changeSecondColor'
		]),
		saveThemeData() {
			axios.post(endpoints.ajax.post.brandbook.save_customize, {
				id: this.$route.params.id,
				title_family: this.mainFont,
				title_weight: this.mainFontWeight,
				title_category: this.mainFontCategory,
				body_family: this.secFont,
				body_weight: this.secFontWeight,
				body_category: this.secFontCategory,
				custom_theme_color: this.mainColorBook,
			}).then(response => {
				if (response.data) {
					this.updateCssForTheme();
				}
			});
		},
		updateCssForTheme() {
			updateCSSVariablesSaveBtn(
				this.mainColorBook,
				this.mainFont,
				this.secFont,
				this.mainFontWeight,
				this.secFontWeight,
                this.mainColor,
                this.secondColor
			);
		},
		async setNewTabOrder(tabArray){
			try {
				this.setLoading(true);
				this.setCurrentBrandTabs([...tabArray]);
			} catch (error) {
				console.error('Error updating tabs order:', error);
			}
			this.setLoading(false);
		}
	},
    watch: {
        'mainColor' : function (newVal, oldVal){
            if(newVal) {
                this.updateCssForTheme();
            }
        }
    },
};
</script>
<style>
@import '../utils/new-brand/css/main.css';

.parentClass .loading-main-background {
    width: 100%;
    height: 100%;
    background: white;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 99999999;
}
</style>

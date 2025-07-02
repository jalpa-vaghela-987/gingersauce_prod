<template>
	<div class="parentClass">
		<div v-if="loading" :style="{'--main_color': main_color}" class="loading-main-background"><div class="loading-main"></div></div>
		<MainHeader/>
		<div class="container-fluid px-0" v-if="!loading">
			<div class="wrapper d-flex align-items-stretch flex-md-row">
				<MainSidebar
				:is_expanded="is_expanded"
				:active-section="activeSection"
				:tabs="tabs"
				@set-active-section="setActiveSection"
				/>
				<MainBook @set-active-section="setActiveSection" />
			</div>
		</div>
		<CustomizeModal />
	</div>
</template>
  
<script>

import MainSidebar from './new-brand/MainSidebar.vue';
import MainHeader from './new-brand/MainHeader.vue';
import CustomizeModal from './new-brand/CustomizeModal.vue';	

import MainBook from './new-brand/MainBook.vue';
import { mapState, mapActions } from "vuex";
export default {
	data() {
		return {
			activeSection: '',
			endpoints  : endpoints,
			tabs : []
		};
	},
	mounted() {
        let bookId = this.$route.params.id;
        axios.get( this.endpoints.ajax.get.tabs + '/' + bookId ).then( response => {
            this.tabs = response.data;
        });
    },
	computed: {
		...mapState(['is_expanded'])
	}, 
	components:{
		MainSidebar,
		MainHeader,
		CustomizeModal,
		MainBook
	},
	methods: {
		setActiveSection(id) {
			if (id) {
				let res = this.tabs.find(element => element.slug == id);
				if (res != undefined) {
					this.activeSection = id;
				}
			}
		},
		...mapActions(['toggleExpand']),
	},
};
</script>
<style>
	@import '../utils/new-brand/css/main.css';
</style>
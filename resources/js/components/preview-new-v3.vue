<template>
    <div class="parentClassV3">
        <div v-if="getLoading || isEditBookLoader" :style="{ '--main_color': mainColor }" class="loading-main-background">
            <div class="loading-main"></div>
        </div>
        <MainHeader :brand_name="brandbook.brand" />
        <div class="container-fluid" v-if="!getLoading">
            <div class="row">
                <MainSidebar :brandbook="brandbook"/>
                <MainBook :brandbook="brandbook"/>
            </div>
        </div>
    </div>
</template>

<script>
    import MainSidebar from '../components/brandbook-v3/new-book/MainSidebar.vue';
    import MainHeader from '../components/brandbook-v3/new-book/MainHeader.vue';

    import MainBook from '../components/brandbook-v3/new-book/MainBook.vue';
    import {mapState, mapActions} from "vuex";
    import {EventBus} from '@/event-bus';

    export default {
        name: 'PreviewNewV3',
        components: {
            MainHeader, // Register it locally
            MainSidebar, // Register it locally
            MainBook // Register it locally
        },
        data() {
            return {
                // Your component's data
                brandbook: {},
                endpoints: endpoints,
            };
        },
        mounted() {
            if (window.user) {
                this.setLoggedInUser(JSON.parse(new TextDecoder().decode(Uint8Array.from(atob(window.user), char => char.charCodeAt(0)))));
            } else {
                this.setLoggedInUser(null);
            }
            this.getBrandbook();
            EventBus.$on('getBrandbookList', this.getBrandbook);
        },
        computed: {
            ...mapState([
                'getLoading',
                "getUser",
                "mainColor",
                "defaultBrandbook",
                "localeUrls",
                "isEditBookLoader",
            ])
        },
        methods: {
            ...mapActions([
                'setLoading',
                'setLoggedInUser',
                'setDefaultBrandbook',
                'setLocaleUrls',
                'setCanEdit',
                'changeMainColor'
            ]),
            async getBrandbook() {
                this.setLoading(true);
                let bookId = this.$route.params.id;
                await axios.get(this.endpoints.ajax.get.new_view_brandbook_v3_page + '/' + bookId).then(response => {
                    if (response.data) {
                        this.brandbook = response.data.brandbook;
                        console.log(this.brandbook);
                        /**Update custom options */
                        this.setLocaleUrls(response.data.locale_urls);
                        this.setDefaultBrandbook({
                            ...this.defaultBrandbook,
                            'colors_list': this.brandbook.colors_list,
                            'approved': this.brandbook.approved,
                            'approved_icon': this.brandbook.approved_icon,
                            'tabs': this.tabs,
                            'delete_tabs': [],
                            'watermark': this.brandbook.watermark
                        });
                        this.changeMainColor(this.brandbook.main_color_hex);

                    }
                    this.setLoading(false);
                }).catch(error => {
                    console.log('from error of api...' + error);
                    this.setLoading(false);
                    if (error.request && error.request.status == 403) {
                        new Noty({
                            type: 'error',
                            text: "Failed loading brandbook. Please ensure, that brandbook is completed and try again later.",
                            timeout: 5000,
                        }).show();
                        setTimeout(() => {
                            window.location.href = (this.getUser && this.getUser.role_id == 2) ? '/my' : '/restricted/brandbooks'
                        }, 2000);
                    }
                });
            }
        }
    };
</script>

<style lang="scss">
    @import '../utils/book-v3/scss/main.scss';
    .parentClassV3 .loading-main-background {
        width: 100%;
        height: 100%;
        background: white;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99999999;
    }
</style>

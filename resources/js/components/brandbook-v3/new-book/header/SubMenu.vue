<template>
    <div class="nav-item dropdown" :class="{ show: showDropdown }">
        <a
            class="nav-link dropdown-toggle d-flex align-items-center py-0 pe-0 fw-bold"
            id="navbarDropdownMenuLink"
            @click="toggleDropdown"
            aria-haspopup="true"
            :aria-expanded="showDropdown"
        >
            <RoundedImage style="width: 34px; height: 34px" :avatar_url="user.avatar_url"/>
            <span class="d-none d-md-flex ms-3 me-1">{{user.name}}</span>
        </a>
        <ul
            class="dropdown-menu"
            :class="{ show: showDropdown }"
            aria-labelledby="navbarDropdownMenuLink"
        >
            <li>
                <a :href="`/my`" class="dropdown-item text-dark">
                    <i class="fas fa-book"></i> My Brandbooks
                </a>
            </li>
            <li>
                <a :href="endpoints.ajax.get.header.plans_pricing" class="dropdown-item text-dark">
                    <i class="fas fa-tag"></i> Plans & Pricing
                </a>
            </li>
            <li>
                <a :href="endpoints.ajax.get.header.profile" class="dropdown-item text-dark">
                    <i class="fa fa-user"></i> My Profile
                </a>
            </li>
            <li>
                <a :href="endpoints.ajax.get.header.plans" class="dropdown-item text-dark">
                    <i class="fa fa-user"></i> Plans
                </a>
            </li>
            <li>
                <a :href="endpoints.ajax.get.header.billing" class="dropdown-item text-dark">
                    <i class="fa fa-credit-card"></i> Billing
                </a>
            </li>
            <li>
                <a :href="endpoints.ajax.get.header.purchase_history" class="dropdown-item text-dark">
                    <i class="fa fa-history"></i> Purchase history
                </a>
            </li>
            <li class="nav-item dropdown" :class="{ show: showSubmenu }">
                <a
                    class="dropdown-item text-dark"
                    @click="toggleSubmenu"
                    href="#"
                    aria-haspopup="true"
                    :aria-expanded="showSubmenu"
                >
                    <i class="fas fa-globe-americas"></i> Language
                </a>
                <ul
                    class="dropdown-menu"
                    :class="{ show: showSubmenu }"
                    aria-labelledby="navbarDropdownMenuLink"
                >
                    <li v-for="(locale, index) in localeUrls"
                        :key="index">
                        <a class="dropdown-item text-dark" :href="locale.url">{{ locale.name }}</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" @click="logout()" class="dropdown-item text-dark">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </a>
            </li>
            <!--<li class="d-flex d-xl-none  px-2 py-1" v-if="user && !this.is_public && !isEditBook">
                <button class="btn main-btn preview-buttons customize-remove-watermark" @click="removeWaterMark">Remove watermark</button>
            </li>
            <li  class="d-flex d-xl-none px-2 py-1" v-if="user && !isEditBook">
                <button class="btn third-btn" @click="downloadAllAsset">Download</button>
            </li>
            <li class="d-flex d-xl-none px-2 py-1" v-if="user && !isEditBook">
              <button class="btn sec-btn" @click="copyUrl">Copy link</button>
            </li>
            <li class="d-flex d-xl-none px-2 py-1" v-if="user && !isEditBook">
              <button class="btn sec-btn" @click="showShareModal">Share</button>
            </li>-->
        </ul>
    </div>
</template>
<script>
    import RoundedImage from '../RoundedImage';
    import {ref} from 'vue';
    import {mapActions, mapState} from "vuex";
    import {EventBus} from '@/event-bus';

    export default {
        data() {
            return {
                endpoints: endpoints,
                showDropdown: false,
                showSubmenu: false,
                showSubsubmenu1: false
            };
        },
        computed: {
            ...mapState(['canRemoveWm', 'localeUrls'])
        },
        props: {
            user: {
                type: Object,
                required: true,
            },
            is_public: {
                type: Boolean,
                required: false,
            }
        },
        components: {
            RoundedImage
        },
        methods: {
            ...mapActions([
                'setLoggedInUser',
            ]),
            copyUrl() {
                this.$emit('copyUrl');
            },
            downloadAllAsset() {
                this.$emit('downloadAllAsset');
            },
            showShareModal() {
                this.toggleDropdown();
                this.$emit('showShareModal');
            },
            removeWaterMark() {
                this.toggleDropdown();
                if (!this.is_public && this.canRemoveWm) {
                    this.$emit('removeWaterMark');
                } else if (!this.is_public) {
                    this.$emit('packageModal');
                }
            },
            logout() {
                axios.post(this.endpoints.ajax.get.header.logout).then(response => {
                    this.setLoggedInUser(null);
                    EventBus.$emit('getBrandbookList');
                });
            },
            toggleDropdown() {
                this.showDropdown = !this.showDropdown;
            },
            toggleSubmenu() {
                this.showSubmenu = !this.showSubmenu;
            },
            toggleSubsubmenu1() {
                event.preventDefault();
                this.showSubsubmenu1 = !this.showSubsubmenu1;
            }
        }
    };
</script>
<style scoped>
    .dropdown:before {
        content: '';
        display: block;
        height: calc(100% + 10px);
        width: 1px;
        background-color: #dadada;
        position: absolute;
        left: 0px;
        top: -5px;
        bottom: -5px;
    }

    .nav-link {
        color: #000 !important;
    }

    .dropdown-menu .dropdown-menu {
        top: 0px;
        left: auto;
        right: 99% !important;
    }
</style>

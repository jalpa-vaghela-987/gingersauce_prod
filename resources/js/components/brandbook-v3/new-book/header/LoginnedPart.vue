<template>
    <nav class="navbar navbar-expand-md fixed-top bg-white">
        <div class="container-fluid">
            <div class="align-content-center d-flex flex-grow-1 justify-content-between">
                <!--<div class="logo fs-20 fw-500 align-self-center me-3 d-flex align-content-center">
                    <svg width="49" height="50" viewBox="0 0 49 50" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0" y="0" width="49" height="50" fill="#EE6636"/>
                        <path
                            d="M-1 0V50H49V0H-1ZM27.8015 42.03C21.49 43.105 14.764 41.5165 9.487 37.088L13.95 31.7675C17.9335 35.1105 23.1055 36.105 27.801 34.9305V42.03H27.8015ZM27.8015 16.256C26.85 15.234 25.498 14.5905 23.994 14.5905C21.122 14.5905 18.7855 16.927 18.7855 19.798C18.7855 22.67 21.1215 25.007 23.994 25.007C25.4975 25.007 26.8495 24.363 27.8015 23.341V31.3315C26.6025 31.729 25.3245 31.951 23.994 31.951C17.293 31.951 11.841 26.4995 11.841 19.7975C11.841 13.097 17.293 7.6455 23.994 7.6455C25.3245 7.6455 26.602 7.8675 27.8015 8.265V16.256Z"
                            fill="#fff"/>
                    </svg>
                </div>-->
                <div class="name fs-20 fw-500 align-self-center me-3">{{ this.brand_name }} Brand Book</div>
                <div class="d-flex gap-2 flex-grow-0">
                    <button class="btn sec-btn generate-btn" @click=redirectToWizard>
                        <svg class="icon icon-generate" width="17" height="17">
                            <use href="/images/symbol-defs.svg#icon-generate"></use>
                        </svg>
                        Regenerate book
                    </button>
                    <button class="btn main-btn copy-button" @click="copyUrl">Copy link</button>
                </div>
                <div class="d-flex gap-2 flex-grow-0 ms-auto">
                    <button v-if="getUser?.package?.price > 0" class="plan-btn font-weight-bold btn plan-btn paid-plan-btn"> Paid Plan </button>
                    <button v-else class="plan-btn font-weight-bold btn plan-btn free-plan-btn"> Free Plan </button>
                    <!--<SubMenu/>-->
                    <SubMenu :user="getUser"/>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
    import LoginPart from '../header/LoginPart';
    import SubMenu from './SubMenu';
    import {mapState} from "vuex";

    export default {
        components: {
            LoginPart,
            SubMenu
        },
        props: {
            brand_name: {
                type: String,
                default: ''
            }
        },
        computed: {
            ...mapState([
                "getUser"
            ]),
        },
        data() {
            return {};
        },
        methods: {
            redirectToWizard() {
                this.$router.push({name: 'Wizard', params: {id: this.$route.params['id']}});
            },
            copyUrl(){
                const url = window.location.href;

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(url)
                        .then(() => {
                            console.log("URL copied to clipboard.");
                        })
                        .catch((err) => {
                            console.error("Failed to copy: ", err);
                        });
                } else {
                    // Fallback for older browsers
                    const textarea = document.createElement("textarea");
                    textarea.value = url;
                    textarea.style.position = "fixed";  // Prevent scrolling to bottom
                    document.body.appendChild(textarea);
                    textarea.focus();
                    textarea.select();
                    try {
                        document.execCommand("copy");
                        console.log("URL copied with fallback.");
                    } catch (err) {
                        console.error("Fallback copy failed: ", err);
                    }
                    document.body.removeChild(textarea);
                }
            }
        }
    };
</script>
<style>
    .copy-button {
        color: #000 !important;
        background-color: #E3E3E3 !important;
    }
    .plan-btn {
        width: 138px !important;
        height: 32px !important;
        border-radius: 6px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 0 !important;
        text-align: center;
        vertical-align: middle;
        line-height: normal;
    }

    .plan-btn.free-plan-btn {
        background-color: #7DCFFF;
        border-color: #7DCFFF;
    }

    .plan-btn.paid-plan-btn {
        background-color: #FFAB8E;
        border-color: #FFAB8E;
    }
</style>

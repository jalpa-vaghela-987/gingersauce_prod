<template>
    <nav class="navbar navbar-expand-md fixed-top bg-white">
        <div class="container-fluid">
            <LoginnedPart v-if="getUser" :brand_name="brand_name" />
            <LoginPart :brand_name="brand_name" v-else/>
        </div>
    </nav>
</template>

<script>
    import LoginPart from './header/LoginPart.vue';
    import LoginnedPart from './header/LoginnedPart.vue';
    import {mapState, mapActions} from "vuex";


    export default {
        components: {
            LoginnedPart,
            LoginPart
        },
        props:{
            brand_name: {
                type: String,
                default: ''
            }
        },
        data() {
            return {};
        },
        computed: {
            ...mapState([
                "getUser"
            ])
        },
    };
</script>

<template>
    <div class="container-fluid">
        <div class="row justify-content-center pt-5"
             style="height: calc(100vh - 50px); overflow: auto;">
            <div class="col-11">
                <div class="row">
                    <div class="col-12">
                        <h2 class="font-weight-bold">{{ translate( 'Pricing' ) }}</h2>
                    </div>
                    <div class="col-5 mb-3">
                        <span class="f-16">
                            {{translate("Don’t settle with just 2 brand books in your portfolio. Upgrade to an unlimited amount of books.")}}
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 pricing" v-for="package_item in packages">
                        <package-item :package_item="package_item" :action="action" :has_package="has_package" :current_package_id="package"></package-item>
                    </div>
                </div>
                <!-- <div class="row" style="margin-top: 50px;">
                    <div class="col-12">
                        <div style="background: white;padding: 50px 100px;border-radius: 10px;">
                            <p>{{
                                    translate(
                                        'All of the paid plans will allow you to create brand guidelines with no watermarks on them. The brand book will be stored online for as long as 6 months. After that you will be able to extend the book expiry date for $19 a year.' )
                                }}</p></div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</template>

<script>
import translate from '../../utils/translate';
import packageItem from './package';

export default {
    name : 'packages',
    components : {
        packageItem
    },
    props: {
        action : String,
        has_package : Boolean,
        package: {
            type: Number,
            required: false
        }
    },
    data() {
        return {
            packages: [],
        };
    },
    mounted() {
        this.load_packages();
    },
    methods: {
        translate,
        load_packages() {
            axios.get( '/packages' ).then( response => {
                this.packages = response.data;
            } );
        },
    },
};
</script>

<style lang="scss" scoped>

</style>

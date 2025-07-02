<template>
    <div class="row card-deck pricing">
        <div class="col-6 pricing" v-for="package_item in packages">
            <package-item :package_item="package_item" :action="action" :has_package="has_package"></package-item>
        </div>
    </div>
</template>

<script>
import translate from '../../utils/translate';
import packageItem from './package';

export default {
    name      : 'modal-packages',
    components: {
        packageItem,
    },
    props     : {
        action: String,
        has_package : Boolean
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

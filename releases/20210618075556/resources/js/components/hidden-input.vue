<template>
    <input type="hidden" :name=name v-model="value">
</template>
<script>
export default {
    props: [ 'name' ],
    data() {
        return {
            value: '',
        };
    },
    mounted() {
        this.$root.$on( 'fill-value', ( value ) => {
            this.value = value;
        } );
        this.$root.$on( 'switch-changed', ( state ) => {
            if ( state )
                this.value = 1;
            else
                this.value = 0;
        } );
    },
};
</script>

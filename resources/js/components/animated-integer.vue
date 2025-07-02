<template>
    <span :class="{ crossed : crossed }">{{ display_string }}</span>
</template>
<script>
import TWEEN from 'tween.js';

export default {
    props   : {
        value      : {
            type    : [ Number, String, null ],
            required: false,
        },
        contr_value: {
            type    : [ Number, String, null ],
            required: false,
        },
        minlength  : {
            type   : Number,
            default: 1,
        },
        padstr     : {
            type   : String,
            default: '0',
        },
        crossed    : false,
        name       : String,
    },
    data    : function() {
        return {
            tweeningValue: 0,
        };
    },
    watch   : {
        value: function( newValue, oldValue ) {
            this.tween( oldValue, newValue );
        },
    },
    computed: {
        display_string() {
            return this.tweeningValue.toString().padStart( this.minlength, this.padstr );
        }
    },
    mounted : function() {
        this.tween( 0, this.value );
        this.$root.$on( 'switch-changed', ( data ) => {
            if ( this.name === data.name ) {
                if ( data.state ) {
                    this.tween( this.contr_value, this.value );
                } else {
                    this.tween( this.value, this.contr_value );
                }
            }
        } );
    },
    methods : {
        tween: function( startValue, endValue ) {
            var vm = this;

            function animate() {
                if ( TWEEN.update() ) {
                    requestAnimationFrame( animate );
                }
            }

            new TWEEN.Tween( {
                                 tweeningValue: startValue,
                             } ).to( {
                                         tweeningValue: endValue,
                                     }, 500 ).onUpdate( function() {
                vm.tweeningValue = this.tweeningValue.toFixed( 0 );
            } ).start();
            animate();
        },
    },
};
</script>
<style lang="scss" scoped>
.crossed {
    text-decoration: line-through;
}
</style>

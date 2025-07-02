<template>
    <div>
        <init :main_color="main_color" v-if="step==='init'" @forward="goto" @skip="$emit('skip')"></init>
        <tags v-if="step==='tags'" @submit="tag_submit"></tags>
        <submit v-if="step==='submit'" :_archetypes="archetypes" :main_color="main_color"
                :secondary_color="secondary_color" @forward="forward"></submit>
    </div>
</template>

<script>
import init from '../voices/initial-select';
import tags from '../voices/tags-select';
import submit from '../voices/submit';

export default {
    name      : 'step20',
    props     : {
        main_color     : String,
        secondary_color: String,
    },
    components: {
        init,
        tags,
        submit,
    },
    data() {
        return {
            step      : 'init',
            archetypes: [],
        };
    },
    methods: {
        goto( step ) {
            console.log( 'go to ' + step );
            this.step = step;
        },
        tag_submit( archetypes ) {
            this.archetypes = archetypes;
            this.step = 'submit';
        },
        forward(archetypes){
            this.save(archetypes);
            this.$emit('saveArchetypes', archetypes);
        },
        save(archetypes){
            //for refactor branch
        }
    },
};
</script>

<style>

</style>

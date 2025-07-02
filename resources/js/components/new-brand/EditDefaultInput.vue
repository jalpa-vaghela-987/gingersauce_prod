<template>
    <section>
        <input
            type="text"
            class="form-control mb-40"
            :value="value"
            @input="handleChangeInput"
        >
    </section>
</template>

<script>
import {mapActions, mapState} from "vuex";

export default {
    props: { value: String, filed: String },
    computed: {
        ...mapState(['defaultBrandbook'])
    },
    methods: {
        ...mapActions([
            'setDefaultBrandbook'
        ]),
        handleChangeInput(event) {
            this.setDefaultBrandbook({
                ...this.defaultBrandbook,
                [this.filed] : event.target.value
            });
        }
    },
};
</script>

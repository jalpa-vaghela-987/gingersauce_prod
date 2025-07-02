<template>
    <div class="watermark" v-if="defaultBrandbook.watermark">
        <img :src="waterMarkImage" alt="watermark" />
    </div>
</template>

<script>

import {mapState} from "vuex";

export default {
    computed: {
        ...mapState(['waterMarkImage', 'defaultBrandbook']),
    },
}

</script>

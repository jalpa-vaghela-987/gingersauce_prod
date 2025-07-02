<template>
    <div class="col-md-6 col-lg-6 col-sm-12">
        <div class="misuse-block-wrapper d-flex gap-4">
            <div v-if="info.image" class="icon flex-shrink-0 align-self-start mt-1">
                <img
                    :src="info.image"
                    alt="Icon"
                    width="38"
                    height="41"
                />
            </div>
            <div class="text">
                <h5 class="fw-boldest mb-12">{{ info.title }}</h5>
                <p class="fs-12 mb-0">
                    {{ info.description }}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            info: Object,
        },
        data() {
            return {};
        },
    };
</script>

<template>
  <div
    class="logo-container d-flex align-items-center justify-content-center logo-block-v3 main-white"
    :style="`background-color: ${details.colorBg}; ${details.customCss}; ${details.border_radius ? `border-radius: ${details.border_radius};` : ''}`"
  >
    <img
      :style="`color: ${details.colorLogo};`"
      :src="details.logo"
      :class="details.logo"
      class="logo-image"
    />
  </div>
</template>
<script>
    export default {
        props: {
            details: {
                type: Object,
                required: true,
                validator: function (value) {
                    return (
                        'logo' in value &&
                        'colorLogo' in value &&
                        'colorBg' in value &&
                        'customCss' in value &&
                        typeof value.logo === 'string' &&
                        typeof value.colorLogo === 'string' &&
                        typeof value.colorBg === 'string' &&
                        typeof value.customCss === 'string'
                    );
                },
            },
        },
    };
</script>
<style scoped>
.logo-container {
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.logo-image {
    max-width: 50%;
    max-height: 50%;
}
</style>

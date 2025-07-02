<template>
  <section class="align-self-start col-12" :style="{backgroundColor: (brandbook.colors_list && brandbook.colors_list[0]) ? brandbook.colors_list[0].color.hex.value : '' }">
    <h1>{{ brandName }} Brand Book</h1>
  </section>
</template>

<script>
export default {
    props: { brandbook: Object },
    computed: {
        brandName() {
            let brandName = this.brandbook.brand;
            return (brandName) ? brandName.charAt(0).toUpperCase() + brandName.slice(1).toLowerCase() : '';
        }
    }
};
</script>

<style scoped>
#title-book {
  background-color: var(--theme-color);
  padding: 270px 0px 60px 90px;
}
h1 {
  color: #fff;
  text-align: left;
}
</style>

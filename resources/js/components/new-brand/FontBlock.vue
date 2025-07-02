<template>
  <div class="font-block" :style="{ fontFamily: name }">
    <h2 class="font-name">{{ name }}</h2>
    <p class="font-value m-0">{{ text }}</p>
    <div
          v-for="(font, index) in fonts"
          :key="index"
          v-if="font"
          :style="{ fontWeight: caseWeight(font.weight) }"
          class="group-samples"
      >
          <div
              class="font-template d-flex gap-4 flex-wrap justify-content-center justify-content-md-start"
          >
              <div
                  class="first-letter d-flex flex-column justify-content-center align-items-center align-self-center"
              >
                  Aa
                  <span class="company-name d-block">{{ brand }}</span>
              </div>
              <div class="font-sample">
          <span class="font-weight-name">
            {{ font.weight }}
          </span>
                  <div class="alphabet fs-18">
                      ABCDEFGHIJKLMNOPQRSTUVWXYZ<br />
                      abcdefghijkImnopqrstuvwxyz<br />
                      1234567890
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>
<script>
export default {
    props: ['name', 'text', 'brand', 'fonts'],
    methods: {
    caseWeight(weight) {
      weight = weight.replace(/\s/g, '').toLowerCase();
      switch (weight) {
        case 'thin':
          return 100;
        case 'extralight':
          return 200;
        case 'light':
          return 300;
        case 'regular':
          return 400;
        case 'medium':
          return 500;
        case 'semibold':
          return 600;
        case 'bold':
          return 700;
        case 'extrabold':
          return 800;
        case 'black':
          return 900;
        default:
          return 400;
      }
    },
  },
};
</script>

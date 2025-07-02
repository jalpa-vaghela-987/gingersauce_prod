<template>
  <v-select
    :options="fontOptions"
    v-model="selectedFont"
    @change="changeSecFont"
    style="max-width: 200px"
  >
    <template #selected-option="{ label }">
      <span :style="{ fontFamily: label }">{{ label }}</span>
    </template>
    <template #option="{ label }">
      <span :style="{ fontFamily: label }">{{ label }}</span>
    </template>
  </v-select>
</template>

<script>
export default {
  computed: {
    fontOptions() {
      return [
        { label: 'Abril Fatface', code: 'AF' },
        { label: 'Roboto', code: 'RO' },
        { label: 'Open Sans', code: 'OS' },
      ];
    },
    selectedFont: {
      get() {
        return this.$store.getters.secFont;
      },
      set(value) {
        this.changeSecFont(value);
      },
    },
  },
  methods: {
    changeSecFont(newFont) {
      this.$store.commit('changeSecFont', newFont.label);
    },
  },
};
</script>

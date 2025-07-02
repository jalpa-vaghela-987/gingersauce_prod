<template>
  <button class="download fs-14" @click="toggleIcon">
    <transition name="fade" mode="out-in">
      <span v-if="!isDownloaded"
        >{{ text }}
        <svg key="download" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M6.53496 11.202C6.76928 11.4363 7.14918 11.4363 7.38349 11.202L11.2019 7.38362C11.4362 7.14931 11.4362 6.76941 11.2019 6.53509C10.9676 6.30078 10.5877 6.30078 10.3533 6.53509L6.95923 9.9292L3.56512 6.53509C3.3308 6.30078 2.9509 6.30078 2.71659 6.53509C2.48227 6.76941 2.48227 7.14931 2.71659 7.38362L6.53496 11.202ZM6.35923 0.263428L6.35923 10.7777L7.55923 10.7777L7.55923 0.263428L6.35923 0.263428Z"
          />
          <line
            x1="0.408691"
            y1="11.1366"
            x2="13.5913"
            y2="11.1366"
            stroke-width="1.2"
            stroke="currentColor"
          />
        </svg>
      </span>
      <svg
        v-else
        key="checkmark"
        xmlns="http://www.w3.org/2000/svg"
        width="16"
        height="16"
        fill="currentColor"
        class="bi bi-check-lg"
        viewBox="0 0 16 16"
      >
        <path
          d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"
        />
      </svg>
    </transition>
  </button>
</template>

<script>
export default {
  data() {
    return {
      isDownloaded: false,
    };
  },
  props: {
    text: {
      type: String,
      default: 'Save',
    },
  },
  methods: {
    toggleIcon() {
      this.isDownloaded = true;
        this.$emit('download', this.text);
        setTimeout(() => {
        this.isDownloaded = false;
      }, 2000);
    },
  },
};
</script>

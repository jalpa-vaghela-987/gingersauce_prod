<template>
  <a class="link fs-12" @click="toggleIcon" :href="url" target="_blank">
    <transition name="fade" mode="out-in">
      <span v-if="!isDownloaded"
        ><span class="fs-14">{{ text }}</span></span
      >
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
  </a>
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
    url: {
      type: String,
      default: '#',
    },
  },
  methods: {
    toggleIcon() {
      this.isDownloaded = true;
      setTimeout(() => {
        this.isDownloaded = false;
      }, 2000);
    },
  },
};
</script>

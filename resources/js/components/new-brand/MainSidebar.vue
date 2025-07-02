<template>
  <aside :class="{ is_expanded }" class="sticky-xl-top flex-shrink-0">
    <div class="menu">
      <ul class="px-0">
        <li v-for="tab in tabs" :key="tab.id">
          <a
            :href="`#${tab.slug}`"
            :class="['menu-item', { active: activeSection === tab.slug }]"
            @click.prevent="handleClick(tab.slug)"
          >
            <span class="menu-icon">
              <svg :class="`icon ${tab.icon}`" width="25" height="25">
                <use :href="`${icons}#${tab.icon}`"></use>
              </svg>
            </span>
            <span class="text">{{ tab.title }}</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="powered mt-auto d-flex justify-content-center align-items-center">
      <svg class="icon icon-gingersauce_square" width="8" height="8">
        <use :href="`${icons}#icon-gingersauce_square`"></use>
      </svg>
      Powered by gingersauce
    </div>
    <div class="footer menu">
      <ul class="m-0">
        <li>
          <a href="#" class="menu-item">
            <span class="menu-icon">
              <svg class="icon icon-menu-help" width="25" height="25">
                <use :href="`${icons}#icon-menu-help`"></use>
              </svg>
            </span>
            <span class="text">Help</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script>
import icons from "@/utils/new-brand/icons/symbol-defs.svg";
export default {
  data() {
    return {
      icons:icons
    };
  },
  props: { is_expanded: Boolean, activeSection: String, tabs: Array },
  methods: {
    handleClick(slug) {
      this.$emit('set-active-section', slug);
      const element = document.getElementById(slug);
      if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
      }
    },
  },
};
</script>

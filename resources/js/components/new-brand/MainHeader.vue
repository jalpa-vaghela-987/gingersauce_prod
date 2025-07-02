<template>
  <nav class="navbar navbar-expand-md fixed-top bg-white border-bottom">
    <div class="container-fluid">
      <div class="header-logo" :class="`${$store.state.is_expanded ? 'is_expanded logo' : 'logo'}`">
        <a @click.prevent="goTopOnPage" class="brandbook-logo">
            <img class="logo_full" :src="brandbook.logo_b64" :class="`${$store.state.is_expanded ? 'd-block' : 'd-none'}`">
            <img class="logo_short" :src="(brandbook.icon_b64) ? brandbook.icon_b64 : brandbook.logo_b64" :class="`${$store.state.is_expanded ? 'd-none' : 'd-block'}`">
        </a>
      </div>
      <div class="menu-toggle-wrap ms-4 d-flex align-content-center">
        <button
          class="menu-toggle border-0 p-0 bg-transparent d-flex align-self-center"
          @click="onClickButton"
        >
          <svg class="icon icon-hamburger" width="20" height="20">
            <use href="@/utils/new-brand/icons/symbol-defs.svg#icon-hamburger"></use>
          </svg>
        </button>
      </div>
      <div class="align-content-center d-flex flex-grow-1 justify-content-between ms-40">
        <div class="name fs-20 fw-500 align-self-center me-3 d-none d-xl-block">{{ brandbook.brand }} Brand Book</div>
        <!-- <LoginPart /> -->
        <LoginnedPart />
      </div>
    </div>
  </nav>
</template>

<script>
import LoginnedPart from './LoginnedPart.vue';
import { mapState, mapActions } from "vuex";
export default {
  data(){
    return {
    }
  },
  props:{
    brandbook: {
      type: Object,
      default: {}
    },
  },
  components:{
    LoginnedPart
  },
  computed: {
    ...mapState(['is_expanded'])
  },
  methods: {
    ...mapActions(['toggleExpand']),
    onClickButton() {
      this.toggleExpand();
    },
    goTopOnPage() {
        var element = document.getElementById('title-book');
        if (element) { element.scrollIntoView({ behavior: 'smooth' }); }
    }
  },
};
</script>

<style scoped>
.header-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.header-logo .logo_short_icon {
    background-color: #0c0c0c;
}

.brandbook-logo{
    cursor: pointer;
}
</style>

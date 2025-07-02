<template>
  <div class="nav-item dropdown" :class="{ show: showDropdown }">
    <a
      class="nav-link dropdown-toggle d-flex align-items-center py-0 pe-0 fw-bold"
      id="navbarDropdownMenuLink"
      @click="toggleDropdown"
      aria-haspopup="true"
      :aria-expanded="showDropdown"
    >
      <RoundedImage style="width: 34px; height: 34px" />
      <span class="d-none d-md-flex ms-3 me-1 fs-14">Josh Bloch</span>
    </a>
    <ul
      class="dropdown-menu"
      :class="{ show: showDropdown }"
      aria-labelledby="navbarDropdownMenuLink"
    >
      <li><a class="dropdown-item" href="#">Action</a></li>
      <li><a class="dropdown-item" href="#">Another action</a></li>
      <li class="nav-item dropdown" :class="{ show: showSubmenu }">
        <a
          class="dropdown-item"
          @click="toggleSubmenu"
          href="#"
          aria-haspopup="true"
          :aria-expanded="showSubmenu"
        >
          Language
        </a>
        <ul
          class="dropdown-menu"
          :class="{ show: showSubmenu }"
          aria-labelledby="navbarDropdownMenuLink"
        >
          <li><a class="dropdown-item" href="#">EN</a></li>
          <li><a class="dropdown-item" href="#">EN</a></li>
        </ul>
      </li>
      <li class="d-flex d-xl-none px-2 py-1">
        <button class="btn main-btn preview-buttons customize-remove-watermark">
          Remove watermark
        </button>
      </li>
      <li class="d-flex d-xl-none px-2 py-1"><button class="btn third-btn">Download</button></li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import RoundedImage from '../RoundedImage.vue';

const showDropdown = ref(false);
const showSubmenu = ref(false);
const showSubsubmenu1 = ref(false);

const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value;
  if (showDropdown.value) {
    showSubmenu.value = false;
  }
};

const toggleSubmenu = () => {
  showSubmenu.value = !showSubmenu.value;
  if (showSubmenu.value) {
    showDropdown.value = true;
  }
};

const toggleSubsubmenu1 = event => {
  event.preventDefault();
  showSubsubmenu1.value = !showSubsubmenu1.value;
};
</script>

<style scoped>
.dropdown:before {
  content: '';
  display: block;
  height: calc(100% + 10px);
  width: 1px;
  background-color: #dadada;
  position: absolute;
  left: 0px;
  top: -5px;
  bottom: -5px;
}
.nav-link {
  color: #000 !important;
}
.dropdown-menu .dropdown-menu {
  top: 0px;
  left: auto;
  right: 99% !important;
}
</style>

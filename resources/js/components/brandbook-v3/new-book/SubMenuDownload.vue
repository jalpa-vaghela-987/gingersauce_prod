<template>
    <div class="dropdown submenu-download" :class="{ isOpen: isOpen }">
        <button @click="openMenu" class="toggle-btn">
      <span :class="{ rotated: isOpen }">
        <svg
            width="15"
            height="9"
            viewBox="0 0 15 9"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
          <path
              d="M7.71181 8.55976L14.4233 2.55482C15.1074 1.94276 14.6744 0.80957 13.7565 0.80957H1.04016C0.149262 0.80957 -0.296905 1.8867 0.333052 2.51667L6.33791 8.52162C6.71319 8.89691 7.31628 8.91365 7.71181 8.55976Z"
              fill="black"
          />
        </svg>
      </span>
        </button>
        <transition name="dropdown">
            <div v-if="isOpen" class="dropdown-menu" :class="grid">
                <div v-for="(item, index) in elements" :key="index">
                    <SaveButton v-if="item.type === 'save'" :text="item.text" :class="`save-${item.text}`"
                                @download="emitDownload"/>
                    <CopyButton v-if="item.type === 'copy'" :text="item.text" :class="`copy-${item.text}`"
                                @copy="emitCopy"/>
                    <LinkButton
                        v-if="item.type === 'link'"
                        :text="item.text"
                        :url="item.url"
                        :class="`link-${item.text.split('').join('')}`"
                    />
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import CopyButton from './CopyButton.vue';
    import LinkButton from './LinkButton.vue';
    import SaveButton from './SaveButton.vue';

    export default {
        data() {
            return {
                isOpen: false,
            };
        },
        components: {
            SaveButton,
            CopyButton,
            LinkButton,
        },
        props: {
            grid: {
                type: String,
                default: '',
            },
            elements: {
                type: Array,
                default: () => [
                    {type: 'save', text: 'PNG'},
                    {type: 'copy', text: 'PNG'},
                    {type: 'save', text: 'SVG'},
                    {type: 'copy', text: 'SVG'},
                ],
            },
        },
        methods: {
            openMenu() {
                this.isOpen = !this.isOpen;
                if (this.isOpen == true) {
                    setTimeout(() => {
                        this.isOpen = false;
                    }, 4000);
                }
            },
            emitDownload(format) {
                this.$emit('download', format);
            },
            emitCopy(format) {
                this.$emit('copy', format);
            },
        },
    };
</script>

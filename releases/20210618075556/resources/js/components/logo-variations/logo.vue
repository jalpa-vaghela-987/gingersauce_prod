<template>
    <div class="grid">
        <div
            class="logo_tile rounded text-left"
            :style="{ background: hexToRGBa(background, eyeMode ? 0.5 : 1) }"
            v-bind:class="{ 'text-white': background != 'transparent', selected: selected }"
            @click="$emit('select', index)"
        >
            <button
                v-if="!eyeMode"
                class="eye"
                v-html="eye(background && background != 'transparent' ? 'white' : 'black')"
                @click="toggleMode"
            ></button>
            <button
                v-if="eyeMode"
                class="eye"
                v-html="eye_closed(background && background != 'transparent' ? 'white' : 'black')"
                @click="toggleMode"
            ></button>

            <div
                class="logo-container text-center"
                :style="{ backgroundImage: 'url(' + src + ')' }"

            >
                <!-- <div v-html="src"></div> -->
                <!-- <img :src="src" style="object-fit: cover" height="100" /> -->
            </div>
            {{ index + 1 }}
        </div>
    </div>
</template>

<script>
import { eye, eye_closed, grid, grid_base64 } from "../../utils/svg/icons";
import { hexToRGBa } from "../../utils/color";

export default {
    props: {
        title: String,
        src: String,
        svg: String,
        index: Number,
        selected_indexes: Array,
        background: String,
    },

    data() {
        return {
            eyeMode: false,
        };
    },

    mounted() {},

    methods: {
        eye,
        eye_closed,
        grid,
        hexToRGBa,
        grid_base64,

        toggleMode() {
            this.eyeMode = !this.eyeMode;
        },

        getGridBackground() {
            return 'url("data:image/svg+xml;utf8,' + grid() + '")';
        },
    },

    computed: {
        selected() {
            return this.selected_indexes.includes(this.index);
        },
    },
};
</script>

<style lang="scss" scoped>
.logo-container {
    background-position: center;
    background-size: contain;
    background-repeat: no-repeat;
    height: 100px;
}

.selected {
    border: solid 2px #29b473 !important;
}
.logo_tile {
    background: white;
    border: solid 2px #efefef;
    padding: 5px 8px;
}

.eye {
    background-position: center;
    background-repeat: no-repeat;
    border: none;
    outline: 0;
    width: 18px;
    height: 12px;
    background-color: transparent;
}

.grid {
    background-image: url("data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgiIGhlaWdodD0iMjgiIHZpZXdCb3g9IjAgMCAyOCAyOCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB4PSIwLjY5OTIxOSIgd2lkdGg9IjEzLjY1IiBoZWlnaHQ9IjEzLjYzNjQiIGZpbGw9IiNEOUQ5RDkiLz48cmVjdCB4PSIxNC4zNTE2IiB5PSIxMy42Mzc3IiB3aWR0aD0iMTMuNjUiIGhlaWdodD0iMTMuNjM2NCIgZmlsbD0iI0Q5RDlEOSIvPjxyZWN0IHg9IjAuNjk5MjE5IiB5PSIxMy42Mzc3IiB3aWR0aD0iMTMuNjUiIGhlaWdodD0iMTMuNjM2NCIgZmlsbD0iI0Y3RjdGNyIvPjxyZWN0IHg9IjE0LjM0OTYiIHdpZHRoPSIxMy42NSIgaGVpZ2h0PSIxMy42MzY0IiBmaWxsPSIjRjdGN0Y3Ii8+PC9zdmc+");
}
</style>

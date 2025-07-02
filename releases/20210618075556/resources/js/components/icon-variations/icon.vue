<template>
    <div title="Primary Negative in Circle">
        <div
            class="mx-auto"
            style="
                width: 35px;
                height: 35px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0px;
                margin-bottom: 5px;
                border-radius: 50%;
                background: rgb(52, 51, 48);
            "
        >
            <img src="" />
        </div>
    </div>
</template>

<script>
import Schemas from "./schemas";
import { eye, eye_closed, grid, grid_base64 } from "../../utils/svg/icons";
import { hexToRGBa } from "../../utils/color";

export default {
    props: {
        title: String,
        src: String,
        svg: String,
        index: Number,
        background: String,
        selected: Boolean,
    },

    data() {
        return {};
    },

    mounted() {},

    methods: {
        hexToRGBa,
    },
};
</script>

<style lang="scss" scoped>
</style>

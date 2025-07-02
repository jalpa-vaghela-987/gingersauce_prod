<template>
    <div class="">
        <div class="step-title less-top px-0 pt-5">
            {{ translate('Approve Icon Variations') }}
        </div>
        <div class="approve-block" style="">
            <div class="main-block">
                <div
                    class="img"
                    :style="{
                        borderRadius: current.border_radius,
                        background: current.background,
                    }"
                >
                    <img class="main_image" :src="current.icon_b64" />
                </div>
                <div class="icon-title-block">
                    <div class="icon-title-block-name">
                        {{ translate('Name') }}
                    </div>
                    <input
                        type="text"
                        class="icon-title-input"
                        v-model="current.title"
                    />
                    <span v-html="edit()"></span>
                </div>
                <div class="title-approval" style="color: rgb(0, 0, 0)"></div>
            </div>
            <div class="approved">
                <div class="approve-block-title">
                    {{ translate('Approved') }}
                </div>

                <div
                    v-for="render in approvedRenders"
                    :key="render.title"
                    :title="render.title"
                >
                    <div
                        class="mx-auto preview_icon"
                        :style="{
                            width: '35px',
                            height: '35px',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            padding: '0px',
                            marginBottom: '5px',
                            borderRadius: render.border_radius,

                            background: render.background,
                        }"
                    >
                        <img 
                            :src="render.icon_b64"
                            :style="{
                                maxWidth: '50%',
                                maxHeight: '50%'
                            }" />
                    </div>
                </div>
            </div>
        </div>
        <div class="upload-footer">
            <button class="btn btn-outline-secondary" @click="next()">
                <span v-html="rejectIcon()"></span>
                {{ translate('Reject') }}
            </button>
            <button class="btn btn-outline-success" @click="approve()">
                <span v-html="approveIcon()"></span>
                {{ translate('Approve') }}
            </button>
        </div>
    </div>
</template>

<script>
import Schemas from "./schemas";
import translate from "../../utils/translate";
import {
    edit,
    approve as approveIcon,
    skip,
    rejectIcon,
} from "../../utils/svg/icons";
export default {
    props: {
        forApproving: Array
    },
    data() {
        return {
            approvedRenders: [],
            renders: this.forApproving,
            current: {},
        };
    },

    mounted() {
        this.next();
    },

    methods: {
        edit,
        rejectIcon,
        approveIcon,
        translate,

        approve() {
            this.approvedRenders.push(this.current);
            this.next();
        },
        next() {
            if (!this.renders.length) {
                this.complete();
            } else {
                this.current = { ...this.renders[0] };
                this.current.title = this.translate(this.current.title)
                this.renders = this.renders.slice(1);
            }
        },


        complete() {
            this.$emit("approveIconVariations", this.approvedRenders);
        },
    },
};
</script>

<style scoped>
.img {
    max-width: 50%;
    max-height: 50%;
    width: 100px;
    height: 100px;
    display: -webkit-box;
    display: flex;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
}
</style>

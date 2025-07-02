<template>
    <div class="step overflow-auto">
        <div class="step-title less-top px-0">
            {{ translate('Name Logo Variations') }}
            <span
                v-tooltip.bottom="translate('The different logo variations will be utilized for the different applications and usage of the logo. Be it in social media, website, printed materials, large scale graphics or signage, there are endless places and formats on which the logo will need to be on. <br><strong>The more diverse the logo will be - the more successful and strong the brand will be.</strong>')
                "
                ><svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M23.625 12C23.625 18.4217 18.4199 23.625 12 23.625C5.58014 23.625 0.375 18.4217 0.375 12C0.375 5.58202 5.58014 0.375 12 0.375C18.4199 0.375 23.625 5.58202 23.625 12ZM12.312 4.21875C9.75741 4.21875 8.12813 5.29486 6.84872 7.20741C6.68297 7.45519 6.73842 7.78936 6.97598 7.9695L8.6025 9.20278C8.84648 9.3878 9.19411 9.34378 9.38367 9.10331C10.221 8.04122 10.7952 7.42533 12.0697 7.42533C13.0274 7.42533 14.2118 8.04164 14.2118 8.97023C14.2118 9.67223 13.6323 10.0328 12.6868 10.5629C11.5841 11.181 10.125 11.9504 10.125 13.875V14.0625C10.125 14.3731 10.3769 14.625 10.6875 14.625H13.3125C13.6231 14.625 13.875 14.3731 13.875 14.0625V14C13.875 12.6659 17.7743 12.6103 17.7743 9C17.7743 6.28116 14.9541 4.21875 12.312 4.21875ZM12 15.8438C10.811 15.8438 9.84375 16.811 9.84375 18C9.84375 19.1889 10.811 20.1562 12 20.1562C13.189 20.1562 14.1562 19.1889 14.1562 18C14.1562 16.811 13.189 15.8438 12 15.8438Z"
                        :fill="colors[0]"
                    /></svg
            ></span>
        </div>

        <div class="approve-block">
            <div class="main-block" :style="{ background: current.background }">
                <div class="logo_variant text-center">
                    <div>
                        <img :src="current.logo_b64" height="250" />
                    </div>
                    <div
                        class="naming"
                        :class="{ dark: current.background !== 'transparent' }"
                    >
                        <span>
                        {{ translate('Name') }}
                        </span>
                        <input
                            type="text"
                            class="nameInput"
                            v-model="current.title"
                        />
                        <svg
                            width="19"
                            height="18"
                            viewBox="0 0 19 18"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M13.4539 11.7409L14.4623 10.6783C14.6199 10.5123 14.8939 10.6285 14.8939 10.8676V15.6953C14.8939 16.5751 14.2165 17.2891 13.3813 17.2891H2.28897C1.45393 17.2891 0.776367 16.5753 0.776367 15.6953V4.00786C0.776367 3.12801 1.45385 2.41409 2.28897 2.41409H10.9076C11.1313 2.41409 11.2447 2.69961 11.0872 2.86894L10.0788 3.93148C10.0315 3.98132 9.96849 4.00786 9.89915 4.00786H2.28897V15.6954H13.3813V11.9269C13.3813 11.857 13.4065 11.7906 13.4539 11.7409ZM18.3886 5.04046L10.1135 13.7596L7.26478 14.0916C6.43926 14.188 5.73643 13.4541 5.82781 12.5775L6.14294 9.57606L14.4182 0.856888C15.1397 0.0965321 16.3056 0.0965321 17.0241 0.856888L18.3855 2.29127C19.1071 3.05163 19.1071 4.28343 18.3886 5.04046ZM15.2752 6.06643L13.4443 4.13731L7.5892 10.3098L7.35915 12.478L9.41693 12.2355L15.2752 6.06643ZM17.3173 3.42016L15.956 1.98577C15.8266 1.84961 15.6156 1.84961 15.4895 1.98577L14.5158 3.01174L16.3467 4.94087L17.3204 3.9149C17.4464 3.77542 17.4464 3.55624 17.3173 3.42016Z"
                                fill="#6C6B6B"
                            />
                        </svg>
                        <div>
                            {{ current_index + 1 }}
                            {{ translate('of') }}
                            {{ selected.length }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="approved" style="max-height: 300px; overflow: auto">
                <div class="approve-block-title">
                    {{ translate('Approved') }}
                </div>
                <div
                    v-for="approved_logo in approved"
                    :key="approved_logo.title"
                    :title="approved_logo.title"
                    :style="{ background: approved_logo.background }"
                >
                    <div
                        :style="{
                            height: '35px',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            padding: '0px',
                            marginBottom: '5px',

                            background: approved_logo.background,
                        }"
                        class="mx-auto"
                    >
                        <img :src="approved_logo.logo_b64" />
                    </div>
                </div>
            </div>
        </div>

        <div class="upload-footer" style="">
            <button class="btn btn-outline-secondary" @click="next">
                <svg
                    width="22"
                    height="22"
                    viewBox="0 0 22 22"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M15.17 11L21.4244 4.74562C22.1919 3.97812 22.1919 2.73375 21.4244 1.96562L20.0344 0.575625C19.2669 -0.191875 18.0225 -0.191875 17.2544 0.575625L11 6.83L4.74563 0.575625C3.97813 -0.191875 2.73375 -0.191875 1.96563 0.575625L0.575625 1.96562C-0.191875 2.73312 -0.191875 3.9775 0.575625 4.74562L6.83 11L0.575625 17.2544C-0.191875 18.0219 -0.191875 19.2662 0.575625 20.0344L1.96563 21.4244C2.73312 22.1919 3.97813 22.1919 4.74563 21.4244L11 15.17L17.2544 21.4244C18.0219 22.1919 19.2669 22.1919 20.0344 21.4244L21.4244 20.0344C22.1919 19.2669 22.1919 18.0225 21.4244 17.2544L15.17 11Z"
                    />
                </svg>
                {{ translate('Reject') }}
            </button>

            <button class="btn btn-outline-success" @click="approve">
                <svg
                    width="28"
                    height="21"
                    viewBox="0 0 28 21"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M27.2417 4.13797L10.6762 20.5227C10.2246 20.9694 9.49537 20.9665 9.04742 20.5162L0.334063 11.7579C-0.113886 11.3076 -0.111006 10.5804 0.340686 10.1337L2.5213 7.97691C2.9729 7.53027 3.70217 7.53314 4.15012 7.98351L9.88908 13.7522L23.4564 0.333103C23.9079 -0.113543 24.6372 -0.110671 25.0852 0.339612L27.2482 2.5138C27.6962 2.96417 27.6933 3.69133 27.2417 4.13797Z"
                    />
                </svg>
                {{ translate('Approve') }}
            </button>
        </div>
    </div>
</template>

<script>
import translate from "../../utils/translate";
export default {
    components: {},

    props: {
        selected: Array,
        colors: Array,
    },
    data() {
        return {
            approved: [],
            pending: [],
            current: {},
            current_index: 0,
        };
    },
    mounted() {
        this.pending = [...this.selected];
        this.current = this.pending[this.current_index];
        this.current.title = this.translate(this.current.title);
    },

    methods: {
        translate,
        approve() {
            this.approved.push(this.current);
            this.next();
        },

        next() {
            if (this.pending.length) {
                this.pending = this.pending.filter(
                    (i) => i.id != this.current.id
                );
                if (!this.pending.length) {
                    this.complete();
                }
                this.current = { ...this.pending[0] };
                this.current.title = this.translate(this.current.title);
                this.current_index++;
            } else {
                this.complete();
            }
        },

        complete() {
            this.$emit("approveLogoVariations", this.approved);
        },
    },
};
</script>

<style lang="scss" scoped>
.naming.dark {
    * {
        color: #fff;
        svg {
            fill: #fff;
        }
    }
}
.nameInput {
    flex-basis: 76%;
    border: 0;
    border-bottom: 1px solid #6c6b6b;
    font-size: 16px;
    line-height: 150%;
    margin: 0 5px;
    outline: none;
    padding-left: 10px;
    color: #6c6b6b;
    background: transparent;
}

.approve-block {
    display: flex;
    justify-content: space-between;
    padding: 14px 30px 26px;

    .main-block {
        height: 309px;
        width: 100%;
        border: 1px solid #dadada;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;

        .title-approval {
            position: absolute;
            bottom: 10px;
            text-align: center;
            z-index: 4;
            font-size: 16px;

            small {
                display: block;
                text-align: center;
                color: #93989b;
            }
        }
        img {
            max-width: 50%;
            max-height: 50%;
        }
    }

    .approve-block-title {
        font-style: normal;
        font-weight: 900;
        font-size: 28px;
        line-height: 150%;
        /* or 42px */
        text-align: center;
        text-transform: uppercase;

        color: #797979;
        border-bottom: 2px solid #c7c7c7;
    }
    .approved,
    .rejected {
        flex-basis: 192px;
        flex-grow: 0;
        flex-shrink: 0;
        margin: 0 30px;

        div {
            padding: 5px;
            text-align: center;

            img {
                max-height: 35px;
            }
        }

        &.rejected {
            margin-left: 0;
        }

        &.approved {
            margin-right: 0;
        }
    }
}
</style>

<template>
    <div class="row no-gutters" style="margin-bottom: 10px;">
        <div class="col-xl-5 no-gutters text-center">
            <svg v-if="type == 'title'" width="20" height="17" viewBox="0 0 20 17" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M19.0206 14.5714H17.9981L12.2887 0.823058C12.1947 0.582986 12.0165 0.374519 11.7791 0.226908C11.5418 0.0792967 11.2572 -5.04709e-05 10.9653 2.40855e-08H8.90534C8.61343 -5.04709e-05 8.32883 0.0792967 8.09147 0.226908C7.85411 0.374519 7.6759 0.582986 7.58185 0.823058L1.87253 14.5714H0.849993C0.664641 14.5714 0.486881 14.6354 0.355817 14.7493C0.224754 14.8631 0.151123 15.0175 0.151123 15.1786L0.151123 16.3929C0.151123 16.5539 0.224754 16.7083 0.355817 16.8222C0.486881 16.936 0.664641 17 0.849993 17H6.44095C6.6263 17 6.80406 16.936 6.93512 16.8222C7.06619 16.7083 7.13982 16.5539 7.13982 16.3929V15.1786C7.13982 15.0175 7.06619 14.8631 6.93512 14.7493C6.80406 14.6354 6.6263 14.5714 6.44095 14.5714H5.58571L6.60344 12.1429H13.2672L14.2849 14.5714H13.4296C13.2443 14.5714 13.0665 14.6354 12.9355 14.7493C12.8044 14.8631 12.7308 15.0175 12.7308 15.1786V16.3929C12.7308 16.5539 12.8044 16.7083 12.9355 16.8222C13.0665 16.936 13.2443 17 13.4296 17H19.0206C19.206 17 19.3837 16.936 19.5148 16.8222C19.6458 16.7083 19.7195 16.5539 19.7195 16.3929V15.1786C19.7195 15.0175 19.6458 14.8631 19.5148 14.7493C19.3837 14.6354 19.206 14.5714 19.0206 14.5714ZM7.87582 9.10714L9.9353 4.19346L11.9948 9.10714H7.87582Z"
                    />
            </svg>
            <svg style="" v-else width="16" height="17" viewBox="0 0 16 17" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7.90411 1C10.1872 1 11.9406 1.54152 13.1644 2.62455C14.3881 3.68953 15 5.30505 15 7.47112V15.7834H11V13.9693C10.1963 15.3231 8.69863 16 6.50685 16C5.37443 16 4.38813 15.8105 3.54795 15.4314C2.72603 15.0523 2.09589 14.5289 1.65753 13.861C1.21918 13.1931 1 12.435 1 11.5866C1 10.2329 1.51142 9.16787 2.53425 8.3917C3.57534 7.61552 5.17352 7.22744 7.32877 7.22744H10.726C10.726 6.30686 10.4429 5.60289 9.87671 5.11552C9.3105 4.61011 8.46119 4.3574 7.32877 4.3574C6.54338 4.3574 5.76712 4.48375 5 4.73646C4.25114 4.97112 3.61187 5.29603 3.08219 5.71119L1.54795 2.75993C2.3516 2.20036 3.3105 1.76715 4.42466 1.46029C5.55708 1.15343 6.71689 1 7.90411 1ZM7.57534 13.157C8.30594 13.157 8.95434 12.9946 9.52055 12.6697C10.0868 12.3267 10.4886 11.8303 10.726 11.1805V9.69133H7.79452C6.0411 9.69133 5.16438 10.2599 5.16438 11.3971C5.16438 11.9386 5.37443 12.3718 5.79452 12.6968C6.23288 13.0036 6.82648 13.157 7.57534 13.157Z"
                    stroke="" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round"/>
            </svg>
            {{ title }}
        </div>
        <div class="col-xl-4 no-gutters">
            <div class="dropdown" v-on-click-away="close">
                <input type="hidden" :name="type + '_category'" v-model="selectedCategory"/>
                <input ref="dropdowninput" v-model="inputValue"
                       class="dropdown-input" type="text" @click="toggleShow" v-on:input="resize"
                       :name="type + '_family'"/>
                <div v-show="apiLoaded && fonts_show" class="dropdown-list" ref="selectList"
                     :style="`--top: ${height}px`">
                    <div @click="selectItem(item)" v-show="itemVisible(item)" v-for="item in itemList"
                         :key="item.family" class="dropdown-item"
                         :style="{'font-family': item.family + ', ' + item.category}">
                        {{ item.family }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 no-gutters">
            <select class="select-css" v-model="selectedFont" :name="type + '_weight'">
                <option 
                    v-for="weight in weights" 
                    :value="weight" 
                    :selected="weight == selectedFont">
                    {{ weight }}
                </option>
            </select>
        </div>
    </div>

</template>

<script>
import {directive as onClickAway} from 'vue-clickaway';

export default {
    name: "font-select",
    props: {
        title: String,
        'index': String,
        type: String,
        font: Object
    },
    data() {
        return {
            selectedItem: {},
            inputValue: '',
            itemList: [],
            apiLoaded: false,
            fonts_show: false,
            weights: [],
            selectedFont: '',
            selectedFamily: '',
            selectedCategory: '',
            height: -500
        }
    },
    directives: {
        onClickAway: onClickAway
    },
    watch: {
        selectedItem: function (val) {
            this.weights = val.variants;
            this.selectedFont = this.weights[0];
        },
        inputValue: function (val) {
            var self = this;
            Vue.nextTick(function () {
                let element = self.$refs.selectList;
                self.height = element.clientHeight == 0 ? -500 : -element.clientHeight;
            })
        }
    },
    mounted() {
        this.apikey = 'AIzaSyAqNaDv_jucLZ9KxfCdR2x5l5C9FD4trgw';
        axios.get('https://www.googleapis.com/webfonts/v1/webfonts?key=' + this.apikey).then(response => {
            this.itemList = response.data.items
            this.apiLoaded = true;
        });
        if(this.font.family){
            this.selectedFamily = this.font.family;
            this.selectedFont = this.font.weight;
            this.selectedCategory = this.font.category;
            this.inputValue = this.font.family;
        }
    },
    methods: {
        selectItem(theItem) {
            this.selectedItem = theItem
            this.inputValue = theItem.family
            this.selectedCategory = theItem.category
            this.fonts_show = false;
        },
        selectWeight(item) {
            this.selectedFont = item;
        },
        itemVisible(item) {
            let currentName = item.family.toLowerCase()
            let currentInput = this.inputValue.toLowerCase()
            return currentName.includes(currentInput)

            let height = this.$refs.selectList.clientHeight;
            console.log(height);
        },
        toggleShow() {
            this.inputValue = '';
            this.fonts_show = !this.fonts_show;
        },
        close() {
            this.fonts_show = false;
        },
        resize() {
            this.$nextTick(() => function () {
                let height = this.$refs.selectList.clientHeight;
                console.log(height);
            });

        }
    }
}
</script>

<style lang="scss">
.custom-edit-block {
    .dropdown {
        position: relative;
        width: 96%;
        max-width: 400px;
        margin: 0 auto;
        background-image: url(data:image/svg+xml;base64,PHN2ZyBmaWxsPSdibGFjaycgaGVpZ2h0PScyNCcgdmlld0JveD0nMCAwIDI0IDI0JyB3aWR0aD0nMjQnIHhtbG5zPSdodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2Zyc+PHBhdGggZD0nTTcgMTBsNSA1IDUtNXonLz48cGF0aCBkPSdNMCAwaDI0djI0SDB6JyBmaWxsPSdub25lJy8+PC9zdmc+);
        background-repeat: no-repeat;
        background-position-x: 100%;
        background-position-y: 5px;
    }

    .dropdown-input, .dropdown-selected {
        width: 100%;
        padding: 1px 8px;
        background: rgba(255, 255, 255, 0.3);
        outline: none;
        border: none;
    }

    .dropdown-input::placeholder {
        opacity: 0.7;
    }

    .dropdown-selected {
        cursor: pointer;
    }

    .dropdown-list {
        --top: -500px;
        position: absolute;
        width: 100%;
        max-height: 500px;
        margin-top: 4px;
        overflow-y: auto;
        background: #ffffff;
        top: var(--top);
        overflow-x: hidden;
    }

    .dropdown-item {
        display: flex;
        width: 100%;
        cursor: pointer;
    }

    /* class applies to select element itself, not a wrapper element */
    .select-css {
        display: block;
        /* font-size: 16px; */
        padding: 1px 8px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        margin: 0;
        -moz-appearance: none;
        -webkit-appearance: none;
        appearance: none;
        background-color: rgba(255, 255, 255, 0.3);
        border: none;
        background-image: url(data:image/svg+xml;base64,PHN2ZyBmaWxsPSdibGFjaycgaGVpZ2h0PScyNCcgdmlld0JveD0nMCAwIDI0IDI0JyB3aWR0aD0nMjQnIHhtbG5zPSdodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2Zyc+PHBhdGggZD0nTTcgMTBsNSA1IDUtNXonLz48cGF0aCBkPSdNMCAwaDI0djI0SDB6JyBmaWxsPSdub25lJy8+PC9zdmc+);
        background-repeat: no-repeat;
        background-position-x: 100%;
        background-position-y: 5px;
    }

    .select-css option {
        color: black;
    }

    /* Hide arrow icon in IE browsers */
    .select-css::-ms-expand {
        display: none;
    }

    /* Hover style */
    .select-css:hover {
        border-color: #888;
    }

    /* Focus style */
    .select-css:focus {
        outline: none;
    }

    /* Set options to normal weight */
    .select-css option {
        font-weight: normal;
    }

    /* Support for rtl text, explicit support for Arabic and Hebrew */
    *[dir="rtl"] .select-css, :root:lang(ar) .select-css, :root:lang(iw) .select-css {
        background-position: left .7em top 50%, 0 0;
        padding: .6em .8em .5em 1.4em;
    }

    /* Disabled styles */
    .select-css:disabled, .select-css[aria-disabled=true] {
        color: graytext;
        background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22graytext%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'),
        linear-gradient(to bottom, #ffffff 0%, #e5e5e5 100%);
    }

    .select-css:disabled:hover, .select-css[aria-disabled=true] {
        border-color: #aaa;
    }

    .dark select.select-css {
        color: white;
    }
}

</style>

<template>
    <div class="color-new">
        <div class="color-block">
            <div class="color-title" :class="title_color">{{title}}</div>
            <div class="color-background"
                 v-bind:style="[typeof color_ !== 'undefined' ? {background: color_.hex} : {background: '#FFFFFF'}]"></div>
            <div class="color-bottom" v-if="typeof color !== 'undefined'">
                <input type="text" :id=_id v-model=color.hex class="color-code">
                <div @click=toggleLock :class="['color-lock', locked?'locked':'']" :style="{'--color': main_color}">
                    <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none"/>
                        <path
                            d="M12 17c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm6-9h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6h1.9c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm0 12H6V10h12v10z"/>
                    </svg>
                </div>
                <div :class="['color-change', locked?'disabled':'']" @click=changeColor>
                    <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none"/>
                        <path
                            d="M3 17v2h6v-2H3zM3 5v2h10V5H3zm10 16v-2h8v-2h-8v-2h-2v6h2zM7 9v2H3v2h4v2h2V9H7zm14 4v-2H11v2h10zm-6-4h2V7h4V5h-4V3h-2v6z"/>
                    </svg>
                </div>
                <div :class="['color-move-left', locked?'disabled':'']" @click="moveLeft" v-if="index>=1">
                    <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z"/>
                        <path d="M0-.5h24v24H0z" fill="none"/>
                    </svg>
                </div>
                <div :class="['color-move-right', locked?'disabled':'']" @click="moveRight" v-if="index<4">
                    <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"/>
                        <path d="M0-.25h24v24H0z" fill="none"/>
                    </svg>
                </div>
            </div>
            <div class="color-description" v-if="typeof color !== 'undefined'">
                <div class="title">{{color.name}}</div>
                <div class="description" :title="color.description">{{color.description}}</div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        'color': Object, 'title': String, 'locked': Boolean, 'main_color': String, 'index': Number
    },
    mounted() {
        this.bindSelector()
        this.color_ = this.color
        this.title_color = this.lightOrDark(this.color.hex);
    },
    data() {
        return {
            color_: {hex: '', name: '', description: ''},
            timeout: null,
            title_color : String
        }
    },
    methods: {
        moveLeft() {
            if (!this.locked)
                this.$root.$emit('move-color-left', {index: this.index})
        },
        moveRight() {
            if (!this.locked)
                this.$root.$emit('move-color-right', {index: this.index})
        },
        toggleLock() {
            if (this.locked)
                this.$root.$emit('color-new-unlock', {index: this.index})
            else
                this.$root.$emit('color-new-lock', {index: this.index})

        },
        changeColor() {
            if (!this.locked)
                $('#' + this._id).focus()
        },
        bindSelector() {
            var _this = this
            setTimeout(() => {
                $('#' + this._id).chromoselector({
                    update: () => {
                        if (_this.color.hex.length == 7) {
                            var color = $('#' + this._id).chromoselector('getColor').getHexString()
                            clearTimeout(_this.timeout)
                            _this.timeout = setTimeout(() => {
                                _this.color_.hex = color
                                _this.$root.$emit('color-new-changed', {index: _this.index, color: color})
                                this.title_color = this.lightOrDark(color);
                                // _this.load(color)
                            }, 2000)
                        }

                        // $('.ui-cs-chromoselector').hide()
                    }
                })
            }, 2000)
        },
        lightOrDark(color) {
            // Check the format of the color, HEX or RGB?
            var r,g,b;
            if (color.match(/^rgb/)) {
                // If HEX --> store the red, green, blue values in separate variables
                color = color.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/);

                r = color[1];
                g = color[2];
                b = color[3];
            } else {
                // If RGB --> Convert it to HEX: http://gist.github.com/983661
                color = +("0x" + color.slice(1).replace(
                        color.length < 5 && /./g, '$&$&'
                    )
                );
                r = color >> 16;
                g = color >> 8 & 255;
                b = color & 255;
            }

            // HSP (Highly Sensitive Poo) equation from http://alienryderflex.com/hsp.html
            let hsp = Math.sqrt(
                0.299 * (r * r) +
                0.587 * (g * g) +
                0.114 * (b * b)
            );

            // Using the HSP value, determine whether the color is light or dark
            if (hsp > 127.5) {

                return 'light';
            } else {

                return 'dark';
            }
        }
    },
    computed: {
        _id() {
            return 'ncolor-' + this._uid
        }
    },
    watch: {
        color: function () {
            this.color_ = this.color
        }
    }
}
</script>
<style lang="scss">
.color-new {
    .color-block {
        .color-background {
            width: 100%;
            height: 90px;
        }

        .color-title {
            font-size: 16px;
            color: #000;
            text-align: center;
            min-height: 28px;
            font-weight: 500;
        }

        .color-description {
            background: #F5F0EF;
            border: 1em solid transparent;
            box-sizing: border-box;
            font-size: 14px;
            height: 135px;
            overflow: hidden;
            text-overflow: ellipsis;

            .title {
                font-weight: bold;
                margin-bottom: 10px;
                white-space: nowrap;
                height: 18px;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .description {
                font-size: 12px;
                text-overflow: ellipsis;
                height: calc(107px - 2em);
                overflow: hidden;
                -webkit-line-clamp: 4;
                -webkit-box-orient: vertical;
                display: -webkit-box;
            }
        }

        .color-bottom {
            display: flex;
            margin-top: 1em;
            flex-wrap: wrap;
            margin-bottom: 1em;
            justify-content: space-between;
            align-items: center;
            align-content: center;

            .color-code {
                font-size: 12px;
                color: #000;
                text-align: left;
                min-height: 1em;
                font-weight: 500;
                text-transform: uppercase;
                border: 0;
                width: 40%;
                flex-basis: 40%;
                text-indent: -8px;
                outline: none;
                letter-spacing: 1px;
            }

            .color-change, .color-move-left, .color-move-right, .color-lock {
                cursor: pointer;
                width: 2em;
                height: 2em;
                display: flex;
                align-items: center;
                justify-content: center;

                svg {
                    fill: #ccc;
                    transition: all .5s;
                    width: 16px;
                    height: auto;
                }

                &:hover {
                    svg {
                        fill: #777;
                    }
                }

                &.disabled {
                    &:hover {
                        svg {
                            fill: #ccc;
                        }
                    }
                }
            }

            .color-move-left, .color-move-right {
                width: 1em;
            }

            .color-lock {

                &.locked {
                    svg {
                        fill: #fff;
                    }

                    background: var(--color);
                    border-radius: 50%;
                    width: 2em;
                    height: 2em;

                }
            }
        }
    }
}
</style>

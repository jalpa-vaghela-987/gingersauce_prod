<template>
    <div class="bg-white rounded p-4">
        <div class="invoice-co-product-row">
            <div class="invoice-co-product-description">
                <div class="invoice-co-title">
                    {{ name }}
                </div>
                <div class="invoice-co-subtitle">
                    <span v-if="upper_title!=''">{{ upper_title }}</span>
                </div>
            </div>
            <div class="invoice-co-price">
                US$<strong>{{ price }}</strong>
            </div>
        </div>
        <div class="invoice-co-product-row" v-if="extend_book">
            <div class="invoice-co-product-description">
                <div class="invoice-co-title">
                    {{ translate('Extend by') }}
                </div>
                <div class="invoice-co-subtitle">
                    <span>{{ extend_duration }} {{ translate('years') }}</span>
                </div>
            </div>
            <div class="invoice-co-price">
            </div>
        </div>
        <div class="invoice-co-product-row" v-if="refund">
            <div class="invoice-co-product-description">
                <input type="hidden" name="upgrade" value="1" />
                <div class="refund">{{translate('Refund')}}</div>

                <div class="invoice-co-title">
                    {{ refund_name }}
                </div>
                <div class="invoice-co-subtitle">
                    <span v-if="refund_upper_title!=''">{{ refund_upper_title }}</span>
                </div>
            </div>
            <div class="invoice-co-price refund-price">
                - US$<strong>{{ refund_price }}</strong>
            </div>
        </div>
        <div class="invoice-co-product-row" v-if="coupon_id==''">
            <div class="invoice-co-product-description">
                <div class="invoice-co-coupon">
                    <label for="invoice-co-coupon">
                        {{ translate('Do you have a coupon?') }}
                    </label>
                    <input type="text" class="form-control form-control-sm" id="invoice-co-coupon" name="coupon"
                           v-model="coupon" :placeholder="translate('Add a coupon code')">
                </div>
            </div>
            <div class="invoice-co-price invoice-co-button">
                <a class="btn btn-link text-danger" @click.prevent="coupon_validate">
                    {{ translate('Apply') }}
                </a>
            </div>
        </div>
        <div class="invoice-co-product-row" v-else>
            <div class="invoice-co-product-description">
                <div class="invoice-co-title">
                    {{ coupon }} <a class="btn btn-link text-danger" @click.prevent="clear">&times;</a>
                </div>
            </div>
            <div class="invoice-co-price">
                <strong>-{{ discount }}%</strong>
            </div>
        </div>
        <div class="invoice-co-product-row" v-if="country === 'IL'">
            <div class="invoice-co-product-description">
                <div class="invoice-co-title">
                    {{ translate('VAT') }}
                </div>
            </div>
            <div class="invoice-co-vat">
                US$<strong
                class="final-price">{{ parseFloat(parseInt(price) * (parseInt(vat) / 100)).toFixed(2) }}</strong>
                <input type="hidden" name="vat" v-model="vat">
            </div>
        </div>
        <div class="invoice-co-product-row">
            <div class="invoice-co-product-description">
                <div class="invoice-co-title">
                    {{ translate('Amount due today') }}
                </div>
            </div>
            <div class="invoice-co-price">
                US$<strong class="final-price">{{ total }}</strong>
                <input type="hidden" name="coupon_id" v-model="coupon_id">
            </div>
        </div>
        <div class="button-row">
            <button class="submit-button btn btn-danger w-100 d-block btn-lg" :disabled="country === ''">
                {{ translate('Complete checkout') }}
            </button>
        </div>
        <div class="invoice-co-description">
            <div class="icon">
                <svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0)">
                        <rect x="1.07422" y="7.79492" width="13.1856" height="9.96185" rx="1.25" stroke="#797979"
                              stroke-width="1.5"/>
                        <path
                            d="M4.05908 4.96324C4.05908 2.97059 5.67444 1.35522 7.66709 1.35522C9.65974 1.35522 11.2751 2.97059 11.2751 4.96323V7.7353H4.05908V4.96324Z"
                            stroke="#797979" stroke-width="1.5"/>
                    </g>
                    <defs>
                        <clipPath id="clip0">
                            <rect x="0.324219" y="0.605225" width="14.6856" height="17.9015" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <div class="text">
                <strong>
                    {{ translate('Secure checkout.') }}
                </strong>
                {{translate('For your convenience Gingersauce will store your encrypted payment information for future orders. Manage your payment information in your Account Details')}}
            </div>
        </div>
    </div>
</template>
<script>
import translate from "../utils/translate";

export default {
    data() {
        return {
            coupon: '',
            discount: 0,
            coupon_id: '',
            country: '',
            vat: 0,
            clicked: false,
            extend_book : Boolean,
            loading : false
        }
    },
    props: {
        name: String,
        credits: Number,
        extend_duration: Number,
        upper_title: String,
        price: Number,
        refund_price : Number,
        refund: Boolean,
        refund_name: String,
        refund_upper_title: String,
    },
    mounted() {
        this.extend_book = this.extend_duration > 0;
        this.$root.$on('country-change', (data) => {
            this.country = data.country;
            this.vat = this.country === 'IL' ? 17 : 0;
        })

        $('.submit-button').on('click', function () {
            $(this).prop('disabled', true);
            $(this).closest('form').submit();
        })
    },
    computed: {
        total() {
            var price = this.price - this.price * (this.discount / 100) - this.refund_price;
            return (price + price * (this.vat / 100)).toFixed(2);
        }
    },
    methods: {
        translate,
        clear() {
            this.coupon_id = ''
            this.coupon = ''
            this.discount = 0
        },
        coupon_validate() {
            axios.post(endpoints.ajax.post.coupon, {coupon: this.coupon})
                .then(response => {
                    if (response.data.status == 'ok') {
                        this.discount = response.data.discount
                        this.coupon_id = response.data.id
                        new Noty({
                            type: 'info',
                            text: this.translate('Congratulations! You have applied :percent% discount.').replace(':percent', response.data.discount),
                            timeout: 5000,
                        }).show();
                    } else {
                        this.discount = 0
                        new Noty({
                            type: 'error',
                            text: this.translate('Unfortunately the coupon you have used is not valid.'),
                            timeout: 5000,
                        }).show();
                    }
                }).catch(error => {
                new Noty({
                    type: 'error',
                    text: this.translate('Unfortunately the coupon you have used is not valid.'),
                    timeout: 5000,
                }).show();
            })
        }
    }
}
</script>
<style lang="scss">
.invoice-co-product-row {
    display: flex;
    justify-content: space-between;
    padding-bottom: 10px;
    padding-top: 10px;
    border-bottom: 2px solid #C7C7C7;

    .invoice-co-product-description {

        flex-basis: 80%;

        .refund {
            color: #29B473;
            font-weight: 800;
            font-size: 14px;
            line-height: 150%;
            margin-bottom: 5px;
        }

        .invoice-co-title {
            font-weight: 500;
            font-size: 18px;
            line-height: 150%;
            /* or 27px */


            color: #000000;
        }

        .invoice-co-subtitle, label {
            font-weight: 500;
            font-size: 14px;
            line-height: 150%;
            /* or 21px */


            color: #797979;
        }
    }

    .invoice-co-price {
        flex-basis: 20%;
        text-align: right;

        font-weight: normal;
        font-size: 18px;
        line-height: 150%;
        /* or 27px */

        text-align: right;

        color: #000000;
    }

    .refund-price{
        margin-top: 20px;
    }

    .form-control-sm {
        border: none;
        outline: none;
        padding: 0;
        font-size: 14px;
        font-weight: 500;
    }
}

.button-row {
    margin-bottom: 20px;
    margin-top: 20px;
}

.invoice-co-description {
    display: flex;

    .icon {
        flex-basis: 80px;
        text-align: center;
    }

    .text {
        font-size: 11px;
        line-height: 150%;
        /* or 16px */


        color: #797979;
    }
}
</style>

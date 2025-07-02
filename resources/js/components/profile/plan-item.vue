<template>
    <div class="plan-item row">
        <div class="plan-item-icon col-2" v-if="book">
            <svg class="svg-calendar" width="32" height="37" viewBox="0 0 32 37" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M32 25.7143V1.71429C32 0.764286 31.2357 0 30.2857 0H6.85714C3.07143 0 0 3.07143 0 6.85714V29.7143C0 33.5 3.07143 36.5714 6.85714 36.5714H30.2857C31.2357 36.5714 32 35.8071 32 34.8571V33.7143C32 33.1786 31.75 32.6929 31.3643 32.3786C31.0643 31.2786 31.0643 28.1429 31.3643 27.0429C31.75 26.7357 32 26.25 32 25.7143ZM9.14286 9.57143C9.14286 9.33571 9.33571 9.14286 9.57143 9.14286H24.7143C24.95 9.14286 25.1429 9.33571 25.1429 9.57143V11C25.1429 11.2357 24.95 11.4286 24.7143 11.4286H9.57143C9.33571 11.4286 9.14286 11.2357 9.14286 11V9.57143ZM9.14286 14.1429C9.14286 13.9071 9.33571 13.7143 9.57143 13.7143H24.7143C24.95 13.7143 25.1429 13.9071 25.1429 14.1429V15.5714C25.1429 15.8071 24.95 16 24.7143 16H9.57143C9.33571 16 9.14286 15.8071 9.14286 15.5714V14.1429ZM27.2429 32H6.85714C5.59286 32 4.57143 30.9786 4.57143 29.7143C4.57143 28.4571 5.6 27.4286 6.85714 27.4286H27.2429C27.1071 28.65 27.1071 30.7786 27.2429 32Z"
                    fill="#EE6636"/>
            </svg>

            <!-- <svg class="svg-calendar" v-if="plan" width="32" height="36" viewBox="0 0 32 36" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0)">
                    <path
                        d="M32 7.80769V32.3462C32 34.1935 30.4643 35.6923 28.5714 35.6923H3.42857C1.53571 35.6923 0 34.1935 0 32.3462V7.80769C0 5.96034 1.53571 4.46154 3.42857 4.46154H6.85714V0.836538C6.85714 0.376442 7.24286 0 7.71429 0H10.5714C11.0429 0 11.4286 0.376442 11.4286 0.836538V4.46154H20.5714V0.836538C20.5714 0.376442 20.9571 0 21.4286 0H24.2857C24.7571 0 25.1429 0.376442 25.1429 0.836538V4.46154H28.5714C30.4643 4.46154 32 5.96034 32 7.80769ZM28.5714 31.9279V11.1538H3.42857V31.9279C3.42857 32.1579 3.62143 32.3462 3.85714 32.3462H28.1429C28.3786 32.3462 28.5714 32.1579 28.5714 31.9279Z"
                        fill="#EE6636" stroke="white"/>
                    <path
                        d="M16 14.7693L17.6579 19.8719H23.0232L18.6826 23.0255L20.3405 28.1282L16 24.9746L11.6594 28.1282L13.3174 23.0255L8.97679 19.8719H14.342L16 14.7693Z"
                        fill="#EE6636"/>
                </g>
                <defs>
                    <clipPath id="clip0">
                        <rect width="32" height="35.6923" fill="white"/>
                    </clipPath>
                </defs>
            </svg> -->

            <div class="icon-header"> {{ plan ? translate('Plan') : translate('Book') }}</div>
        </div>
        <div class="plan-info-item-wrapper col-7">
            <!-- <div class="plan-item-info">
                <div class="plan-item-label">{{ plan ? translate('Plan') : translate('Book') }}</div>
                <div class="plan-item-field">{{ title }}</div>
            </div> -->
            <!-- <div class="plan-item-info" v-if="plan">
                <div class="plan-item-label">{{ translate('Books remaining untill') }} {{ expire_date }}</div>
                <div class="plan-item-field">{{ books_remaining }}</div>
            </div> -->
            <div class="plan-item-info" v-if="book">
                <div class="plan-item-label">{{ translate('Books number') }}</div>
                <div class="plan-item-field">{{ _id }}</div>
            </div>
            <div class="plan-item-info">
                <div class="plan-item-label">{{
                        plan ? translate('Subscription renewal date') : translate('Book Expiry Date')
                    }}
                </div>
                <div class="plan-item-field border-bottom-0">{{ expire_date?expire_date:translate('Forever') }}</div>
                <button v-if="book" class="extend-book-date profile-button" @click="extendDate">
                    {{ translate('Extend date') }}
                </button>
            </div>
            <div class="plan-item-info" v-if="plan">
                <div class="plan-item-label">{{translate('Subscription Amount')}}
                </div>
                <div class="plan-item-field border-bottom-0">USD ${{ amount.toFixed(2) }}</div>
            </div>
            <div class="plan-item-info" v-if="book">
                <div class="plan-item-label">{{ translate('Auto renewal') }}</div>
                <div class="plan-item-field">{{ auto_renewal ? translate('On') : translate('Off') }}</div>
                <button class="autorenewal profile-button" :class="{'button_off' : auto_renewal}"
                        @click="toggleAutorenewal">
                    {{ auto_renewal ? translate('Switch off Auto renewal') : translate('Switch on Auto renewal') }}
                </button>
            </div>
            <div class="plan-item-info" v-if="plan">
                <div class="plan-item-label" v-if="auto_renewal">
                    <a href="javascript:void(0);" @click="toggleAutorenewal" class="plan-item-anchor">{{ translate('Cancel renewal of subscription') }}</a>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="img-wrapper" v-if="book">
                <a :href="book_href">
                    <img :src="preview_src">
                </a>
            </div>
            <button class="upgrade-plan profile-button" v-if="plan && allow_upgrade" @click="upgrade">
                {{ translate('Upgrade plan') }}
            </button>
        </div>
    </div>
</template>

<script>
import translate from "../../utils/translate";

export default {
    name: "plan-item",
    props: {
        title: String,
        expire_date: String,
        books_remaining: String,
        auto_renewal: Boolean,
        preview_src: String,
        plan: Boolean,
        book: Boolean,
        book_href : String,
        _id: Number,
        amount: {
            type: Number,
            required:false,
        }
    },
    data() {
        return {
            endpoints: endpoints,
            action_submit_cancel_auto_renewal: 'waiting-for-submit',
            action_add_payment_method_submit: 'add-payment-method',
            action_id: String,
            allow_upgrade: Boolean
        }
    },
    mounted() {
        this.type = this.book ? 'book' : 'plan';
        this.action_id = this.type + this._id;
        this.allow_upgrade = this.title === 'professional' && this.plan;

        this.$root.$on(this.action_submit_cancel_auto_renewal, (data) => {
            if (data.action_id === this.action_id) {
                axios.post(this.endpoints.ajax.post.toggle_reccuring, {
                    action: 'off',
                    type: this.book ? 'book' : 'package',
                    id: this._id
                }).then(response => {
                    this.auto_renewal = false;
                }).catch(error => {
                    console.log(error);
                })
            }
        });

        this.$root.$on(this.action_add_payment_method_submit, (data) => {
            if(data.action_id === this.action_id){
                window.location = this.endpoints.create_payment_method;
            }
        })
    },
    methods: {
        translate,
        upgrade() {
            this.$root.$emit('show-upgrade-modal');
        },
        showNoPaymentModal() {
            this.$root.$emit('show-submit-modal', {
                title: translate('No payment on file'),
                body: translate('In order to switch on Auto renewal we need you to have a payment method o'),
                button_cancel_text: translate('Keep off'),
                button_submit_text: translate('Add payment method'),
                button_dismiss_class : 'btn-outline-secondary',
                button_confirm_class : 'btn-danger',
                action: this.action_add_payment_method_submit,
                action_id: this.action_id
            });
        },
        toggleAutorenewal() {
            if (this.auto_renewal) {
                this.autorenewalOff();
            } else {
                this.autorenewalOn();
            }
        },
        autorenewalOn() {
            axios.post(this.endpoints.ajax.post.toggle_reccuring,
                {
                    action: 'on',
                    type: this.plan ? 'package' : 'book',
                    id: this._id
                }).then(response => {
                this.auto_renewal = true;
            }).catch(error => {
                if(error.response.data.error_message == 'no_pm'){
                    this.showNoPaymentModal();
                } else {
                    new Noty({
                        type: 'error',
                        text: error.response.data.error_message,
                        timeout: 5000,
                    }).show();
                }
            });
        },
        autorenewalOff() {
            this.$root.$emit('show-submit-modal', {
                title: translate('Auto Renewal'),
                body: translate('Are you sure you want to suspend auto renewal? <br/> <br/> Gingersauce’s auto renewal feature ensures that your subscription or book automatically renews so that you can maintain an uninterrupted supply of books.'),
                button_cancel_text: translate('Keep on'),
                button_submit_text: translate('Turn off'),
                action: this.action_submit_cancel_auto_renewal,
                action_id: this.action_id
            });
        },
        extendDate() {
            this.$root.$emit('show-extend-modal', {
                preview_src: this.preview_src,
                book: {
                    id: this._id,
                    name: this.title,
                    expiry: this.expire_date
                },

            })
        }
    }
}
</script>

<style scoped>

</style>

<template>
    <div class="payment-method-wrapper">
        <div class="card-info-row" @click="collapsed = !collapsed">
            <div class="card-info-label row" style="position:relative;font-size: 18px">
                <div class="col-1"><i :class="card_type.toLowerCase()" class="payment-card-icon"></i></div>
                <div class="col-11"> {{ card_type }} {{ translate('ending in') }} {{ last4 }}
                    <div v-if="is_default" class="default-payment-label">{{ translate('Default payment method') }}</div>
                </div>

                <div class="arrow">
                    <svg v-if="!collapsed" width="13" height="7" viewBox="0 0 13 7" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 6L6.5 1L1 6" stroke="black"/>
                    </svg>
                    <svg v-if="collapsed" width="13" height="7" viewBox="0 0 13 7" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L6.5 6L12 1" stroke="black"/>
                    </svg>
                </div>
            </div>

        </div>
        <div class="collapse-area" :class="{hidden : !collapsed}">
            <div class="card-info-row">
                <div class="row">
                    <div class="col-1"></div>
                    <div class="card-info-label col-11">{{ translate('Name on card') }}</div>
                </div>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="card-info-value col-11">{{ card_name }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-6"></div>
                <div class="col-3"><a :href="make_default" class="card-info-actions" @click.prevent="make_default"
                                      v-if="!is_default">{{
                        translate('Make default payment')
                    }}</a></div>
                <div class="col-3" style="text-align: right"><a v-if="!is_default" :href="delete_href" @click.prevent="delete_confirm"
                                                                class="card-info-actions">{{ translate('Delete') }}</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import translate from "./../../utils/translate";

export default {
    name: "payment-method",
    props: {
        id: Number,
        card_type: String,
        last4: String,
        card_name: String,
        make_default_href: String,
        delete_href: String,
        create_href: String,
        _is_default: false,
        _collapsed : false,
    },


    data() {
        return {
            is_default: false,
            collapsed: Number
        }
    },
    mounted() {
        this.is_default = this._is_default;
        this.collapsed = this._collapsed;
        var self = this;
        $('#confirm-delete-pm').on('click', function (event) {
            if (event.target.dataset.id == self.id) {
                self.delete();
            }
        });

        this.$root.$on('default_changed', (data) => {
            if(data.id !== this.id){
                this.is_default = false;
            }
        })
    },
    methods: {
        translate,
        make_default: function () {
            axios.put(this.make_default_href).then(response => {
                this.is_default = true;
                this.$root.$emit('default_changed', {id : this.id});
            })
        },
        delete_confirm: function () {
            var modal = $('#modal-confirm-delete-pm').modal();
            modal.find('#confirm-delete-pm').attr('data-id', this.id);
            modal.show();
        },
        delete: function () {
            axios.delete(this.delete_href).then(response => {
                location.reload();
            })
        }
    }
}
</script>

<style scoped>

</style>

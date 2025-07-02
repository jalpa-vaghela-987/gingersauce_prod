<template>
    <div class="current-plan-card">
        <div class="card-title">{{ isPaidPlan ? this.translate('Paid plan') : this.translate('Free plan') }}</div>
        <div class="divider"></div>
        <div class="section">
            <div class="label">{{ this.translate('Subscription renewal date') }}</div>
            <div class="value">{{ expire_date ? expire_date : translate('Forever') }}</div>
        </div>
        <div class="section">
            <div class="label">{{ this.translate('Subscription amount') }}</div>
            <div class="value">USD ${{ formattedAmount }}</div>
        </div>
        <div v-if="isPaidPlan && plan.autorenewal" class="cancel-link">
            <a href="javascript:void(0)" @click="$emit('cancel-renewal')">{{ this.translate('Cancel renewal of subscription') }}</a>
        </div>
    </div>
</template>

<script>
import translate from "../../utils/translate";
export default {
    name: 'CurrentPlanCard',
    props: {
        plan: {
            type: Object,
            default: () => ({
                amount: 0,
                package_expiry: null,
                autorenewal: false
            })
        },
        expire_date: String,
    },
    methods: {
        translate
    },
    computed: {
        isPaidPlan() {
            return this.plan && Number(this.plan.amount) > 0;
        },
        formattedAmount() {
            const amount = this.plan ? Number(this.plan.amount) : 0;
            return isNaN(amount) ? '0.00' : amount.toFixed(2);
        }
    }
}
</script>

<style lang="scss" scoped>
.current-plan-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.16);
    max-width: 460px;
    padding: 32px 32px 16px 32px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;

    .card-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #232323;
        margin-bottom: 18px;
    }
    .divider {
        width: 100%;
        height: 1px;
        background: #e0e0e0;
        margin-bottom: 28px;
    }
    .section {
        margin-bottom: 32px;
        width: 100%;
        .label {
            color: #979797;
            font-size: 1rem;
            margin-bottom: 6px;
        }
        .value {
            color: #232323;
            font-size: 1.1rem;
            font-weight: 500;
        }
    }
    .cancel-link {
        width: 100%;
        text-align: left;
        margin-top: 10px;
        a {
            color: #979797;
            font-size: 0.98rem;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.2s;
            &:hover {
                color: #232323;
                text-decoration: underline;
            }
        }
    }
}
</style>

<template>
    <div
        class="popup-wrap"
        :class="{ 'open': isOpenModal }"
        @click.self="popupClick"
    >
        <div class="popup-body">
            <h1 class="popup-body-title">
                {{ message.title || 'Error' }}
            </h1>
            <p class="popup-body-article" v-html="message.article"></p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ErrorModal',
    props: {
        isOpen: {
            type: Boolean,
            default: false,
        },
        message: {
            type: Object,
            required: true,
        },
    },
    data: () => ({
        isOpenModal: false,
    }),
    watch: {
        isOpen(value) {
            this.isOpenModal = value;
        },
    },
    methods: {
        popupClick() {
            this.isOpenModal = false;
            this.$emit('modal-answer', this.isOpenModal);
        },
    },
};
</script>

<style scoped>
    .popup-wrap{
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1300;
        background-color: rgba(0, 0, 0, 0.4);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        visibility: hidden;
        opacity: 0;
        transition: 0.3s;
        padding: 1rem;
    }
    .popup-body{
        min-width: 30%;
        min-height: 20%;
        background-color: white;
        padding: 2rem;
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .popup-body-title{
        text-align: center;
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }
    .popup-body-article{
        text-align: center;
        color: rgba(0, 0, 0, 0.5);
    }
    .popup-wrap.open{
        visibility: visible;
        opacity: 1;
    }
</style>

<template>
    <div class="voices-init-select">
        <div class="step-title less-top px-0">
            {{ translate( 'Do you know your Brand Archetype?' ) }} <span
            v-tooltip.bottom="translate('The archetype is essentially the character of the brand. An alive representation, that is created taking into consideration all the nuances of the target audience and the brand’s concept. The character that the audience can relate to.')"><svg
            width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path
            d="M23.625 12C23.625 18.4217 18.4199 23.625 12 23.625C5.58014 23.625 0.375 18.4217 0.375 12C0.375 5.58202 5.58014 0.375 12 0.375C18.4199 0.375 23.625 5.58202 23.625 12ZM12.312 4.21875C9.75741 4.21875 8.12813 5.29486 6.84872 7.20741C6.68297 7.45519 6.73842 7.78936 6.97598 7.9695L8.6025 9.20278C8.84648 9.3878 9.19411 9.34378 9.38367 9.10331C10.221 8.04122 10.7952 7.42533 12.0697 7.42533C13.0274 7.42533 14.2118 8.04164 14.2118 8.97023C14.2118 9.67223 13.6323 10.0328 12.6868 10.5629C11.5841 11.181 10.125 11.9504 10.125 13.875V14.0625C10.125 14.3731 10.3769 14.625 10.6875 14.625H13.3125C13.6231 14.625 13.875 14.3731 13.875 14.0625V14C13.875 12.6659 17.7743 12.6103 17.7743 9C17.7743 6.28116 14.9541 4.21875 12.312 4.21875ZM12 15.8438C10.811 15.8438 9.84375 16.811 9.84375 18C9.84375 19.1889 10.811 20.1562 12 20.1562C13.189 20.1562 14.1562 19.1889 14.1562 18C14.1562 16.811 13.189 15.8438 12 15.8438Z"
            :fill="main_color"/></svg></span></div>
        <div class="options two d-flex">
            <div class="click-option" @click="$emit('forward', 'submit')">
                <div class="voices-option">
                    {{ translate( 'Yes' ) }}
                </div>
            </div>
            <div class="click-option" @click="$emit('forward', 'tags')">
                <div class="voices-option">
                    {{ translate( 'No' ) }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import translate from '../../utils/translate';

export default {
    name   : 'initial-select',
    props  : {
        main_color: String,
    },
    methods: {
        translate,
    },
};
</script>

<style lang="scss" scoped>
.voices-init-select {

    .voices-option {
        margin-top: 18px;
        font-weight: 500;
        margin-bottom: 18px;
        font-size: 18px;
        line-height: 150%;
        text-align: center;
        color: var(--main_color);
        border: 2px solid var(--main_color);
        padding: 20px;
        border-radius: 15px;
    }
}
</style>

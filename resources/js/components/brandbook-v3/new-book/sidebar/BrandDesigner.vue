<template>
    <div class="wrapper-default-block mt-20">
        <span class="data-name">Brand designer</span>
        <div class="profile-block default-block d-flex align-items-center justify-content-between">
            <div class="profile-info d-flex gap-3">
                <RoundedImage :avatar_url="user.avatar_url" style="width: 50px; height: 50px"/>

                <div class="text-content ms-1 d-flex flex-column justify-content-center">
                    <div class="name fs-14 fw-bold">{{ user?.name || 'Josh Bloch' }}</div>
                    <div class="title fs-14">{{ user?.position || 'Senior UX Designer' }}</div>
                </div>
            </div>
            <a class="arrow-button sec-btn btn flex-shrink-0"
               :href="`${currentDomain}/my/author-dashboard?user_id=${user.encrypted_id}`">
                <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M13.1825 1.04062C13.1825 0.488332 12.7347 0.0406164 12.1825 0.0406162L3.18245 0.040617C2.63017 0.0406166 2.18245 0.488332 2.18245 1.04062C2.18245 1.5929 2.63017 2.04062 3.18245 2.04062L11.1825 2.04062L11.1825 10.0406C11.1825 10.5929 11.6302 11.0406 12.1825 11.0406C12.7347 11.0406 13.1825 10.5929 13.1825 10.0406L13.1825 1.04062ZM1.52466 13.1126L12.8896 1.74772L11.4753 0.33351L0.110444 11.6984L1.52466 13.1126Z"
                    />
                </svg>
            </a>
        </div>
    </div>
</template>
<script>
    import RoundedImage from '../RoundedImage.vue';

    export default {
        components: {RoundedImage},
        props: {
            user: {
                type: Object,
                default: () => ({})
            },
        },
        data() {
            return {
                currentDomain: ''
            };
        },
        mounted() {
            this.currentDomain = window.location.origin;
        }
    };
</script>

<template>
    <div class="d-flex gap-2">
        <button class="btn main-btn" @click="copyUrl">Copy Link</button>
        <button class="btn sec-btn" @click="redirectToLogin">Login</button>
    </div>
</template>
<script>
export default {
	data() {
		return {
		};
	},
    mounted(){
    },
    components:{
    },
    methods:{
        copyUrl(){
            const currentUrl = window.location.href;
            navigator.clipboard.writeText(currentUrl).then(() => {
                new Noty({
                    type   : 'success',
                    text   : "URL copied successfully",
                    timeout: 5000,
                }).show();
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        },
        redirectToLogin(){
            window.location.href =   '/login';
        }
    }
};
</script>

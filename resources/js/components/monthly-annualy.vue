<template>
	<span>{{text}}</span>
</template>
<script>
	import translate from "../utils/translate";
	export default {
		data(){
			return {
				text: this.translate('Annually')
			}
		},
		mounted(){
			this.$root.$on('switch-changed', (state)=>{
				this.text = this.translate('Monthly')
				if(state)
					this.text = this.translate('Annually')
			})
		},
		methods: {
			translate
		}
	}
</script>
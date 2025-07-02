<template>
	<label class="switch">
      <input type="checkbox" v-model=swatch>
      <span class="slider round"></span>
    </label>
</template>
<script>
	export default {
		data(){
			return {
				swatch: true
			}
		},
		watch:{
			swatch(){
				this.$root.$emit('switch-changed', this.swatch)
			}
		},
		mounted(){
			setTimeout(()=>{
				this.$root.$emit('switch-changed', this.swatch)
			}, 500)
		}
	}
</script>
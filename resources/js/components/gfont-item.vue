<template>
	<intersect @enter="entered">
	<div :style="{'font-family': family}" @click.prevent.stop='clicked'>
	{{translate(family)}}</div>
	</intersect>
</template>
<script>
	import Intersect from 'vue-intersect'
	import translate from "../utils/translate";
	export default {
		components: {Intersect},
		props: [
			'family',
			'index',
			'font'
		],
		data(){
			return {
				visible: []
			}
		},
		mounted(){
			// this.$nextTick(function () {
				//$('#ff-'+this.idFromFamily(this.family)).remove()
				//$('<link id="ff-'+this.idFromFamily(this.family)+'" rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Crimson+Pro&family='+this.family+'">').appendTo(document.head);
			// })
		},
		methods: {
			translate,
			entered(){
				$('<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family='+this.family+'">').appendTo(document.head);
				this.$root.$emit('entered', {family: this.family, index: this.index})
				// var index = _.indexOf(this.visible, this.family)
				// console.log('entered '+this.family)
			},
			clicked(){
				this.$root.$emit('gfont-selected', {font: this.font})
			}
		}
	}
</script>
<template>
    <div class="small-color-item" :style="{background: gradient_code==''?_hex:gradient_code}">
    </div>
</template>

<script>
const simpleColorConverter = require('simple-color-converter')
import translate from "../utils/translate";
export default {
    props: {
        title: String,
        color: Object,
        index: Number,
        is_primary: Boolean,
        is_new: Boolean,
        pinned: Boolean,
        shades: Boolean
    },
    components: {
        // GradientPicker: GradientPicker
    },
    data(){
        return {
            loaded: false,
            is_pinned: false,
            is_gradient: false,
            gradient_code: '',

            show_shades: true,

            load_to: null,
            currentFocus: null,
            selectorCreated: false,
            nodeColor: ""
        }
    },
    mounted(){
        if(this.pinned)
            this.is_pinned = true
        if(this.color.loaded===false){
            this.load(this.color.hex.value)
        }
        this.$root.$on('colors.redraw', ()=>{
            // if(this.color.loaded===false){
            this.load(this.color.hex.value)
            // }
        })
        setTimeout(()=>{
            // gradX("#gp_"+this._id);
            // const gp = new Grapick({el: '#gp_'+this._id});

            // gp.addHandler(0, this._hex);
            // gp.addHandler(100, '#fff');

            // // Do stuff on change of the gradient
            // gp.on('change', complete => {
            // 	document.body.style.background = gp.getSafeValue();
            // })
            const gpickr = new GPickr({
                el: "#gp_"+this._id+' div',
                stops: [
                    [this._hex, 0],
                    ['#fff', 1]
                ]
            }).on('change', instance => {
                clearTimeout(this.toto)
                this.toto = setTimeout(()=>{
                    this.gradient_code = instance.getGradient()
                    this.$root.$emit('color.gradient', {data: this.gradient_code, id: this.index})
                    this.is_gradient = false
                }, 4000)
            });
            this.bindSelector()
        }, 1000)
        this.bindSelector()

    },
    methods:{
        translate,
        toggleShades(){
            this.show_shades = !this.show_shades
            this.$root.$emit('color.shades', {shades: this.show_shades, id: this.index})
        },
        pantone_updated(e){
            this.$root.$emit('color.update', {type: 'pantone', color: e.target.value, id: this.index})
        },
        cmyk_updated(e){
            this.$root.$emit('color.update', {type: 'cmyk', color: e.target.value, id: this.index})
        },
        pantone_func(e, r){
            console.log(r)
        },
        load(color){
            if(color.search('rgb')>-1){
                color = color.replace('rgba','').replace('rgb', '').replace('(','').replace(')','').split(',')
                var rgb = {
                    r: color[0],
                    g: color[1],
                    b: color[2]
                }
                color = simpleColorConverter({
                    rgb: rgb,
                    to: 'hex6'
                })
            }
            var _this = this;
            axios.get('https://www.thecolorapi.com/id?hex='+color.replace('#','')+'&format=json')
                .then(response => {
                    this.loaded = response.data
                    this.$root.$emit('color.load', {data: this.loaded, id: this.index, index: this.index, new_index: color})

                    this.bindSelector()
                })
        },
        bindSelector(){
            var _this = this
            setTimeout(()=>{
                $('#'+this._id).chromoselector({
                    update: ()=>{
                        if(_this._hex.length == 7)
                        {

                            var color = $('#' + this._id).chromoselector('getColor').getHexString()
                            clearTimeout(this.load_to)
                            this.load_to = setTimeout(() => {

                                _this.load(color)
                            }, 2000)
                        }
                        // $('.ui-cs-chromoselector').hide()
                    },
                    create: ()=>{
                        _this.selectorCreated = true;
                        console.log('create!');
                        console.log($('#'+this._id).chromoselector('getColor').getHexString());
                    }
                })
                if(this.is_new){
                    $('#'+this._id).focus()
                }
            }, 2000)
        },
        pin(){
            this.is_pinned = true
            this.$root.$emit('color.pinned', {id: this.index})
        },
        unpin(){
            this.is_pinned = false
            this.$root.$emit('color.unpinned', {id: this.index})
        },
        gradient(){
            this.is_gradient = true

        },
        trash(){
            this.$root.$emit('color.trashed', {id: this.index})
            // this.$root.$emit('color.trashed', {id: this._hex})
        },
        color_activation(){
            if(!this.is_pinned && this.selectorCreated)
                $('#'+this._id).trigger('focus')
        }
    },
    watch: {
        shades(){
            this.show_shades = this.shades
        }
    },
    computed:{
        pantone(){
            if(this._color!=undefined && this._color.hex!=undefined){
                var color = simpleColorConverter({
                    hex3: this._color.hex.value,
                    to: 'pantone'
                })
                return color
            }
        },
        _color(){
            if(this.loaded!==false)
                return this.loaded
            return this.color
        },
        _title(){
            if(this.title=='' || this.title==undefined)
                if (this._color	!= undefined && this._color.name!=undefined) {
                    return this._color.name.value
                }
            return this.title
        },
        _hex(){
            if(this._color!=undefined && this._color.hex!==undefined)
                return this._color.hex.value
        },
        _rgb(){
            if(this._color!=undefined && this._color.rgb!==undefined)
                return this._color.rgb.value
        },
        _cmyk(){
            if(this._color!=undefined && this._color.cmyk!==undefined)
                return this._color.cmyk.value
        },
        _id(){
            return 'color-'+this._uid
        },
        titlus(){
            switch(this.index){
                case 0: return this.translate("Primary Color"); break
                case 1: return this.translate("Secondary Color"); break
                case 2: return this.translate("Tertiary Color"); break
                default: return " "
            }
        }
    }
}

</script>

<style>
.small-color-item.color-item-empty{
    border: 2px dashed #999999;
}

.small-color-item.color-item {
    height: 25px;
    width: 10%;
}
.small-colors.row {
    width: 100%;
    justify-content: center;
    margin: 0;
}
</style>

<template>
    <div class="step overflow-auto">
        <div class="step-title less-top px-0">
            {{ translate( 'Choose Logo Variations' ) }}
            <span
                v-tooltip.bottom="translate('The different logo variations will be utilized for the different applications and usage of the logo. Be it in social media, website, printed materials, large scale graphics or signage, there are endless places and formats on which the logo will need to be on. <br><strong>The more diverse the logo will be - the more successful and strong the brand will be.</strong>')
                "
                v-html="tooltipIcon()"
            ></span>
        </div>

        <div class="pt-5 pb-4 px-5">
            <div class="logo_variant row">
                <div
                    v-for="(logo, index) in logo_variations"
                    :key="index"
                    class="col-md-4 mb-5"
                >
                    <Logo
                        :index="index"
                        :src="logo.logo_b64"
                        :background="logo.background"
                        :title="logo.title"
                        @select="selectLogoVariation"
                        :selected_indexes="selected_indexes"
                    />
                </div>
            </div>
        </div>

        <div class="upload-footer">
            <button
                :disabled="!selected_indexes.length"
                v-bind:class="[ selected_indexes ? 'btn-outline-success' : 'btn-outline-secondary', 'btn']"
                @click="confirmSelection"
            >
                {{ translate( 'Next' ) }}
            </button>
            <div class="skip" @click="$emit('skip')">
                {{ translate( 'or skip' ) }}
                <span v-html="skip()"></span>
            </div>
        </div>
    </div>
</template>

<script>
import Logo from './logo';
import Brightness from '../../utils/brightness';
import SVG from '../../utils/svg/svg';
import { parse } from 'svg-parser';
import { applyStyles, extractStyles } from '../../utils/svg/style';
import { tooltipIcon, skip } from '../../utils/svg/icons';
import translate from '../../utils/translate';

export default {
    components: {
        Logo,
    },

    props: {
        logo         : String,
        logo_versions: Array,
        colors       : Array,
    },
    data() {
        return {
            schemas                : [],
            schemas_versions       : [],
            selected               : [],
            selected_versions      : [],
            selected_indexes       : [],
            logo_variations        : [],
            logo_versions_converted: [],

            primary_color     : this.colors[ 0 ],
            secondary_color   : this.colors[ 1 ],
            tetriatry_color   : this.colors[ 2 ],
            max_approved_count: 14,
            logo_converted    : '',
            svg               : '',
            trees             : [],

            styles      : [],
            template_ids: [ '0_White Negative on Secondary', '0_Secondary color Positive' ],
        };
    },
    mounted() {
        this.max_approved_count = this.max_approved_count - ( this.logo_versions.length - 1 );
        this.logo_versions_converted = this.logo_versions.map( version => {
            version.logo = applyStyles( version.logo );
            return version;
        } );

        //var styles = this.logo_versions_converted.map((logo) => extractStyles(logo));

        this.logo_variations = this.logo_versions_converted.map( ( version, index ) => {
            return this.applyVariations( version, index );
        } );

        this.logo_variations = this.logo_variations.flat();

        // removing duplications
        var unique_images = [];
        var unique_versions = [];

        this.$emit( 'saveAllLogoVariations', this.logo_variations );

        this.logo_variations.forEach( ( version ) => {
            var hashcode = ( version.logo_b64 + version.background ).split( '' ).reduce( ( a, b ) => {
                a = ( ( a << 5 ) - a ) + b.charCodeAt( 0 );
                return a & a;
            }, 0 );

            if ( ! unique_images.includes( hashcode ) && ! this.template_ids.includes( version.id ) ) {
                unique_images.push( hashcode );
                unique_versions.push( version );
            }
        } );

        this.logo_variations = unique_versions;
    },

    methods: {
        tooltipIcon,
        translate,
        skip,

        applyVariations( version, top_index ) {
            var result = this.list().map( ( params, index ) => this.applyVariation( version, params, top_index ) );
            return result;
        },

        gradientClasses( logo ) {
            var regexAll = /<linearGradient [a-zA-Z0-9="_\s\-.()><:;#\/]+<\/linearGradient>/gmi;
            const array = [ ...logo.matchAll( regexAll ) ];
            //console.log('array of gradients', array);
            var gradientClasses = array.map( g => {
                var svgClass = new SVG( '<svg>' + g + '</svg>' );
                return this.extractGradientColor( svgClass.tree().children[ 0 ] );
            } );

            return gradientClasses;
        },

        rgbToHex( rgb ) {
            try {
                rgb = rgb.match( /^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/ );
                return '#' + this.hex( rgb[ 0 ] ) + this.hex( rgb[ 1 ] ) + this.hex( rgb[ 2 ] );
            } catch {
            }
            return null;
        },

        hex( x ) {
            var hexDigits = [ '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f' ];
            return isNaN( x ) ? '00' : hexDigits[ ( x - x % 16 ) / 16 ] + hexDigits[ x % 16 ];
        },

        applyVariation( version, params, prefix ) {
            // preprocess gradients
            var logo = version.logo;
            let invert = version.white_bg_logo_type == 'white';
            var gradientClasses = this.gradientClasses( logo );
            if ( gradientClasses.length ) {
                gradientClasses.forEach( g => {
                    if ( params.fill ) {
                        var newColor = this.convertColor( g.color, params.fill, invert );
                    }
                    if ( newColor ) {
                        logo = logo.replace( 'url(#' + g.id + ')', g.color );
                    }

                    var brightness = new Brightness( g.color );
                    var tone = brightness.tone();

                } );
            }

            // Hex values replace
            var regex = /fill:#[a-zA-Z0-9]{6}/gmi;
            var fills = logo.match( regex );
            if ( fills ) {
                fills.forEach( f => {
                    var oldColor = f.replace( 'fill:', '' );
                    if ( params && params.fill ) {
                        var newColor = this.convertColor( oldColor, params.fill, invert );
                    }

                    if ( newColor ) {
                        logo = logo.replace( f, 'fill:' + newColor );
                    }
                } );
            }

            // RGB values replace
            var regex = /fill:rgb\([0-9]{1,3},[0-9]{1,3},[0-9]{1,3}\)/gmi;
            var fills = logo.match( regex );
            if ( fills ) {
                fills.forEach( f => {
                    var oldRGB = f.replace( [ 'fill:rgb(' ], ')', '' ).split( ',' );
                    var oldHex = '#' + oldRGB.map( c => this.hex( c ) ).join( '' );
                    if ( params && params.fill ) {
                        var newColor = this.convertColor( oldHex, params.fill, invert );
                    }

                    if ( newColor ) {
                        logo = logo.replace( f, 'fill:' + newColor );
                    }
                } );
            }

            // convert logo to tree
            var svgClass = new SVG( logo );
            var tree = svgClass.tree();

            var viewBox = tree.properties.viewBox;
            var width = viewBox.split( ' ' )[ 2 ];

            var converted_tree = this.render( tree, params, width, invert );

            var converted_logo = svgClass.to_svg( converted_tree );

            var converted_b64 = 'data:image/svg+xml;base64,' + btoa( converted_logo );

            return {
                logo      : converted_logo,
                logo_b64  : converted_b64,
                title     : params.title,
                background: params.background ? params.background : 'transparent',
                id        : prefix + '_' + params.title,
            };
            // 2. proceed changes
            // 3. generate back to svg
            // 4. return correct format

        },
        list() {
            return [
                {
                    fill : {
                        default: this.primary_color,
                        light  : '#FFFFFF',
                    },
                    title: 'Primary Color Positive',
                },
                {
                    fill : {
                        default: this.secondary_color,
                        light  : '#FFFFFF',
                    },
                    title: 'Secondary Color Positive',
                },
                {
                    fill : {
                        default: '#000000',
                        light  : '#FFFFFF',
                    },
                    title: 'Black & White Positive',
                },
                {
                    fill      : {
                        default: '#FFFFFF',
                        light  : this.primary_color,
                    },
                    background: this.primary_color,
                    title     : 'White Negative on Primary',
                },
                {
                    fill      : {
                        default: '#FFFFFF',
                        light  : '#000000',
                    },
                    background: '#000000',
                    title     : 'White Negative',
                },
                {
                    fill : {
                        default: this.primary_color,
                        dark   : '#000000',
                    },
                    title: 'Primary & Black',
                },
                {
                    fill : {
                        default: this.secondary_color,
                        dark   : '#000000',
                    },
                    title: 'Secondary & Black',
                },
                {
                    fill  : {
                        default: '#FFFFFF',
                        dark   : '#000000',
                    },
                    stroke: {
                        color: '#000000',
                        width: 2,
                    },
                    title : 'White & Black',
                },
                {
                    fill  : {
                        default: this.primary_color,
                        dark   : '#FFFFFF',
                    },
                    stroke: {
                        color: '#000000',
                        width: 2,
                    },
                    title : 'Primary Color Negative',
                },
                {
                    fill  : {
                        default: this.secondary_color,
                        dark   : '#FFFFFF',
                    },
                    stroke: {
                        color: '#000000',
                        width: 2,
                    },
                    title : 'Secondary Color Negative',
                },
                {
                    fill  : {
                        default: '#000000',
                        dark   : '#FFFFFF',
                    },
                    stroke: {
                        color: '#000000',
                        width: 2,
                    },
                    title : 'Black & White Negative',
                },
                {
                    fill : {
                        dark : this.primary_color,
                        light: '#FFFFFF',
                    },
                    title: 'Primary & Colors',
                },
                {
                    fill : {
                        dark : this.secondary_color,
                        light: '#FFFFFF',
                    },
                    title: 'Secondary & Colors',
                },
                {
                    fill      : {
                        dark : '#FFFFFF',
                        light: '#000000',
                    },
                    background: '#000000',
                    title     : 'White & Colors',
                },
                {
                    fill      : {
                        default: '#FFFFFF',
                        light  : this.secondary_color,
                    },
                    background: this.secondary_color,
                    title     : 'White Negative on Secondary',
                },
                {
                    fill : {
                        default: this.secondary_color,
                        light  : '#FFFFFF',
                    },
                    title: 'Secondary color Positive',
                },
                {
                    title     : 'Positive on Black',
                    background: '#000000',

                },
            ];
        },

        selectLogoVariation( index ) {
            if ( this.selected_indexes.includes( index ) ) {
                this.selected_indexes = this.selected_indexes.filter(
                    ( el ) => el != index,
                );
            } else {
                if ( this.selected_indexes.length < this.max_approved_count ) {
                    this.selected_indexes.push( index );
                }
            }
        },

        confirmSelection() {
            var variations = this.logo_variations.filter( ( v, key ) =>
                                                              this.selected_indexes.includes( key ),
            );
            this.$emit( 'selectLogoVariations', variations );
        },

        logoIndex( indexChild, indexParent, length ) {
            return 1 + indexChild + indexParent * length;
        },

        isSelected( index ) {
            return this.selected_indexes.includes( index );
        },

        getByName( name ) {
            return this.list().find( s => s.title == name );
        },

        render( block, params, width, invert ) {

            if ( block.tagName && ! [ 'svg', 'root' ].includes( block.tagName ) ) {
                block.properties = this.applyParams( block.properties, { ...params }, block, width, invert );
            }

            if ( block.children && block.children.length ) {
                block.children = block.children.map( kid => this.render( { ...kid }, params, width, invert ) );
            }

            return { ...block };
        },

        applyParams( properties, params, block, width, invert ) {
            var updatedProperties = properties;

            if ( params.fill ) {
                updatedProperties = this.applyFillChange( updatedProperties, { ...params.fill }, block, invert );
            }
            if ( params.stroke ) {
                updatedProperties = this.applyStrokeChange( updatedProperties, { ...params.stroke }, width, invert );
            }

            return updatedProperties;
        },

        applyStyleParams( properties ) {
            this.styles.forEach( val => {
                if ( properties.class.includes( val ) ) {
                    //properties
                }
            } );
        },

        applyFillChange( properties, params, block, invert ) {
            if ( properties.hasOwnProperty( 'fill' ) && properties.fill && properties.fill != 'none' ) {
                var newColor = this.convertColor( properties.fill, params, invert );
                if ( newColor ) {
                    properties.fill = newColor;
                }
            }
            // else if (
            //     ['rect', 'circle', 'ellipse', 'line', 'polyline', 'polygon', 'path'].includes(block.tagName)
            // ) {
            //     console.log('no fill', properties, params, block)
            //     //var newColor = this.convertColor('black', params);
            //     //properties.fill = newColor;
            // }

            return { ...properties };
        },

        applyFillTextChange( text, params ) {
            const regexp = RegExp( 'fill:[#a-zA-Z0-9]{4,7};', 'g' );
            let match;

            while ( ( match = regexp.exec( text ) ) !== null ) {
                let color = match[ 0 ].replace( 'fill:', '' ).replace( ';', '' );
                let newColor = this.convertColor( color, params.fill );
                if ( newColor ) {
                    text = text.replaceAll( color, newColor );
                }
            }

            return text;
        },

        applyStrokeChange( properties, params, width ) {
            properties.stroke = params.color;
            if ( params.width ) {
                properties[ 'stroke-width' ] = parseInt( width / 280 );
            }

            return properties;
        },

        applyStrokeTextChange( text, params ) {
            return '';
        },

        src_svg( schema_name ) {
            var params = this.getByName( schema_name );
            var logo_tmp = this.replaceScheme( params );
            return logo_tmp;
        },

        src_b64( schema_name ) {
            var src_b64 = 'data:image/svg+xml;base64,'
                          + btoa( this.src_svg( schema_name ) );

            return src_b64;
        },

        convertColor( color, params, invert ) {
            var brightness = new Brightness( color );
            var tone = brightness.tone();
            if ( invert ) {
                if ( tone == 'dark' ) {
                    tone = 'light';
                } else if ( tone == 'light' ) {
                    tone = 'dark';
                }
            }

            var newColor = null;

            if ( params.light && tone == 'light' ) {
                newColor = params.light;
            } else if ( params.dark && tone == 'dark' ) {
                newColor = params.dark;
            } else if ( params.default ) {
                newColor = params.default;
            }

            return newColor;
        },

        extractGradientColor( block ) {
            //console.log(block);
            var res = { 'id': block.properties.id };
            var stops = block.children.map( c => {
                return {
                    'offset': c.properties.offset,
                    'style' : c.properties.style,
                    'id'    : c.properties.id,
                };
            } );
            var colors = this.getGradientColorFromStops( stops );

            if ( ! colors ) {
                return null;
            }

            var color = this.getMiddleColor( colors );

            return {
                color,
                'id': block.properties.id,
            };
        },

        getMiddleColor( colors ) {
            var closest = 0.5;
            var closestIndex = 0;
            colors.forEach( ( color, index ) => {
                var diff = Math.abs( 0.5 - color.offset );
                if ( diff < closest ) {
                    closest = diff;
                    closestIndex = index;
                }
            } );

            return colors[ closestIndex ].color;
        },

        getGradientColorFromStops( stops ) {
            var regexAll = /stop-color:#[0-9A-Za-z]{3,6}/gmi;
            var colors = stops.map( c => {
                if (!c.style) {
                    return {
                        "offset": c.offset,
                        "color": "#000000"
                    }
                }
                var match = c.style.match( regexAll );
                var colorValue = match.length ?
                                 match[ 0 ].replaceAll( 'stop-color:', '' ) :
                                 null;
                return {
                    'offset': c.offset,
                    'color' : colorValue,
                };
            } );

            return colors;
        },
    },
};
</script>

<style scoped>
.logo_variant {
    overflow-y: auto;
    max-height: 275px;
}
</style>

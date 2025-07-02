import Brightness from "../../utils/brightness";
import SVG from "../../utils/svg/svg";
import { parse } from 'svg-parser';
import { applyStyles } from "../../utils/svg/style";

export default class Schemas {
    constructor(colors, logo) {
        this.primary_color = colors[0];
        this.secondary_color = colors[1];
        this.tetriatry_color = colors[2];

        this.logo = applyStyles(logo);
        this.svg = new SVG(logo);
        this.tree = this.svg.tree();

        this.styles = [];
    }

    getByName(name) {
        return this.list().find(s => s.title == name);
    }

    renders(titles) {
        var items = titles && titles.length ?
            this.list().filter(i => titles.includes(i.title)) :
            this.list();

        return items.map(params => {
            var render = this.render({ ...this.tree }, params);
            var parsed = parse(this.logo);
            var svg = this.render_svg(parsed.children[0], params);
            var b64 = "data:image/svg+xml;base64," + btoa(svg);

            return {
                schema: params,
                render: this.render({ ...this.tree }, params),
                tree: parse(this.logo),
                b64: b64,
                svg: svg,
                original: this.logo,
                result: {
                    logo: svg,
                    logo_b64: b64,
                    title: params.title,
                    background: params.background ? params.background : "transparent",
                    id: params.title
                }
            }
        });

    }

    render_b64(block, params) {
        var src_b64 = "data:image/svg+xml;base64,"
            + btoa(this.render_svg({ ...block }, params));

        return src_b64;
    }

    render_svg(block, params) {
        return this.svg.to_svg(this.render({ ...block }, params));
    }

    render(block, params) {

        // if (block.properties.hasOwnProperty('class')) {
        //     block.properties = this.applyStyleParams(block.properties);
        // }

        if (block.tagName && !['svg', 'root'].includes(block.tagName)) {
            block.properties = this.applyParams(block.properties, { ...params }, block);
        }


        // if (block.type == 'text' && block.value) {
        //     this.initStyles(block.value);
        // }

        if (block.children && block.children.length) {
            block.children = block.children.map(kid => this.render({ ...kid }, params));
        }

        return { ...block };
    }

    applyParams(properties, params, block) {
        var updatedProperties = this.applyFillChange(properties, { ...params.fill }, block);
        if (params.stroke) {
            updatedProperties = this.applyStrokeChange(updatedProperties, { ...params.stroke }, block);
        }

        return updatedProperties;
    }

    applyStyleParams(properties) {
        this.styles.forEach(val => {
            if (properties.class.includes(val)) {
                //properties
            }
        });
    }

    applyFillChange(properties, params, block) {
        if (properties.hasOwnProperty('fill') && properties.fill && properties.fill != 'none') {
            var newColor = this.convertColor(properties.fill, params);
            if (newColor) {
                properties.fill = newColor;
            }
        } else if (
            ['rect', 'circle', 'ellipse', 'line', 'polyline', 'polygon', 'path'].includes(block.tagName)
        ) {
            var newColor = this.convertColor('black', params);
            properties.fill = newColor;
        }

        return { ...properties };
    }

    applyFillTextChange(text, params) {
        const regexp = RegExp('fill:[#a-zA-Z0-9]{4,7};', 'g');
        let match;

        while ((match = regexp.exec(text)) !== null) {
            let color = match[0].replace('fill:', '').replace(';', '');
            let newColor = this.convertColor(color, params.fill);
            if (newColor) {
                text = text.replaceAll(color, newColor);
            }
        }

        return text;
    }

    applyStrokeChange(properties, params) {
        properties.stroke = params.color;
        if (params.width) {
            properties['stroke-width'] = params.width;
        }

        return properties;
    }

    applyStrokeTextChange(text, params) {
        return '';
    }

    src_svg(schema_name) {
        var params = this.getByName(schema_name);
        var logo_tmp = this.replaceScheme(params);
        return logo_tmp;
    }

    src_b64(schema_name) {
        var src_b64 = "data:image/svg+xml;base64,"
            + btoa(this.src_svg(schema_name));

        return src_b64;
    }

    convertColor(color, params) {
        var brightness = new Brightness(color);
        var tone = brightness.tone();

        var newColor = null;

        if (params.light && tone == "light") {
            newColor = params.light;
        } else if (params.dark && tone == "dark") {
            newColor = params.dark;
        } else if (params.default) {
            newColor = params.default;
        }

        return newColor;
    }

    list() {
        return [
            {
                fill: {
                    default: this.primary_color,
                    light: "#FFFFFF",
                },
                title: "Primary Color Positive"
            },
            {
                fill: {
                    default: this.secondary_color,
                    light: "#FFFFFF",
                },
                title: "Secondary Color Positive"
            },
            {
                fill: {
                    default: "#000000",
                    light: "#FFFFFF",
                },
                title: "Black & White Positive"
            },
            {
                fill: {
                    default: "#FFFFFF",
                    light: this.primary_color,
                },
                background: this.primary_color,
                title: "White Negative on Primary"
            },
            {
                fill: {
                    default: "#FFFFFF",
                    light: "#000000",
                },
                background: "#000000",
                title: "White Negative"
            },
            {
                fill: {
                    default: this.primary_color,
                    dark: "#000000",
                },
                title: "Primary & Black"
            },
            {
                fill: {
                    default: this.secondary_color,
                    dark: "#000000",
                },
                title: "Secondary & Black"
            },
            {
                fill: {
                    default: "#FFFFFF",
                    dark: "#000000",
                },
                stroke: {
                    color: "#000000",
                    width: 2
                },
                title: "White & Black"
            },
            {
                fill: {
                    default: this.primary_color,
                    dark: "#FFFFFF",
                },
                stroke: {
                    color: "#000000",
                    width: 2
                },
                title: "Primary Color Negative"
            },
            {
                fill: {
                    default: this.secondary_color,
                    dark: "#FFFFFF",
                },
                stroke: {
                    color: "#000000",
                    width: 2
                },
                title: "Secondary Color Negative"
            },
            {
                fill: {
                    default: "#000000",
                    dark: "#FFFFFF",
                },
                stroke: {
                    color: "#000000",
                    width: 2
                },
                title: "Black & White Negative"
            },
            {
                fill: {
                    dark: this.primary_color,
                    light: "#FFFFFF",
                },
                title: "Primary & Colors"
            },
            {
                fill: {
                    dark: this.secondary_color,
                    light: "#FFFFFF",
                },
                title: "Secondary & Colors"
            },
            {
                fill: {
                    dark: "#FFFFFF",
                    light: "#000000",
                },
                background: "#000000",
                title: "White & Colors"
            }];
    }

}

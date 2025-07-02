import Brightness from "../../utils/brightness";
import SVG from "../../utils/svg/svg";
import { parse } from 'svg-parser';
import { removeStyleTag } from "../../utils/svg/style";

export default class Schemas {
    constructor(colors, icon) {
        this.primary_color = colors[0];
        this.secondary_color = colors[1];
        this.tetriatry_color = colors[2];

        this.icon = icon;
        this.svg = new SVG(icon);
        this.tree = this.svg.tree();
    }

    getByName(name) {
        return this.list().find(s => s.title == name);
    }

    renders() {
        var items = this.list();

        return items.map(params => {
            var parsed = parse(this.icon);
            var svg = this.render_svg(parsed.children[0], params);
            svg = removeStyleTag(svg);
            var b64 = "data:image/svg+xml;base64," + btoa(svg);

            //console.log(this.render_svg({ ...this.tree }, params));

            return {
                icon: svg,
                icon_b64: b64,
                title: params.title,
                border_radius: params.border_radius,
                background: params.background ? params.background : "transparent",
                id: params.title
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
        if (block.tagName && !['svg', 'root'].includes(block.tagName)) {
            block.properties = this.applyParams(block.properties, { ...params }, block);
        }

        if (block.type == 'text' && block.value) {
            block.value = this.applyStyleParams(block.value, { ...params });
        }

        if (block.children && block.children.length) {
            block.children = block.children.map(kid => this.render({ ...kid }, params));
        }

        return { ...block };
    }

    applyParams(properties, params, block) {
        var updatedProperties = this.applyFillChange(properties, { ...params }, block);
        updatedProperties = this.applyStrokeChange(updatedProperties, params);

        return updatedProperties;
    }

    applyStyleParams(text, params) {
        var updatedText = this.applyFillTextChange(text, { ...params });
        //updatedText = this.applyStrokeTextChange(updatedText, params);

        return updatedText;
    }

    applyFillChange(properties, params, block) {
        if (properties.hasOwnProperty('fill') && properties.fill && properties.fill != 'none') {
            var newColor = this.convertColor(properties.fill, params.fill);
            if (newColor) {
                properties.fill = newColor;
            }
        } else if (
            ['rect', 'circle', 'ellipse', 'line', 'polyline', 'polygon', 'path'].includes(block.tagName)
        ) {
            var newColor = this.convertColor('black', params.fill);
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
        if (params.stroke) {
            properties.stroke = params.stroke.color;
            if (params.stroke.width) {
                properties['stroke-width'] = params.stroke.width;
            }
        }

        return properties;
    }

    applyStrokeTextChange(text, params) {
        return '';
    }

    src_svg(schema_name) {
        var params = this.getByName(schema_name);
        var icon_tmp = this.replaceScheme(params);
        return icon_tmp;
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
                    default: "#FFFFFF",
                    light: this.primary_color,
                },
                background: this.primary_color,
                border_radius: 0,
                title: "White Negative on Primary in Square"
            },
            {
                fill: {
                    default: "#FFFFFF",
                    light: this.primary_color,
                },
                background: this.primary_color,
                border_radius: '50%',
                title: "White Negative on Primary in Circle"
            },
            {
                fill: {
                    default: "#FFFFFF",
                    light: this.secondary_color,
                },
                background: this.secondary_color,
                border_radius: 0,
                title: "White Negative on Secondary in Square"
            },
            {
                fill: {
                    default: "#FFFFFF",
                    light: this.secondary_color,
                },
                background: this.secondary_color,
                border_radius: '50%',
                title: "White Negative on Secondary in Circle"
            },
            {
                fill: {
                    dark: "#FFFFFF",
                    light: "#000000",
                },
                background: "#000000",
                border_radius: 0,
                title: "White & Colors on Secondary in Square"
            },
            {
                fill: {
                    dark: "#FFFFFF",
                    light: "#000000",
                },
                background: "#000000",
                border_radius: '50%',
                title: "White & Colors on Secondary in Circle"
            },

            {
                fill: {
                    default: this.secondary_color,
                    light: "#FFFFFF",
                },
                border_radius: '0',
                background: "#000000",
                title: "Secondary Color Positive"
            },
            {
                fill: {
                    default: "#000000",
                    light: "#FFFFFF",
                },
                border_radius: '0',
                background: "#000000",
                title: "Black & White Positive"
            },
            {
                fill: {
                    default: this.primary_color,
                    light: "#FFFFFF",
                },
                border_radius: '0',
                background: "#000000",
                title: "Primary Color Positive"
            }
        ];
    }

}

import { parse } from 'svg-parser';

export default class SVG {
    constructor(svg) {
        this.svg = svg;
    }

    tree() {
        var parsed = parse(this.svg);
        return { ...parsed.children[0] };
    }

    to_svg(data) {
        if (!data) {
            data = this.tree().children[0];
        }
        return this.generate_block(data);
    }

    generate_block(block) {
        if (block.tagName) {
            var output = '<' + block.tagName;
            output += this.generate_attributes(block.properties);

            if (block.children && block.children.length) {
                output += ' >';
                output += block.children.map(kid => this.generate_block(kid)).join('');
                output += ` </${block.tagName}>`;
            } else {
                output += ' />';
            }

            return output;
        } else if (block.type == 'text' && block.value) {
            return block.value;
        } else {
            return '';
        }
    }

    generate_attributes(object) {
        var output = '';
        for (var key in object) {
            if (object.hasOwnProperty(key)) {
                output += ` ${key}="${object[key]}" `;
            }
        }

        return output;
    }

}

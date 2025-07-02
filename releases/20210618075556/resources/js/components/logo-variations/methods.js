import Brightness from "../../utils/brightness";
import SVG from "../../utils/svg/svg";

function gradientClasses(logo) {
    var regexAll = /<linearGradient [a-zA-Z0-9="_\s\-.()><:;#\/]+<\/linearGradient>/gmi;
    const array = [...logo.matchAll(regexAll)];
    //console.log('array of gradients', array);
    var gradientClasses = array.map(g => {
        var svgClass = new SVG('<svg>' + g + '</svg>');
        return extractGradientColor(svgClass.tree().children[0]);
    });

    return gradientClasses;
}

export function generateVariation(logo, params) {
    // preprocess gradients 
    // var gradientClasses = gradientClasses(logo);
    // if (gradientClasses.length) {
    //     gradientClasses.forEach(g => {
    //         if (params.fill) {
    //             var newColor = convertColor(g.color, params.fill);
    //         }
    //         if (newColor) {
    //             logo = logo.replace('url(#' + g.id + ')', g.color);
    //         }
    //         //console.log('newColor', newColor, g.color);
    //         var brightness = new Brightness(g.color);
    //         var tone = brightness.tone();
    //         //console.log(newColor, tone, params, gradientClasses,);
    //     });
    // }


    // Hex values replace
    var regex = /fill:#[a-zA-Z0-9]{6}/gmi;
    var fills = logo.match(regex);
    if (fills) {
        fills.forEach(f => {
            var oldColor = f.replace('fill:', '');
            if (params && params.fill) {
                var newColor = convertColor(oldColor, params.fill);
            }

            if (newColor) {
                logo = logo.replace(f, "fill:" + newColor);
            }
        });
    }

    // RGB values replace
    var regex = /fill:rgb\([0-9]{1,3},[0-9]{1,3},[0-9]{1,3}\)/gmi;
    var fills = logo.match(regex);
    if (fills) {
        fills.forEach(f => {
            var oldRGB = f.replace(['fill:rgb('], ')', '').split(',');
            var oldHex = '#' + oldRGB.map(c => hex(c)).join('');
            if (params && params.fill) {
                var newColor = convertColor(oldHex, params.fill);
            }

            if (newColor) {
                logo = logo.replace(f, "fill:" + newColor);
            }
        });
    }



    // convert logo to tree
    var svgClass = new SVG(logo);
    var tree = svgClass.tree();

    var viewBox = tree.properties.viewBox;
    var width = viewBox.split(" ")[2];


    var converted_tree = render(tree, params, width);

    var converted_logo = svgClass.to_svg(converted_tree);

    var converted_b64 = "data:image/svg+xml;base64," + btoa(converted_logo);

    var generatedVariation = {
        logo: converted_logo,
        logo_b64: converted_b64,
        title: params.title,
        background: params.background ? params.background : "transparent",
    }
    // 2. proceed changes
    // 3. generate back to svg
    // 4. return correct format

    //console.log('generatdVariation', generatedVariation);

    return generatedVariation;
}



function convertColor(color, params) {
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

function hex(x) {
    var hexDigits = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f"]
    return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
}

function render(block, params, width) {

    if (block.tagName && !['svg', 'root'].includes(block.tagName)) {
        block.properties = applyParams(block.properties, { ...params }, block, width);
    }

    if (block.children && block.children.length) {
        block.children = block.children.map(kid => render({ ...kid }, params, width));
    }

    return { ...block };
}

function applyParams(properties, params, block, width) {
    var updatedProperties = properties;

    if (params.fill) {
        updatedProperties = applyFillChange(updatedProperties, { ...params.fill }, block);
    }
    if (params.stroke) {
        updatedProperties = applyStrokeChange(updatedProperties, { ...params.stroke }, width);
    }

    return updatedProperties;
}

function applyFillChange(properties, params, block) {
    if (properties.hasOwnProperty('fill') && properties.fill && properties.fill != 'none') {
        var newColor = convertColor(properties.fill, params);
        if (newColor) {
            properties.fill = newColor;
        }
    }

    return { ...properties };
}

function applyStrokeChange(properties, params, width) {
    properties.stroke = params.color;
    if (params.width) {
        properties['stroke-width'] = parseInt(width / 280);
    }

    return properties;
}

function extractGradientColor(block) {
    //console.log(block);
    var res = { "id": block.properties.id };
    var stops = block.children.map(c => {
        return {
            'offset': c.properties.offset,
            'style': c.properties.style,
            'id': c.properties.id
        }
    });
    var colors = getGradientColorFromStops(stops);

    if (!colors) {
        return null;
    }

    var color = getMiddleColor(colors);

    return {
        color,
        'id': block.properties.id
    };
}

function getMiddleColor(colors) {
    var closest = 0.5;
    var closestIndex = 0;
    colors.forEach((color, index) => {
        var diff = Math.abs(0.5 - color.offset);
        if (diff < closest) {
            closest = diff;
            closestIndex = index;
        }
    });

    return colors[closestIndex].color;
}

function getGradientColorFromStops(stops) {
    var regexAll = /stop-color:#[0-9A-Za-z]{3,6}/gmi;
    var colors = stops.map(c => {
        if (!c.style) {
            return {
                "offset": c.offset,
                "color": "#000000"
            }
        }
        var match = c.style.match(regexAll);
        var colorValue = match.length ?
            match[0].replaceAll('stop-color:', '') :
            null;
        return {
            "offset": c.offset,
            'color': colorValue
        }
    });

    return colors;
}
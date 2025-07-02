import SVG from "./svg";

export function applyStyles(logo) {
    logo = addBlackFillToShapesWithoutAnyStyling(logo);
    var styleContent = getStyleTagContent(logo);
    if (logo.indexOf('linearGradient') !== -1) {
        logo = processGradients(logo);
    }
    if (!styleContent) {
        return logo;
    }
    //console.log('styleContent', styleContent);
    var classSections = getClassSections(styleContent);
    //console.log('classSections', classSections);
    var classGroups = getClassGroupsFromSections(classSections);
    //console.log('classGroups', classGroups);
    var classes = getClassesFromGroups(classGroups);
    //console.log('classes', classes);
    var newLogo = replaceClasses(logo, classes);

    var cleared = removeStyleTag(newLogo);
    return cleared;
}

function addBlackFillToShapesWithoutAnyStyling(logo) {
    // Getting all lines with single-tags like <XXXXXX/>
    var regexAll = /<[^<>]+\/>/gmi;

    let shapes = [...logo.matchAll(regexAll)];

    // filter out entries that already have fill or class params
    shapes.forEach((el) => {
        el = el[0];
        if (
            el.indexOf('fill') == -1 &&
            el.indexOf('class') == -1
        ) {
            var newEl = el.replace("/>", ' fill="#000000" />');
            logo = logo.replace(el, newEl);
        }
    });

    return logo;
}

export function getStyleTagContent(logo) {
    logo = logo.replace(' type="text/css"', '');
    var regexStyle = /<style>[\s\S]+<\/style>/gmi;
    var styleContentMatch = logo.match(regexStyle);
    if (styleContentMatch && styleContentMatch.length) {
        var styleContent = styleContentMatch[0];
        styleContent = styleContent.replace('<style>', '').replace('</style>', '');
        return styleContent;
    } else {
        return null;
    }
}

function processGradients(logo) {
    var regexAll = /<linearGradient [a-zA-Z0-9="_\s\-.()><:;#\/]+<\/linearGradient>/gmi;
    const array = [...logo.matchAll(regexAll)];
    //console.log('array of gradients', array);
    var gradientClasses = array.map(g => {
        var svgClass = new SVG('<svg>' + g + '</svg>');
        return extractGradientColor(svgClass.tree().children[0]);
    });

    //console.log('gradientClasses', gradientClasses);

    gradientClasses.forEach(c => {
        //console.log('REPLACEMENT', 'url(#' + c.id + ')', c.color);
        //logo = logo.replace('url(#' + c.id + ')', c.color);
    });

    return logo;
}

export function gradientClasses(logo) {
    var regexAll = /<linearGradient [a-zA-Z0-9="_\s\-.()><:;#\/]+<\/linearGradient>/gmi;
    const array = [...logo.matchAll(regexAll)];
    //console.log('array of gradients', array);
    var gradientClasses = array.map(g => {
        var svgClass = new SVG('<svg>' + g + '</svg>');
        return extractGradientColor(svgClass.tree().children[0]);
    });

    return gradientClasses;
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

function getClassSections(text) {
    var regexAll = /\.[a-zA-Z0-9_,-.\n\s]+\{[a-zA-Z0-9:_#;.\n\s-()]*\}/gmi;
    const array = [...text.matchAll(regexAll)];
    var res = array.map((el, i) => {
        return el.length ? el[0] : null;
    });
    return res;
}

//(^.[a-zA-Z0-9]+)?(\{[a-zA-Z]+:#[a-zA-Z0-9]+;)

function getClassGroupsFromSections(sections) {
    var regexClassParams = /\{[a-zA-Z0-9:_#;.()\n\s-]*\}/gmi;
    var result = sections.map(section => {
        const classParamsStr = [...section.matchAll(regexClassParams)];
        if (classParamsStr.length) {
            var classParams = classParamsStr[0][0];
            var index = classParamsStr[0].index;
            var classNames = section.slice(0, index);

            return {
                names: classNames,
                params: classParams
            }
        }
    });

    return result.filter(el => el != undefined);
}

function getClassesFromGroups(groups) {
    var regexClassIndividual = /\.[a-zA-Z0-9-]+/gmi;
    var regexParamsIndividual = /[a-zA-Z0-9-]+:[a-zA-Z0-9()_\-#]+/gi;
    var classes = [];
    groups.forEach(group => {

        var classNames = [];
        var individualClasses = [...group.names.matchAll(regexClassIndividual)];
        if (individualClasses.length) {
            individualClasses.forEach(cl => {
                var className = cl[0].replace('.', '');
                classNames.push(className);
            });
        }

        var classParams = {};
        var individualParams = [...group.params.matchAll(regexParamsIndividual)];
        if (individualParams.length) {
            individualParams.forEach(param => {
                if (param.length) {
                    var paramStr = param[0];
                    var paramsParts = paramStr.split(':');
                    if (paramsParts.length == 2) {
                        classParams[paramsParts[0]] = paramsParts[1];
                    }
                }
            });
        }

        classNames.forEach(className => {
            classes[className] = { ...classes[className], ...classParams }
        });


    });

    return classes;
}

function replaceClasses(logo, classes) {
    //console.log('classes', classes);
    var regexClass = /class="[a-zA-Z0-9_.-]+"/gmi;
    var availableClasses = [...logo.matchAll(regexClass)];
    availableClasses.forEach(classStrTmp => {
        //console.log('classStrTmp', classStrTmp);
        var classStr = classStrTmp[0];
        //console.log('classStr', classStr);
        var className = classStr.replace('class="', '').replace('"', '');
        //console.log('className', className);
        if (classes.length) {
            var classParams = classes[className];
            //console.log('classParams', classParams);
            logo = logo.replaceAll(classStr, paramsObjToStr(classParams));
        }
    });

    return logo;
}

function paramsObjToStr(params) {
    var output = '';
    var keys = Object.keys(params)
    keys.forEach((param, key) => {
        output += ' ' + param + '="' + params[param] + '" ';
    });

    return output;
}

export function removeStyleTag(data) {
    var start = data.indexOf('<style');
    var finish = data.indexOf('</style>');
    if (start !== -1 && finish !== -1) {
        var styleTag = data.slice(start, finish);
        var replaced = data.replace([styleTag, '<style>', '</style>'], '');

        return replaced;
        return data;
    }
    return data;
}

export function extractStyles(logo) {
    var start = logo.indexOf('<style');
    //console.log('start', start);
    var finish = logo.indexOf('</style>');
    //console.log('finish', finish);
    if (start !== -1 && finish !== -1) {
        var styleBlock = logo.slice(start, finish);
        var svgStyle = new SVG('<svg>' + styleBlock + '</svg>');

        return extractGradientColor(svgClass.tree().children[0]);
    } else {
        return null;
    }
    return logo;
}

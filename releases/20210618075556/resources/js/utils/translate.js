export default function translate(string) {
    let lang = document.getElementsByTagName('html')[0].attributes.lang.value;
    if (typeof translations[lang] !== "undefined" && typeof translations[lang][string] !== "undefined") {
        return translations[lang][string];
    }
    return string;
}
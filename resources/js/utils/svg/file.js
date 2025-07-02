export function prepareToBtoa(str) {
    if (typeof str !== "undefined" && str !== null)
        return str.replace(/[\u0250-\ue007]/g, "");

    return str;
    // first we use encodeURIComponent to get percent-encoded UTF-8,
    // then we convert the percent encodings into raw bytes which
    // can be fed into btoa.
    return encodeURIComponent(str).replace(
        /%([0-9A-F]{2})/g,
        function toSolidBytes(match, p1) {
            return String.fromCharCode("0x" + p1);
        }
    );
}

export function headers() {
    return {
        "X-CSRF-TOKEN": document.querySelector(
            'meta[name="csrf-token"]'
        ).content
    };
}
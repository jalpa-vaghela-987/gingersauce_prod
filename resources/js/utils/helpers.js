export function dateFormat(dateString) {
    if(dateString!=null){
        const isoDateString = dateString.replace(' ', 'T');
        const date = new Date(isoDateString);
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        const day = String(date.getDate()).padStart(2, '0');
        const formattedDate = `${day}.${month}.${year}`;
        return formattedDate;
    }
    return "N/A";
}

export function isSVG(str) {
    var svgRegex = /<svg\s[^>]*xmlns="http:\/\/www\.w3\.org\/2000\/svg"/;
    return svgRegex.test(str);
}
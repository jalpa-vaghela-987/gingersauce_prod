export default class Brightness {

    constructor(color) {
        this.color = color;
        this.dark_hsp = 83;
        this.light_hsp = 230;
    }

    tone() {
        if (this.color == "black") return "dark";
        if (this.color == "white") return "light";
        if (this.light()) return "light";
        if (this.dark()) return "dark";

        return null;
    }

    light() {
        return this.hsp() >= this.light_hsp;
    }

    dark() {
        return this.hsp() <= this.dark_hsp;
    }

    hsp() {
        if (!this.color) {
            console.log('color missing', this.color);
            return 0;
        }

        var color = +(
            "0x" + this.color.slice(1).replace(this.color.length < 5 && /./g, "$&$&")
        );

        var r = color >> 16;
        var g = (color >> 8) & 255;
        var b = color & 255;

        // HSP (Highly Sensitive Poo) equation from http://alienryderflex.com/hsp.html
        var hsp = Math.sqrt(
            0.299 * (r * r) + 0.587 * (g * g) + 0.114 * (b * b)
        );

        var hsp = Math.round(hsp);

        return hsp;
    }

}

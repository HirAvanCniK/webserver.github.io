var canvas = document.getElementById('canvascolorpicker');
var ctx = canvas.getContext("2d");
var img = document.getElementById('colorpickerimage');

var RGBinput = document.getElementById('rgbinput');
var HEXinput = document.getElementById('hexinput');

var ColorPickerContainer = document.getElementById('colorpicker');

ctx.drawImage(img, 0, 0);

function rgbToHex(r, g, b){
    const toHex = (c) => {
        const hex = c.toString(16);
        return hex.length === 1 ? '0' + hex : hex;
    };

    return `#${toHex(r)}${toHex(g)}${toHex(b)}`;
}

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
      R: parseInt(result[1], 16),
      G: parseInt(result[2], 16),
      B: parseInt(result[3], 16)
    } : null;
  }

canvas.addEventListener('click', (e) => {
    const x = e.offsetX;
    const y = e.offsetY;
    const pixel = ctx.getImageData(x, y, 1, 1);
    const color = `${pixel.data[0]}, ${pixel.data[1]}, ${pixel.data[2]}`;
    RGBinput.value = color;
    HEXinput.value = rgbToHex(pixel.data[0], pixel.data[1], pixel.data[2]);
    ColorPickerContainer.style.boxShadow = `0 0 10px 1px ${HEXinput.value}`;
});

function changeRGBcolor(){
    const R = parseInt(RGBinput.value.split(', ')[0]);
    const G = parseInt(RGBinput.value.split(', ')[1]);
    const B = parseInt(RGBinput.value.split(', ')[2]);
    if(!Number.isNaN(R) && !Number.isNaN(G) && !Number.isNaN(B)){
        HEXinput.value = rgbToHex(R, G, B);
        ColorPickerContainer.style.boxShadow = `0 0 10px 1px ${HEXinput.value}`;
    }
}

function changeHEXcolor(){
    const HEXcolor = HEXinput.value;
    if(HEXcolor.length == 7){
        const { R, G, B } = hexToRgb(HEXcolor);
        const RGBcolor = `${R}, ${G}, ${B}`;
        RGBinput.value = RGBcolor;
        ColorPickerContainer.style.boxShadow = `0 0 10px 1px ${HEXinput.value}`;
    }
}

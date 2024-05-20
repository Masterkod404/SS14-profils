
var HexCode=document.querySelectorAll(".hexcod");
var HexCodeBody=document.querySelectorAll(".hexcodBody");
var hexcodBodyHuman_Dworf=document.querySelector(".hexcodBodyHuman_Dworf");
function hexToRgb(hex,i,type) {
    hex.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i
        ,(m, r, g, b) => '#' + r + r + g + g + b + b)
    .substring(1).match(/.{2}/g)
    .map(x => parseInt(x, 16));
    if(type==true){
        document.querySelectorAll(".rCod")[i].value=parseInt(hex.substring(1, 3), 16);
        document.querySelectorAll(".gCod")[i].value=parseInt(hex.substring(3, 5), 16);
        document.querySelectorAll(".bCod")[i].value=parseInt(hex.substring(5, 7), 16);
        document.querySelectorAll(".rCheck")[i].value=parseInt(hex.substring(1, 3), 16);
        document.querySelectorAll(".gCheck")[i].value=parseInt(hex.substring(3, 5), 16);
        document.querySelectorAll(".bCheck")[i].value=parseInt(hex.substring(5, 7), 16);
    }else{
        document.querySelectorAll(".bodyrCod")[i].value=parseInt(hex.substring(1, 3), 16);
        document.querySelectorAll(".bodygCod")[i].value=parseInt(hex.substring(3, 5), 16);
        document.querySelectorAll(".bodybCod")[i].value=parseInt(hex.substring(5, 7), 16);
        document.querySelectorAll(".bodyrCheck")[i].value=parseInt(hex.substring(1, 3), 16);
        document.querySelectorAll(".bodygCheck")[i].value=parseInt(hex.substring(3, 5), 16);
        document.querySelectorAll(".bodybCheck")[i].value=parseInt(hex.substring(5, 7), 16);
    }

}
function hexToRgbBody(hex) {
    hex.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i
    ,(m, r, g, b) => '#' + r + r + g + g + b + b)
    .substring(1).match(/.{2}/g)
    .map(x => parseInt(x, 16));
    var G = parseInt(hex.substring(3, 5), 16);
    document.querySelector(".flesh_color").value=G;
    document.querySelector(".RGBcodBodyHuman_Dworf").value=G;
    
}
// hexToRgbBody(hexcodBodyHuman_Dworf.value);

for (let index = 0; index < HexCode.length; index++) {
     hexToRgb(HexCode[index].value,index,true);
}
for (let index = 0; index < HexCodeBody.length; index++) {
    hexToRgb(HexCodeBody[index].value,index,false);
}
// HexCode.forEach(element => {
//     alert(element.value);
   
// });

function ReturnRgb(selectRGB,inputRGB) {
    document.querySelector('#'+inputRGB).value=document.querySelector('#'+selectRGB).value;
}
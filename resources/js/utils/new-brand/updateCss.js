export default function updateCSSVariables(mainColor, secondColor, tertiaryColor, pantoneColor1) {
  document.body.style.setProperty('--theme-color', mainColor);
  document.body.style.setProperty('--sec-color', secondColor);
  document.body.style.setProperty('--tertiaryColor', tertiaryColor);
  document.body.style.setProperty('--pantoneColor1', pantoneColor1);
}

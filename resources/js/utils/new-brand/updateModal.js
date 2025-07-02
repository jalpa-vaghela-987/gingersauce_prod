export default function updateCSSVariablesSaveBtn(
  mainColorBook,
  mainFont,
  secFont,
  mainFontWeight,
  secFontWeight,
  mainColor,
  secondaryColor
) {
  document.body.style.setProperty('--main-color-book', mainColorBook);
  document.body.style.setProperty('--mainFont', mainFont);
  document.body.style.setProperty('--secFont', secFont);
  document.body.style.setProperty('--mainFontWeight', mainFontWeight);
  document.body.style.setProperty('--secFontWeight', secFontWeight);
  document.body.style.setProperty('--theme-color', mainColor);
  document.body.style.setProperty('--sec-color', secondaryColor);

  //ckeditor primary color set
    document.body.style.setProperty('--ck-color-button-on-color', mainColor);
    document.body.style.setProperty('--ck-color-base-foreground', mainColor);
    document.body.style.setProperty('--ck-color-split-button-hover-border', mainColor);
    document.body.style.setProperty('--ck-color-list-button-on-background', mainColor);
    document.body.style.setProperty('--ck-color-list-button-on-background-focus', mainColor);
    document.body.style.setProperty('--ck-color-link-default', mainColor);
}

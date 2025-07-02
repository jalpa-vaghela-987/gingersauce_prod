  function resize_to_fit(container) {
    let output = container.children[0]
    let fontSize = window.getComputedStyle(output).fontSize;
    let fontSizeValue = (parseFloat(fontSize) - 1);
    if(fontSizeValue<3) return;

    output.style.fontSize = fontSizeValue + 'px';
    //document.querySelector('#status').innerHTML += output.clientHeight + ' - ' + container.clientHeight + 'Font-size: ' + fontSizeValue +'<br>'
    if(output.clientHeight > container.clientHeight){
      resize_to_fit(container);
    }
  }

  var blocks = document.getElementsByClassName('autosize')
  Array.from(blocks).forEach((block) => {
    try {
      resize_to_fit(block);
    } catch (error) {
      block.innerText = error
    }

    block.style.borderWidth = '2px'
  });
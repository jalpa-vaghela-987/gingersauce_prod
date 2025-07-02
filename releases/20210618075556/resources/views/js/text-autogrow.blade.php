<script>
  document.addEventListener("DOMContentLoaded", function(event) {

    function resize_to_fit(container) {
      let output = container.children[0]
      let fontSize = window.getComputedStyle(output).fontSize;
      let fontSizeValue = (parseFloat(fontSize) - 1);
      if(fontSizeValue<3) return;

      container.style.fontSize = fontSizeValue + 'px';
      output.style.fontSize = fontSizeValue + 'px';
      if(output.clientHeight > container.clientHeight){
        resize_to_fit(container);
      }
    }

    var blocks = document.getElementsByClassName('autosize')
    Array.from(blocks).forEach((block) => {
      try {
        resize_to_fit(block);
      } catch (error) {
      }
    });

  });
</script>
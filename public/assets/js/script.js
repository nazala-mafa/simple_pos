$('#togglerBtn, #collapseSide').click(function(){ document.getElementsByTagName('body')[0].classList.toggle('g-sidenav-pinned') })

$(".numeric").on("keyup", function(event ) {                   
  // When user select text in the document, also abort.
  var selection = window.getSelection().toString(); 
  if (selection !== '') {
      return; 
  }       
  // When the arrow keys are pressed, abort.
  if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
      return; 
  }       
  var $this = $(this);            
  // Get the value.
  var input = $this.val();            
  input = input.replace(/[\D\s\._\-]+/g, ""); 
  input = input?parseInt(input, 10):0; 
  $this.val(function () {
      return (input === 0)?"":input.toLocaleString("id-ID"); 
  }); 
});
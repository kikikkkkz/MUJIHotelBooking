// var btn = getElementByID("btn");
$('#btn').click(function(){
	toggleText();
});

function toggleText() {
      var Disabled = document.getElementById("txtBox").disabled;
      document.getElementById("txtBox").disabled = !Disabled;
  }
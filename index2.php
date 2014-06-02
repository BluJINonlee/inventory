<html>
	<head>
	</head>
	<!--List of all the CTA Site-->
<body onload="selectType()">
<form name="scanItem" id="scanItem" onsubmit="return onEnter()" action="listRequest.php" method="POST">
  <!--change to checkForEndRow()-->
  <select name="site" id="site">
    <option value="103">103</option>
    <option value="ASH">ASH</option>
    <option value="BEV">BEV</option>
    <option value="CHP">CHP</option>
    <option value="DIV">DIV</option>
    <option value="DSP">DSP</option>
    <option value="E63">E63</option>
    <option value="E89">E89</option>
    <option value="FAC">FAC</option>
    <option value="FGL">FGL</option>

    <option value="103">103</option>
    <option value="ASH">ASH</option>
    <option value="BEV">BEV</option>
    <option value="CHP">CHP</option>
    <option value="DIV">DIV</option>
    <option value="DSP">DSP</option>
    <option value="E63">E63</option>
    <option value="E89">E89</option>
    <option value="FAC">FAC</option>
    <option value="FGL">FGL</option>


    <option value="FRK">FRK</option>
    <option value="HAR">HAR</option>
    <option value="HOW">HOW</option>
    <option value="JEF">JEF</option>
    <option value="KED">KED</option>
    <option value="KIM">KIM</option>
    <option value="LAK">LAK</option>
    <option value="LIN">LIN</option>
    <option value="MAD">MAD</option>
    <option value="MID">MID</option>


    <option value="NPK">NPK</option>
    <option value="OHR">OHR</option>
    <option value="ORL">ORL</option>
    <option value="RAC">RAC</option>
    <option value="RSM">RSM</option>
    <option value="S54">S54</option>
    <option value="SKO">SKO</option>
    <option value="SSH">SSH</option>
    <option value="W74">W74</option>
    
    <option value="W79">W79</option>
    <option value="W95">W95</option>
    <option value="WSH">WSH</option>
  </select>
  
  <select name="location" id="location">
    <option value="clerk">Clerks</option>
    <option value="trans">Transportation</option>
    <option value="maint">Maintanence</option>
    <option value="office">Office</option>
    <option value="training">Training</option>
    <option value="class">Class Rooms</option>
  </select>
  
  <select name="scanType" id="scanType" onchange="selectType()">
    <option value="pc" default>Full Set (PC + Monitor + Printer)</option>
    <option value="monitor">Monitor Only</option>
    <option value="printer">Local Printer Only</option>
    <option value="netPrinter">Network Printer</option>    
  </select>
  
  <div id="scanForm">
    
  </div>
  <input type="submit" id="submit"/>
</form>
<div id="value"></div>

<script type="text/javascript">
	

	var scanForm = document.getElementById("scanForm");

var modelInput = "<input id='model' name='model' placeholder='Model #'/>";
var assetInput = "<input id='asset' name='asset' placeholder='Asset Tag #'/>";
var serialInput = "<input id='serial' name='serial' placeholder='Serial #'/>";
var typeValue = document.getElementById("scanType");
var counter = 1;
var submit = document.getElementById("submit");
var active = document.activeElement;

//variables if type equals PC

var lastInput = null;
var counter = 0;

function checkValue(){
  var siteValue = document.getElementById("site").value;
  var locationValue = document.getElementById("location").value;

  document.getElementById("value").innerHTML = 
    "Site: "+ siteValue + "<br/> Location: " + locationValue;
  return false;
}







//find type and provide appropriate form. selectType() is called when page loads and when "scanType" input changes.
function selectType(){
  


  //creates form need for what is being input.
  if (typeValue.value == "pc"){
    var counter = 0;
    var deviceType = ["PC","Monitor","Printer"];
    scanForm.innerHTML ="";
    while(counter < 3) {
    
    var newModel = "<input id='model"+(counter+1)+"' name='model"+(counter+1)+"' placeholder='Model #'/>";
    var newAsset = "<input id='asset"+(counter+1)+"' name='asset"+(counter+1)+"' placeholder='Asset Tag #'/>";
    var newSerial = "<input id='serial"+(counter+1)+"' name='serial"+(counter+1)+"' placeholder='Serial #'/>";
    
    
    
      scanForm.innerHTML += newModel + newAsset + newSerial ;
    
    counter++;
  }
   // scanForm.firstChild.focus();

} else {
  if (typeValue.value == "monitor"){
    scanForm.innerHTML = "Please enter monitor's: ";
  } else {
    scanForm.innerHTML = "Please enter printer's: ";
  }
  
  scanForm.innerHTML= scanForm.innerHTML + modelInput + assetInput + serialInput;
  scanForm.firstChild.focus();
  }
}







//when pressing enter, focus either moves to the next input, or if the is no more, submits it.
function onEnter(){
  active = document.activeElement;
  if (typeValue.value == "pc") {
    //create another if statement to see if the set is done.
    
    
   
    //document.getElementById("value").innerHTML = active.value + " Last Input: " + lastInput;
    
    if (lastInput == active.value){
    //when last number is inserted twice, as a signal to end the entry, the last entry is omitted since it was just a signal.
      //clear active element, then return true.
     
    active.value = "";
    return true;
    
    
    } else if (active.nextSibling == submit) {
      //create new row of input
      counter++;
      var newModel = document.createElement("input");
      var newAsset = document.createElement("input");
      var newSerial = document.createElement("input");
      
      newModel.setAttribute("name","model"+counter);
      newAsset.setAttribute("name","asset"+counter);
      newSerial.setAttribute("name","serial"+counter);
      
      scanForm.insertBefore(newModel,submit);
      scanForm.insertBefore(newAsset,submit);
      scanForm.insertBefore(newSerial,submit);
      lastInput = active.value;
      return false;
    } else {
      
      lastInput = active.value;
      active.nextSibling.focus();
      
      return false;
      
      
    }
    
    
    } else {
    if(document.activeElement.nextSibling != document.getElementById("submit")) {
      
      document.activeElement.nextSibling.focus();
      return false;
     
    }
  }
}


</script>
</body>
</html>
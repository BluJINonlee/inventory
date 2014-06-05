<?php session_start() ?>

<html>
	<head>
	</head>
	<!--List of all the CTA Site-->
<body onload="selectType()">
<form name="scanItem" id="scanItem" onsubmit="return onEnter()" action="updateInventory.php" method="POST">
  <!--change to checkForEndRow()-->
  <select name="site" id="site">
    <option id='103' value="103">103</option>
    <option id='ASH' value="ASH">ASH</option>
    <option id='BEV' value="BEV">BEV</option>
    <option id='CHP' value="CHP">CHP</option>
    <option id='DIV' value="DIV">DIV</option>
    <option id='DSP' value="DSP">DSP</option>
    <option id='E63' value="E63">E63</option>
    <option id='E89' value="E89">E89</option>
    <option id='FAC' value="FAC">FAC</option>
    <option id='FGL' value="FGL">FGL</option>

    <option id='FRK' value="FRK">FRK</option>
    <option id='HAR' value="HAR">HAR</option>
    <option id='HOW' value="HOW">HOW</option>
    <option id='JEF' value="JEF">JEF</option>
    <option id='KED' value="KED">KED</option>
    <option id='KIM' value="KIM">KIM</option>
    <option id='LAK' value="LAK">LAK</option>
    <option id='LIN' value="LIN">LIN</option>
    <option id='MAD' value="MAD">MAD</option>
    <option id='MID' value="MID">MID</option>


    <option id='MID' value="NPK">NPK</option>
    <option id='OHR' value="OHR">OHR</option>
    <option id='ORL' value="ORL">ORL</option>
    <option id='RAC' value="RAC">RAC</option>
    <option id='RSM' value="RSM">RSM</option>
    <option id='S54' value="S54">S54</option>
    <option id='SKO' value="SKO">SKO</option>
    <option id='SSH' value="SSH">SSH</option>
    <option id='W74' value="W74">W74</option>
    
    <option id='W79' value="W79">W79</option>
    <option id='W95' value="W95">W95</option>
    <option id='WSH' value="WSH">WSH</option>
  </select>
  
  <select name="location" id="location">
    <option id="clerk" value="clerk">Clerks</option>
    <option id="transman" value="transman">Transportation Manager</option>
    <option id="maint" value="maint">Maintanence</option>
    <option id="maintman" value="maintman">Maintanence Manager</option>
    <option id="office" value="office">Office</option>
    <option id="training" value="training">Training</option>
    <option id="instruction" value="instruction">Class Rooms</option>
    <option id="stockroom" value="stockroom">Stock Room</option>
    <option id="payroll" value="payroll">Payroll</option>
    <option id="admin" value="admin">Admin Manager</option>
    <option id="gm" value="gm">General Manager</option>
    <option id="revmaint" value="revmaint">Revenue Maintenance</option>
    <option id="BSM" value="BSM">BSM</option>
    <option id="radio" value="radio">Radio Room</option>
    <option id="fuel" value="fuel">Fuel Office</option>
    <option id="yardmaster" value="yardmaster">Yard Master</option>
    <option id="power-way" value="power-way">Power and Way</option>
    <option id="signal" value="signal">Signal Room</option>
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
var monitorModels = [ "17in", "19in","15in","20in","24in"];
var pcModels = ["Dell Optiplex 790","Dell Optiplex 755", "Dell Optiplex 780", "Dell Latitude E6500", "Dell Latitude D820", "Dell Latitude D830", "Lenovo T430s", "Lenovo T600", "Lenovo T61", "Panasonic Toughbook" ];
var html = "";
var deviceType = ["monitor","printer"];
var deviceSelect ="<select id='deviceSelect' name='deviceSelect'>";

for (var i = 0; i < deviceType.length; i++){
  deviceSelect += "<option id='"+deviceType[i]+"' value='"+deviceType[i]+"'>"+deviceType[i].toUpperCase()+"</option>";
}

deviceSelect += "</select>";
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
  
document.getElementById("<?php ($_SESSION != null ? Print($_SESSION['site']): Print('FRK')); ?>").setAttribute("selected", "selected");
document.getElementById("<?php ($_SESSION != null ? Print($_SESSION['location']): Print('BSM')); ?>").setAttribute("selected", "selected");

  //creates form need for what is being input.
  if (typeValue.value == "pc"){
    var counter = 0;
    
    scanForm.innerHTML ="";
    
    
    var newModel = "<select id='model"+(counter+1)+"' name='model"+(counter+1)+"'>"
    for(var i = 0; i < pcModels.length; i++){

    	newModel += "<option value='"+pcModels[i]+"'>"+pcModels[i]+"</options>";
		
	}
	newModel += "</select>";
    var newAsset = "<input id='asset"+(counter+1)+"' name='asset"+(counter+1)+"' placeholder='Asset Tag #'/>";
    var newSerial = "<input id='serial"+(counter+1)+"' name='serial"+(counter+1)+"' placeholder='Serial #'/>";
    scanForm.innerHTML += newModel + newAsset + newSerial + "<br/>" ;
    counter++;

    //monitor

    newModel = "<select id='model"+(counter+1)+"' name='model"+(counter+1)+"'>"
    for(var i = 0; i < monitorModels.length; i++) {
    	newModel += "<option value='"+monitorModels[i]+"'>"+ monitorModels[i]+"</options>";			
	}
	newModel += "</select>";
    newAsset = "<input id='asset"+(counter+1)+"' name='asset"+(counter+1)+"' placeholder='Asset Tag #'/>";
    newSerial = "<input id='serial"+(counter+1)+"' name='serial"+(counter+1)+"' placeholder='Serial #'/>";
    scanForm.innerHTML += newModel + newAsset + newSerial + "<br/>" ;
    counter++;

    //misc 1

   newModel = "<input name='model"+(counter+1)+"'' placeholder='Model #'/>";
  newAsset = "<input id='asset"+(counter+1)+"' name='asset"+(counter+1)+"' placeholder='Asset Tag #'/>";
  newSerial = "<input id='serial"+(counter+1)+"' name='serial"+(counter+1)+"' placeholder='Serial #'/>";
  scanForm.innerHTML += deviceSelect + newModel + newAsset + newSerial + "<br/>" ;
  document.getElementById("deviceSelect").setAttribute("name","misc1");
  document.getElementById("deviceSelect").setAttribute("id","misc1");
  counter++;

  //misc 2

  newModel = "<input name='model"+(counter+1)+"'' placeholder='Model #'/>";
  newAsset = "<input id='asset"+(counter+1)+"' name='asset"+(counter+1)+"' placeholder='Asset Tag #'/>";
  newSerial = "<input id='serial"+(counter+1)+"' name='serial"+(counter+1)+"' placeholder='Serial #'/>";
  scanForm.innerHTML += deviceSelect + newModel + newAsset + newSerial + "<br/>" ;
  document.getElementById("deviceSelect").setAttribute("name","misc2");
  document.getElementById("deviceSelect").setAttribute("id","misc2");
  counter++;


  
    scanForm.firstChild.nextSibling.focus();

} else {
  if (typeValue.value == "monitor"){
    html = "Please enter monitor's: <select name ='model'>";
    for (var i = 0; i < monitorModels.length; i++){
    	html += "<option value ='" + monitorModels[i]+"'>"+ monitorModels[i] +"</option>";
    }
    scanForm.innerHTML = html;
  } else {
    scanForm.innerHTML = "Please enter printer's: <input name='model' placeholder='Model #'/>";
  }
  
  scanForm.innerHTML += assetInput + serialInput;
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
    
    
    } else if (active.nextSibling.nodeName == "BR") {
    	lastInput = active.value;
    	if (active.nextSibling.nextSibling.nodeName == "SELECT"){
    		active.nextSibling.nextSibling.nextSibling.focus();
    	} else {

    	active.nextSibling.nextSibling.focus();
    	}
    	return false;
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
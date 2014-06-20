<?php session_start();
//2 arrays listing all CTA cites, and realized area locations.
$site = array("103","ASH","BEV","CHP","DIV","DSP","E63","E89","FAC","FLG","FRK","HAR","HOW","JEF","KED","KIM","LAK","LIN","MAD","MID","OHR","ORL","RAC","RSM","S54","SKO","SSH","W74","W79","W95","WSH");
$location = array("Clerk","Transportation Manager","Maintenance","Maintenance Manager","Offices","Training","Instruction","Stock Room","Payroll","Administrator Manager","General Manager","Revenue Maintenance","BSM","Radio","Yard Master","Power-Way","Signal");

?>
<html>
	<head>
	</head>
	
	<body onload="selectType()">
		
		<form name="scanItem" id="scanItem" onsubmit="return onEnter()" action="updateInventory.php" method="POST">
		  <!--change to checkForEndRow()-->
		  <select name="site" id="site">
			<?php
			/*creates a dropdown menu with all the sites and locations, and if one had been selected during a previous
			 entry, makes it selected*/
			for($i=0; $i < sizeof($site); $i++){
				echo "<option id='{$site[$i]}' value='{$site[$i]}'";
				
				echo (isset($_SESSION['site']) && $site[$i] == $_SESSION['site'] ? "selected = selected" : "");
				
				
				
				echo ">$site[$i]</option>";
			}
			?>
		  </select>
		  <select name="location" id="location">
			<?php
			for($i=0; $i < sizeof($location); $i++){
				echo "<option id='{$location[$i]}' value='{$location[$i]}'";
				
				echo (isset($_SESSION['location']) && $location[$i] == $_SESSION['location'] ? "selected = selected" : "");
				echo ">$location[$i]</option>";
			}
			?>
		   
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
		var pcModels = [];
		var printerModels = [];
		var monitorModels = [];
		var netPrinterModels = [];
		
		
		<?php
		
		
		$con = mysqli_connect("localhost", "root", "", "inventory");
		
		$printerModel;
		$netPrinterModel;
		
		
		$results = mysqli_query($con, "SELECT DISTINCT model from PCs ORDER BY Model");
		
		
		while ($row = mysqli_fetch_array($results)){
			
			echo "pcModels.push('{$row[0]}'); \n";
			
		}
		
		$results = mysqli_query($con, "SELECT DISTINCT model from monitors ORDER BY Model");
		while ($row = mysqli_fetch_array($results)){
			
			echo "monitorModels.push('{$row[0]}'); \n";
			
		}
		
		$results = mysqli_query($con, "SELECT DISTINCT model from Printers ORDER BY Model");
		while ($row = mysqli_fetch_array($results)){
			
			echo "printerModels.push('{$row[0]}'); \n";
			
		}
		
		$results = mysqli_query($con, "SELECT DISTINCT model from netPrinters ORDER BY Model");
		while ($row = mysqli_fetch_array($results)){
			
			echo "netPrinterModels.push('{$row[0]}'); \n";
		}
		
		?>
	
	var scanForm = document.getElementById("scanForm");
	
	var modelInput = "<input id='model' name='model' placeholder='Model #'/>";
	var assetInput = "<input id='asset' name='asset' placeholder='Asset Tag #'/>";
	var serialInput = "<input id='serial' name='serial' placeholder='Serial #'/>";
	var typeValue = document.getElementById("scanType");
	var counter = 1;
	var submit = document.getElementById("submit");
	var active = document.activeElement;
	//var monitorModels = [ "17in", "19in","15in","20in","24in"];
	//var pcModels = ["Dell Optiplex 790","Dell Optiplex 755", "Dell Optiplex 780", "Dell Latitude E6500", "Dell Latitude D820", "Dell Latitude D830", "Lenovo T430s", "Lenovo T600", "Lenovo T61", "Panasonic Toughbook" ];
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
	} else if (typeValue.value == "printer") {
	    html = "Please enter printer's: <select name='model' onchange='ifOther()'>";
	    for (var i = 0; i < printerModels.length; i++){
		html += "<option value ='" + printerModels[i]+"'>"+ printerModels[i] +"</option>";
	    }
	    html += "<option value='other'>other</option></select>";
	    scanForm.innerHTML = html;
	  } else {
		html = "Please enter printer's: <select name='model' onchange ='ifOther()'>";
		for (var i = 0; i < netPrinterModels.length; i++){
		html += "<option value ='" + netPrinterModels[i]+"'>"+ netPrinterModels[i] +"</option>";
	    }
	    html += "</option>";
	    scanForm.innerHTML = html;
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
	
	function ifOther() {
		if (this.value == "other") {
			var newModel = document.createElement("input");
			document.getElementById("model").removeAttribute("id");
			newModel.setAttribute("id", "model");
			document.insertBefore(newDevice,this.nextSibling);
		} else {
			selectType();
		}
		
	}
	
	
	</script>
	</body>
</html>
<?php

require "connectDatabase.php";

echo "
    <html>
        <head></head>
        <body>
            <form action='updateEntry.php' method='POST'>
                <input type='hidden' name='id' value='{$_REQUEST['id']}'/>
                <input type='hidden' name='deviceType' value='{$_REQUEST['deviceType']}'/>
                <label for='site'>Site: </label><input type='text' name='site' id='site' value='{$_REQUEST['site']}'/><br/>
                <label for='location'>Location: </label><input type='text' name='location' id='location' value='{$_REQUEST['location']}'/><br/>
                <label for='model'>Model: </label><input type='text' name='model' id='model' value='{$_REQUEST['model']}'/><br/>
                <label for='asset'>Asset Tag #: </label><input type='text' name='asset' id='asset' value='{$_REQUEST['asset']}'/><br/>
                <label for='serial'>Serial #: </label><input type='text' name='serial' id='serial' value='{$_REQUEST['serial']}'/><br/>
                <label for='sid'>Set ID: </label><input type='text' name='sid' id='sid' value='{$_REQUEST['sid']}'/><br/>
                <input type='submit'/>
            </form>
        
        
        </body>

    <html>


"

?>
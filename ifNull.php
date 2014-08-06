<?php
function ifNull ($data) {
	if ($data == "" || $data == null){
		return "NULL";
	} elseif(is_nan($data)){
            return $data;
        } else {
	    return "'".$data."'";
	}
}
?>
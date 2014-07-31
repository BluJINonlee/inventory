<?php
    class Entry{
        //initializes all the attributes of an entry
        protected $model;
        protected $asset;
        protected $serial;
        protected $date;
        protected $con;
        public $sid;
        protected $site;
        protected $location;
        protected $device;
        
        
        function __construct($site,$location,$model,$asset,$serial,$device) {
            $this->site = $site;
            $this->location = $location;
            $this->model = $model;
            $this->asset = $asset;
            $this->serial = $serial;
            $this->device = $device;
            $this->con = mysqli_connect("localhost","root","","inventory");
            $row = mysqli_fetch_row(mysqli_query($con, "SELECT MAX(sid) from pcs"));
            $sid = $row[0] + 1;
        }
        
        function submit(){
            $sql = "INSERT INTO table (sid, asset, serial, model, site, location) VALUES (SID, asset, serial, model, 'site', 'location');";
            $con = con;
            if ($error = mysqli_error($con)){
                echo $error;
            } else {
                echo "Success!";
            }
        }
    }
    
    //test
    
    $entry = new Entry("103", "Clerk","CoolPlex", "123456", "45679", "pcs");
    
    //echo $entry->submit();
?>
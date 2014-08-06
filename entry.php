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
        
        
        function __construct($table, $site,$location,$model,$asset,$serial,$device,$lastName,$firstName) {
            include_once("connectDatabase.php");
            include_once("ifNull.php");
            $this->table = $table;
            $this->site = ifNull($site);
            $this->location = ifNull($location);
            $this->model = ifNull($model);
            $this->asset = ifNull($asset);
            $this->serial = ifNull($serial);
            $this->device = ifNull($device);
            $this->lastName = ifNull($lastName);
            $this->firstName = ifNull($firstName);
            $this->con = $con;
            $row = mysqli_fetch_row(mysqli_query($con, "SELECT MAX(sid) from pcs"));
            $this->sid = $row[0] + 1;
            
           
        }
        
        function submit(){
            $con = $this->con;
            $row = mysqli_fetch_row(mysqli_query($con, "SELECT MAX(sid) from pcs"));
            $sid = $row[0] + 1;
            
            $sql = "INSERT INTO $this->table (sid, asset, serial, model, site, location) VALUES ($this->sid, $this->asset, $this->serial, $this->model, $this->site, $this->location);";
            echo $sql;
            mysqli_autocommit($con,false);
            mysqli_query($con, $sql);
            
            
            if ($error = mysqli_error($con)){
                
                echo $error;
            } else {
                //mysqli_commit($con);
                echo "Success!";
            }
        }
    }
    
    //test
    try {
    $entry = new Entry("pcs","103", "Clerk","CoolPlex", "123456", "45679", "pcs", null, null);
    $entry->submit();
    } catch(Exception $e) {
        echo $e;
    }
    
?>
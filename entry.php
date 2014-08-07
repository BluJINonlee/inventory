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
        protected $table;
        
        
        function __construct($table, $site,$location,$model,$asset,$serial,$lastName,$firstName, $sid) {
            include("connectDatabase.php");
            include_once("ifNull.php");
            $this->table = $table;
            $this->site = ifNull($site);
            $this->location = ifNull($location);
            $this->model = ifNull($model);
            $this->asset = ifNull($asset);
            $this->serial = ifNull($serial);
            $this->lastName = ifNull($lastName);
            $this->firstName = ifNull($firstName);
            $this->con = $con;
            $row = mysqli_fetch_row(mysqli_query($con, "SELECT MAX(sid) from pcs"));
            $this->sid = ifNull($sid);
            
           
        }
        
        static function getSID() {
            require "connectDatabase.php";
            $row = mysqli_fetch_row(mysqli_query($con, "SELECT MAX(sid) from pcs"));
            return $row[0] + 1;
        }
        
        function submit(){
            $con = $this->con;
            $sid = $this->sid;
            
            if ($this->table == "netPrinters") {
                $sql = "INSERT INTO $this->table (asset, serial, model, site, location,lastUpdate)
             VALUES ($this->asset, $this->serial, $this->model,$this->site, $this->location, now());";
            } else {
                $sql = "INSERT INTO $this->table (sid, asset, serial, model, lastName, firstName, site, location,lastUpdate)
             VALUES ($this->sid, $this->asset, $this->serial, $this->model,$this->lastName,$this->firstName, $this->site, $this->location, now());";
            }
            echo $sql."<br/>";
            mysqli_autocommit($con,false);
            mysqli_query($con, $sql);
            
            if ($error = mysqli_error($con)){
                
                echo $error;
            } else {
                mysqli_commit($con);
                echo "Success!";
            }
        }
    }
    
   
?>
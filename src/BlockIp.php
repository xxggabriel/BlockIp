<?php 

namespace BlockIp;

class BlockIp
{
    private static $instance;
    private static $ips = [];
    private static $data;

    private function __construct()
    {
    }
    

    public static function getInstance($data) : BlockIp
    {
        if(self::$instance == NULL){
            self::$instance = new BlockIp();
        }

        self::init($data);

        return self::$instance;
    }

    public static function init($data) : void
    {
        self::$data = $data;
        
        $ips = $data;

        if(!is_array($data)){

            $handle = fopen(self::$data, "a+");
            fclose($handle);

            if(!is_writable(self::$data)){
                throw new \Exception("Error, the file does not have permission to write: {self::$data}", 500);
            }
    
            if(!is_readable(self::$data)){
                throw new \Exception("Error, the file does not have permission to read: {self::$data}", 500);
            }

            $ips = file(self::$data);
        }

        foreach ($ips as $ip) {

            $ip = trim($ip);

            if(!empty($ip)){
                self::$ips[] = $ip;
            }
        }     
    }

    public function add($ip) : array
    {
        if(is_array($ip)){
            foreach ($ip as $key) {
                $this->validateIp($key);

                self::$ips[] = $key;
            }
        } else {

            $this->validateIp($ip);
    
            self::$ips[] = $ip;
        }

        $ips = array_unique(self::$ips);

        return $ips;
    }

    public function remove($ip) : array
    {
        
        if(is_array($ip)){
            foreach ($ip as $key => $value) {
                $this->validateIp($value);
                
                unset(self::$ips[$key]); 
            }
        } else {

            foreach (self::$ips as $key => $value) {
                $this->validateIp($value);
                if($value == $ip){
                    unset(self::$ips[$key]); 
                }
            }
        }

        if(is_array(self::$data)){

            $ips = array_unique(self::$ips);
            unlink(self::$data);
            $handle = fopen(self::$data, "a+");
    
            foreach ($ips as $ip) {
                fwrite($handle, $ip."\n");
            }
    
            fclose($handle);
        }

        return self::$ips;
    }

    public function itsBlocked($ip) : bool
    {
        $this->validateIp($ip);
        
        foreach(self::$ips as $ipBlock){
            if($ipBlock == $ip) {
                return true;
            }
        }

        return false;
    }

    private function validateIp(String $ip) : void
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new \Exception("IP invalid: {$ip}", 400);
        } 
    }

}
<?php

class Timer{
    private $time_start='';
    private $time_end='';
    private $state=false;
    
    public function start(){
        if($this->state == false){
            $this->state = true;
            $this->time_start = microtime(true);
        }
    }

    public function stop(){
        if($this->state == true){
            $this->state = false;
            $this->time_end = microtime(true);
            return ($this->time_end - $this->time_start);
        }
    }
}

?>

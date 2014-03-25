<?php

class ExecutionTime{
    
    private $iOverallStart;
    private $iOverallEnd;
    private $aTabTimers;
    private $valueLastCheckPoint = 1;      
    
    /* CONSTRUCTEUR DE LA CLASSE */
    function __construct() {
        $this->iOverallStart = microtime(true);
    }
    
    function checkpoint($nameCheckpoint = ''){
        //LE CHECKPOINT COMMENCE
        $this->aTabTimers[$nameCheckpoint][0] = microtime(true);
    }
    
    function __destruct(){
        if(ENVIRONNEMENT != 'PROD'){
            $this->iOverallEnd = microtime(true);
            if(isset($this->aTabTimers) && !empty($this->aTabTimers)){
                foreach($this->aTabTimers as $nomCheckPoint=>$timer){
                    if(!isset($timer[$valueLastCheckPoint])){
                        $this->aTabTimers[$nomCheckPoint][$valueLastCheckPoint] = microtime(true);
                    }
                    echo 'Duree globale : '.number_format($totalExecutionTime,3).'s';
                }
            }
            $this->afficheTimers();
        }
        
    }
    
    public function afficheTimers(){
        
        $totalExecutionTime = $this->iOverallEnd-$this->iOverallStart;
        echo '<div id="execution-time" style="background-color: #413D3D;bottom: 0;height: 100px;position: fixed;width: 100%;z-index: 5;color : white; overflow-y : scroll;">';
        echo 'Duree globale : '.number_format($totalExecutionTime,3).'s<br/>';
        if(isset($this->aTabTimers) && !empty($this->aTabTimers)){
            $ligneRecapitulative =  'Debut[0] ';
            $timer0EnCours = $this->iOverallStart;
            foreach($this->aTabTimers as $nomCheckPoint=>$timer){
                $timerStartCheckpoint = $timer[0];
                $timerEndCheckpoint = $timer[$valueLastCheckPoint];
                unset($timer[0]);
                unset($timer[$valueLastCheckPoint]);

                $ligneRecapitulative .= ' -> '.$nomCheckPoint.'['.number_format($timerStartCheckpoint-$timer0EnCours,3).']';
                $timer0EnCours = $timerStartCheckpoint;
                echo 'Checkpoint "'.$nomCheckPoint.'" : ';
                
                echo '[ Debut du script : 0';
                echo ' -> '.number_format($timerStartCheckpoint-$this->iOverallStart,3).'s';
                $timerEnCours = $timerStartCheckpoint;
                if(isset($timer) && !empty($timer)){
                    foreach($timer as $temps){
                        echo ' -> '.number_format($temps-$timerEnCours,3).'s';
                        $timerEnCours = $temps;
                    }
                }
                echo ' -> '.number_format($timerEndCheckpoint-$timerEnCours,3).' : Fin du script ]';
                
                echo '<br/>';

            }
            $ligneRecapitulative .= ' -> Fin['.number_format($this->iOverallEnd-$timer0EnCours,3).']]';
            echo $ligneRecapitulative.'<br/>';
        }
        echo '</div>';
        
        
    }
    
}

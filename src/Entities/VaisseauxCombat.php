<?php
namespace App\Entities;
use Exception;

class VaisseauxCombat extends Vaisseaux{

    private $munitions;
    
    public function __construct($nom, $carburant, $munitions) {
        parent ::__construct($nom, $carburant);
        if ($munitions < 0) {
            throw new \InvalidArgumentException("La quantité de munitions doit être un nombre positif.");
        }
        $this->munitions = $munitions;
    }

    /* Methodes Setters */

    public function setMunitions($munitions){
       return $this->munitions = $munitions;
    }

    /* Methodes Getters */

    public function getMunitions(){
        return $this->munitions;
    }

    /* Methodes */

    public function tirer($munitions){

        if ($this->getEtat() === false) {
            throw new \RuntimeException("Le vaisseau n'est pas opérationnel");
        }
        
        if($munitions <= 0){
            throw new \InvalidArgumentException("La quantité de munitions doit être un nombre positif.");
        }

        if($munitions > $this->munitions){
            throw new \InvalidArgumentException("Pas assez de munitions pour tirer.");
        }
        $this->munitions -= $munitions;
        $this->interaction("tirer", $munitions);
        return true;
    }
}
?>
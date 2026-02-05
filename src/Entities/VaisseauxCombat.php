<?php
namespace App\Entities;

class VaisseauxCombat extends Vaisseaux{

    private $munitions;
    
    public function __construct( $id, $nom, $carburant, $etat, $munitions) {
        parent ::__construct($id, $nom, $carburant, $etat);
        if ($munitions < 0) {
            throw new \InvalidArgumentException("La quantité de munitions doit être un nombre positif.");
        }
        $this->munitions = $munitions;
    }

    /* Methodes Setters */

    public function setMunitions($munitions)
    {
        $this->munitions = $munitions;

        return $this;
    }

    /* Methodes Getters */

    public function getMunitions(){
        return $this->munitions;
    }

    /* Methodes */

    public function tirer($munitions){

        if ($this->estOperationnel() === false) {
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
    }
}
?>
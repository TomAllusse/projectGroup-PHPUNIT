<?php
namespace App\Entities;

class VaisseauxCombat extends Vaisseaux{

    private $munitions;
    
    public function __construct($id, $nom, $carburant, $degatSubies, $etat, $munitions){

        parent:: __construct($id, $nom, $carburant, $degatSubies, $etat);
        $this->munitions = $munitions;

    }

    /* Methodes Setters */
    public function

    /* Methodes Getters */

    public function getMunitions(){
        return $this->munitions;
    }

    /* Methodes */

    public function tirer($balle){

        if ($this->estOperationnel() === false) {
            throw new \RuntimeException("Le vaisseau n'est pas opérationnel");
        }
        
        if($balle <= 0){
            throw new \InvalidArgumentException("La quantité de balle doit être un nombre positif.");
        }

        if($balle > $this->munitions){
            throw new \InvalidArgumentException("Pas assez de munitions pour tirer.");
        }
        $this->munitions -= $balle;
        $this->interaction("tirer", $balle);
    }


}


?>
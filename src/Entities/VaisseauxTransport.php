<?php

namespace App\Entities;

use Exception;

class VaisseauxTransport extends Vaisseaux{

    private $capaciteMax;
    private $chargeActuelle;

    public function __construct($nom, $carburant, $capaciteMax) {
        parent ::__construct($nom, $carburant);
        if ($capaciteMax < 0) {
            throw new \InvalidArgumentException("La capacité maximale doit être un nombre positif.");
        }
        $this->capaciteMax = $capaciteMax;
        $this->chargeActuelle = 0;
    }

    /* Methodes Setters */

    public function setCapaciteMax($capaciteMax){
        $this->capaciteMax = $capaciteMax;

        return $this;
    }

    public function setChargeActuelle($chargeActuelle){
        $this->chargeActuelle = $chargeActuelle;

        return $this;
    }

    /* Methodes Getters */

    public function getCapaciteMax(){
        return $this->capaciteMax;
    }

    public function getChargeActuelle(){
        return $this->chargeActuelle;
    }

    /* Methodes */

    public function charger($quantite){

        if ($this->getEtat() === false) {
            throw new \RuntimeException("Le vaisseau n'est pas opérationnel");
        }

        if ($quantite<=0){
            throw new \InvalidArgumentException("La quantité à charger doit être un nombre positif.");
        }

        if (($this->chargeActuelle + $quantite) > $this->capaciteMax){
            throw new \RuntimeException("La capacité de la soute est dépassée");
        }

        $this->chargeActuelle += $quantite;
    }

    public function decharger($quantite){

        if ($quantite <= 0 || $quantite  > $this->getChargeActuelle()){
            throw new \RuntimeException("Le déchargement est invalide");
        }

        $this->chargeActuelle -= $quantite;
    }

}


























?>
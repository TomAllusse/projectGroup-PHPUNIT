<?php

namespace App\Entities;

class VaisseauxTransport extends Vaisseaux{

    private $capaciteMax;
    private $chargeActuelle;

    public function __construct( $id, $nom, $carburant, $etat, $capaciteMax) {
        parent ::__construct($id, $nom, $carburant, $etat);
        if ($capaciteMax < 0) {
            throw new \InvalidArgumentException("La capacité maximale doit être un nombre positif.");
        }
        $this->capaciteMax = $capaciteMax;
        $this->chargeActuelle = 0;
    }

    /* Methodes Setters */

    public function setCapaciteMax($capaciteMax)
    {
        $this->capaciteMax = $capaciteMax;

        return $this;
    }

    public function setChargeActuelle($chargeActuelle)
    {
        $this->chargeActuelle = $chargeActuelle;

        return $this;
    }

    /* Methodes Getters */

    public function getCapaciteMax()
    {
        return $this->capaciteMax;
    }

    public function getChargeActuelle()
    {
        return $this->chargeActuelle;
    }

    /* Methodes */

    public function charger($quantite){

        if ($this->estOperationnel() === false) {
            throw new \RuntimeException("Le vaisseau n'est pas opérationnel");
        }

        if ($quantite<=0){
            throw new \InvalidArgumentException("La quantité à charger doit être un nombre positif.");
        }

        if ($this->chargeActuelle + $quantite > $this->capaciteMax){
            throw new \RuntimeException ("La capacité de la soute est dépassée");
        }

        $this->chargeActuelle += $quantite;
    }

    public function decharger($quantite){

        if ($quantite <=0 || $quantite  > $this->ChargeActuelle){
            throw new \RuntimeException ("Le déchargement est invalide");
        }

        $this->chargeActuelle -= $quantite;
    }

}


























?>
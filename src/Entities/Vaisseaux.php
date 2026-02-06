<?php

namespace App\Entities;

use Exception;

class Vaisseaux
{
    private $nom; // Nom du vaisseau
    private $carburant; // Niveau de carburant (0 à 100) => 100 valeur par défaut
    private $degatSubies;
    private $etat; // True pour opérationnel, False pour non opérationnel

    /* Constructeur */
    
    public function __construct($nom, $carburant = 100)
    {
       
        $this->nom = $nom;
        if ($carburant < 0 || $carburant > 100) {
            throw new \InvalidArgumentException("Le niveau de carburant doit être compris entre 0 et 100.");
        }
        $this->degatSubies = 0;
        if ($carburant > 0) {
            $this->etat = true;
        } else {
            $this->etat = false;
        }
    }

    /* Methodes Setters */

    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    public function setCarburant($carburant)
    {
        $this->carburant = $carburant;

        return $this;
    }

    public function setDegatSubies($degats)
    {
        $this->degatSubies = $degats;

        return $this;
    }

    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /* Methodes Getters */

    public function getNom()
    {
        return $this->nom;
    }

    public function getCarburant()
    {
        return $this->carburant;
    }

    public function getDegatSubies()
    {
        return $this->degatSubies;
    }

    public function getEtat()
    {
        return $this->etat;
    }
    
    /* Methode */

    public function conso($quantite)
    {
        if($quantite < 0){
            return "La quantité d'énergie à consommer doit être positive.";
        }
        if($this->etat === FALSE){
            return "Le vaisseau est non opérationnel et ne peut pas consommer d'énergie.";
        }
        if($quantite > $this->carburant){
            return "Pas assez de carburant pour consommer {$quantite} unités.";
        }
        $this->carburant -= $quantite;
        $this->simulateurAvaries();
        return "Le vaisseau a consommé {$quantite} unités de carburant.";
    }

    public function reparation()
    {
        $this->degatSubies = 0;
        if($this->etat === FALSE && $this->carburant > 0){
            $this->etat = TRUE;
        }
        return "Le vaisseau est entrain de se faire réparer";
    }

    public function simulateurAvaries()
    {
        if($this->carburant <= 0 || $this->degatSubies >= 100){
            $this->etat = FALSE;
            return "Le vaisseau {$this->nom} est devenu non opérationnel.";
        } elseif($etat=false){
            $this->etat = True;
            return "Le vaisseau {$this->nom} est devenu opérationnel.";
        }
    }

    public function interaction($action, $param = null)
    {
        if ($action === "charger")
        {
            return "Le vaisseau est entrain d'être charger";
        } else if($action === "tirer" && $param !== null ){
            return "Le vaisseau Tire {$param} munitions";
        } else if($action === "reparer"){
            return $this->reparation();
        } else if($action === "diagnostique"){
            return "Etat du vaisseau: " . ($this->etat ? "Opérationnel" : "Non opérationnel") . ", Carburant: ".$this->carburant.", Dégâts subis: ".$this->degatSubies;
        } else if($action === "consommationEnergie" && $param !== null ){
            return $this->conso($param);
        } else if($action === "rempliEnergie" ){
            $this->carburant = 100;
            return "Le vaisseau est entrain d'être remplie d'énergie";
        }else {
            return "Action inconnue ou paramètre manquant.";
        }
    }
}

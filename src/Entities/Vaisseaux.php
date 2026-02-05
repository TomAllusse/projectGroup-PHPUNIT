<?php

namespace App\Entities;

use Exception;

class Vaisseaux
{
    private $id; // Identifiant unique du vaisseau (à voir si on le met ou pas => voir si c'est le nom à la place)
    private $nom; // Nom du vaisseau
    private $carburant; // Niveau de carburant (0 à 100) => 100 valeur par défaut
    private $degatSubies;
    private $etat; // True pour opérationnel, False pour non opérationnel

    /* Constructeur */
    
    public function __construct($id, $nom, $carburant = 100, $etat = true)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->carburant = $carburant;
        $this->degatSubies = 0;
        $this->etat = $etat;
    }

    /* Methodes Setters */
    
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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

    public function getId()
    {
        return $this->id;
    }

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

    public function simulateurAvaries()
    {
        if($this->carburant <= 0 || $this->degatSubies >= 100){
            $this->etat = FALSE;
            return "Le vaisseau {$this->nom} est devenu non opérationnel.";
        }
    }

    public function interaction($action, $param = null)
    {
        if ($action === "charger")
        {
            return "Le vaisseau est entrain d'être charger";
        } else if($action === "tirer" ){
            return "Le vaisseau Tire {$param} munitions";
        } else if($action === "reparer"){
            $this->degatSubies = 0;
            if($this->etat === FALSE && $this->carburant > 0){
                $this->etat = TRUE;
            }
            return "Le vaisseau est entrain de se faire réparer";
        } else if($action === "diagnostique"){
            return "Etat du vaisseau: " . ($this->etat ? "Opérationnel" : "Non opérationnel") . ", Carburant: ".$this->carburant.", Dégâts subis: ".$this->degatSubies;
        } else if($action === "consommationEnergie" ){
            if($param === null){
                return "Veuillez spécifier la quantité d'énergie à consommer.";
            }else if($param < 0){
                return "La quantité d'énergie à consommer doit être positive.";
            }
            if($this->etat === FALSE){
                return "Le vaisseau est non opérationnel et ne peut pas consommer d'énergie.";
            }
            if($param > $this->carburant){
                return "Pas assez de carburant pour consommer {$param} unités.";
            }
            $this->carburant -= $param;
            return "Le vaisseau a consommé {$param} unités de carburant.";
        } else if($action === "rempliEnergie" ){
            $this->carburant = 100;
            return "Le vaisseau est entrain d'être remplie d'énergie";
        } else {
            return "Action inconnue";
        }
    }
}
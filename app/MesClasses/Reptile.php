<?php
namespace App\MesClasses;

use App\MesClasses\Animal;
use App\MesClasses\Mammifere;
use App\MesClasses\Oiseau;
use App\TableReptile;
use App\TableAnimal;

class Reptile extends Animal
{
    const NOMTYPE = 'Reptile';

    private $ecaille;

    public function __construct($idAnimal, $nom, $genre, $ecaille) {
    	parent::__construct($idAnimal, $nom, $genre);
        $this->ecaille = $ecaille;
    }

    public function getEcaille(){
    	return $this->ecaille;
    }

    public function setEcaille($ecaille){
    	$this->ecaille = $ecaille;
    }

    public function hiss(){
        $mot = "un";
        if($this->genre == "Féminin"){$mot = "une";}
        return "je suis ".$mot." ".$this->nom;
    }

    public function hissLong(){
        return $this->hiss()." et mes écailles sont ".$this->ecaille;
    }

    public function getJSON(){

        //on utilise html_entity_decode pour les variables qui ont été encodé, celles qui ont été saisie par un utilisateur
        $arr = array(
            'id' => $this->id, 
            'nom' => html_entity_decode($this->nom), 
            'genre' => $this->genre,
            'type' => $this::NOMTYPE, 
            'ecaille' => html_entity_decode($this->ecaille), 
            'hiss' => html_entity_decode($this->hiss()), 
            'hissLong' => html_entity_decode($this->hissLong()),
        );

        return json_encode($arr);
    }

    public function modifierUnReptile(){
        //on supprime l'ancien animal, ne sachant pas de qu'elle type il était
        Reptile::supprimerUnReptile($this->id);
        Mammifere::supprimerUnMammifere($this->id);
        Oiseau::supprimerUnOiseau($this->id);

        //ajout de l'animal dans la table animal
        $ligneAnimal = new TableAnimal;

        $ligneAnimal->id = $this->id;
        $ligneAnimal->nom = $this->nom;
        $ligneAnimal->genre = $this->genre;

        $ligneAnimal->save();

        //ajout du reptile dans la table reptile
        $ligneReptile = new TableReptile;

        $ligneReptile->idAnimal = $this->id;
        $ligneReptile->ecaille = $this->ecaille;

        $ligneReptile->save();

    }

    /*=================Fonctions statiques=================*/

    public static function tousLesReptiles(){

        $lesReptiles = array();
        $tableReptile = TableReptile::all();
        foreach ($tableReptile as $ligneReptile) {

            $ligneAnimal = TableAnimal::find($ligneReptile->idAnimal);

            $unReptile = new Reptile($ligneAnimal->id, $ligneAnimal->nom, $ligneAnimal->genre, $ligneReptile->ecaille);

            $lesReptiles[] = $unReptile;
        }

        return $lesReptiles;
    }

    public static function supprimerUnReptile($idAnimal){

        //suppression du reptile dans la table reptile
        TableReptile::where('idAnimal', $idAnimal)->delete();
        //suppression de l'animal dans la table animal
        TableAnimal::where('id', $idAnimal)->delete();

    }

    public static function ajouterUnReptile($nom, $genre, $ecaille){

        //ajout de l'animal dans la table animal
        $ligneAnimal = new TableAnimal;

        $ligneAnimal->nom = $nom;
        $ligneAnimal->genre = $genre;

        $ligneAnimal->save();

        $nouvelleLigne = TableAnimal::whereRaw('id = (select max(`id`) from animal)')->first();
        $idAnimal = $nouvelleLigne->id;

        //ajout du reptile dans la table reptile
        $ligneReptile = new TableReptile;

        $ligneReptile->idAnimal = $idAnimal;
        $ligneReptile->ecaille = $ecaille;

        $ligneReptile->save();

        return $idAnimal;
    }

}

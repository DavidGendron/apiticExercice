<?php
namespace App\MesClasses;

use App\MesClasses\Animal;
use App\MesClasses\Reptile;
use App\MesClasses\Mammifere;
use App\TableOiseau;
use App\TableAnimal;

class Oiseau extends Animal
{
    const NOMTYPE = 'Oiseau';

    private $plumage;

    public function __construct($id, $nom, $genre, $plumage) {
    	parent::__construct($id, $nom, $genre);
        $this->plumage = $plumage;
    }

    public function getPlumage(){
    	return $this->plumage;
    }

    public function setFourrure($plumage){
    	$this->plumage = $plumage;
    }

    public function tweet(){
        $mot = "un";
        if($this->genre == "Féminin"){$mot = "une";}
        return "je suis ".$mot." ".$this->nom;
    }

    public function tweetLong(){
        return $this->tweet()." et mon plumage est ".$this->plumage;
    }

    public function getJSON(){
        //on utilise html_entity_decode pour les variables qui ont été encodé, celles qui ont été saisie par un utilisateur
        $arr = array(
            'id' => $this->id, 
            'nom' => html_entity_decode($this->nom), 
            'genre' => $this->genre,
            'type' => $this::NOMTYPE, 
            'plumage' => html_entity_decode($this->plumage), 
            'tweet' => html_entity_decode($this->tweet()), 
            'tweetLong' => html_entity_decode($this->tweetLong()),
        );

        return json_encode($arr);
    }

    public function modifierUnOiseau(){
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

        //ajout de l'oiseau dans la table oiseau
        $ligneOiseau = new TableOiseau;

        $ligneOiseau->idAnimal = $this->id;
        $ligneOiseau->plumage = $this->plumage;

        $ligneOiseau->save();

    }

    /*=================Fonctions statiques=================*/

    public static function tousLesOiseaux(){

        $lesOiseaux = array();
        $tableOiseaux = TableOiseau::all();
        foreach ($tableOiseaux as $ligneOiseau) {

            $ligneAnimal = TableAnimal::find($ligneOiseau->idAnimal);

            $unOiseau = new Oiseau($ligneAnimal->id, $ligneAnimal->nom, $ligneAnimal->genre, $ligneOiseau->plumage);

            $lesOiseaux[] = $unOiseau;
        }

        return $lesOiseaux;
    }

    public static function supprimerUnOiseau($idAnimal){

        //suppression de l'oiseau dans la table oiseau
        TableOiseau::where('idAnimal', $idAnimal)->delete();
        //suppression de l'animal dans la table animal
        TableAnimal::where('id', $idAnimal)->delete();

    }

    public static function ajouterUnOiseau($nom, $genre, $plumage){

        //ajout de l'animal dans la table animal
        $ligneAnimal = new TableAnimal;

        $ligneAnimal->nom = $nom;
        $ligneAnimal->genre = $genre;

        $ligneAnimal->save();

        $nouvelleLigne = TableAnimal::whereRaw('id = (select max(`id`) from animal)')->first();
        $idAnimal = $nouvelleLigne->id;

        //ajout de l'oiseau dans la table oiseau
        $ligneOiseau = new TableOiseau;

        $ligneOiseau->idAnimal = $idAnimal;
        $ligneOiseau->plumage = $plumage;

        $ligneOiseau->save();

        return $idAnimal;
    }

}

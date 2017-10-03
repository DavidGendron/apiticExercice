<?php
namespace App\MesClasses;

use App\MesClasses\Animal;
use App\MesClasses\Reptile;
use App\MesClasses\Oiseau;
use App\TableMammifere;
use App\TableAnimal;

class Mammifere extends Animal
{
    const NOMTYPE = 'Mammifère';

    private $fourrure;

    public function __construct($id, $nom, $genre, $fourrure) {
    	parent::__construct($id, $nom, $genre);
        $this->fourrure = $fourrure;
    }

    public function getFourrure(){
    	return $this->fourrure;
    }

    public function setFourrure($fourrure){
    	$this->fourrure = $fourrure;
    }

    public function growl(){
        $mot = "un";
        if($this->genre == "Féminin"){$mot = "une";}
        return "je suis ".$mot." ".$this->nom;
    }

    public function growlLong(){
        return $this->growl()." et ma fourrure est ".$this->fourrure;
    }

    public function getJSON(){
        //on utilise html_entity_decode pour les variables qui ont été encodé, celles qui ont été saisie par un utilisateur
        $arr = array(
            'id' => $this->id, 
            'nom' => html_entity_decode($this->nom),
            'genre' => $this->genre,
            'type' => $this::NOMTYPE,
            'fourrure' => html_entity_decode($this->fourrure), 
            'growl' => html_entity_decode($this->growl()), 
            'growlLong' => html_entity_decode($this->growlLong()),
        );

        return json_encode($arr);
    }

    public function modifierUnMammifere(){
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

        //ajout du mammifère dans la table mammifere
        $ligneMammifere = new TableMammifere;

        $ligneMammifere->idAnimal = $this->id;
        $ligneMammifere->fourrure = $this->fourrure;

        $ligneMammifere->save();

    }

    /*=================Fonctions statiques=================*/

    public static function tousLesMammiferes(){

        $lesMammiferes = array();
        $tableMammifere = TableMammifere::all();
        foreach ($tableMammifere as $ligneMammifere) {

            $ligneAnimal = TableAnimal::find($ligneMammifere->idAnimal);

            $unMammifere = new Mammifere($ligneAnimal->id, $ligneAnimal->nom, $ligneAnimal->genre, $ligneMammifere->fourrure);

            $lesMammiferes[] = $unMammifere;
        }

        return $lesMammiferes;
    }

    public static function supprimerUnMammifere($idAnimal){

        //suppression du mammifère dans la table mammifere
        TableMammifere::where('idAnimal', $idAnimal)->delete();
        //suppression de l'animal dans la table animal
        TableAnimal::where('id', $idAnimal)->delete();

    }

    public static function ajouterUnMammifere($nom, $genre, $fourrure){

        //ajout de l'animal dans la table animal
        $ligneAnimal = new TableAnimal;

        $ligneAnimal->nom = $nom;
        $ligneAnimal->genre = $genre;

        $ligneAnimal->save();

        $nouvelleLigne = TableAnimal::whereRaw('id = (select max(`id`) from animal)')->first();
        $idAnimal = $nouvelleLigne->id;

        //ajout du mammifère dans la table mammifere
        $ligneMammifere = new TableMammifere;

        $ligneMammifere->idAnimal = $idAnimal;
        $ligneMammifere->fourrure = $fourrure;

        $ligneMammifere->save();

        return $idAnimal;
    }

}


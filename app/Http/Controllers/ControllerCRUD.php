<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MesClasses\Reptile;
use App\MesClasses\Oiseau;
use App\MesClasses\Mammifere;

class ControllerCRUD extends Controller
{

    public function accueil()
    {
        $reptiles = Reptile::tousLesReptiles();
        $mammiferes = Mammifere::tousLesMammiferes();
        $oiseaux = Oiseau::tousLesOiseaux();

        $animaux = array_merge($reptiles, $mammiferes, $oiseaux);
        
        //on trie par ordre alphabétique
		usort
		(
		    $animaux,
		    create_function
		    (
		        '$obj1, $obj2',
		        'return strcmp($obj1->getNom(), $obj2->getNom());'
		    )
		);

		return view('accueil', compact('animaux'));
    }

    public function ajaxSupprimer()
    {
    	$reponse = "false";
    	//on teste si on a pas d'erreur au niveau des paramètres
    	if(!empty($_POST["idAnimal"]) AND is_numeric($_POST["idAnimal"]) AND !empty($_POST["type"]) 
    		AND (($_POST["type"] == "Reptile") OR ($_POST["type"] == "Mammifère") OR ($_POST["type"] == "Oiseau"))){
 
    		//suppression de l'animal
    		switch ($_POST["type"]) {
    			case 'Reptile':
    				Reptile::supprimerUnReptile(intval($_POST["idAnimal"]));
    				break;
    			case 'Mammifère':
    				Mammifere::supprimerUnMammifere(intval($_POST["idAnimal"]));
    				break;
    			case 'Oiseau':
    				Oiseau::supprimerUnOiseau(intval($_POST["idAnimal"]));
    				break;
    			default:
    				# code...
    				break;
    		}

    		$reponse = "true";
    	}
    	return "true";
    }

    public function ajaxAjouter()
    {
        $reponse = "false";
        //on teste si on a pas d'erreur au niveau des paramètres
        if(!empty(trim($_POST["nom"])) AND isset($_POST["description"]) AND !empty($_POST["type"]) 
            AND (($_POST["type"] == "Reptile") OR ($_POST["type"] == "Mammifère") OR ($_POST["type"] == "Oiseau"))
            AND !empty($_POST["genre"]) AND (($_POST["genre"] == "Féminin") OR ($_POST["genre"] == "Masculin") )){

            //filtre de sécurité, contre injection js, à supposer que Laravel Eloquent lutte par défaut au injection SQL
            $nom = htmlentities(trim($_POST["nom"]));
            $description = htmlentities(trim($_POST["description"]));
            $type = $_POST["type"];
            $genre = $_POST["genre"];


            //ajout de l'animal
            switch ($type) {
                case 'Reptile':
                    $idAnimal = Reptile::ajouterUnReptile($nom, $genre, $description);
                    $leReptile = new Reptile($idAnimal, $nom, $genre, $description);
                    $reponse = $leReptile->getJSON();
                    break;

                case 'Mammifère':
                    $idAnimal = Mammifere::ajouterUnMammifere($nom, $genre, $description);
                    $leMammifere = new Mammifere($idAnimal, $nom, $genre, $description);
                    $reponse = $leMammifere->getJSON();
                    break;

                case 'Oiseau':
                    $idAnimal = Oiseau::ajouterUnOiseau($nom, $genre, $description);
                    $lOiseau = new Oiseau($idAnimal, $nom, $genre, $description);
                    $reponse = $lOiseau->getJSON();
                    break;

                default:
                    # code...
                    break;
            }

        }
        return $reponse;
    }

    public function ajaxModifier()
    {
        $reponse = "false";
        //on teste si on a pas d'erreur au niveau des paramètres
        if(!empty(trim($_POST["nom"])) AND isset($_POST["description"]) AND !empty($_POST["type"]) 
            AND (($_POST["type"] == "Reptile") OR ($_POST["type"] == "Mammifère") OR ($_POST["type"] == "Oiseau"))
            AND !empty($_POST["genre"]) AND (($_POST["genre"] == "Féminin") OR ($_POST["genre"] == "Masculin") )
            AND !empty($_POST["idAnimal"]) AND is_numeric($_POST["idAnimal"])){

            //filtre de sécurité, contre injection js et html
            $nom = htmlentities(trim($_POST["nom"]));
            $description = htmlentities(trim($_POST["description"]));
            $type = $_POST["type"];
            $genre = $_POST["genre"];
            $idAnimal = intval($_POST["idAnimal"]);


            //modification de l'animal
            switch ($type) {
                case 'Reptile':

                    $leReptile = new Reptile($idAnimal, $nom, $genre, $description);
                    //on modifie l'animal
                    $leReptile->modifierUnReptile();
                    
                    $reponse = $leReptile->getJSON();

                    break;

                case 'Mammifère':
                    
                    $leMammifere = new Mammifere($idAnimal, $nom, $genre, $description);
                    //on modifie l'animal
                    $leMammifere->modifierUnMammifere();
                    
                    $reponse = $leMammifere->getJSON();

                    break;

                case 'Oiseau':

                    $lOiseau = new Oiseau($idAnimal, $nom, $genre, $description);
                    //on modifie l'animal
                    $lOiseau->modifierUnOiseau();
                    
                    $reponse = $lOiseau->getJSON();
                    break;

                default:
                    # code...
                    break;
            }

        }
        return $reponse;
    }
}
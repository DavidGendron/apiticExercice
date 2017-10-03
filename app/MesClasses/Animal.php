<?php
namespace App\MesClasses;

class Animal
{

    public $id;

    public $nom;

    public $genre;

    //private $poids;

    //private $taille;

    public $timestamps = true;

    public function __construct($id, $nom, $genre) {
    	$this->id = $id;
    	$this->nom = $nom;
    	$this->genre = $genre;
    }

    public function getNom(){
    	return $this->nom;
    }
    public function getGenre(){
    	return $this->genre;
    }
	public function getId(){
    	return $this->id;
    }

    public function setNom($nom){
    	$this->nom = $nom;
    } 
	public function setGenre($genre){
    	$this->genre = $genre;
    }	
    public function setId($id){
    	$this->id = $id;
    }

}

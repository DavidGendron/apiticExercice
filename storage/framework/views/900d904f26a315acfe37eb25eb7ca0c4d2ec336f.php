<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>" id="haut">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
        <link rel="icon" type="image/x-icon" href="<?php echo asset('image/favicon.ico')?>">

        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Roboto:100,200,400,700" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo asset('css/font-awesome-4.7.0/css/font-awesome.min.css')?>" type="text/css">
        
        <link rel="stylesheet" href="<?php echo asset('css/normalize.css')?>" type="text/css">
        <link rel="stylesheet" href="<?php echo asset('css/app.css')?>" type="text/css">
        
        <script src="<?php echo asset('js/jquery-3.2.1.min.js')?>"></script>
        <script src="<?php echo asset('js/app.js')?>"></script>
    </head>
    <body>
        <h1>Exercice pour <img src="<?php echo asset('image/logoApiticMenu.png')?>" alt="logo apitic"></h1>
        <form method="POST" action="" class="formAjouter">
            <div class="cache">
                <label><input name="nom" type="text" placeholder="Nom"></input></label>
                <select name="genre">
                    <option value="Féminin" selected>Féminin</option> 
                    <option value="Masculin">Masculin</option>
                </select>
                <select name="type">
                    <option value="Reptile" selected>Reptile</option> 
                    <option value="Mammifère">Mammifère</option>
                    <option value="Oiseau">Oiseau</option>
                </select>
                
                <label><input name="description" type="text" placeholder="Écailles"></input></label>
            </div>

            <submit class="boutonAjouter" value="envoyer">Ajouter <i class="fa fa-plus" aria-hidden="true"></i></submit>
           
        </form>

        <form method="POST" action="" id="formModifier">
            <div class="cache visible">
                <input name="idAnimal" type="hidden" value="0">
                <label><input name="nom" type="text" placeholder="Nom"></input></label>
                <select name="genre">
                    <option value="Féminin" selected>Féminin</option> 
                    <option value="Masculin">Masculin</option>
                </select>
                <select name="type">
                    <option value="Reptile" selected>Reptile</option> 
                    <option value="Mammifère">Mammifère</option>
                    <option value="Oiseau">Oiseau</option>
                </select>
                
                <label><input name="description" type="text" placeholder="Écailles"></input></label>
            </div>

            <submit class="boutonModifier" value="envoyer">Modifier <i class="fa fa-pencil" aria-hidden="true"></i></submit>
           
        </form>

        <table id="animaux">
            <tr><th>Nom</th><th>Description</th><th>Actions</th></tr>
        <?php

        foreach($animaux as $animal){
        
            //on construit la description propre à chaque type d'animal, ainsi que ça classe css
            switch ($animal::NOMTYPE) {
                case "Reptile":
                    $description = $animal->hissLong();
                    $classeCss = "reptile";
                    $caracteristique = $animal->getEcaille();
                    break;
                case "Mammifère":
                    $description = $animal->growlLong();
                    $classeCss = "mammifere";
                    $caracteristique = $animal->getFourrure();
                    break;
                case "Oiseau":
                    $description = $animal->tweetLong();
                    $classeCss = "oiseau";
                    $caracteristique = $animal->getPlumage();
                    break;
                default:
                    $description = "";
                    $classeCss = "";
            }

            echo "<tr data-id='".$animal->getId()."' data-type='".$animal::NOMTYPE."' data-nom='".$animal->getNom()."' data-caracteristique='".$caracteristique."' data-genre='".$animal->getGenre()."' class='".$classeCss."'>
            <td>".$animal->getNom()."</td><td>".$description."</td>
            <td><i class='fa fa-pencil modifier' aria-hidden='true'></i> <i class='fa fa-trash supprimer' aria-hidden='true'></i></td>
            </tr>";
        }
        ?>
        </table>
        <form method="POST" action="" class="formAjouter">
            <div class="cache">
                <label><input name="nom" type="text" placeholder="Nom"></input></label>
                <select name="genre">
                    <option value="Féminin" selected>Féminin</option> 
                    <option value="Masculin">Masculin</option>
                </select>
                <select name="type">
                    <option value="Reptile" selected>Reptile</option> 
                    <option value="Mammifère">Mammifère</option>
                    <option value="Oiseau">Oiseau</option>
                </select>
                
                <label><input name="description" type="text" placeholder="Écailles"></input></label>
            </div>

            <submit class="boutonAjouter" value="envoyer">Ajouter <i class="fa fa-plus" aria-hidden="true"></i></submit>
           
        </form>

    </body>
</html>

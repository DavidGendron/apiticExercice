$( document ).ready(function() {
    
	$('body').on('click', '.boutonAjouter', function() {
		if( $(this).hasClass("aDroite")){
			var inputNom = $(this).parent().find("input[name='nom']");
			var selectGenre = $(this).parent().find("select[name='genre']");
			var selectType = $(this).parent().find("select[name='type']");
			var inputDescription = $(this).parent().find("input[name='description']");
			var token = $('meta[name="csrf-token"]').attr('content');
			var classeCss = "";
			var description = "";
			var caracteristique = "";
			var boutonAjouter = $(this);

			//on est bien au deuxième clique du bouton, donc validation du formulaire
			//test si présence d'un nom d'animal
			if($.trim(inputNom.val()) == ''){
				
				//Erreur
				inputNom.addClass("erreur");

			} else{

				//ajax ajout
		    	$.ajax({
			        url : '/ajouter',
			        type : 'POST',
			        data: {
				        "_method": 'POST',
				        "_token": token,
				        "nom": inputNom.val(),
				        "genre": selectGenre.val(),
				        "type": selectType.val(),
				        "description": inputDescription.val()
				    },
			        dataType : 'JSON',
			    	success:function(data){
				        //console.log('success');
				        //console.log(data);

				        switch (data["type"]) {
			                case "Reptile":
			                    classeCss = "reptile";
			                    description = data["hissLong"];
			                    caracteristique = data["ecaille"];
			                    break;
			                case "Mammifère":
			                    classeCss = "mammifere";
			                    description = data["growlLong"];
			                    caracteristique = data["fourrure"];
			                    break;
			                case "Oiseau":
			                    classeCss = "oiseau";
			                    description = data["tweetLong"];
			                    caracteristique = data["plumage"];
			                    break;
			                default:
			            }

			            //Création de la ligne

				        $('#animaux tr:last').after("<tr data-id='"+data["id"]+"' data-type='"+data["type"]
				        +"' data-nom='"+data["nom"]+"' data-caracteristique='"+caracteristique+"' data-genre='"+data["genre"]+"' class='"+classeCss+"'>"
			            +"<td>"+data["nom"]+"</td><td>"+description+"</td>"
			            +"<td><i class='fa fa-pencil modifier' aria-hidden='true'></i> <i class='fa fa-trash supprimer' aria-hidden='true'></i></td>"
			            +"</tr>");

				        //Initialisation CSS
						inputNom.removeClass("erreur");
						boutonAjouter.removeClass("aDroite");
						boutonAjouter.parent().find(".cache").removeClass("visible");
						//Initialisation formulaire
						inputNom.val("");
						selectGenre.val("Féminin");
						selectType.val("Reptile");
						inputDescription.val("");
						inputDescription.attr("placeholder", "Écailles");
				    },
				    error:function(data){
				    	//console.log('erreur');
				    	//console.log(data);
				    },
			    });

			}

		} else {

			$(this).addClass("aDroite");
			$(this).parent().find(".cache").addClass("visible");
		}
		
	});

    $('body').on('click', '.modifier', function() {
    	var inputId = $("#formModifier").find("input[name='idAnimal']");
    	var inputNom = $("#formModifier").find("input[name='nom']");
		var selectGenre = $("#formModifier").find("select[name='genre']");
		var selectType = $("#formModifier").find("select[name='type']");
		var inputDescription = $("#formModifier").find("input[name='description']");
		var idAnimal = $(this).parent().parent().data("id");
		var type = $(this).parent().parent().data("type");
		var nom = $(this).parent().parent().data("nom");
		var caracteristique = $(this).parent().parent().data("caracteristique");
		var genre = $(this).parent().parent().data("genre");

		var nouveauPlaceholder;

		switch (type) {
		  	case "Reptile":
		    	nouveauPlaceholder = "Écailles";
		    	break;
		    case "Mammifère":
		    	nouveauPlaceholder = "Fourrure";
		    	break;
		    case "Oiseau":
		    	nouveauPlaceholder = "Plumage";
		    	break;
		}

    	//on remplit le formulaire modifier
    	inputId.val(idAnimal);
    	inputNom.val(nom);
		selectGenre.val(genre);
		selectType.val(type);
		inputDescription.val(caracteristique);
		inputDescription.attr("placeholder", nouveauPlaceholder);

    	if ($("#formModifier").css('display') == "none") {
    		$("#formModifier").slideToggle();
    	}

		$('html, body').animate({
			scrollTop:$("#haut").offset().top
		}, 'slow');

	});

	$('body').on('click', '.boutonModifier', function() {
		var inputId = $(this).parent().find("input[name='idAnimal']");
		var inputNom = $(this).parent().find("input[name='nom']");
		var selectGenre = $(this).parent().find("select[name='genre']");
		var selectType = $(this).parent().find("select[name='type']");
		var inputDescription = $(this).parent().find("input[name='description']");
		var token = $('meta[name="csrf-token"]').attr('content');
		var classeCss = "";
		var caracteristique = "";
		var description = "";
		var boutonModifier = $(this);
		var ligneModifier = $("#animaux").find("[data-id='"+inputId.val()+"']");

		//test si présence d'un nom d'animal
		if($.trim(inputNom.val()) == ''){
			
			//Erreur
			inputNom.addClass("erreur");

		} else {

			//ajax modifier
	    	$.ajax({
		        url : '/modifier',
		        type : 'POST',
		        data: {
				        "_method": 'POST',
				        "_token": token,
				        "idAnimal": inputId.val(),
				        "nom": inputNom.val(),
				        "genre": selectGenre.val(),
				        "type": selectType.val(),
				        "description": inputDescription.val()
				},
		        dataType : 'JSON',
		    	success:function(data){

					//modification de la ligne
					switch (data["type"]) {
		                case "Reptile":
		                    classeCss = "reptile";
		                    description = data["hissLong"];
		                    caracteristique = data["ecaille"];
		                    break;
		                case "Mammifère":
		                    classeCss = "mammifere";
		                    description = data["growlLong"];
		                    caracteristique = data["fourrure"];
		                    break;
		                case "Oiseau":
		                    classeCss = "oiseau";
		                    description = data["tweetLong"];
		                    caracteristique = data["plumage"];
		                    break;
		                default:
		            }

		            //modifier les data de la ligne, pas besoin pour le id, car c'est le même

		            ligneModifier.data( "type", data["type"] );
		            ligneModifier.data( "nom", data["nom"] );
		            ligneModifier.data( "caracteristique", caracteristique );
		            ligneModifier.data( "genre", data["genre"] );

		            //changer la couleur selon le type
		            ligneModifier.removeClass().addClass(classeCss);

		            //modifier les valeurs visibles
		            ligneModifier.find("td:first-child").text(data["nom"]);
		            ligneModifier.find("td:nth-child(2)").text(description);

			        //console.log('success ');
			        //console.log(data);
			    },
			    error:function(data){
			    	//console.log('erreur');
			    	//console.log(data);
			    },
		    });
			


			$("#formModifier").slideToggle( "slow", function() {

				//Initialisation CSS
				inputNom.removeClass("erreur");
				//Initialisation formulaire
				inputNom.val("");
				selectGenre.val("Féminin");
				selectType.val("Reptile");
				inputDescription.val("");
				inputDescription.attr("placeholder", "Écailles");

			});
		}

	});

	$('body').on('click', '.supprimer', function() {
		var ligneSupprimer = $(this).parent().parent();
		var confirmation=confirm('Souhaitez-vous vraiment supprimer cette ligne ?');
		var token = $('meta[name="csrf-token"]').attr('content');
		var idAnimal = $(this).parent().parent().data("id");
		var type = $(this).parent().parent().data("type");

	    if (confirmation) {
	    	
	    	//ajax Suppression
	    	$.ajax({
		        url : '/supprimer',
		        type : 'POST',
		        data: {
			        "_method": 'POST',
			        "_token": token,
			        "idAnimal": idAnimal,
			        "type": type
			    },
		        dataType : 'JSON',
		    	success:function(data){

		    		ligneSupprimer.remove();
			        //console.log('success');
			        //console.log(data);
			    },
			    error:function(data){
			    	//console.log('erreur');
			    	//console.log(data);
			    },
		    });
	    } 
	});

	$( "select[name='type']" ).change(function() {
		var nouveauPlaceholder;

		switch (this.value) {
		  	case "Reptile":
		    	nouveauPlaceholder = "Écailles";
		    	break;
		    case "Mammifère":
		    	nouveauPlaceholder = "Fourrure";
		    	break;
		    case "Oiseau":
		    	nouveauPlaceholder = "Plumage";
		    	break;
		}

		$(this).parent().find("input[name='description']").attr("placeholder", nouveauPlaceholder);

	});

});
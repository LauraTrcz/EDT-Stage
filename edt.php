<?php 
	
	include 'php/database.php';
	global $db;

	//focus sur le dossier contenant les fichiers xml
	$dir = glob('xml/*.xml');

	//insertion des données dans la base de données "solutions" et récupération des clés sous forme de tableau pour exécution de la fonction parser
	if(isset($_POST['formsend'])){

		extract($_POST); /*extraire toutes les variables*/

		if(!empty($instance) && !empty($solver) && !empty($format) && !empty($representation) && !empty($temps_calcul)) { /*tant que le formulaire n'est pas vide*/

			$i = $db->prepare("INSERT INTO solutions(fichier_probleme,solver,format,representation,temps_calcul) VALUES (:instance, :solver, :format, :representation, :temps_calcul)");
			$i->execute(['instance' => $instance, 'solver' => $solver, 'format' => $format, 'representation' => $representation, 'temps_calcul' => $temps_calcul]);
			echo "Données entrées";

			array{

			}
		}	
	}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Emploi Du Temps</title>
		<link rel="stylesheet" href="css/formulaire.css">
		<script src="js/Animations.js"></script> 
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&display=swap" rel="stylesheet"> 
</head>
<body>

	<!-- Bande de menu -->

	<section class="haut">
		<div class="top-page">
			<header>
				<img src="images/edt.jpg" alt="Logo du site">
				<nav class="menu">
					<ul class="menuList">
						<li><a href="edt.php" style="text-decoration: none;">Emploi du temps</a></li>
						<li><a href="php/insertion.php" style="text-decoration: none;" style="color: white;">Formulaire d'insertion</a></li>
						<li><a href="php/visualisation.php" style="text-decoration: none;" style="color: white;">Visualisation de la base de données</a></li>
					</ul>
				</nav>
			</header>
		</div>
	</section>

	<!-- Reste de la page -->

	<section class="page">
		
		<h1>Emploi Du Temps</h1>
		
		<!-- Formulaire de jeu de données et de solveur -->
		<div class="formulaires">

			<form method="POST"  id="parametrage" action="" enctype="multipart/form-data">

				<fieldset form="parametrage">

				<!-- Choix d'instance -->
				<div class="instances">
		            <label class="label" for="instance">Instance</label><br>
		    		<select class="bouton" name="instance" , type="submit">
						<option disabled selected value> -- Sélectionner -- </option>
						<?php foreach ($dir as $key => $instance) { //retourne une liste
							?>
							<option value="1"><?php print_r(basename($instance)); ?></option> <!-- Nom du fichier sans le chemin "xml/"" -->
						<?php
						}
						?>
					</select>
				</div>

				<!-- Filtrage
				<div class="filtres">
					<label class="label">Filtrer</label>
					<input type="button" value="Filtrer" class="bouton" onclick="show('div');"/>
					<div  style="display:none" id="div">

						Filtrer par composante
						<input type="button" value="Composante" class="bouton" onclick="showComposantes('div2');"/>
						<div style="display:none" id="div2">
							<form method="post" class="instance">
							<select class="bouton" name="choix" , type="submit">
								<option disabled selected value> -- Sélectionner -- </option>
								<option value="1">Informatique</option>
								<option value="2">Mathématiques</option>
								<option value="3">Biologie</option>
							</select>
				        	</form>
						</div>

						Filtrer par filière
						<input type="button" value="Filière" class="bouton"onclick="showFilieres('div3');"/>
						<div style="display:none" id="div3">

							<form method="post" class="instance">
							<select class="bouton" name="choix" , type="submit">
								<option disabled selected value> -- Sélectionner -- </option>
								<option value="L1L2">Portail L1/L2</option>
								<option value="LP">Licence Pro</option>
								<option value="L">Licence</option>
								<option value="M">Master</option>
								<option value="CMI">Master Ingénierie</option>
							</select>
				            <input class="bouton" type="submit" name="select" id="select" value="Go">
				        	</form>
						</div>
						
						Filtrer par année
						<input type="button" value="Année" class="bouton"onclick="showAnnees('div4');"/>
						<div style="display:none" id="div4">
							<p class="co">Veuillez choisir l'année d'études:</p>
							<form method="post" class="instance">
							<select class="bouton" name="choix" , type="submit">
								<option disabled selected value> -- Sélectionner -- </option>
								<option value="1">1e année</option>
								<option value="2">2e année</option>
								<option value="3">3e année</option>
							</select>
				            <input class="bouton" type="submit" name="select" id="select" value="Go">
				        	</form>
						</div>
					</div>

					<input type="button" value="Supprimer les filtres" class="bouton" onclick="suppr();"/>
				</div>
				-->

				<hr noshade width="90%" size="3" align="center">

				<!-- Formulaire paramétrage solveur -->
				<!-- Choix du solveur et du format-->

				<div class="boite">
					<label class="label">Solveur |</label><br>
					<div class="boite2">
						<label class="info"for="solver">Minizinc</label>
						<input type="radio" name="solver" class="radio" value="MZN" onchange="showMZN('div6'); effacerCHR()" content-type="choices" trigger="true" target="format">
						<div class="boite2" id="div6" style="display:none">
							<div>
								<label class="label" for="format">DZN</label><br>
					    		<input type="radio" name="format" class="radio" value="DZN">
							</div>
						    <div>
						    	<label class="label" for="format">JSON</label><br>
								<input type="radio" name="format" class="radio" value="JSON">
							</div>
						</div>
						<label class="info"for="solver">Constraint Handling Rules</label>
						<input type="radio" name="solver" class="radio" value="CHR" onchange="showCHR('div7'); effacerMZN()" content-type="choices" trigger="true" target="format">
						<div class="boite2 display-none" id="div7" style="display:none">
							<label class="label" for="format">JSON</label><br>
							<input type="radio" name="format" class="radio" value="JSON">
						</div>
					</div>
						
				</div>

				<!-- Choix de la representation -->

				<div class="boite">
					<label class="label">Type |</label>
					<div class="boite2">
						<div>
							<label class="info" for="representation">Intension</label><br>
					    	<input type="radio" name="representation" class="radio" value="INT">
					    </div>
					    <div>
					    	<label class="info" for="representation">Extension</label><br>
					    	<input type="radio" name="representation" class="radio" value="EXT" checked>
						</div>
					</div>	
				</div>

				<!-- Choix du modèle
				
				<div class="boite">
					<label class="label" for="modele">Modèle |</label><br>
			    	<select class="bouton" name="modele" id="modele" type="submit" required>
						<option disabled selected value> -- Sélectionner -- </option>
						<option value="SQC">Sequenced</option>
						<option value="WEE">Weekly</option>
					</select>
				</div>

				Choix des heuristiques 
				
				<div class="boite">
					<label class="label">Heuristiques |</label>
					<div class="boite2">
						<div class="bouton2">
							<label class="info" for="heuristiques">De variable</label><br>
					    	<input type="radio" name="heuristiques" class="radio" value="VAR" checked>
					    </div>
					    <div class="bouton2">
					    	<label class="info" for="heuristiques">De valeur</label><br>
					    	<input type="radio" name="heuristiques" class="radio" value="VAL" checked>
						</div>
					</div>	
				</div> -->

				<!-- Temps de calcul -->

				<div class="boite">
					<label class="label">Temps de calcul |</label>
					<div class="boite2">
						<div>
							<label class="info" for="temps_calcul">hh:mm</label><br>
					    	<input class="bouton" type="time" name="temps_calcul" min="00:01" max="24:00" required>
					    </div>
					</div>	
				</div>

				<!-- Bouton GO -->
			
				<div class="valider">
					<input class="bouton" type="submit" name="select" id="select" value="Go">
				</div>
				</fieldset>
			</form>
		</div>
	</section>
</body>

<?php 
	
	include ('database.php');
	global $db;

	if(isset($_POST['formulaire_insertion'])){ 

		extract($_POST);

		if(!empty($fichier) && !empty($auteur) && !empty($composantes) && !empty($formation) && !empty($filiere) && !empty($annee) && !empty($periode)) {
		
			$q = $db->prepare("INSERT INTO probleme(fichier, auteur, composantes, formation, filiere, annee, periode) VALUES (:fichier, :auteur, :composantes, :formation, :filiere, :annee, :periode)");
			$q->execute(['fichier' => $fichier, 'auteur' => $auteur, 'composantes' => $composantes, 'formation' => $formation, 'filiere' => $filiere, 'annee' => $annee, 'periode' => $periode]);
			//echo "Ajout réussi!";
		}

	}

	/*
	if (isset($_FILES['fichier'])) {

        // Enregistrement et renommage du fichier
        $result = move_uploaded_file($_FILES["fichier"]["name"]);
        if ($result == TRUE) {
            echo "<b>Vous avez bien transféré le fichier</b><hr />";
            echo "Le nom du fichier est : ", $_FILES["fichier"], "<hr/>";
            echo "Votre fichier a une taille de ", $_FILES["fichier"]["size"], "<hr />";
        } else {
            echo "<hr /> Erreur de transfert n°", $_FILES["fichier"]["error"];
        }
    }	
    */

	//focus sur le dossier contenant les fichiers xml
	$dir = glob('../instance_xml/*.xml');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Insertion jeux de données</title>
		<link rel="stylesheet" href="../css/insertion.css">
		<script src="../js/Animations.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&display=swap" rel="stylesheet"> 
</head>

<body>

	<!-- Bande de menu -->

	<section class="haut">
		<div class="top-page">
			<header>
				<img src="../images/edt.jpg" alt="Logo du site">
				<nav class="menu">
					<ul class="menuList">
						<li><a href="../edt.php" style="text-decoration: none;">Emploi du temps</a></li>
						<li><a href="insertion.php" style="text-decoration: none;" style="color: white;">Formulaire d'insertion</a></li>
						<li><a href="visualisation.php" style="text-decoration: none;" style="color: white;">Visualisation de la base de données</a></li>
					</ul>
				</nav>
			</header>
		</div>
	</section>
		
	<!-- Reste de la page -->

	<section class="page">
		<h1> Insérer des données </h1>

		<!-- Formulaire d'insertion -->

		<div class="formulaires">

		<form method="POST" id="insertion" action=""> 

			<div class="formulaire">

				<fieldset form="insertion">

				<!-- Fichier XML à téléverser -->
				<div class="boite">
					<label class="label" for="fichier">Fichier problème xml</label><br><br>
					<div class="boite2">
						<div>
							<label class="label2" for="fichier">Ajouter depuis votre appareil</label><br>
							<input	class="bouton" id="fichier" name="fichier" type="file" accept="text/xml">
						</div>
						<div>
							<img src="../images/barre_verticale2.jpg">
						</div>
						<div>
							<label class="label2" for="fichier">Chercher dans le dossier <i>"instance_xml"</i></label><br>
				    		<select class="bouton" name="fichier" id="fichier" type="submit">
								<option disabled selected value> -- Sélectionner -- </option>
								<?php foreach ($dir as $key => $fichier) { //retourne une liste
									?>
									<option value="<?php print_r(basename($fichier)); ?>"><?php print_r(basename($fichier)); ?></option> <!-- Nom du fichier sans le chemin "xml/"" -->
								<?php
								}
								?>
							</select>
						</div>      
			    	</div>
				</div>
				

				<!-- Nom de l'auteur -->

				<div class="boite boite2">
					<div>
						<label class="label" for="auteur">Auteur |</label><br>
					</div>
					<div>
						<select class="bouton" name="auteur" id="auteur" type="submit" required>
						<option disabled selected value> -- Sélectionner -- </option>
						<option value="M. LESAINT">M. LESAINT</option>
						<option value="M. JAMIN">M. JAMIN</option>
						<option value="M. RICHER">M. RICHER</option>
						</select>
					</div>
					
				</div>

				<!-- Nom de la composante -->

				<div class="boite boite2">
					<div>
						<label for="composantes" class="label">Composantes |</label> 
					</div>
					<div>
						<select id="composantes" name="composantes" class="bouton" content-type="choices" trigger="true" target="filiere" required> 
		                <option disabled selected value> -- Sélectionner -- </option>
		                <option value="UFR-Droit-Eco-Gestion" disabled>UFR-Droit-Eco-Gestion</option>
						<option value="UFR-Lettres-Langues-Sciences Humaines" disabled>UFR-Lettres-Langues-Sciences Humaines</option>
						<option value="UFR Esthua, Tourisme et Culture" disabled>UFR Esthua, Tourisme et Culture</option>
						<option value="UFR-Sciences">UFR-Sciences</option>
						<option value="IUT">IUT</option>
						<option value="Polytech" disabled>Polytech</option>
						<option value="IAE" disabled>IAE</option> 
		            	</select> 
					</div>
	        	</div>

	        	<!-- Nom de la filière -->

				<div class="boite boite2">
					<div>
						<label class="label" for="filiere">Filière |</label><br>
					</div>
					<div>
						<select class="bouton" name="filiere" id="filiere" type="submit" content-type="choices" trigger="true" target="formation" required>
			    		<optgroup reference="UFR-Droit-Eco-Gestion" label="UFR-Droit-Eco-Gestion">
			    			<option disabled selected value> -- Sélectionner -- </option>
			    			<option value="Portail L1/L2 - DEG">Portail L1/L2</option>
			    			<option value="Licence Pro - DEG">Licence Pro</option>
							<option value="Licence - DEG">Licence</option>
							<option value="Master - DEG">Master</option>
			    		</optgroup>
			    		<optgroup reference="UFR-Lettres-Langues-Sciences Humaines" label="UFR-Lettres-Langues-Sciences Humaines">
			    			<option disabled selected value> -- Sélectionner -- </option>
			    			<option value="Portail L1/L2 - LLSH">Portail L1/L2</option>
			    			<option value="Licence Pro - LLSH">Licence Pro</option>
							<option value="Licence - LLSH">Licence</option>
							<option value="Master - LLSH">Master</option>	
			    		</optgroup>
			    		<optgroup reference="UFR Esthua, Tourisme et Culture" label="UFR Esthua, Tourisme et Culture">
			    			<option disabled selected value> -- Sélectionner -- </option>
			    			<option value="DEUST - ETC">DEUST</option>
			    			<option value="Licence Pro - ETC">Licence Pro</option>
							<option value="Licence - ETC">Licence</option>
							<option value="Master - ETC">Master</option>
							<option value="DIU - ETC">DIU</option>
			    		</optgroup>
			    		<optgroup reference="UFR-Sciences" label="UFR-Sciences">
			    			<option disabled selected value> -- Sélectionner -- </option> 
			    			<option value="Portail L1/L2 - Sciences">Portail L1/L2</option>
			    			<option value="Licence Pro - Sciences">Licence Pro</option>
							<option value="Licence - Sciences">Licence</option>
							<option value="Master - Sciences">Master</option>
							<option value="Master Ingénierie - Sciences">Master ingénierie</option>
			    		</optgroup>
			    		<optgroup reference="IUT" label="IUT">
			    			<option disabled selected value> -- Sélectionner -- </option>
			    			<option value="BUT" disabled>BUT</option>
							<option value="DUETI"disabled>DUETI</option>
							<option value="DCG" disabled>DCG</option>
							<option value="DSCG" disabled>DSCG</option>
			    		</optgroup>
			    		<optgroup reference="Polytech" label="Polytech">
			    			<option disabled selected value> -- Sélectionner -- </option>
			    			<option value="Cycle Préparatoire">Cycle Préparatoire</option>
							<option value="Cycle Ingénieur">Cycle Ingénieur</option>
							<option value="Master Polytech">Master</option>
			    		</optgroup>
			    		<optgroup reference="IAE" label="IAE" >
			    			<option disabled selected value> -- Sélectionner -- </option>
			    			<option value="Licence IAE">Licence</option>
							<option value="Master IAE">Master</option>
			    		</optgroup>
						</select>
					</div>
				</div>

				<!-- Nom de la filière (on se contente de l'UFR Sciences) -->

				<div class="boite boite2"> 
					<div>
						<label class="label" for="formation">Formation |</label>
					</div>
		            <div>
		            	<select id="formation" name="formation" id="formation" class="bouton" required> 
		            	<optgroup reference="Portail L1/L2 - Sciences" label="Portail L1/L2">
		                	<option disabled selected value> -- Sélectionner -- </option> 
		                    <option value="Licence 1 Sciences, technologies, santé / Portail MPCIE" >Licence 1 Sciences, technologies, santé / Portail MPCIE</option> 
		                    <option value="Licence 1 Sciences, technologies, santé / Portail MPCIE - CMI CE" >Licence 1 Sciences, technologies, santé / Portail MPCIE - CMI CE/option>
		                    <option value="Licence 1 Sciences, technologies, santé / Portail MPCIE - CMI PSI" >Licence 1 Sciences, technologies, santé / Portail MPCIE - CMI PSI</option> 
		                    <option value="Licence 1 Sciences, technologies, santé / Portail MPCIE - Mise à niveau" >Licence 1 Sciences, technologies, santé / Portail MPCIE - Mise à niveau</option>
		                    <option value="Licence 2 Sciences, technologie, santé / Portail MPCIE Parcours santé" >Licence 2 Sciences, technologie, santé / Portail MPCIE Parcours santé</option> 
		                    <option value="Licence 2 Sciences, technologies, santé / Portail MPCIE" >Licence 2 Sciences, technologies, santé / Portail MPCIE</option> 
		                    <option value="Licence 2 Sciences, technologies, santé / Portail MPCIE - CMI CE" >Licence 2 Sciences, technologies, santé / Portail MPCIE - CMI CE</option> 
		                    <option value="Licence 2 CMI-CE (MPCIE + SVT)" >Licence 2 CMI-CE (MPCIE + SVT)</option>
		                    <option value="Licence 2 Sciences, technologies, santé / Portail MPCIE - CMI PSI  " >Licence 2 Sciences, technologies, santé / Portail MPCIE - CMI PSI  </option>
		                    <option value="Licence 2 Sciences, technologies, santé / S4 MPI Pluripass" >Licence 2 Sciences, technologies, santé / S4 MPI Pluripass</option>
		                </optgroup>
		                <optgroup reference="Licence Pro - Sciences" label="Licence Pro">
		                	<option disabled selected value> -- Sélectionner -- </option> 
		                    <option value="Productions végétales / Gestion de la santé des plantes" >Productions végétales / Gestion de la santé des plantes</option> 
		                    <option value="Métiers de l'informatique: systèmes d'information et gestion de données / Logiciels libres" >Métiers de l'informatique: systèmes d'information et gestion de données / Logiciels libres</option> 
		                    <option value="Métiers du commerce international / Marketing et commerce international des vins de terroir ESA" >Métiers du commerce international / Marketing et commerce international des vins de terroir ESA</option>
		                    <option value="Maîtrise de l'énergie, électricité, développement durable / Energie électrique" >Maîtrise de l'énergie, électricité, développement durable / Energie électrique</option> 
		                    <option value="Maîtrise énergie, électricité, développement durable / Génie thermique" >Maîtrise énergie, électricité, développement durable / Génie thermique</option>
		                    <option value="Gestion des organisations agricoles & agroalimentaires / Management des entreprises d'horticulture et du paysage" >Gestion des organisations agricoles & agroalimentaires / Management des entreprises d'horticulture et du paysage</option>
		                    <option value="Agronomie / Techniques et technologies en végétal ESA" >Agronomie / Techniques et technologies en végétal ESA</option>
		                    <option value="Commercialisation de produits alimentaires/ Valorisation innovation transformation de produits alimentaires ESA" >Commercialisation de produits alimentaires/ Valorisation innovation transformation de produits alimentaires ESA</option>
		                </optgroup>
		                <optgroup reference="Licence - Sciences" label="Licence">
		                	<option disabled selected value> -- Sélectionner -- </option>
		                	<option disabled style="font-weight: bold; color: white; background-color: black;" label="Licence 1"> 
		                    <option value="Licence 1 Double Licence Math-Économie" >Licence 1 Double Licence Math-Économie</option> 
		                    <option value="Licence 1 Sciences de la vie et de la terre - Accès santé" >Licence 1 Sciences de la vie et de la terre - Accès santé</option>
		                    <option value="Licence 1 Sciences de la vie et de la terre" >Licence 1 Sciences de la vie et de la terre</option> 
		                    <option value="Licence 1 Sciences de la vie et de la terre - CMI -BSV" >Licence 1 Sciences de la vie et de la terre - CMI -BSV</option> 
		                    <option value="Licence 1 Sciences de la vie et de la terre - CMI - CE" >Licence 1 Sciences de la vie et de la terre - CMI - CE</option> 
		                    <option value="Licence 1 Sciences de la vie et de la terre - CPGE" >Licence 1 Sciences de la vie et de la terre - CPGE</option>
		                    <option disabled style="font-weight: bold; color: white; background-color: black;" label="Licence 2"> 
		                    <option value="Licence 2 Double Licence Math-Économie" >Licence 2 Double Licence Math-Économie</option> 
		                    <option value="Licence 2 Sciences, technologies, santé / Mathématiques à distance" >Licence 2 Sciences, technologies, santé / Mathématiques à distance</option> 
		                    <option value="Licence 2 Sciences de la vie et de la terre - Parcours santé" >Licence 2 Sciences de la vie et de la terre - Parcours santé</option> 
		                    <option value="Licence 2 Sciences de la vie et de la terre" >Licence 2 Sciences de la vie et de la terre</option> 
		                    <option value="Licence 2 Sciences de la vie et de la terre - CMI -BSV" >Licence 2 Sciences de la vie et de la terre - CMI -BSV</option> 
		                    <option value="Licence 2 Sciences de la vie et de la terre - CMI - CE" >Licence 2 Sciences de la vie et de la terre - CMI - CE</option>
		                    <option disabled style="font-weight: bold; color: white; background-color: black;" label="Licence 3">
		                    <option value="Licence 3 Biologie cellulaire moléculaire et physiologie" >Licence 3 Biologie cellulaire moléculaire et physiologie</option> 
		                    <option value="Licence 3 SVT / Biologie cellulaire moléculaire et physiologie - Parcours santé" >Licence 3 SVT / Biologie cellulaire moléculaire et physiologie - Parcours santé</option> 
		                    <option value="Licence 3 SVT / Biologie des organismes et des populations - Parcours santé" >Licence 3 SVT / Biologie des organismes et des populations - Parcours santé</option>
		                    <option value="Licence 3 Physique Chimie / Chimie-environnement - Parcours santé" >Licence 3 Physique Chimie / Chimie-environnement - Parcours santé</option>
		                    <option value="Licence 3 Physique Chimie / Chimie - Environnement" >Licence 3 Physique Chimie / Chimie - Environnement</option>
		                    <option value="Licence 3 Physique Chimie / Chimie - Environnement - CMI" >Licence 3 Physique Chimie / Chimie - Environnement - CMI</option>
		                    <option value="Licence 3 Physique Chimie/Chimie-médicaments - Parcours santé" >Licence 3 Physique Chimie/Chimie-médicaments - Parcours santé</option>
		                    <option value="Licence 3 Chimie - médicaments" >Licence 3 Chimie - médicaments</option>
		                    <option value="Licence 3 Diffusion du savoir et de la culture scientifique" >Licence 3 Diffusion du savoir et de la culture scientifique</option>
		                    <option value="Licence 3 SVT / Géosciences et environnement" >Licence 3 SVT / Géosciences et environnement</option>
		                    <option value="Licence 3 SVT / Géosciences et environnement - Parcours santé" >Licence 3 SVT / Géosciences et environnement - Parcours santé</option>
		                    <option value="Licence 3 Informatique" >Licence 3 Informatique</option>
		                    <option value="Licence 3 Informatique - Parcours santé" >Licence 3 Informatique - Parcours santé</option>
		                    <option value="Licence 3 Mathématiques appliquées" >Licence 3 Mathématiques appliquées</option>
		                    <option value="Licence 3 Maths / Mathématiques appliquées Parcours santé" >Licence 3 Math / Mathématiques appliquées Parcours santé</option>
		                    <option value="Licence 3 Mathématiques" >Licence 3 Mathématiques</option>
		                    <option value="Licence 3 Double Licence Math-Économie" >Licence 3 Double Licence Math-Économie</option>
		                    <option value="Licence 3 Mathématiques - Parcours santé" >Licence 3 Mathématiques - Parcours santé</option>
		                    <option value="Licence 3 Phys Chimie / Physique applications - Parcours santé" >Licence 3 Phys Chimie / Physique applications - Parcours santé</option>
		                    <option value="Licence 3 Physique applications" >Licence 3 Physique applications</option>
		                    <option value="Licence 3 Physique applications - CMI - PSI" >Licence 3 Physique applications - CMI - PSI</option>
		                    <option value="Licence 3 Physique - Chimie Parcours santé" >Licence 3 Physique-Chimie - Parcours santé</option>
		                    <option value="Licence 3 Physique - Chimie" >Licence 3 Physique-Chimie</option>
		                    <option value="Licence 3 SVT/Sciences des productions végétales Parcours santé" >Licence 3 SVT/Sciences des productions végétales Parcours santé</option>
		                    <option value="Licence 3 SVT / Sciences des productions végétales" >Licence 3 SVT / Sciences des productions végétales</option>
		                    <option value="Licence 3 SVT / Sciences des productions végétales - CMI - BSV" >Licence 3 SVT / Sciences des productions végétales - CMI - BSV</option>
		                </optgroup> 
		                <optgroup reference="Master - Sciences" label="Masters">
		                	<option disabled style="font-weight: bold; color: white; background-color: black;" label="Masters 1">
		                	<option disabled selected value> -- Sélectionner -- </option> 
		                	<option value="Informatique / Analyse, Conception et Développement Informatique" >Informatique / Analyse, Conception et Développement Informatique</option>
		                    <option value="Biologie végétale / Biologie systémique du végétal BSV - CMI" >Biologie végétale / Biologie systémique du végétal BSV - CMI</option>
		                    <option value="Biologie Santé / Interactions Cellulaires Applications Thérapeutiques" >Biologie Santé / Interactions Cellulaires Applications Thérapeutiques</option>
		                    <option value="Chimie / Chimie-environnement" >Chimie / Chimie-environnement</option>
		                    <option value="Mathématiques et Applications / Data science et Données Biologiques et Numériques" >Mathématiques et Applications / Data science et Données Biologiques et Numériques</option>
		                    <option value="Biodiversité, écologie et évolution / Ecologie et éco-ingénierie des zones humides" >Biodiversité, écologie et évolution / Ecologie et éco-ingénierie des zones humides</option>
		                    <option value="Biologie Végétale / Filières de l'horticulture et innovations" >Biologie Végétale / Filières de l'horticulture et innovations</option>
		                    <option value="Biologie végétale / Gestion de la Santé des plantes" >Biologie végétale / Gestion de la Santé des plantes</option>
		                    <option value="Informatique / Intelligence décisionnelle" >Informatique / Intelligence décisionnelle</option>
		                    <option value="Chimie /  Lumière Molécule Matière" >Chimie /  Lumière Molécule Matière</option> 
		                    <option value="Mathématiques et Applications / Mathématiques fondamentales appliquées / Algèbre et géométrie" >Mathématiques et Applications / Mathématiques fondamentales appliquées / Algèbre et géométrie</option>
		                    <option value="Mathématiques et Applications / Mathématiques fondamentales et appliquées / Analyse et probabilités" >Mathématiques et Applications / Mathématiques fondamentales et appliquées / Analyse et probabilités</option> 
		                    <option value="Métiers de l'Enseignement, de l'Education et de la Formation 2nd degré / Mathématiques" >Métiers de l'Enseignement, de l'Education et de la Formation 2nd degré / Mathématiques</option>
		                    <option value="Biologie Santé / Neurobiologie Cellulaire et Moléculaire" >Biologie Santé / Neurobiologie Cellulaire et Moléculaire</option> 
		                    <option value="Bio-géoscience / Paléontologie, paléo-environnement & patrimoine" >Bio-géoscience / Paléontologie, paléo-environnement & patrimoine</option>
		                    <option value="Mathématiques et Applications / Préparation supérieure à l'Enseignement" >Mathématiques et Applications / Préparation supérieure à l'Enseignement</option>
		                    <option value="Physique Appliquée et Ingénierie Physique /  Photonique signal imagerie" >Physique Appliquée et Ingénierie Physique /  Photonique signal imagerie</option>
		                    <option value="Physique Appliquée et Ingénierie Physique /  Photonique signal imagerie" >Physique Appliquée et Ingénierie Physique /  Photonique signal imagerie</option>       
		                    <option value="Physique Appliquée et Ingénierie Physique /  Photonique signal imagerie" >Physique Appliquée et Ingénierie Physique /  Photonique signal imagerie</option>
		                    <option value="Biologie Végétale / Qualité des production spécialisées" >Biologie Végétale / Qualité des production spécialisées</option> 
		                    <option value="Chimie / Sciences et ingénierie de l'environnement" >Chimie / Sciences et ingénierie de l'environnement</option> 
		                    <option value="Biologie Végétale / Semences et plants" >Biologie Végétale / Semences et plants</option>
		                    <option value="Toxicologie et écotoxicologie / Toxicologie environnementale et humaine" >Toxicologie et écotoxicologie / Toxicologie environnementale et humaine</option> 
		                	<option disabled style="font-weight: bold; color: white; background-color: black;" label="Masters 2"> 
		                	<option value="Informatique / Analyse, Conception et Développement Informatique" >Informatique / Analyse, Conception et Développement Informatique</option>
		                    <option value="Biologie végétale / Biologie systémique du végétal BSV - CMI" >Biologie végétale / Biologie systémique du végétal BSV - CMI</option>
		                    <option value="Biologie Santé / Interactions Cellulaires Applications Thérapeutiques" >Biologie Santé / Interactions Cellulaires Applications Thérapeutiques</option>
		                    <option value="Chimie / Chimie-environnement" >Chimie / Chimie-environnement</option>
		                    <option value="Mathématiques et Applications / Data science et Données Biologiques et Numériques" >Mathématiques et Applications / Data science et Données Biologiques et Numériques</option>
		                    <option value="Biodiversité, écologie et évolution / Ecologie et éco-ingénierie des zones humides" >Biodiversité, écologie et évolution / Ecologie et éco-ingénierie des zones humides</option>
		                    <option value="Biologie Végétale / Filières de l'horticulture et innovations" >Biologie Végétale / Filières de l'horticulture et innovations</option>
		                    <option value="Biologie végétale / Gestion de la Santé des plantes" >Biologie végétale / Gestion de la Santé des plantes</option>
		                    <option value="Informatique / Intelligence décisionnelle" >Informatique / Intelligence décisionnelle</option>
		                    <option value="Chimie /  Lumière Molécule Matière" >Chimie /  Lumière Molécule Matière</option> 
		                    <option value="Mathématiques et Applications / Mathématiques fondamentales appliquées / Algèbre et géométrie" >Mathématiques et Applications / Mathématiques fondamentales appliquées / Algèbre et géométrie</option>
		                    <option value="Mathématiques et Applications / Mathématiques fondamentales et appliquées / Analyse et probabilités" >Mathématiques et Applications / Mathématiques fondamentales et appliquées / Analyse et probabilités</option> 
		                    <option value="Métiers de l'Enseignement, de l'Education et de la Formation 2nd degré / Mathématiques" >Métiers de l'Enseignement, de l'Education et de la Formation 2nd degré / Mathématiques</option>
		                    <option value="Biologie Santé / Neurobiologie Cellulaire et Moléculaire" >Biologie Santé / Neurobiologie Cellulaire et Moléculaire</option> 
		                    <option value="Bio-géoscience / Paléontologie, paléo-environnement & patrimoine" >Bio-géoscience / Paléontologie, paléo-environnement & patrimoine</option>
		                    <option value="Mathématiques et Applications / Préparation supérieure à l'Enseignement" >Mathématiques et Applications / Préparation supérieure à l'Enseignement</option>
		                    <option value="Physique Appliquée et Ingénierie Physique /  Photonique signal imagerie" >Physique Appliquée et Ingénierie Physique /  Photonique signal imagerie</option>
		                    <option value=">Physique Appliquée et Ingénierie Physique /  Photonique signal imagerie" >Physique Appliquée et Ingénierie Physique /  Photonique signal imagerie</option>       
		                    <option value="Physique Appliquée et Ingénierie Physique /  Photonique signal imagerie" >Physique Appliquée et Ingénierie Physique /  Photonique signal imagerie</option>
		                    <option value="Biologie Végétale / Qualité des production spécialisées" >Biologie Végétale / Qualité des production spécialisées</option> 
		                    <option value="Chimie / Sciences et ingénierie de l'environnement" >Chimie / Sciences et ingénierie de l'environnement</option> 
		                    <option value="Biologie Végétale / Semences et plants" >Biologie Végétale / Semences et plants</option>
		                    <option value="Toxicologie et écotoxicologie / Toxicologie environnementale et humaine" >Toxicologie et écotoxicologie / Toxicologie environnementale et humaine</option>              
		                </optgroup> 
		                <optgroup reference="Master Ingénierie - Sciences" label="Master ingénierie">
		                	<option disabled selected value> -- Sélectionner -- </option> 
		                    <option value="Biologie Systémique du Végétal" >Biologie Systémique du Végétal</option> 
		                    <option value="Chimie Environnement" >Chimie Environnement</option> 
		                    <option value="Photonique signal imagerie" >Photonique signal imagerie</option> 
		                </optgroup>
		           		</select>
		            </div>
		            
		        </div>

		        <script type="text/javascript">
				
					//Formulaires en cascade
					function choix(object){ //jQuery
					    // Object représente composantes (la sélection va déterminer la suite)
					    // La sélection d'une composante permet de récupérer les filières correspondantes
					    var target = $("#"+object.attr('target')); 
					  
					    // On récupère tous les optgroup du select cible spécifié avec target 
					    var listGroups = target.find("optgroup"); 
					  
					    // On récupère le optgroup qui correspond à la valeur de la composante sélectionnée 
					    var validGroup = target.find("optgroup[reference='"+object.find(':selected').val()+"']"); 
					  
					    //On modifie la valeur courante du select cible (filieres) 
					    target.val(validGroup.find("option").val()); 
					  
					    //On cache tous les optgroup de filieres
					    listGroups.hide(); 
					  
					    //On affiche uniquement le optgroup de département qui correspond à la valeur courante de pays 
					    validGroup.show(); 
					  
					    //On vérifie si la cible filieres doit déclencher une mise à jour d'une autre liste 
					    // Département peut par exemple déclencher la mise à jour des villes, et les villes déclenches celle des quartiers... 
					    if(target.attr('content-type')=='choices') 
					        target.change(); 
					} 
					  
					//On associe la fonction choixFiliere à l'événement onChange des listes qui doivent déclencher des mises à jour d'autres listes 
					$("select[content-type='choices']").on('change',function(){ 
					    choix($(this)); 
					}); 
					  
					$(document).ready(function(){ 
					    choix($("select[trigger='true']")); 
					});
				</script>

				<!-- Année universitaire -->

				<div class="boite">
					<label class="label" for="annee">Année universitaire</label><br>
					<p class="info">Veuillez sélectionner la date de début de l'année universitaire (ex: 2020/2021 => 2020)</p>
			    	<input class="bouton" type="number" name="annee" id="annee" min="2015" max="2021" value="2020" step="1" required>
				</div>

				<!-- Semestre -->

				<div class="boite boite2">
					<div>
						<label class="label" for="periode">Période |</label><br>
					</div>
					<div>
						<select class="bouton" name="periode" id="periode" type="submit" required>
						<option disabled selected value> -- Sélectionner -- </option>
						<optgroup label="Semestre">
							<option value="Semestre 1">Semestre 1</option>
							<option value="Semestre 2">Semestre 2</option>
						</optgroup>
						<optgroup label="Période">
							<option disabled style="font-weight: bold; color: white; background-color: black;" label="Périodes du semestre 1">
							<option value="Période 1">Période 1</option>
							<option value="Période 2">Période 2</option>
							<option value="Période 3">Période 3</option>
							<option value="Période 4">Période 4</option>
							<option value="Période 5">Période 5</option>
							<option value="Période 6">Période 6</option>
							<option disabled style="font-weight: bold; color: white; background-color: black;" label="Périodes du semestre 2">
							<option value="Période 7">Période 7</option>
							<option value="Période 8">Période 8</option>
							<option value="Période 9">Période 9</option>
							<option value="Période 10">Période 10</option>
							<option value="Période 11">Période 11</option>
							<option value="Période 12">Période 12</option>
						</optgroup>
						</select>
					</div>		
				</div>

				<!-- Bouton validation -->

				<input  class="bouton2" type="submit" name="formulaire_insertion" value="Valider">
				</fieldset>
			</div>
		</form>
		</div>
	</section>
</body>
</html>
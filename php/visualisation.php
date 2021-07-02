<?php 
	
	include ('database.php');
	global $db;
	$value = 0;

	//focus sur le dossier contenant les fichiers xml
	$dir = glob('../instance_xml/*.xml');

	//---------------------------- TABLEAU 1 -----------------------------------------------------------------------------------------------------------------
	//------------------------------- FILTRES -----------------------------------------------------------------------------------------------------

	// Composantes

	if(isset($_GET['filtre_composante'])) { //filtre composantes classées par date de publication décroissante
		$filtre_composante = htmlspecialchars($_GET['filtre_composante']);

		switch($filtre_composante){

			case 'DEG': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE composantes = "UFR-Droit-Eco-Gestion" ORDER BY date_t DESC');
		        $data_instances = $reponse->fetchAll();
		        break;
		    }
			case 'LLSH': {
				$reponse = $db->query('SELECT * FROM probleme WHERE composantes = "UFR-Lettres-Langues-Sciences Humaines" ORDER BY date_t DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'ETC': {
	            $reponse = $db->query('SELECT * FROM probleme WHERE composantes = "UFR Esthua, Tourisme et Culture" ORDER BY date_t DESC');
	            $data_instances = $reponse->fetchAll();
	            break;
	        }
			case 'SC': {
	            $reponse = $db->query('SELECT * FROM probleme WHERE composantes = "UFR-Sciences" ORDER BY date_t DESC');
	            $data_instances = $reponse->fetchAll();
	            break;
	        }
			case 'IUT': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE composantes = "IUT" ORDER BY date_t DESC');
		        $data_instances = $reponse->fetchAll();
		        break;
		    }
			case 'POLY': {
				$reponse = $db->query('SELECT * FROM probleme WHERE composantes = "Polytech" ORDER BY date_t DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'IAE': {
	            $reponse = $db->query('SELECT * FROM probleme WHERE composantes = "IAE" ORDER BY date_t DESC');
	            $data_instances = $reponse->fetchAll();
	            break;
	        }
	    } 

	// Filières

	} else if(isset($_GET['filtre_filiere'])) {	//filtre filières classées par date de publication décroissante
		$filtre_filiere = htmlspecialchars($_GET['filtre_filiere']);

		switch($filtre_filiere){

			case 'L1L2': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE filiere = "Portail L1/L2 - Sciences" ORDER BY date_t DESC');
		        $data_instances = $reponse->fetchAll();
		        break;
		    }
			case 'LP': {
				$reponse = $db->query('SELECT * FROM probleme WHERE filiere = "Licence Pro - Sciences" ORDER BY date_t DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'L': {
	            $reponse = $db->query('SELECT * FROM probleme WHERE filiere = "Licence - Sciences" ORDER BY date_t DESC');
	            $data_instances = $reponse->fetchAll();
	            break;
	        }
			case 'M': {
	            $reponse = $db->query('SELECT * FROM probleme WHERE filiere = "Master - Sciences" ORDER BY date_t DESC');
	            $data_instances = $reponse->fetchAll();
	            break;
	        }
			case 'CMI': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE filiere = "Master Ingénierie - Sciences" ORDER BY date_t DESC');
		        $data_instances = $reponse->fetchAll();
		        break;
		    }
	    } 

	// Année

	} else if (isset($_GET['filtre_annee'])) { //années classées par filière (ordre alphabétique)
		$filtre_annee = htmlspecialchars($_GET['filtre_annee']);

		switch($filtre_annee){

			case '2021': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE annee = "2021" ORDER BY filiere ASC');
		        $data_instances = $reponse->fetchAll();
		        break;
		    }
			case '2020': {
				$reponse = $db->query('SELECT * FROM probleme WHERE annee = "2020" ORDER BY filiere ASC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case '2019': {
	            $reponse = $db->query('SELECT * FROM probleme WHERE annee = "2019" ORDER BY filiere ASC');
	            $data_instances = $reponse->fetchAll();
	            break;
	        }
			case '2018': {
	            $reponse = $db->query('SELECT * FROM probleme WHERE annee = "2018" ORDER BY filiere ASC');
	            $data_instances = $reponse->fetchAll();
	            break;
	        }
			case '2017': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE annee = "2017" ORDER BY filiere ASC');
		        $data_instances = $reponse->fetchAll();
		        break;
		    }
		    case '2016': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE annee = "2016" ORDER BY filiere ASC');
		        $data_instances = $reponse->fetchAll();
		        break;
		    }
		    case '2015': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE annee = "2015" ORDER BY filiere ASC');
		        $data_instances = $reponse->fetchAll();
		        break;
		    }
	    } 

	// Periode

	} else if (isset($_GET['filtre_periode'])) { //periode classées par annee décroissante
		$filtre_periode = htmlspecialchars($_GET['filtre_periode']);

		switch($filtre_periode){

			case 'S1': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE periode = "Semestre 1" ORDER BY annee DESC');
		        $data_instances = $reponse->fetchAll();
		        break;
		    }
			case 'S2': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "Semestre 2" ORDER BY annee DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'P1': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P1" ORDER BY annee DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'P2': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P2" ORDER BY annee DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'P3': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P3" ORDER BY annee DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'P4': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P4" ORDER BY annee DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'P5': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P5" ORDER BY annee DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'P6': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P6" ORDER BY annee DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'P7': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P7" ORDER BY annee DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'P8': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P8" ORDER BY annee DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'P9': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P9" ORDER BY annee DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'P10': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P10" ORDER BY annee DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'P11': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P11" ORDER BY annee DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'P12': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P12" ORDER BY annee DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
	    } 

	//------------------------------- TRI ---------------------------------------------------------------------------------------------------------

	} else if (isset($_GET['tri_tableau1'])){
		$tri_tableau1 = htmlspecialchars($_GET['tri_tableau1']);

		switch($tri_tableau1){

			// ordre croissant
			case 'AC': { //tri par année croissant
				$reponse = $db->query('SELECT * FROM probleme ORDER BY annee ASC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'AUC': { //tri par ordre alphabétique auteur croissant
				$reponse = $db->query('SELECT * FROM probleme ORDER BY auteur ASC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'DC': { //tri par date de publication croissant
				$reponse = $db->query('SELECT * FROM probleme ORDER BY date_t ASC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'OC': { //tri par ordre alphabétique formation croissant
				$reponse = $db->query('SELECT * FROM probleme ORDER BY formation ASC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'PC': { //tri par période croissant (ERROR)
				$reponse = $db->query('SELECT * FROM probleme ORDER BY CHAR_LENGTH(periode) ASC');
			    $data_instances = $reponse->fetchAll();
			     break;
			} 

			// ordre décroissant
			case 'AD': { //tri par année décroissant
				$reponse = $db->query('SELECT * FROM probleme ORDER BY annee DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'AUD': { //tri par ordre alphabétique auteur décroissant
				$reponse = $db->query('SELECT * FROM probleme ORDER BY auteur DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'DD': { //tri par date de publication décroissant
				$reponse = $db->query('SELECT * FROM probleme ORDER BY date_t DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'OD': { //tri par ordre alphabétique formation décroissant
				$reponse = $db->query('SELECT * FROM probleme ORDER BY formation DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
			case 'PD': { //tri par période décroissant (ERROR)
				$reponse = $db->query('SELECT * FROM probleme ORDER BY CHAR_LENGTH(periode) DESC');
			    $data_instances = $reponse->fetchAll();
			     break;
			}
	    } 
	} else {
		$reponse = $db->query('SELECT * FROM probleme ORDER BY date_t DESC');
		$data_instances = $reponse->fetchAll();
	}

	//------------------------------------------ TABLEAU 2 --------------------------------------------------------------------------------------------------------
	//------------------------------------------ FILTRES ----------------------------------------------------------------------------------------------------------

	// Instance

	if(isset($_GET['filtre_solver'])) {
		$filtre_solver = htmlspecialchars($_GET['filtre_solver']);

		switch($filtre_solver){

			case 'MZN': {
			    $reponse = $db->query('SELECT * FROM solutions WHERE solver = "minizinc" ORDER BY timestamp_t DESC');
		        $data_solutions = $reponse->fetchAll();
		        break;
		    }
			case 'CHR': {
				$reponse = $db->query('SELECT * FROM solutions WHERE solver = "CHR" ORDER BY timestamp_t DESC');
			    $data_solutions = $reponse->fetchAll();
			     break;
			}
	    }

	// Format

	}else if(isset($_GET['filtre_format'])) {
		$filtre_format = htmlspecialchars($_GET['filtre_format']);

		switch($filtre_format){

			case 'DZN': {
			    $reponse = $db->query('SELECT * FROM solutions WHERE format = "dzn" ORDER BY timestamp_t DESC');
		        $data_solutions = $reponse->fetchAll();
		        break;
		    }
			case 'JSON': {
				$reponse = $db->query('SELECT * FROM solutions WHERE format = "json" ORDER BY timestamp_t DESC');
			    $data_solutions = $reponse->fetchAll();
			     break;
			}
	    }

	// Représentation

	}else if(isset($_GET['filtre_representation'])) {
		$filtre_representation = htmlspecialchars($_GET['filtre_representation']);

		switch($filtre_representation){

			case 'INT': {
			    $reponse = $db->query('SELECT * FROM solutions WHERE representation = "intent" ORDER BY timestamp_t DESC');
		        $data_solutions = $reponse->fetchAll();
		        break;
		    }
			case 'EXT': {
				$reponse = $db->query('SELECT * FROM solutions WHERE representation = "extent" ORDER BY timestamp_t DESC');
			    $data_solutions = $reponse->fetchAll();
			     break;
			}
	    }

	// Solve Time (intervalles)

	}else if(isset($_GET['filtre_solveTime'])) {
		$filtre_solveTime = htmlspecialchars($_GET['filtre_solveTime']);

		switch($filtre_solveTime){

			case '0': {
			    $reponse = $db->query('SELECT * FROM solutions WHERE solveTime BETWEEN "0.000" AND "59.000" ORDER BY CAST(solveTime as FLOAT) ASC');
		        $data_solutions = $reponse->fetchAll();
		        break;
		    }
			case '1': {
				$reponse = $db->query('SELECT * FROM solutions WHERE solveTime BETWEEN "59.000" AND "299.000" ORDER BY CAST(solveTime as FLOAT) ASC');
			    $data_solutions = $reponse->fetchAll();
			     break;
			}
			case '5': {
				$reponse = $db->query('SELECT * FROM solutions WHERE solveTime BETWEEN "300.000" AND "599.000" ORDER BY CAST(solveTime as FLOAT) ASC');
			    $data_solutions = $reponse->fetchAll();
			     break;
			}
			case '10': {
				$reponse = $db->query('SELECT * FROM solutions WHERE solveTime BETWEEN "600.000" AND "1199.000" ORDER BY CAST(solveTime as FLOAT) ASC');
			    $data_solutions = $reponse->fetchAll();
			     break;
			}
			case '20': {
				$reponse = $db->query('SELECT * FROM solutions WHERE solveTime BETWEEN "1200.000" AND "3599.000" ORDER BY CAST(solveTime as FLOAT) ASC');
			    $data_solutions = $reponse->fetchAll();
			     break;
			}
	    }

	//------------------------------------------------------- TRI ---------------------------------------------------------------------------------------

	} else if (isset($_GET['tri_tableau2'])){
		$tri_tableau2 = htmlspecialchars($_GET['tri_tableau2']);

		switch($tri_tableau2){

			// ordre croissant
			case 'DC2': {
				$reponse = $db->query('SELECT * FROM solutions ORDER BY timestamp_t ASC');
			    $data_solutions = $reponse->fetchAll();
			     break;
			}
			case 'STC': {	//A REMPLACER
				$reponse = $db->query('SELECT * FROM solutions ORDER BY CAST(solveTime as FLOAT) ASC');
			    $data_solutions = $reponse->fetchAll();
			     break;
			}


			// ordre décroissant
			case 'DD2': {
				$reponse = $db->query('SELECT * FROM solutions ORDER BY timestamp_t DESC');
			    $data_solutions = $reponse->fetchAll();
			     break;
			}
			case 'STD': {	//A REMPLACER
				$reponse = $db->query('SELECT * FROM solutions ORDER BY CAST(solveTime as FLOAT) DESC');
			    $data_solutions = $reponse->fetchAll();
			     break;
			}
	    } 
	} else {
		$solutions = $db->query('SELECT * FROM solutions ORDER BY timestamp_t DESC');
		$data_solutions = $solutions->fetchAll();
	}

	//------------------------------- PAGE HTML ---------------------------------------------------------------------------------------------------
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
	<title>Insertion jeux de données</title>
	<link rel="stylesheet" href="../css/visualisation.css">
	<script src="../js/Animations.js"></script> 
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&display=swap" rel="stylesheet"> 
</head>

<body>

	<!--En-tête-->

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
		<h1>Base de données</h1>

		<!-- Tableau 1 : Visualisation des instances + métadonnées -->

		<div class="tableau-1">

			<h2>Table <i>"probleme"</i></h2>

			<!-- Filtres -->

			<aside class="filtres">

				<div class="filtrer">
		 
					<form method="GET" action="visualisation.php" >

						<!-- Filtrer par composante -->

						<div class="boite">
							<h3 class="co">Filtrer</h3>
							<input type="button" value="Composante" class="bouton" onclick="showComposantes('div2');"/>
							<div style="display:none" id="div2">
								<div  class="choix">
									<label for="filtre_composante">UFR-Droit-Eco-Gestion</label>
									<input type="checkbox" class="checkbox" name="filtre_composante" value="DEG">
								</div>
								<div  class="choix">
									<label for="filtre_composante">UFR-Lettres-Langues-Sciences Humaines</label>
									<input type="checkbox" class="checkbox" name="filtre_composante" value="LLSH">
								</div>
								<div  class="choix">
									<label for="filtre_composante">UFR Esthua, Tourisme et Culture</label>
									<input type="checkbox" class="checkbox" name="filtre_composante" value="ETC">
								</div>
								<div  class="choix">
									<label for="filtre_composante">UFR-Sciences</label>
									<input type="checkbox" class="checkbox" name="filtre_composante" value="SC">
								</div>
								<div  class="choix">
									<label for="filtre_composante">IUT</label>
									<input type="checkbox" class="checkbox" name="filtre_composante" value="IUT">
								</div>
								<div  class="choix">
									<label for="filtre_composante">Polytech</label>
									<input type="checkbox" class="checkbox" name="filtre_composante" value="POLY">
								</div>
								<div  class="choix">
									<label for="filtre_composante">IAE</label>
									<input type="checkbox" class="checkbox" name="filtre_composante" value="IAE">
								</div>		
							</div>
						</div>
						

						<!-- Filtrer par filières -->

						<div class="boite">
							<input type="button" value="Filière" class="bouton" onclick="showFilieres('div3');"/>
							<div style="display:none" id="div3">
								<div class="choix">
									<label for="filtre_filiere">Portail L1/L2</label>
									<input type="checkbox" class="checkbox" name="filtre_filiere" value="L1L2">
								</div>
								<div class="choix">
									<label for="filtre_filiere">Licence Pro</label>
									<input type="checkbox" class="checkbox" name="filtre_filiere" value="LP">
								</div>
								<div class="choix">
									<label for="filtre_filiere">Licence</label>
									<input type="checkbox" class="checkbox" name="filtre_filiere" value="L">
								</div>
								<div class="choix">
									<label for="filtre_filiere">Master</label>
									<input type="checkbox" class="checkbox" name="filtre_filiere" value="M">
								</div>
								<div class="choix">
									<label for="filtre_filiere">Master Ingénierie</label>
									<input type="checkbox" class="checkbox" name="filtre_filiere" value="CMI">
								</div>
							</div>
						</div>
						

						<!-- Filtrer par année -->

						<div class="boite">
							<input type="button" value="Année universitaire" class="bouton" onclick="showAnnee('div5');"/>
							<div style="display:none" id="div5">
								<div class="choix">
									<label for="filtre_annee">2015</label>
									<input type="checkbox" class="checkbox" name="filtre_annee" value="2015">
								</div>
								<div class="choix">
									<label for="filtre_annee">2016</label>
									<input type="checkbox" class="checkbox" name="filtre_annee" value="2016">
								</div>
								<div class="choix">
									<label for="filtre_annee">2017</label>
									<input type="checkbox" class="checkbox" name="filtre_annee" value="2017">
								</div>
								<div class="choix">
									<label for="filtre_annee">2018</label>
									<input type="checkbox" class="checkbox" name="filtre_annee" value="2018">
								</div>
								<div class="choix">
									<label for="filtre_annee">2019</label>
									<input type="checkbox" class="checkbox" name="filtre_annee" value="2019">
								</div>
								<div class="choix">
									<label for="filtre_annee">2020</label>
									<input type="checkbox" class="checkbox" name="filtre_annee" value="2020">
								</div>
								<div class="choix">
									<label for="filtre_annee">2021</label>
									<input type="checkbox" class="checkbox" name="filtre_annee" value="2021">
								</div>	
							</div>
						</div>
						

						<!-- Filtrer par semestre -->

						<div class="boite">
							<input type="button" value="Période" class="bouton" onclick="showPeriode('div4');"/>
							<div style="display:none" id="div4">
								<div class="choix">
									<label for="filtre_periode">Semestre 1</label>
									<input type="checkbox" class="checkbox" name="filtre_periode" value="S1">
								</div>
								<div class="choix">
									<label for="filtre_periode">Semestre 2</label>
									<input type="checkbox" class="checkbox" name="filtre_periode" value="S2">
								</div>
								<div class="choix">
									<label for="filtre_periode">Période 1</label>
									<input type="checkbox" class="checkbox" name="filtre_periode" value="P1">
								</div>
								<div class="choix">
									<label for="filtre_periode">Période 2</label>
									<input type="checkbox" class="checkbox" name="filtre_periode" value="P2">
								</div>
								<div class="choix">
									<label for="filtre_periode">Période 3</label>
									<input type="checkbox" class="checkbox" name="filtre_periode" value="P3">
								</div>
								<div class="choix">
									<label for="filtre_periode">Période 4</label>
									<input type="checkbox" class="checkbox" name="filtre_periode" value="P4">
								</div>
								<div class="choix">
									<label for="filtre_periode">Période 5</label>
									<input type="checkbox" class="checkbox" name="filtre_periode" value="P5">
								</div>
								<div class="choix">
									<label for="filtre_periode">Période 6</label>
									<input type="checkbox" class="checkbox" name="filtre_periode" value="P6">
								</div>
								<div class="choix">
									<label for="filtre_periode">Période 7</label>
									<input type="checkbox" class="checkbox" name="filtre_periode" value="P7">
								</div>	
								<div class="choix">
									<label for="filtre_periode">Période 8</label>
									<input type="checkbox" class="checkbox" name="filtre_periode" value="P8">
								</div>	
								<div class="choix">
									<label for="filtre_periode">Période 9</label>
									<input type="checkbox" class="checkbox" name="filtre_periode" value="P9">
								</div>	
								<div class="choix">
									<label for="filtre_periode">Période 10</label>
									<input type="checkbox" class="checkbox" name="filtre_periode" value="P10">
								</div>
								<div class="choix">
									<label for="filtre_periode">Période 11</label>
									<input type="checkbox" class="checkbox" name="filtre_periode" value="P11">
								</div>	
								<div class="choix">
									<label for="filtre_periode">Période 12</label>
									<input type="checkbox" class="checkbox" name="filtre_periode" value="P12">
								</div>	
							</div>
						</div>

						<!-- Bouton validation -->
						<div class="boite">
							<input  class="bouton2" type="submit" name="formulaire_instances" id="formulaire_instances" value="Filtrer">
						</div>

						<br><hr noshade width="100%" size="3" align="center" color="black">
					</form>
				</div>

				<!-- Tri -->

				<div class="trier">

					<form method="GET" action="visualisation.php">
						<div class="sort">
							<h3 class="co">Trier</h3>
							<select class="bouton3" name="tri_tableau1" type="submit">
								<option disabled selected value> -- Sélectionner -- </option>
								<optgroup label="Ordre croissant">
									<option value="AC">Année</option>
									<option value="AUC">Auteur</option>
									<option value="DC">Date de publication</option>
									<option value="OC">Ordre alphabétique</option>
									<option value="PC">Période</option>
								</optgroup>
								<optgroup label="Ordre décroissant">
									<option value="AD">Année</option>
									<option value="AUD">Auteur</option>
									<option value="DD">Date de publication</option>
									<option value="OD">Ordre alphabétique</option>
									<option value="PD">Période</option>
								</optgroup>
							</select>
		               	 	<input class="bouton2" type="submit" name="tri" id="tri" value="Trier">
		               	 </div>
		               	 <br><hr noshade width="100%" size="3" align="center" color="black">
					</form>
				</div>

				<!-- Export -->

				<div class="exporter">

					<form method='POST' action='export.php'>

						<h3 class="co">Exporter</h3>

						<?php 
						    $result = $db->query('SELECT * FROM probleme ORDER BY id ASC'); //on ordonne par id (insertion)
						    $probleme_arr = array();
						    foreach($result as $row){	//on associe les valeurs des colonnes à des variables
							    $id = $row['id'];
							    $fichier = $row['fichier'];
							    $date_t = $row['date_t'];
							    $auteur = $row['auteur'];
							    $composantes = $row['composantes'];
							    $filiere = $row['filiere'];
							    $formation = $row['formation'];
							    $annee = $row['annee'];
							    $periode = $row['periode'];
							    $probleme_arr[] = array($id,$fichier,$date_t,$auteur,$composantes,$filiere,$formation,$annee,$periode); //variables dans tableau
							}

					    	$serialize_probleme_arr = serialize($probleme_arr); //sérialize (prépare à la sauvegarde en retournant une chaîne contenant une représentation linéaire pour être stockée)
						?>

						<input class="bouton2" type='submit' value='export' name='export'>
					    <textarea name='export_data' style='display: none;'><?php echo $serialize_probleme_arr; ?></textarea>
					
					</form>
				</div>

			</aside>


			<!-- Tableau -->

			<div class="tableau">
				<div class="table_header">
				    <table>
				        <thead>
				            <tr>
						        <th class="fichier">Fichier xml</th>
						        <th class="auteur">Auteur</th>
						        <th class="composantes">Composantes</th>
						        <th class="filiere">Filière</th>
						        <th class="formation">Formation</th>
						        <th class="au">Année</th>
						        <th class="semestre">Semestre</th>
				        	</tr>
				        </thead>
				    </table>
				</div>
			    <div class="table_body">
			    	<table>
				    	<?php 
				    	foreach ($data_instances as $key => $value) //Affichage tableau ligne par ligne
				    	{
				    	?>
				        <tbody>
				        	<tr>
					            <td><?php echo $value['fichier'];?></td>
					            <td><?php echo $value['auteur'];?></td>
					            <td><?php echo $value['composantes'];?></td>
					            <td><?php echo $value['filiere'];?></td>
					            <td><?php echo $value['formation'];?></td>
					            <td><?php echo $value['annee'];?></td>
					            <td><?php echo $value['periode'];?></td>
				        	</tr>
				     	</tbody>
				        <?php
					    }
					        if(!$value || !$data_instances){	//Si aucune valeur trouvée
					        echo "Aucun résultat ne correspond à vos critères";
					    }
					    ?>
			    	</table>
				</div>
			</div>
		</div>


		<!-- Tableau 2 : Visualisation des solutions et statistiques -->

		<div class="tableau-2">

			<h2>Table <i>"Solutions"</i></h2>

			<!-- Filtres -->

			<aside class="filtres">

				<div class="filtrer">

					<h3 class="co">Filtrer</h3>
		 
					<form method="GET" action="visualisation.php" >

						<!-- Filtrer par instance -->

						<div class="boite">
							<select class="bouton" name="filtre_instance" type="submit">
								<option disabled selected value> -- Sélectionner -- </option>
								<?php foreach ($dir as $key => $instance) { //retourne une liste
									?>
									<option value="<?php $instance_name = print_r(basename($instance)); ?>"><?php $instance_name = print_r(basename($instance)); ?></option> 
									<!-- Nom du fichier sans le chemin "xml/"" -->
								<?php
								}
								?>
							</select>
						</div>

						<!-- Filtrer par solver -->

						<div class="boite">
							<input type="button" value="Solver" class="bouton" onclick="showSolver('div8');"/>
							<div style="display:none" id="div8">
								<div class="choix">
									<label for="filtre_solver">MZN</label>
									<input type="checkbox" class="checkbox" name="filtre_solver" value="MZN">
								</div>
								<div class="choix">
									<label for="filtre_solver">CHR</label>
									<input type="checkbox" class="checkbox" name="filtre_solver" value="CHR">
								</div>
							</div>
						</div>
						

						<!-- Filtrer par format -->

						<div class="boite">
							<input type="button" value="Format" class="bouton" onclick="showFormat('div9');"/>
							<div style="display:none" id="div9">
								<div class="choix">
									<label for="filtre_format">DZN</label>
									<input type="checkbox" class="checkbox" name="filtre_format" value="DZN">
								</div>
								<div class="choix">
									<label for="filtre_format">JSON</label>
									<input type="checkbox" class="checkbox" name="filtre_format" value="JSON">
								</div>
							</div>
						</div>	
						

						<!-- Filtrer par représentation -->

						<div class="boite">
							<input type="button" value="Représentation" class="bouton" onclick="showRepresentation('div10');"/>
							<div style="display:none" id="div10">
								<div class="choix">
									<label for="filtre_representation">Intension</label>
									<input type="checkbox" class="checkbox" name="filtre_representation" value="INT">
								</div>
								<div class="choix">
									<label for="filtre_representation">Extension</label>
									<input type="checkbox" class="checkbox" name="filtre_representation" value="EXT">
								</div>
							</div>
						</div>

						<!-- Filtrer par temps de calcul final -->

						<div class="boite">
							<input type="button" value="Temps de calcul final" class="bouton" onclick="showTCF('div11');"/>
							<div style="display:none" id="div11">
								<div class="choix">
									<label for="filtre_solveTime">0 => 59s</label>
									<input type="checkbox" class="checkbox" name="filtre_solveTime" value="0">
								</div>
								<div class="choix">
									<label for="filtre_solveTime">1 => 4.99min</label>
									<input type="checkbox" class="checkbox" name="filtre_solveTime" value="5">
								</div>
								<div class="choix">
									<label for="filtre_solveTime">5 => 9.99min</label>
									<input type="checkbox" class="checkbox" name="filtre_solveTime" value="10">
								</div>
								<div class="choix">
									<label for="filtre_solveTime">10 => 19.99min</label>
									<input type="checkbox" class="checkbox" name="filtre_solveTime" value="20">
								</div>
								<div class="choix">
									<label for="filtre_solveTime">20 => 59.99min</label>
									<input type="checkbox" class="checkbox" name="filtre_solveTime" value="59">
								</div>
							</div>
						</div>

						<!-- Bouton validation -->
						<div class="boite">
							<input  class="bouton2" type="submit" name="formulaire_solutions" value="Filtrer">
						</div>

						<br><br><hr noshade width="100%" size="3" align="center" color="black">
					</form>
				</div>

				<!-- Tri -->

				<div class="trier">
					<h3 class="co">Trier</h3>
					<form method="GET" action="visualisation.php">
						<div class="sort">
							<select class="bouton3" name="tri_tableau2" type="submit">
								<option disabled selected value> -- Sélectionner -- </option>
								<optgroup label="Ordre croissant">
									<option value="DC2">Timestamp</option>
									<option value="STC">Solve Time</option>
								</optgroup>
								<optgroup label="Ordre décroissant">
									<option value="DD2">Timestamp</option>
									<option value="STD">Solve Time</option>
								</optgroup>
							</select>
		               	 	<input class="bouton2" type="submit" name="tri" id="tri" value="Trier">
		               	 </div>
					</form>
				</div>

				<!-- Export -->

				<div class="exporter">

					<form method='POST' action='export.php'>

						<h3 class="co">Exporter</h3>

						<?php 
						    $result = $db->query('SELECT * FROM solutions ORDER BY id ASC');
						    $probleme_arr = array();
						    foreach($result as $row){
							    $id = $row['id'];
							    $fichier_probleme = $row['fichier_probleme'];
							    $solver = $row['solver'];
							    $format = $row['format'];
							    $representation = $row['representation'];
							    $temps_calcul = $row['temps_calcul'];
							    $fichier_solution = $row['fichier_solution'];
							    $timestamp_t = $row['timestamp_t'];
							    $initTime = $row['initTime'];
							    $solveTime = $row['solveTime'];
							    $variables = $row['variables'];
							    $propagators = $row['propagators'];
							    $propagations = $row['propagations'];
							    $nodes = $row['nodes'];
							    $failures = $row['failures'];
							    $restarts = $row['restarts'];
							    $peakDepth = $row['peakDepth'];
							    $probleme_arr[] = array($id, $fichier_probleme, $solver, $format, $representation, $temps_calcul, $fichier_solution, $timestamp_t, $initTime, $solveTime, $variables, $propagators, $propagations, $nodes, $failures, $restarts, $peakDepth);
							}

					    	$serialize_probleme_arr = serialize($probleme_arr);
						?>

						<input class="bouton2" type='submit' value='export' name='export'>
					    <textarea name='export_data2' style='display: none;'><?php echo $serialize_probleme_arr; ?></textarea>
					
					</form>
				</div>
			</aside>


			<!-- Tableau -->

			<div class="tableau">
				<div class="table_header2">
				    <table>
				        <thead>
				            <tr class="tr1">
						        <th colspan="5">Paramètres</th>
						        <th colspan="2">Solution</th>
						        <th colspan="9">Statistiques</th>
				        	</tr>
				        </thead>
				        <tr class="table_header2">
					        <th class="th2">Fichier problème</th>
					        <th class="th2">Solver</th>
					        <th class="th2">Format</th>
					        <th class="th2">Représentation</th>
					        <th class="th2 th3">Temps de calcul souhaité</th>
					        <th class="th2 th3">Fichier solution</th>
					        <th class="th2 th3">Timestamp</th>
					        <th class="th2">initTime</th>
					        <th class="th2">solveTime</th>
					        <th class="th2">variables</th>
					        <th class="th2">propagators</th>
					        <th class="th2">propagations</th>
					        <th class="th2">nodes</th>
					        <th class="th2">failures</th>
					        <th class="th2">restarts</th>
					        <th class="th2">peakDepth</th>
				        </tr>
				    </table>
				</div>
			    <div class="table_body2">
			    	<table>
				    	<?php 
				    	foreach ($data_solutions as $key => $value) //Affichage tableau ligne par ligne
				    	{
				    	?>
				        <tbody>
				        	<tr>
					            <td><?php echo $value['fichier_probleme'];?></td>
					            <td><?php echo $value['solver'];?></td>
					            <td><?php echo $value['format'];?></td>
					            <td><?php echo $value['representation'];?></td>
					            <td><?php echo $value['temps_calcul'];?></td>
					            <td><?php echo $value['fichier_solution'];?></td>
					            <td><?php echo $value['timestamp_t'];?></td>
					            <td><?php echo $value['initTime'];?></td>
					            <td><?php echo $value['solveTime'];?></td>
					            <td><?php echo $value['variables'];?></td>
					            <td><?php echo $value['propagators'];?></td>
					            <td><?php echo $value['propagations'];?></td>
					            <td><?php echo $value['nodes'];?></td>
					            <td><?php echo $value['failures'];?></td>
					            <td><?php echo $value['restarts'];?></td>
					            <td><?php echo $value['peakDepth'];?></td>
				        	</tr>
				     	</tbody>
				        <?php
					    }
					        if(!$value || !$data_solutions){	//Si aucune valeur trouvée
					        echo "Aucun résultat ne correspond à vos critères";
					    }
					    ?>
			    	</table>
				</div>
			</div>
		</div>
	</section>
</body>
</html>
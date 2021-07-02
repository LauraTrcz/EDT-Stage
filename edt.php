<?php 
	
	include 'php/database.php';
	include 'Edt_parser_solver_070621/parser_edt.php';
	global $db;
	global $writeExec;
	global $instance;
	$instance = 0;
	$writeExec = true;

	//focus sur le dossier contenant les fichiers xml
	$dossier = glob('instance_xml/*.xml');

	//insertion des données dans la base de données "solutions" et récupération des clés sous forme de tableau pour exécution de la fonction parser
	if(isset($_POST['formulaire_edt'])){

		extract($_POST); /*extraire toutes les variables*/

		//enregistrement des données du formulaire dans la bdd "solutions"

		if(!empty($instance) && !empty($solver) && !empty($format) && !empty($representation) && !empty($temps_calcul)) { /*tant que le formulaire n'est pas vide*/

			$i = $db->prepare("INSERT INTO solutions(fichier_probleme,solver,format,representation,temps_calcul,fichier_solution,initTime,solveTime,variables,propagators,propagations,nodes,failures,restarts,peakDepth) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");	//["place dans la bdd","clé"] => ["clé","valeur"]
			$i -> bindParam(1,$instance);
			$i -> bindParam(2,$solver);
			$i -> bindParam(3,$format);
			$i -> bindParam(4,$representation);
			$i -> bindParam(5,$temps_calcul);
			//$i->execute(['instance' => $instance, 'solver' => $solver, 'format' => $format, 'representation' => $representation, 'temps_calcul' => $temps_calcul]);

			//on redéclare la variable instance en ajoutant le path une fois que le fichier a été mis dans la base de données pour ne pas avoir de souci avec le parser

			$instance2 = "instance_xml\\".$instance; //anti-slash = système, slash = PHP
			
			$parametres = [
			    "instance" => $instance2,
			    "solver"=> $solver,
			    "format"=> $format,
			    "representation"=> $representation,
			    "temps_calcul"=> $temps_calcul
			];

			//shell_exec("del statistique_instance_xml\\*.txt"); //delete tous les fichiers .txt dans le dossier

			//try catch pour attraper les erreurs

			try{	//vérifier que les fichiers xml et csv ont été générés
				$solution = runParser($parametres);
			} catch(Exception $e) {
				echo "<script>alert(\"Aucun fichier généré\");</script>";
				$writeExec = false;
			}



			if($writeExec){	//si la solution ne retourne pas [] ni ["",""] (si deux fichiers sont créés)

				//commande lire fichier csv
				$csv = $solution[0];  //solution est un tableau contenant [fichier_stats_csv, fichier_solution_xml] d'où indice 0
				$xml_verify = $solution[1];
				$xml = basename($xml_verify); //fichier xml
				$fileCsv = 0;
				$i->bindParam(6, $xml); //bindParam le fichier xml solution

				try{	//sécurité
					//$xml_verify.="11";
					if(!file_exists($xml_verify)){ //vérifie que le fichier xml est créé
						throw new Exception('Le fichier xml n\'existe pas! :(');
					}
					//$xml = [];
					if($xml_verify == []){	//vérifie que le fichier xml n'est pas vide
						throw new Exception('Le fichier xml est vide! :(');
					}	
					//$csv.="11";
					if(!file_exists($csv)){ //vérifie que le fichier csv est créé
						throw new Exception('Le fichier csv n\'existe pas! :(');
					}
					$fileCsv = file($csv);
					//$fileCsv = [];
					if($fileCsv == []){ //vérifie que le fichier csv n'est pas vide
						throw new Exception('Le fichier csv est vide! :(');
					}
				} catch(Exception $exception){
					echo "<script>alert(\"".$exception->getMessage()."\");</script>";
					$writeExec = false;
				}
			}

			if($writeExec){	// si tout est bon
				

				foreach($fileCsv as $line_csv){	//lit le fichier csv et crée un tableau, ; sépare deux cellules d'une ligne
					$valid_data = str_getcsv($line_csv,";");
					if(!in_array($valid_data[0],["solutions"])){	//cherche dans la 1e colonne du tableau $valid_data un tableau de ce que tu veux pas, ici "solutions" seulement
						$data[] = $valid_data;	//le tableau valide
					}
				}

				//$handle = fopen($csv, "r");
				//$data_csv = fgetcsv($handle, 1024, ";");

				//enregistrement des stats du fichier csv dans la bdd
				//$i = $db->prepare("INSERT INTO solutions(initTime,solveTime,variables,propagators,propagations,nodes,failures,restarts,peakDepth) VALUES (:initTime, :solveTime, :variables, :propagators, :propagations,:nodes,:failures,:restarts,:peakDepth)");
				for($j = 7;$j<16;$j++){
					$i -> bindParam($j,$data[$j-7][1]);
				}
				
				$i->execute(/*['initTime' => $data[0][1], 'solveTime' => $data[1][1], 'variables' => $data[3][1], 'propagators' => $data[4][1], 'propagations' => $data[5][1], 'nodes' => $data[6][1], 'failures' => $data[7][1], 'restarts' => $data[8][1], 'peakDepth' => $data[9,1]]*/);
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
						<?php foreach ($dossier as $key => $instance) { //retourne une liste
							?>
							<option value="<?php print_r(basename($instance))?>"><?php print_r(basename($instance)); ?></option> <!-- Nom du fichier sans le chemin "xml/" -->
						<?php
						}
						?>
					</select>
				</div>

				<hr noshade width="90%" size="3" align="center">

				<!-- Formulaire paramétrage solveur -->
				<!-- Choix du solveur et du format-->

				<div class="boite">
					<label class="label">Solveur |</label><br>
					<div class="boite2">
						<div>
							<label class="info"for="solver">Minizinc</label><br>
							<input type="radio" name="solver" class="radio" value="minizinc" onchange="showMZN('div6'); effacerCHR()" content-type="choices" trigger="true" target="format">
							<div class="boite2" id="div6" style="display:none">
								<div>
									<label class="label" for="format">DZN</label><br><br>
						    		<input type="radio" name="format" class="radio" value="dzn">
								</div>
							    <div>
							    	<label class="label" for="format">JSON</label><br><br>
									<input type="radio" name="format" class="radio" value="json">
								</div>
							</div>
						</div>
						<div>
							<label class="info"for="solver">Constraint Handling Rules</label><br>
							<input type="radio" name="solver" class="radio" value="CHR" onchange="showCHR('div7'); effacerMZN()" content-type="choices" trigger="true" target="format">
							<div class="boite2 display-none" id="div7" style="display:none">
								<label class="label" for="format">JSON</label><br>
								<input type="radio" name="format" class="radio" value="json">
							</div>
						</div>
					</div>
						
				</div>

				<!-- Choix de la representation -->

				<div class="boite">
					<label class="label">Type |</label>
					<div class="boite2">
						<div>
							<label class="info" for="representation">Intension</label><br>
					    	<input type="radio" name="representation" class="radio" value="intent">
					    </div>
					    <div>
					    	<label class="info" for="representation">Extension</label><br>
					    	<input type="radio" name="representation" class="radio" value="extent" checked>
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
							<label class="info" for="temps_calcul">hh : mm : ss</label><br>
					    	<input class="bouton" type="time" name="temps_calcul" step="1" min="00:00:01" max="23:59:59" required>
					    </div>
					</div>	
				</div>

				<!-- Bouton GO -->
			
				<div class="valider">
					<input class="bouton2" type="submit" name="formulaire_edt" id="select" value="Go">
				</div>
				</fieldset>
			</form>
		</div>
	</section>


		<?php
		if (isset($_POST['formulaire_edt']) && ($writeExec == true) ) { //si on a envoyé le formulaire et que tout est ok du côté du programme
		?>

		<hr noshade width="90%" size="3" align="center" color="black">

		<!-- Affichage des résultats -->

		<section class="resultats">

			<h2>Résultats</h2>
			<div class="resultats2">
			<div>
				<h3>Fichiers</h3>
				<table>
					<tr>
						<td class="thead">Fichier <i>.csv :</i></td>
						<td><?php print_r(basename($csv));?></td>	<!--csv possède le chemin système ! -->
					</tr>
					<tr>
						<td class="thead">Fichier <i>.xml :</i></td>
						<td><?php print_r($xml);?></td>
					</tr>
				</table>
			</div>
			<div>
				<h3>Statistiques</h3>
				<table>
					<tr>
						<td class="thead">initTime</td>
						<td><?php print_r($data[0][1]);?></td>
					</tr>
					<tr>
						<td class="thead">solveTime</td>
						<td><?php print_r($data[1][1]);?></td>
					</tr>
					<tr>
						<td class="thead">variables</td>
						<td><?php print_r($data[2][1]);?></td>
					</tr>
					<tr>
						<td class="thead">propagators</td>
						<td><?php print_r($data[3][1]);?></td>
					</tr>
					<tr>
						<td class="thead">propagations</td>
						<td><?php print_r($data[4][1]);?></td>
					</tr>
					<tr>
						<td class="thead">nodes</td>
						<td><?php print_r($data[5][1]);?></td>
					</tr>
					<tr>
						<td class="thead">failures</td>
						<td><?php print_r($data[6][1]);?></td>
					</tr>
					<tr>
						<td class="thead">restarts</td>
						<td><?php print_r($data[7][1]);?></td>
					</tr>
					<tr>
						<td class="thead">peakDepth</td>
						<td><?php print_r($data[8][1]);?></td>
					</tr>
				</table>
			</div>
		</div>
		<?php
		}
		?>		
	</section>
</body>

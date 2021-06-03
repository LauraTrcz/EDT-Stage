<?php 
	
	include ('database.php');
	global $db;


	//------------------------------- FILTRES -----------------------------------------------------------------------------------------------------

	// Composantes

	if(isset($_GET['choix_composante'])) {
		$choix_composante = htmlspecialchars($_GET['choix_composante']);

		switch($choix_composante){

			case 'DEG': {
			    $reponse = $db->query('SELECT * FROM instance WHERE composantes = "UFR-Droit-Eco-Gestion" ORDER BY date_t DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
			case 'LLSH': {
				$reponse = $db->query('SELECT * FROM instance WHERE composantes = "UFR-Lettres-Langues-Sciences Humaines" ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'ETC': {
	            $reponse = $db->query('SELECT * FROM instance WHERE composantes = "UFR Esthua, Tourisme et Culture" ORDER BY date_t DESC');
	            $data = $reponse->fetchAll();
	            break;
	        }
			case 'SC': {
	            $reponse = $db->query('SELECT * FROM instance WHERE composantes = "UFR-Sciences" ORDER BY date_t DESC');
	            $data = $reponse->fetchAll();
	            break;
	        }
			case 'IUT': {
			    $reponse = $db->query('SELECT * FROM instance WHERE composantes = "IUT" ORDER BY date_t DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
			case 'POLY': {
				$reponse = $db->query('SELECT * FROM instance WHERE composantes = "Polytech" ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'IAE': {
	            $reponse = $db->query('SELECT * FROM instance WHERE composantes = "IAE" ORDER BY date_t DESC');
	            $data = $reponse->fetchAll();
	            break;
	        }
	    } 

	// Filières

	} else if(isset($_GET['choix_filiere'])) {
		$choix_filiere = htmlspecialchars($_GET['choix_filiere']);

		switch($choix_filiere){

			case 'L1L2': {
			    $reponse = $db->query('SELECT * FROM instance WHERE filiere = "Portail L1/L2 - Sciences" ORDER BY date_t DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
			case 'LP': {
				$reponse = $db->query('SELECT * FROM instance WHERE filiere = "Licence Pro - Sciences" ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'L': {
	            $reponse = $db->query('SELECT * FROM instance WHERE filiere = "Licence - Sciences" ORDER BY date_t DESC');
	            $data = $reponse->fetchAll();
	            break;
	        }
			case 'M': {
	            $reponse = $db->query('SELECT * FROM instance WHERE filiere = "Master - Sciences" ORDER BY date_t DESC');
	            $data = $reponse->fetchAll();
	            break;
	        }
			case 'CMI': {
			    $reponse = $db->query('SELECT * FROM instance WHERE filiere = "Master Ingénierie - Sciences" ORDER BY date_t DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
	    } 

	// Année

	} else if (isset($_GET['choix_annee'])) {
		$choix_annee = htmlspecialchars($_GET['choix_annee']);

		switch($choix_annee){

			case '2021': {
			    $reponse = $db->query('SELECT * FROM instance WHERE annee = "2021" ORDER BY semestre DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
			case '2020': {
				$reponse = $db->query('SELECT * FROM instance WHERE annee = "2020" ORDER BY semestre DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case '2019': {
	            $reponse = $db->query('SELECT * FROM instance WHERE annee = "2019" ORDER BY semestre DESC');
	            $data = $reponse->fetchAll();
	            break;
	        }
			case '2018': {
	            $reponse = $db->query('SELECT * FROM instance WHERE annee = "2018" ORDER BY semestre DESC');
	            $data = $reponse->fetchAll();
	            break;
	        }
			case '2017': {
			    $reponse = $db->query('SELECT * FROM instance WHERE annee = "2017" ORDER BY semestre DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
		    case '2016': {
			    $reponse = $db->query('SELECT * FROM instance WHERE annee = "2016" ORDER BY semestre DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
		    case '2015': {
			    $reponse = $db->query('SELECT * FROM instance WHERE annee = "2015" ORDER BY semestre DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
	    } 

	// Semestre

	} else if (isset($_GET['choix_semestre'])) {
		$choix_semestre = htmlspecialchars($_GET['choix_semestre']);

		switch($choix_semestre){

			case 'S1': {
			    $reponse = $db->query('SELECT * FROM instance WHERE semestre = "Semestre 1" ORDER BY date_t DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
			case 'S2': {
				$reponse = $db->query('SELECT * FROM instance WHERE semestre = "Semestre 2" ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
	    } 
	}else {
		$reponse = $db->query('SELECT * FROM instance ORDER BY date_t DESC');
		$data = $reponse->fetchAll();
	}
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

		<!-- Filtres -->

		<div class="filtres">

			<p class="co">Filtrer</p>
 
			<form method="GET" action="visualisation.php">

				<!-- Filtrer par composante -->

				<div class="boite">
					<input type="button" value="Composante" class="bouton" onclick="showComposantes('div2');"/>
					<div style="display:none" id="div2">
						<label for="choix_composante">UFR-Droit-Eco-Gestion</label>
						<input type="checkbox" name="choix_composante" value="DEG">
						<label for="choix_composante">UFR-Lettres-Langues-Sciences Humaines</label>
						<input type="checkbox" name="choix_composante" value="LLSH">
						<label for="choix_composante">UFR Esthua, Tourisme et Culture</label>
						<input type="checkbox" name="choix_composante" value="ETC">
						<label for="choix_composante">UFR-Sciences</label>
						<input type="checkbox" name="choix_composante" value="SC">
						<label for="choix_composante">IUT</label>
						<input type="checkbox" name="choix_composante" value="IUT">
						<label for="choix_composante">Polytech</label>
						<input type="checkbox" name="choix_composante" value="POLY">
						<label for="choix_composante">IAE</label>
						<input type="checkbox" name="choix_composante" value="IAE">
					</div>
				</div>
				

				<!-- Filtrer par filières -->

				<div class="boite">
					<input type="button" value="Filière" class="bouton" onclick="showFilieres('div3');"/>
					<div style="display:none" id="div3">
						<label for="choix_filiere">Portail L1/L2</label>
						<input type="checkbox" name="choix_filiere" value="L1L2">
						<label for="choix_filiere">Licence Pro</label>
						<input type="checkbox" name="choix_filiere" value="LP">
						<label for="choix_filiere">Licence</label>
						<input type="checkbox" name="choix_filiere" value="L">
						<label for="choix_filiere">Master</label>
						<input type="checkbox" name="choix_filiere" value="M">
						<label for="choix_filiere">Master Ingénierie</label>
						<input type="checkbox" name="choix_filiere" value="CMI">
					</div>
				</div>
				

				<!-- Filtrer par année -->

				<div class="boite">
					<input type="button" value="Année universitaire" class="bouton" onclick="showAnnee('div5');"/>
					<div style="display:none" id="div5">
				    	<label for="choix_annee">2015</label>
						<input type="checkbox" name="choix_annee" value="2015">
						<label for="choix_annee">2016</label>
						<input type="checkbox" name="choix_annee" value="2016">
						<label for="choix_annee">2017</label>
						<input type="checkbox" name="choix_annee" value="2017">
						<label for="choix_annee">2018</label>
						<input type="checkbox" name="choix_annee" value="2018">
						<label for="choix_annee">2019</label>
						<input type="checkbox" name="choix_annee" value="2019">
						<label for="choix_annee">2020</label>
						<input type="checkbox" name="choix_annee" value="2020">
						<label for="choix_annee">2021</label>
						<input type="checkbox" name="choix_annee" value="2021">
					</div>
				</div>
				

				<!-- Filtrer par semestre -->

				<div class="boite">
					<input type="button" value="Semestre" class="bouton" onclick="showSemestre('div4');"/>
					<div style="display:none" id="div4">
						<label for="choix_semestre">Semestre 1</label>
						<input type="checkbox" name="choix_semestre" value="S1">
						<label for="choix_semestre">Semestre 2</label>
						<input type="checkbox" name="choix_semestre" value="S2">
					</div>
				</div>
				

				<!-- Bouton validation -->
				<div class="boite">
					<input  class="bouton2" type="submit" name="formulaire_edt" value="Trier">
				</div>
			</form>
		</div>

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
			    	foreach ($data as $key => $value) //Affichage tableau ligne par ligne
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
				            <td><?php echo $value['semestre'];?></td>
			        	</tr>
			     	</tbody>
			        <?php
				    }
				        if(!$value){	//Si aucune valeur trouvée
				        echo "Aucun résultat ne correspond à vos critères";
				    }
				    ?>
		    	</table>
			</div>
		</div>
	</section>
</body>
</html>
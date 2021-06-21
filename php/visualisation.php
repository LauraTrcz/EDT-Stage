<?php 
	
	include ('database.php');
	global $db;


	//------------------------------- FILTRES -----------------------------------------------------------------------------------------------------

	// Composantes

	if(isset($_GET['choix_composante'])) {
		$choix_composante = htmlspecialchars($_GET['choix_composante']);

		switch($choix_composante){

			case 'DEG': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE composantes = "UFR-Droit-Eco-Gestion" ORDER BY date_t DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
			case 'LLSH': {
				$reponse = $db->query('SELECT * FROM probleme WHERE composantes = "UFR-Lettres-Langues-Sciences Humaines" ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'ETC': {
	            $reponse = $db->query('SELECT * FROM probleme WHERE composantes = "UFR Esthua, Tourisme et Culture" ORDER BY date_t DESC');
	            $data = $reponse->fetchAll();
	            break;
	        }
			case 'SC': {
	            $reponse = $db->query('SELECT * FROM probleme WHERE composantes = "UFR-Sciences" ORDER BY date_t DESC');
	            $data = $reponse->fetchAll();
	            break;
	        }
			case 'IUT': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE composantes = "IUT" ORDER BY date_t DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
			case 'POLY': {
				$reponse = $db->query('SELECT * FROM probleme WHERE composantes = "Polytech" ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'IAE': {
	            $reponse = $db->query('SELECT * FROM probleme WHERE composantes = "IAE" ORDER BY date_t DESC');
	            $data = $reponse->fetchAll();
	            break;
	        }
	    } 

	// Filières

	} else if(isset($_GET['choix_filiere'])) {
		$choix_filiere = htmlspecialchars($_GET['choix_filiere']);

		switch($choix_filiere){

			case 'L1L2': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE filiere = "Portail L1/L2 - Sciences" ORDER BY date_t DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
			case 'LP': {
				$reponse = $db->query('SELECT * FROM probleme WHERE filiere = "Licence Pro - Sciences" ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'L': {
	            $reponse = $db->query('SELECT * FROM probleme WHERE filiere = "Licence - Sciences" ORDER BY date_t DESC');
	            $data = $reponse->fetchAll();
	            break;
	        }
			case 'M': {
	            $reponse = $db->query('SELECT * FROM probleme WHERE filiere = "Master - Sciences" ORDER BY date_t DESC');
	            $data = $reponse->fetchAll();
	            break;
	        }
			case 'CMI': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE filiere = "Master Ingénierie - Sciences" ORDER BY date_t DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
	    } 

	// Année

	} else if (isset($_GET['choix_annee'])) {
		$choix_annee = htmlspecialchars($_GET['choix_annee']);

		switch($choix_annee){

			case '2021': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE annee = "2021" ORDER BY periode DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
			case '2020': {
				$reponse = $db->query('SELECT * FROM probleme WHERE annee = "2020" ORDER BY periode DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case '2019': {
	            $reponse = $db->query('SELECT * FROM probleme WHERE annee = "2019" ORDER BY periode DESC');
	            $data = $reponse->fetchAll();
	            break;
	        }
			case '2018': {
	            $reponse = $db->query('SELECT * FROM probleme WHERE annee = "2018" ORDER BY periode DESC');
	            $data = $reponse->fetchAll();
	            break;
	        }
			case '2017': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE annee = "2017" ORDER BY periode DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
		    case '2016': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE annee = "2016" ORDER BY periode DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
		    case '2015': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE annee = "2015" ORDER BY periode DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
	    } 

	// Periode

	} else if (isset($_GET['choix_periode'])) {
		$choix_periode = htmlspecialchars($_GET['choix_periode']);

		switch($choix_periode){

			case 'S1': {
			    $reponse = $db->query('SELECT * FROM probleme WHERE periode = "Semestre 1" ORDER BY date_t DESC');
		        $data = $reponse->fetchAll();
		        break;
		    }
			case 'S2': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "Semestre 2" ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'P1': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P1" ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'P2': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P2" ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'P3': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P3" ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'P4': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P4" ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'P5': {
				$reponse = $db->query('SELECT * FROM probleme WHERE periode = "P5" ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'P6': {
				$reponse = $db->query('SELECT * FROM probleme WHERE semestre = "P6" ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
	    } 

	//------------------------------- TRI ---------------------------------------------------------------------------------------------------------

	} else if (isset($_GET['choix_tri'])){
		$choix_tri = htmlspecialchars($_GET['choix_tri']);

		switch($choix_tri){

			// ordre croissant
			case 'AC': {
				$reponse = $db->query('SELECT * FROM probleme ORDER BY annee ASC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'AUC': {
				$reponse = $db->query('SELECT * FROM probleme ORDER BY auteur ASC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'DC': {
				$reponse = $db->query('SELECT * FROM probleme ORDER BY date_t ASC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'OC': {
				$reponse = $db->query('SELECT * FROM probleme ORDER BY formation ASC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'PC': {
				$reponse = $db->query('SELECT * FROM probleme ORDER BY periode ASC');
			    $data = $reponse->fetchAll();
			     break;
			} 

			// ordre décroissant
			case 'AD': {
				$reponse = $db->query('SELECT * FROM probleme ORDER BY annee DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'AUD': {
				$reponse = $db->query('SELECT * FROM probleme ORDER BY auteur DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'DD': {
				$reponse = $db->query('SELECT * FROM probleme ORDER BY date_t DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'OD': {
				$reponse = $db->query('SELECT * FROM probleme ORDER BY formation DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
			case 'PD': {
				$reponse = $db->query('SELECT * FROM probleme ORDER BY periode DESC');
			    $data = $reponse->fetchAll();
			     break;
			}
	    } 
	} else {
		$reponse = $db->query('SELECT * FROM probleme ORDER BY date_t DESC');
		$data = $reponse->fetchAll();
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

		<!-- Filtres -->

		<aside class="filtres">

			<div class="filtrer">

				<h2 class="co">Filtrer</h2>
	 
				<form method="GET" action="visualisation.php" >

					<!-- Filtrer par composante -->

					<div class="boite">
						<input type="button" value="Composante" class="bouton" onclick="showComposantes('div2');"/>
						<div style="display:none" id="div2">
							<div  class="choix">
								<label for="choix_composante">UFR-Droit-Eco-Gestion</label>
								<input type="checkbox" class="checkbox" name="choix_composante" value="DEG">
							</div>
							<div  class="choix">
								<label for="choix_composante">UFR-Lettres-Langues-Sciences Humaines</label>
								<input type="checkbox" class="checkbox" name="choix_composante" value="LLSH">
							</div>
							<div  class="choix">
								<label for="choix_composante">UFR Esthua, Tourisme et Culture</label>
								<input type="checkbox" class="checkbox" name="choix_composante" value="ETC">
							</div>
							<div  class="choix">
								<label for="choix_composante">UFR-Sciences</label>
								<input type="checkbox" class="checkbox" name="choix_composante" value="SC">
							</div>
							<div  class="choix">
								<label for="choix_composante">IUT</label>
								<input type="checkbox" class="checkbox" name="choix_composante" value="IUT">
							</div>
							<div  class="choix">
								<label for="choix_composante">Polytech</label>
								<input type="checkbox" class="checkbox" name="choix_composante" value="POLY">
							</div>
							<div  class="choix">
								<label for="choix_composante">IAE</label>
								<input type="checkbox" class="checkbox" name="choix_composante" value="IAE">
							</div>		
						</div>
					</div>
					

					<!-- Filtrer par filières -->

					<div class="boite">
						<input type="button" value="Filière" class="bouton" onclick="showFilieres('div3');"/>
						<div style="display:none" id="div3">
							<div class="choix">
								<label for="choix_filiere">Portail L1/L2</label>
								<input type="checkbox" class="checkbox" name="choix_filiere" value="L1L2">
							</div>
							<div class="choix">
								<label for="choix_filiere">Licence Pro</label>
								<input type="checkbox" class="checkbox" name="choix_filiere" value="LP">
							</div>
							<div class="choix">
								<label for="choix_filiere">Licence</label>
								<input type="checkbox" class="checkbox" name="choix_filiere" value="L">
							</div>
							<div class="choix">
								<label for="choix_filiere">Master</label>
								<input type="checkbox" class="checkbox" name="choix_filiere" value="M">
							</div>
							<div class="choix">
								<label for="choix_filiere">Master Ingénierie</label>
								<input type="checkbox" class="checkbox" name="choix_filiere" value="CMI">
							</div>
						</div>
					</div>
					

					<!-- Filtrer par année -->

					<div class="boite">
						<input type="button" value="Année universitaire" class="bouton" onclick="showAnnee('div5');"/>
						<div style="display:none" id="div5">
							<div class="choix">
								<label for="choix_annee">2015</label>
								<input type="checkbox" class="checkbox" name="choix_annee" value="2015">
							</div>
							<div class="choix">
								<label for="choix_annee">2016</label>
								<input type="checkbox" class="checkbox" name="choix_annee" value="2016">
							</div>
							<div class="choix">
								<label for="choix_annee">2017</label>
								<input type="checkbox" class="checkbox" name="choix_annee" value="2017">
							</div>
							<div class="choix">
								<label for="choix_annee">2018</label>
								<input type="checkbox" class="checkbox" name="choix_annee" value="2018">
							</div>
							<div class="choix">
								<label for="choix_annee">2019</label>
								<input type="checkbox" class="checkbox" name="choix_annee" value="2019">
							</div>
							<div class="choix">
								<label for="choix_annee">2020</label>
								<input type="checkbox" class="checkbox" name="choix_annee" value="2020">
							</div>
							<div class="choix">
								<label for="choix_annee">2021</label>
								<input type="checkbox" class="checkbox" name="choix_annee" value="2021">
							</div>	
						</div>
					</div>
					

					<!-- Filtrer par semestre -->

					<div class="boite">
						<input type="button" value="Période" class="bouton" onclick="showPeriode('div4');"/>
						<div style="display:none" id="div4">
							<div class="choix">
								<label for="choix_periode">Semestre 1</label>
								<input type="checkbox" class="checkbox" name="choix_periode" value="S1">
							</div>
							<div class="choix">
								<label for="choix_periode">Semestre 2</label>
								<input type="checkbox" class="checkbox" name="choix_periode" value="S2">
							</div>
							<div class="choix">
								<label for="choix_periode">Période 1</label>
								<input type="checkbox" class="checkbox" name="choix_periode" value="P1">
							</div>
							<div class="choix">
								<label for="choix_periode">Période 2</label>
								<input type="checkbox" class="checkbox" name="choix_periode" value="P2">
							</div>
							<div class="choix">
								<label for="choix_periode">Période 3</label>
								<input type="checkbox" class="checkbox" name="choix_periode" value="P3">
							</div>
							<div class="choix">
								<label for="choix_periode">Période 4</label>
								<input type="checkbox" class="checkbox" name="choix_periode" value="P4">
							</div>
							<div class="choix">
								<label for="choix_periode">Période 5</label>
								<input type="checkbox" class="checkbox" name="choix_periode" value="P5">
							</div>
							<div class="choix">
								<label for="choix_periode">Période 6</label>
								<input type="checkbox" class="checkbox" name="choix_periode" value="P6">
							</div>	
						</div>
					</div>

					<!-- Bouton validation -->
					<div class="boite">
						<input  class="bouton2" type="submit" name="formulaire_edt" id="formulaire_edt" value="Filtrer">
					</div>
				</form>
			</div>

			<hr noshade width="90%" size="3" align="center" color="black">

			<!-- Tri -->

			<div class="trier">
				<h2 class="co">Trier</h2>
				<form method="GET" action="visualisation.php">
					<div class="sort">
						<select class="bouton3" name="choix_tri" type="submit">
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
				</form>
			</div>
		</aside>


		<!-- Tableau -->

		<aside class="tableau">
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
				            <td><?php echo $value['periode'];?></td>
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
		</aside>
	</section>
</body>
</html>
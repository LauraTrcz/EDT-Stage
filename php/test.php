// Instance


<?php

	global $tab;
	global $name_instance;
	global $instance_name;

	if(isset($_GET['filtre_instance'])){
		$filtre_instance = htmlspecialchars($_GET['filtre_instance']);
		
		print_r($tab);
		$data_solutions = $db->query('SELECT * FROM solutions WHERE solver = "'.$tab[$instance_name].'" ORDER BY timestamp_t DESC');
	}
?>

<div class="boite">
	<select class="bouton" name="filtre_instance" type="submit">
		<option disabled selected value> -- Sélectionner -- </option>
		<?php foreach ($dir as $key => $instance) { //retourne une liste
			?>
			<option value="<?php $name_instance = print_r(basename($instance)); ?>"><?php $name_instance = print_r(basename($instance)); ?></option> 
			<!-- Nom du fichier sans le chemin "xml/"" -->
		<?php
		$tab = [$instance_name => "$name_instance"];
		}
		?>
	</select>
</div>
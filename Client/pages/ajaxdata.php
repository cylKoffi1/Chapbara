<?php 
include '../../action/dba.php';

if (isset($_POST['country_id'])) {
	$query = "SELECT * FROM specialite where idMetS=".$_POST['country_id'];
	$result = $bdd->query($query);
	if ($result->rowCount() > 0 ) {
			echo '<option value="">Select specialite</option>';
		 while ($row = $result->fetch()) {
		 	echo '<option value='.$row['idSp'].'>'.$row['nomSp'].'</option>';
		 }
	}else{

		echo '<option value="">Aucune Specialité!</option>';
	}

}


?>
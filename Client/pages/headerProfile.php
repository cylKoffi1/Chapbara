<?php
include('../../action/dba.php');
//Vérifier si l'id de la question est bien passé en paramètre dans l'URL

if(isset($_GET['id']) AND !empty($_GET['id'])){

  $idClient = $_GET['id'];

  //Vérifier si la question existe
  $checkIfQuestionExists = $bdd->prepare('SELECT * FROM client WHERE idCb = ?');
  $checkIfQuestionExists->execute(array($idClient));

  if($checkIfQuestionExists->rowCount() > 0){

      //Récupérer les données de la question
      $clientInfos = $checkIfQuestionExists->fetch();
      if($clientInfos['idCb'] == $_SESSION['id']){
        $photo = $clientInfos['photoCb'];
        $nom = $clientInfos['nomCb'];
        $prenom = $clientInfos['prenomCb'];
        $loginn = $clientInfos['userCb'];
      }}}


?>
      <div class="card-body p-3 card shadow-lg mx-4">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="<?= '../photoC/'.$photo?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                <?php echo $nom.' '.$prenom?>
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
                <?php echo $loginn?>
              </p>
            </div>
          </div>
         
        </div>
      </div>
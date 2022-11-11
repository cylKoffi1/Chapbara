<?php 
include('../../action/dba.php');
session_start();
if (!isset($_SESSION['auth'])) {
  header('Location: ../../connexion.php');
}
$id = $_SESSION['id'];
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
        $nom = $clientInfos['nomCb'];
        $prenom = $clientInfos['prenomCb'];
        $sexe =$clientInfos['sexeCb'];
        $date =$clientInfos['dateCb'];
        $tel = $clientInfos['telCb'];
        $dom = $clientInfos['domCb'];
        $email = $clientInfos['emailCb'];
        $loginn = $clientInfos['userCb'];
        $mdp = $clientInfos['mdpCb'];
        $code = $clientInfos['codeCb'];
        $photo = $clientInfos['photoCb'];
        
      }else{
      }
  }
}

if(isset($_POST['valider'])){
if(!empty($_POST['sexeV']) AND !empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['login']) AND !empty($_POST['date']) AND !empty($_POST['tel']) AND !empty($_POST['email'])){

  //Les données à faire passer dans la requête
  $nomM = htmlspecialchars($_POST['nom']);
  $prenomM = htmlspecialchars($_POST['prenom']);
  $loginM = htmlspecialchars($_POST['login']);
  $dateM = htmlspecialchars($_POST['date']);
  $sexeM = htmlspecialchars($_POST['sexeV']);
  $telM = htmlspecialchars($_POST['tel']);
  $emailM = htmlspecialchars($_POST['email']);

  if(empty($_POST['sexe'])){
  //Modifier les informations de la question qui possède l'id rentré en paramètre dans l'URL
  $editQuestionOnWebsite = $bdd->prepare('UPDATE client SET nomCb = ?, prenomCb = ? , dateCb = ? , telCb = ?, emailCb = ? WHERE idCb = ?');
  $editQuestionOnWebsite->execute(array($nomM, $prenomM, $dateM, $telM, $emailM, $idClient));
  }
  $edit = $bdd->prepare('UPDATE client SET sexeCb = ? WHERE idCb = ?');
  $edit->execute(array($sexeM, $idClient));

  //Redirection vers la page d'affichage des questions de l'utilisateur
  $errorMsg = "Modification effectuée";

}else{
  $errorMsg = "Veuillez compléter tous les champs...";
}
}
if(!isset($_SESSION['id']));
header('Location :index.php');
$id=$_SESSION['id'];
?>
        
        <?php     
          if(!isset($photo)){
            $src = "../../images/noprofil.jpg";
          }else{
            $src = "../photoC/$photo";
          }
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Argon Dashboard 2 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  

  <style>
    select{
  font-family: inherit;
  font-size: 50%;
  margin: 3px 0px;
  display: inline-block;
  padding: 10px 10px;
  box-sizing: border-box;
  border-radius: 5px;
  border: 1px solid lightgrey;
  font-size: 1em;
  font-family:inherit;
  background:white;
}

  </style>
</head>


<body class="g-sidenav-show bg-gray-100">
  <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
    <span class="mask bg-primary opacity-6"></span>
  </div>
  <?php include_once('navbar.php')?>
  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <?php include_once('nav.php')?>
    <!-- End Navbar -->
    <div class="card shadow-lg mx-4 card-profile-bottom">
    <?php include_once('headerProfile.php')?>
    </div>
    <div class="container-fluid py-4">
    
      <div class="row">
      
        <div class="col-md-8">
          <form action="#" method="post">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Votre profile</p>
                <button class="btn btn-primary btn-sm ms-auto">Settings</button>
              </div>
            </div>

            <div class="card-body">
              <form action="" method="post">
                <div class="form-group">
                <?php if(isset($errorMsg)){ echo '<center><h3 style="color: red;">'.$errorMsg.'</h3></center>'; } ?>

                  <p class="text-uppercase text-sm">Information client</p>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Nom</label>
                        <input class="form-control" name="nom" value="<?= $nom ?>" type="text" >
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Prenom </label>
                        <input class="form-control" type="text" name="prenom" value="<?= $prenom ?>" placeholder="cyl ">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">utilisateur</label>
                        <input class="form-control" name="login" value="<?= $loginn ?>" type="tel" placeholder="cyl koffi">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="form-control">
                        
                        <label for="example-text-input" class="form-control-label">Sexe </label>
                        
                          <div class="form-check">
                            <input class="form-check-input" type="radio" value="Homme" id="inlineRadio1" name="sexeV">
                            <label class="form-check-label"  for="example-text-input">Homme</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" value="Femme" id="inlineRadio2" name="sexeV">
                            <label class="form-check-label"  for="example-text-input">Femme</label>
                          </div>
                          
                          <label class="form-check-label" for="example-text-input">Vous êtes<?php if( $sexe =="Homme"){echo " un ".$sexe;}elseif($sexe =="Femme"){echo " une ".$sexe;}else{echo " ... ";}?></label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="form-control">
                        <label for="example-text-input" class="form-control-label">Date de naissance</label><br>
                        <center>
                          <span>
                            <input class="form-control mb-2 col-md-2" value="<?= $date?>" type="date" name="date" id="">
                          </span>
                        
                        </center>
                      
                      </div>
                    </div>
                  </div>
                  <p class="text-uppercase text-sm">Adresse Client</p>
                  <div class="row">
                    
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Téléphone</label>
                        <input class="form-control" name="tel" value="<?= $tel ?>" type="tel" placeholder="0103204629">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Domicile</label>
                        <input class="form-control" name="dom" value="<?= $dom ?>" type="text" placeholder="Port bouet">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Email</label>
                        <input class="form-control" name="email" value="<?= $email ?>" type="email" placeholder="cylkoffi@gmail.com">
                      </div>
                    </div>
                  </div>                  
                  <center><button type="submit" name="valider" class="btn btn-danger btn-sm w-30 mb-3">MODIFIER</button></center>
                </div>
              </form>

              <hr class="horizontal dark">
              <hr class="horizontal dark">
              <p class="text-uppercase text-sm">Changer votre mot de passe</p>
<?php 

if(isset($_POST['valide'])){

  //Vérifier si les champs sont remplis

      //Les données à faire passer dans la requête
      $mdp1 = htmlspecialchars($_POST['mdp1']);
      $mdp2 = htmlspecialchars($_POST['mdp2']);
      if(($mdp1 == $clientInfos['mdpCb'])){
      //Modifier les informations de la question qui possède l'id rentrée en paramètre dans l'URL
      $editQuestionOnWebsite = $bdd->prepare('UPDATE client SET mdpCb = ? WHERE idCb = ?');
      $editQuestionOnWebsite->execute(array($mdp2,$id));
      $php_errormsg = "Mot de passe modifié";
      }else{
        $php_errormsg = "Ancien mot de passe incorrect";
      }


}     
?>
              <form method="post">
              <?php if(isset($php_errormsg)){ echo '<center><h3 style="color: red;">'.$php_errormsg.'</h3></center>'; } ?>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Mot de passe actuel</label>
                      <input class="form-control" name="mdp1" type="password" >
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Nouveau mot de passe </label>
                      <input class="form-control" name="mdp2" type="password" >
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Code</label>
                      <input class="form-control" value="<?= $code?>" type="text"  readonly>
                    </div>
                  </div>
                  
                  <center><button type="submit" name="valide" class="btn btn-danger btn-sm w-30 mb-3">MODIFIER</button></center>
                </div>
              </form>
            </div>
          </div>
        </form>
        </div>
        <?php
          if(isset($_POST['validePho'])){
           
              //Les données à faire passer dans la requête
              $photo_C = $_FILES['image']['name'];
              $upload_C = "../photoC/".$photo_C;
              move_uploaded_file($_FILES['image']['tmp_name'],$upload_C);
              
              //Modifier les informations de la question qui possède l'id rentrée en paramètre dans l'URL
              $editQuestionOnWebsite = $bdd->prepare("UPDATE `client` SET `photoCb`='$photo_C'  WHERE `idCb`=?");
              $editQuestionOnWebsite->execute(array($id));

              $php_errorms = "photo modifiée";
            
          }else{
            $php_errorms = "Erreur...";
          }
        ?>

        <div class="col-md-4">
        <form method="post" enctype="multipart/form-data">
        <?php if(!isset($php_errorms)){ echo '<center><h3 style="color: red;">'.$php_errorms.'</h3></center>'; } ?>
          <div class="card card-profile">
            
            <img src="../assets/img/bg-profile.jpg" alt="Image placeholder" class="card-img-top">
            
            <div class="row justify-content-center">
            

                <div class="col-4 col-lg-4 order-lg-2">
                  <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                    <a href="javascript:;">
                      <div class="wrapper" >
                        <div class="profile-pic-div">
                          <img src="<?= $src ?>" id="photo" class="rounded-circle img-fluid border border-20 border-dark">
                          <input type="file" id="file"  accept="jpg, png, jpeg" class="my_file"  name="image">
                          <label for="file" id="uploadBtn">Modifier photo</label>
                          
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
            </div><center><button type="submit" name="validePho" class="btn btn-danger btn-sm w-50 mb-1">MODIFIER</button></center>

            
            <script>
              //declearing html elements

              const imgDiv = document.querySelector('.profile-pic-div');
              const img = document.querySelector('#photo');
              const file = document.querySelector('#file');
              const uploadBtn = document.querySelector('#uploadBtn');

              //if user hover on img div 

              imgDiv.addEventListener('mouseenter', function(){
                  uploadBtn.style.display = "block";
              });

              //if we hover out from img div

              imgDiv.addEventListener('mouseleave', function(){
                  uploadBtn.style.display = "none";
              });

              //lets work for image showing functionality when we choose an image to upload

              //when we choose a foto to upload

              file.addEventListener('change', function(){
                  //this refers to file
                  const choosedFile = this.files[0];

                  if (choosedFile) {

                      const reader = new FileReader(); //FileReader is a predefined function of JS

                      reader.addEventListener('load', function(){
                          img.setAttribute('src', reader.result);
                      });

                      reader.readAsDataURL(choosedFile);

                      //Allright is done

                      //please like the video
                      //comment if have any issue related to vide & also rate my work in comment section

                      //And aslo please subscribe for more tutorial like this

                      //thanks for watching
                  }
              });
            </script>
            
            <style>
                            
              .wrapper{
                height: 170px;
                width: 170px;
                position: relative;
                border: 4px solid #fff;
                border-radius: 50px;
                background-size: 100% 100%;
                transform: translate(-20%,-10%);
                overflow: hidden;
              }


              .profile-pic-div{
                height: 200px;
                width: 200px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%,-50%);
                border-radius: 50%;
                overflow: hidden;
                border: 1px solid grey;
              }

              #photo{
                height: 100%;
                width: 100%;
              }

              #file{
                display: none;
              }

              #uploadBtn{
                height: 70px;
                width: 100%;
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                text-align: center;
                background: rgba(0, 0, 0, 0.7);
                color: wheat;
                line-height: 30px;
                font-family: sans-serif;
                font-size: 15px;
                cursor: pointer;
                display: none;
              }

              .cont{
                display: flex;
                margin-left: 10%;
              } 
              .left{
                flex-grow: 0;
                transform: translate(-20%,-20%);
              }

            </style>
            
          </div>
          </form>
        </div>
        </form>
      </div>
      <footer class="footer pt-3  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                Crée <i class="fa fa-heart"></i>par
                <a href="#" class="font-weight-bold" target="_blank">4!techno</a>
                
              </div>
            </div>
            
          </div>
        </div>
      </footer>
    
    
    
    </div>
  </div>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="fa fa-cog py-2"> </i>
    </a>
    
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
  </body>

</html>
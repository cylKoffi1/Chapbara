<?php 
session_start();
include('action/dba.php');

//validation du formulaire 
if(isset($_POST['ok'])){
  //les données du client
  $userC = htmlspecialchars($_POST['nom']);
  $mdpC = htmlspecialchars($_POST['mdp']);

  //les données de l'adherant
  $userA = htmlspecialchars($_POST['nom']);
  $mdpA = htmlspecialchars($_POST['mdp']);

  //les données de l'admin
  $user = htmlspecialchars($_POST['nom']);
  $mdp = htmlspecialchars($_POST['mdp']);

  //Vérifier si les données entrée existe dans la base de donnée
  $verifieC = $bdd->prepare(('SELECT * FROM client WHERE userCb = ?'));
  $verifieC->execute(array($userC));

  $verifieA = $bdd->prepare(('SELECT * FROM adh WHERE userAd = ?'));
  $verifieA->execute(array($userA));

  $verifie = $bdd->prepare(('SELECT * FROM admin WHERE userAm = ?'));
  $verifie->execute(array($user));

  if(  $verifieC->rowCount() > 0 or $verifieA->rowCount() > 0 or $verifie->rowCount() > 0){
    //recuperer les données 
    //client 
    $usersInfos = $verifieC->fetch();
    

     //adherant
     $infosA = $verifieA->fetch();

      //admin
    $infos = $verifie->fetch();

    //verifie mot de passe client 
    if(($mdpC== $usersInfos['mdpCb'])){
      //Authentifier le client sur le site et récupérer ses données dans des variables globales sessions
      $_SESSION['auth'] = true;
      $_SESSION['id'] = $usersInfos['idCb'];
      $_SESSION['nomC'] = $usersInfos['nomCb'];
      $_SESSION['prenomC'] = $usersInfos['prenomCb'];
      $_SESSION['loginC'] = $usersInfos['userCb'];
      $_SESSION['dateC'] =$usersInfos['dateCb'];
      $_SESSION['telC'] =$usersInfos['telCb'];
      $_SESSION['domC'] =$usersInfos['domCb'];
      $_SESSION['emailC'] =$usersInfos['emailCb'];
      $_SESSION['codeC'] =$usersInfos['codeCb'];
      $_SESSION['sexeC'] =$usersInfos['sexeCb'];
      $_SESSION['photo'] =$usersInfos['photoCb'];
      $id = $_SESSION['id'];
      header("Location: Client/pages/demande.php?id=$id");



      //verifie le mdp de l'adh
    }elseif(($mdpA == $infosA['mdpAd'])){
      //Authentifier le client sur le site et récupérer ses données dans des variables globales sessions
      $_SESSION['auth'] = true;
      $_SESSION['idA'] = $infosA['idAd'];
      $_SESSION['nomA'] = $infosA['nomAd'];
      $_SESSION['prenomA'] = $infosA['prenomAd'];
      $_SESSION['loginA'] = $infosA['userAd'];
      $_SESSION['special']= $infosA['speAd'];
      $idA = $_SESSION['idA'];
      //Rediriger le client sur la page client 
      header("Location: Adherant/pages/demandeA.php?id=$idA");

    }elseif(($mdp == $infos['mdpAm'])){
      //Authentifier le client sur le site et récupérer ses données dans des variables globales sessions
      $_SESSION['auth'] = true;
      $_SESSION['idm'] = $infos['idAm'];
      $_SESSION['nom'] = $infos['nomAm'];
      $_SESSION['prenom'] = $infos['prenomAm'];
      $_SESSION['login'] = $infos['userAm'];
      
      $idm = $_SESSION['idm'];
      //Rediriger le client sur la page client 
      header("Location: admin/pages/demandeA.php?id=$idm");
    }
  }else{
    header('Location: connexion.php?reg_err=erre');
}

}else{
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="include/css/navbar.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/css/connexion.css">
 <!-- <title> Responsive Drop Down Navigation Menu | CodingLab </title>-->
 <link rel="stylesheet" href="css/navbar.css">
 <!-- Boxicons CDN Link -->
 <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <header>
        <!--<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script> 
        $(function(){
          $("#inclusion").load("include/navbar.html"); 
        });
    
        </script> 
         <div id="inclusion"></div>-->
         <link rel="stylesheet" href="style.css">
    
         <nav>
            <div class="navbar">
              <i class='bx bx-menu'></i>
              <div class="logo"><i class="fas fa-atom"></i><a href="#">ChapBara</a></div>
              <div class="nav-links">
                <div class="sidebar-logo">
                  <span class="logo-name">ChapBara</span>
                  <i class='bx bx-x' ></i>
                </div>
                <ul class="links">
                  <li><a href="index.php">ACCUEIL</a></li>
                  <li><a href="connexion.php">CONNEXION</a></li>
                  <li>
                    <a href="#">INSCRIPTION</a>
                    <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
                    <ul class="htmlCss-sub-menu sub-menu">
                      <li><a href="inscriptionA.php">CLIENT</a></li>
                      <li><a href="inscriptionAdhe.php">ADHERENT</a></li>
                      
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="search-box">
                <i class='bx bx-search'></i>
                <div class="input-box">
                  <input type="text" placeholder="Search...">
                </div>
              </div>
            </div>
          </nav>
          <script src="include/css/navbar.js"></script>
      </header>
      <h2 style="color: red;">
    <?php 
      if(isset($_GET['reg_err'])){
        $err = htmlspecialchars($_GET['reg_err']);

        switch($err){
          
          case 'erre':
            ?>
            <div class="alert alert-danger">
              <strong>Erreur:</strong> Erreur de connexion 
            </div>
            <?php
          break;
        }
      }
    ?>
    </h2>
      
    <form id="login"   method="post" enctype="multipart/form-data">
    
      <center>
        <h1 id="ff-proof" class="ribbon">Connexion &nbsp;&nbsp;</h1>
        <div class="apple">
          <div class="top"><span></span></div>
          <div class="butt"><span></span></div>
            <div class="bite"></div>
        </div>
        <fieldset id="inputs">
            <input id="username" type="text" name="nom" placeholder="Pseudo ID" />
            <input id="password" type="password" name="mdp" placeholder="Mot de passe" />
        </fieldset>
        <fieldset id="actions">
            <input type="submit" name="ok" id="submit" value="connexion"/>
           <p class="option"><a href="inscriptionA.php">Inscription</a></p>
        </fieldset>
      </center>
      <br><br>      
    </form>
</body>
</html>


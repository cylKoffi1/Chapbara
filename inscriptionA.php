<?php
$nomServeur = "localhost";
$username = "root";
$password ="";
$dbname ="chapbara";

//creer connexion 
$bdd= new PDO("mysql:host=$nomServeur;dbname=$dbname;charset=utf8",$username,$password);
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
if(isset($_POST['validate'])){

$jourC =$_POST['day'];
$mois =$_POST['month'];
$année = $_POST['year'];
$aujourdhui = ($année.'-'.$mois.'-'.$jourC);
$nom = htmlspecialchars($_POST['nomC']);
$prenom = htmlspecialchars($_POST['prenomC']);
$sexe = htmlspecialchars( $_POST['sexe']);
$tel = htmlspecialchars($_POST['telC']);
$dom = htmlspecialchars($_POST['domC']);
$email = $_POST['emailC'];
$date = $aujourdhui;
$login = htmlspecialchars($_POST['loginC']);
$mdp = $_POST['mdpC'];
$mdp1 =$_POST['mdpC1'];
$code=htmlspecialchars($_POST['code']);

  $photo_C = $_FILES['imageC']['name'];
  $upload_C = "Client/photoC/".$photo_C;
  move_uploaded_file($_FILES['imageC']['tmp_name'],$upload_C);

        
        if($mdp == $mdp1){
         

        //Vérifier si l'utilisateur existe déjà sur le site
        $checkIfUserAlreadyExists = $bdd->prepare('SELECT userCb FROM client WHERE userCb = ?');
        $checkIfUserAlreadyExists->execute(array($login));

        if($checkIfUserAlreadyExists->rowCount() == 0){

          
            //Insérer l'utilisateur dans la bdd
            $insertUserOnWebsite = $bdd->prepare("INSERT INTO `client`(`nomCb`, `prenomCb`, `dateCb`, `sexeCb`, `telCb`, `domCb`, `emailCb`, `userCb`, `mdpCb`, `codeCb`, photoCb) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $insertUserOnWebsite->execute(array(
                $nom,$prenom,$date,$sexe,$tel,$dom,$email,$login,$mdp,$code,$photo_C));
              
                
                //Récupérer les informations de l'utilisateur
            $getInfosOfThisUserReq = $bdd->prepare('SELECT idCb, userCb, nomCb, prenomCb FROM client WHERE userCb=? AND nomCb = ? AND prenomCb = ? ');
            $getInfosOfThisUserReq->execute(array($login,$nom,$prenom));

            $usersInfos = $getInfosOfThisUserReq->fetch();

            //Authentifier l'utilisateur sur le site et récupérer ses données dans des variables globales sessions
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $usersInfos['idCb'];
            $_SESSION['nom'] = $usersInfos['nomCb'];
            $_SESSION['prenom'] = $usersInfos['prenomCb'];
            $_SESSION['user'] = $usersInfos['userCb'];

            //Rediriger l'utilisateur vers la page d'accueil
            header('Location: inscriptionA.php?reg_err=success');

        }else{
          header('Location: inscriptionA.php?reg_err=existe');
        }

      }else{
        header('Location: inscriptionA.php?reg_err=mot_de_passe');
    }
 
  }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title>Inscription</title>
  <link rel="stylesheet" href="asset/css/inscriptionA.css">
  <link rel="stylesheet" href="include/css/navbar.css" >
  <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <!--<title> Responsiive Admin Dashboard | CodingLab </title>-->

  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script type="text/javascript" src="asset/js/insciptionA.js"></script>
</head>

<body>
  <header>

 <nav>
      <div class="navbar">
        <i class='bx bx-menu'></i>
        <div class="logo"><i class="fas fa-atom"></i><a href="#">ChapBara</a></div>
        <div class="nav-links">
          <div class="sidebar-logo"><i class="fas fa-atom"></i>
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
  <br><br>
  
  
  
    <div id="svg_wrap"></div>

    <h1>Inscription Client</h1>
    <h2 style="color: red;">
    <?php 
      if(isset($_GET['reg_err'])){
        $err = htmlspecialchars($_GET['reg_err']);

        switch($err){
          
          case 'success':
            ?>
            <div class="alert alert-danger">
              <strong>Succes:</strong> Enregistrement effectué 
            </div>
            <?php
          break;

          case 'mot_de_passe':
            ?>
            <div class="alert alert-danger">
              <strong>Erreur:</strong> mot de passe incorrect
            </div>
            <?php
          break;

          case 'photo':
            ?>
            <div class="alert alert-danger">
              <strong>Erreur:</strong>Photo est déjà utiisée par un utilisateur
            </div>
            <?php
          break;

          case 'email':
            ?>
            <div class="alert alert-danger">
              <strong>Erreur:</strong> email incorrect
            </div>
            <?php
          break;

          case 'already':
            ?>
            <div class="alert alert-danger">
              <strong>Erreur:</strong> compte non existant
            </div>
            <?php
          break;
          
          case 'existe':
            ?>
            <div class="alert alert-danger">
              <strong>Erreur:</strong> compte non existant
            </div>
            <?php
          break;
        }
      }
    ?>
    </h2>

      
    <form method="post"  enctype="multipart/form-data">
      <section>
        <center><h2>Infos Client</h2></center>
          <div class="cont">
            <div class="left"><br><br>
            
              <div class="wrapper" >
                <div class="profile-pic-div">
                  <img src="images/noprofil.jpg" id="photo">
                  <input type="file" id="file" value="" accept="jpg, png, jpeg" class="my_file" name="imageC" required="required">
                  <label for="file" id="uploadBtn">Choisir une photo</label>
                </div>
              </div>

            </div>
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
            
              <div class="droit">
                
                  <label class="nom" id="nom">Nom </label>
                  <input type="text" required="required" name="nomC" id="nom"  >
               
                  <label class="nom" id="nom">Prenom </label>
                  <input type="text" required="required" name="prenomC" id="nom" >
                
              </div>
          </div>

                
                  <label for="nom">Date de naissance </label><br>
                  <span>
                    <label for="day">Jour:</label>
                    <select name="day" id="day"></select>
                  </span>
                  <span>
                    <label for="month">Mois:</label>
                    <select name="month" id="month">
                      <option value="1">Janvier</option>
                      <option value="2">Février</option>
                      <option value="3">Mars</option>
                      <option value="4">Avril</option>
                      <option value="5">Mai</option>
                      <option value="6">Juin</option>
                      <option value="7">Juillet</option>
                      <option value="8">Août</option>
                      <option value="9">Septembre</option>
                      <option value="10">Octobre</option>
                      <option value="11">Novembre</option>
                      <option value="12">Decembre</option>
                    </select>
                  </span>
                  <span>
                    <label for="year">Année:</label>
                    <select name="year" id="year">Year:</select>
                  </span> 
               <br>
                  <label for="nom">Sexe </label><br>
                  <div class="form-check">
                    <input class="form-check-input" type="radio"  id="inlineRadio1" value="Homme" name="sexe">
                    <label class="form-check-label" for="inlineRadio1">Homme</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio"  id="inlineRadio2" value="Femme" name="sexe">
                    <label class="form-check-label" for="inlineRadio2">Femme</label>
                  </div>
                  
              
        
      
      </section>
      <section>
     
        <center><h2>Adresse Client</h2></center>
         
              <label for="nom" class="nom">Telephone </label>
              <input type="text" required="required" id="telephone" name="telC" >
           
              <label for="nom" class="nom">Domicile</label>
              <input type="text" required="required" id="nom" name="domC">
            
              <label for="nom" class="nom">Email </label>
              <input type="email" required="required" id="nom" name="emailC"  >
            <br><br>
      
      </section>
      <?php
date_default_timezone_set('Europe/Paris');
      $dateAndTime = date('dimy ', time());

      $req =$bdd->query('SELECT * FROM client ORDER BY idCb DESC LIMIT 1');
      $dernier_client = $req->fetch();
      $req->closeCursor();
      $incremente = "Client_$dateAndTime.1";

      if(!empty($dernier_client)){
        $part = explode('_',$dernier_client['idCb']);
        $incremente = "Client".'_'.$dateAndTime.(int)$part[0]+= 1;
      }

      
      
    ?>   
      <section>
        <center><h2>Infos Connexion</h2></center><br>
          
              <label class="nom">utilisateur </label>
              <input type="text" required="required" id="nom" name="loginC" >
           
              <label for="nom" class="nom">Mot_de_passe</label>
              <input type="password" required="required" id="nom" name="mdpC"  >
           
              <label for="nom" class="nom">Confirmer_mot_de_passe </label>
              <input type="password" required="required" name="mdpC1" id="nom" >
           
              <label for="nom" class="nom"  >Votre_Code </label>
              <input type="url" required="required" name="code" id="nom" value="<?php echo $incremente ?>" readonly >
             
              <button type="submit" name="validate" class="button">Enregistrer</button>  
      </section>
      
    
    </form>
    <div class="button" id="prev">&larr; Retour</div>
    <div class="button" id="next">Suivant &rarr;</div>
      
</body>
</html>
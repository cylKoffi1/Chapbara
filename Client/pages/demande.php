<?php
include('../../action/dba.php');
include('../../map/config.php');
session_start();
if (!isset($_SESSION['auth'])) {
  header('Location: ../../connexion.php');
}
$id = $_SESSION['id'];
if(isset($_POST['validate'])){
  $long = htmlspecialchars($_POST['longitude']);
  $lap = htmlspecialchars($_POST['latitude']);
  $metier = htmlspecialchars($_POST['country']);
  $special = htmlspecialchars($_POST['state']);
  $motif = nl2br(htmlspecialchars($_POST['motif']));
  $grade = htmlspecialchars($_POST['SelectGr']);
  $dateD = htmlspecialchars($_POST['dateD']);
  $heureD = htmlspecialchars($_POST['heureD']);
  $demande_id_author = $_SESSION['id'];
  $demande_pseudo_author = $_SESSION['loginC'];
  $codeD = htmlspecialchars($_POST['codeD']);

  $insertUserOnWebsite = $bdd->prepare("INSERT INTO `demande`(`long`, `lap`, `idCb`, `userCb`, `motif`, `idSpecialite`, `idMetier`, `idGrade`, `date`, `heure`,`codeD`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
  $insertUserOnWebsite->execute(array(
    $long, $lap, $demande_id_author, $demande_pseudo_author, $motif, $special, $metier, $grade, $dateD, $heureD, $codeD
  ));

  header("Location: demande.php?id=$id&reg_err=success");
}







?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="../../map/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <title>
    Page Client
  </title>
  <!--     Fonts and icons     --><!--cléd'activation map AIzaSyBZqyYBihfsNPxj8FbbQ9D2hEDankJm66w   AIzaSyBD0I-sYMHILFOBzO9De7SNu7aYvbznJP0-->
  <script defer src="https://maps.googleapis.com/maps/api/js?libraries=places&language=<?= $_SESSION['lang'] ?>&key=AIzaSyBZqyYBihfsNPxj8FbbQ9D2hEDankJm66w" type="text/javascript"></script>
  <script type="text/javascript" src="geo.js?id=<?php echo time(); ?>"></script>

  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZqyYBihfsNPxj8FbbQ9D2hEDankJm66w&callback=loadMap"></script>
  <script>
      function showPosition() {
          if(navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(showMap, showError);
          } else {
              alert("Sorry, your browser does not support HTML5 geolocation.");
          }
      }
      
      // Define callback function for successful attempt
      function showMap(position) {
          // Get location data
          lat = position.coords.latitude;
          long = position.coords.longitude;
          var latlong = new google.maps.LatLng(lat, long);
          
          var myOptions = {
              center: latlong,
              zoom: 16,
              mapTypeControl: true,
              navigationControlOptions: {
                  style:google.maps.NavigationControlStyle.SMALL
              }
          }
              document.querySelector();
          var map = new google.maps.Map(document.getElementById("embedMap"), myOptions);
          var marker = new google.maps.Marker({ position:latlong, map:map, title:"Vous êtes ici!" });
      }
      
      // Define callback function for failed attempt
      function showError(error) {
          if(error.code == 1) {
              result.innerHTML = "Vous avez décidé de ne pas partager votre position, mais ce n'est pas grave. Nous ne vous le demanderons pas à nouveau.";
          } else if(error.code == 2) {
              result.innerHTML = "Le réseau est en panne ou le service de positionnement n'est pas joignable.";
          } else if(error.code == 3) {
              result.innerHTML = "La tentative s'est arrêtée avant d'avoir pu obtenir les données de localisation.";
          } else {
              result.innerHTML = "La géolocalisation a échoué en raison d'une erreur inconnue.";
          }
      }
  </script>
</head>

<body class="g-sidenav-show   bg-gray-100" onload="getLocal();">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <?php include_once('navbar.php') ?>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <?php include_once('nav.php') ?>
    <!-- End Navbar -->

    <?php include_once('headerProfile.php') ?>
    <div class="container-fluid py-4">

    <form  method="post" class="myForm" autocomplete="off" enctype="multipart/form-data">
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
          case 'err':
            ?>
            <div class="alert alert-danger">
              <strong>Erreur:</strong> Le reseau est en panne 
            </div>
            <?php
          break;
        }
      }
    ?>
    </h2>
        <div class="row mt-4">
          <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-100">
              <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">Localisation</h6>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZqyYBihfsNPxj8FbbQ9D2hEDankJm66w&callback=loadMap"></script>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <button class="btn btn btn-lg" style="background-color: #E6E6E6;" type="button" onclick="showPosition();">Votre position</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group"><label>Origine: </label>
                                <input class="form-control" id="from_places" placeholder="Entrer la position"/>
                                <input id="origin" name="origin"  type="hidden"/>
                                <input type="hidden" name="latitude" >
                                <input type="hidden" name="longitude" >
                            </div>
                        </div>

                    </div>
                </div>
                
                <div id="embedMap" style="width: 100%; height: 300px;">
                    <!--Google map will be embedded here-->
                </div>
                <div id="result">
                    <!--Position information will be inserted here-->
                </div>
              </div>

            </div>
          </div>
          
    
        </div>
        <div class="row mt-4">
          <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card ">
              <div class="card-header pb-0 p-3">
                <div class="d-flex justify-content-between">
                  <h6 class="mb-2">Infos de la demande</h6>
                </div>
              </div>
              <div class="card-body">
                
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Motif</label>
                      <textarea name="motif" required="required" class="form-control" cols="20" rows="10"></textarea>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Metier</label>
                        <select name="country" required="required" id="country" class="form-control" onchange="FetchState(this.value)"  required>
                        <option>Select metier</option>  
                          <?php
                          $result = $bdd->query("SELECT * FROM metier");
                        if ($result->rowCount() > 0 ) {
                          while ($row = $result->fetch()) {
                            echo '<option value='.$row['idMet'].'>'.$row['nomMet'].'</option>';
                          }
                        }
                      ?> 
                        </select>
                        
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Specialité</label>
                      <select name="state" id="state" class="form-control" onchange="FetchCity(this.value)"  required>
                        <option>Select specialite</option>  
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Grade</label>
                      <select name="SelectGr" required="required" id="" class="form-control">
                        <option value="1">Debutant</option>
                        <option value="2">Intermediaire</option>
                        <option value="3">Expert</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Date</label>
                      <input type="date" required="required" name="dateD" class="form-control" id="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Heure</label>
                      <input type="time" required="required" name="heureD" class="form-control" id="">
                    </div>
                  </div>
                  <?php
                    date_default_timezone_set('Europe/Paris');
                    $dateAndTime = date('yidm ', time());

                    $req =$bdd->query('SELECT * FROM adh INNER JOIN demande ORDER BY idAd AND idDem DESC LIMIT 1');
                    $dernier_client = $req->fetch();
                    $req->closeCursor();
                    $incremente = "dem$dateAndTime.1";

                    if(!empty($dernier_client)){
                      $part = explode('_',$dernier_client['idAd'].$dernier_client['idDem']);
                      $incremente = "dem".'_'.$dateAndTime.(int)$part[0]+=1;
                    }
                  ?> 
                  <input type="hidden" value="<?php echo $incremente ?>" name="codeD">
                </div>
              </div>
              <center><button name="validate" class="btn btn-danger btn-sm w-50 mb-3">ENVOYER</button></center>
            </div>
          </div>
          <div class="col-lg-5">
          <div class="card">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">Accessibilité</h6>
            </div>
            <div class="card-body p-3">
              <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Adherent</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Specialité</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Statut</th>
                      </tr>
                    </thead>
                    <tbody>

                    <?php 
                      $requtte =$bdd->query('SELECT * FROM adh INNER JOIN specialite ON adh.speAd = specialite.idSp ');
                      if($requtte->rowCount()>0){
                        while($aff = $requtte->fetch()){
                    ?>
                      <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div>
                              <img src="../../Adherant/photoA/<?= $aff['photoAd']?>" class="avatar avatar-sm me-3" alt="user1">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm"><?= $aff['nomAd']?></h6>
                              <p class="text-xs text-secondary mb-0"><?= $aff['emailAd']?></p>
                            </div>
                          </div>
                        </td>

                        <td class="align-middle text-center text-sm">
                          <span><?= $aff['nomSp']?></span>
                        </td>

                        <td class="align-middle text-center text-sm">
                          <span class="badge badge-sm bg-gradient-success">En ligne</span>
                        </td>

                      </tr>
                      <?php }} ?>
                     
                  
                    </tbody>
                  </table>

                </div>
              </div>

            </div>
          </div>
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
    </form>
    
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="fa fa-cog py-2"> </i>
    </a>

  </div>

<script type="text/javascript">
  function FetchState(id){
    $('#state').html('');
    $('#city').html('<option>Select City</option>');
    $.ajax({
      type:'post',
      url: 'ajaxdata.php',
      data : { country_id : id},
      success : function(data){
         $('#state').html(data);
      }

    })
  }

  function FetchCity(id){ 
    $('#city').html('');
    $.ajax({
      type:'post',
      url: 'ajaxdata.php',
      data : { state_id : id},
      success : function(data){
         $('#city').html(data);
      }

    })
  }
</script>

  <script type="text/javascript">
    function getLocal(){
      if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showPositio, showErro);
      }
    }
    function showPositio(positio){
      document.querySelector('.myForm input[name = "latitude"]').value = positio.coords.latitude;
      document.querySelector('.myForm input[name = "longitude"]').value = positio.coords.longitude;

    }
    function showErro(error) {
        if(error.code == 1) {
            result.innerHTML = "Vous avez décidé de ne pas partager votre position, mais ce n'est pas grave. Nous ne vous le demanderons pas à nouveau.";
        } else if(error.code == 2) {
            result.innerHTML = "Le réseau est en panne ou le service de positionnement n'est pas joignable.";
        } else if(error.code == 3) {
            result.innerHTML = "La tentative s'est arrêtée avant d'avoir pu obtenir les données de localisation.";
        } else {
            result.innerHTML = "La géolocalisation a échoué en raison d'une erreur inconnue.";
        }
      }
  </script>
  <script>
    function showPosition() {
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showMap, showError);
        } else {
            alert("Sorry, your browser does not support HTML5 geolocation.");
        }
    }
    
    // Define callback function for successful attempt
    function showMap(position) {
        // Get location data
      document.querySelector('.myForm input[name = "latitude"]').value = position.coords.latitude;
    document.querySelector('.myForm input[name = "longitude"]').value = position.coords.longitude;

        lat = position.coords.latitude;
        long = position.coords.longitude;
        var latlong = new google.maps.LatLng(lat, long);
        
        var myOptions = {
            center: latlong,
            zoom: 16,
            mapTypeControl: true,
            navigationControlOptions: {
                style:google.maps.NavigationControlStyle.SMALL
            }
        }
            
        var map = new google.maps.Map(document.getElementById("embedMap"), myOptions);
        var marker = new google.maps.Marker({ position:latlong, map:map, title:"Vous êtes ici!" });
            
      }
    
    
    // Define callback function for failed attempt
    function showError(error) {
      if(error.code == 1) {
          result.innerHTML = "Vous avez décidé de ne pas partager votre position, mais ce n'est pas grave. Nous ne vous le demanderons pas à nouveau.";
      } else if(error.code == 2) {
          result.innerHTML = "Le réseau est en panne ou le service de positionnement n'est pas joignable.";
      } else if(error.code == 3) {
          result.innerHTML = "La tentative s'est arrêtée avant d'avoir pu obtenir les données de localisation.";
      } else {
          result.innerHTML = "La géolocalisation a échoué en raison d'une erreur inconnue.";
      }
    }
  </script>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Mobile apps",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
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
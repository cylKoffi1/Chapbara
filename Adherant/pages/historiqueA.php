<?php
include('../../action/dba.php');
session_start();
if(!isset($_SESSION['auth'])){
    header('Location: ../../connexion.php');
}
$idA = $_SESSION['idA']
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
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
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <?php include_once('navbar.php')?>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <?php include_once('nav.php')?>
    <!-- End Navbar -->
    
  <?php include_once('headerProfile.php')?>

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-6">
              <h6>HISTORIQUE DE DEMANDES </h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
              <style>
                td span {
                    display: block;
                    overflow: hidden;
                }
                  table td {
                      text-shadow: 0 1px 0 #fff;
                      vertical-align: middle;
                  }

                  table {
                      width: 100%;
                      margin-bottom: 1rem;
                      color: #444;
                  }
                  table {
                      border-collapse: collapse;
                  }
                  table {
                      border-collapse: separate;
                      text-indent: initial;
                      border-spacing: 2px;
                  }
                  style attribut {
                      margin-bottom: 21.4375px;
                      margin-left: 240px;
                      padding-top: 59.5625px;
                      cursor: inherit;
                  }
              </style>
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Client</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Motif</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Heure</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $req = $bdd->prepare('SELECT * FROM adh WHERE idAd = ? ');
                    $req->execute(array($_SESSION['idA']));
                    if($req->rowCount()>0){
                      while($aff = $req->fetch()){
                    ?>
                  <?php 
                       $requtte =$bdd->prepare('SELECT * from client INNER JOIN demande ON client.idCb = demande.idCb AND demande.idSpecialite = ? ORDER BY idDem DESC');
                       $requtte->execute(array($aff['speAd']));
                       if($requtte->rowCount()>0){
                         while($affi = $requtte->fetch()){
                        ?>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../../Client/photoC/<?= $affi['photoCb']?>" class="avatar avatar-sm me-3" alt="user1">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?= $affi['nomCb']?> </h6>
                            <p class="text-xs text-secondary mb-0"><?= $affi['emailCb']?></p>
                          </div>
                        </div>
                      </td>
                      <td data-decimals="0" data-type="blob" data-originallength="247" class="data grid_edit click2 not_null    pre_wrap truncated">
                        <p   class="text-xs font-weight-bold mb-0"><?= $affi['motif']?></p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <p class="badge badge-sm bg-gradient-success"><?= $affi['heure']?></p>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold"><?= $affi['date']?></span>
                      </td>
                      <td class="align-middle">
                       
                      </td>
                    </tr>
                    <?php }} ?>
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
  </main>
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
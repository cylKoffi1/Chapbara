<?php
include('../../action/dba.php');
include('../../securite.php');


$getAllMyQuestions = $bdd->prepare('SELECT * FROM demande WHERE idCb = ? ORDER BY idDem DESC');
$getAllMyQuestions->execute(array($_SESSION['id']));


if(!isset($_SESSION['auth'])){
    header('Location: ../../connexion.php');
}
$id = $_SESSION['id']
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
            <div class="card-header pb-0">
              <h6>Historique des demandes</h6>
            </div>
    <!--  <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Modifier Votre demande </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="updatecode.php" method="POST">

                    <div class="modal-body">
                    
                        <input type="hidden" name="update_id" id="update_id">

                        <div class="form-group">
                            <label> Date  </label>
                            <input type="date" name="date" id="date" class="form-control">
                        </div>

                        <div class="form-group">
                            <label> Heure </label>
                            <input type="time" name="lname" id="lname" class="form-control">
                           
                        </div>

                        <div class="form-group">
                            <label> Metier </label>
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

                        <div class="form-group">
                            <label> Specialité </label>
                            <select name="state" id="state" class="form-control" onchange="FetchCity(this.value)"  required>
                        <option>Select specialite</option>  
                      </select>
                        </div>
                        <div class="form-group">
                            <label> Grade </label>
                            <select name="SelectGr" required="required" id="" class="form-control">
                        <option value="1">Debutant</option>
                        <option value="2">Intermediaire</option>
                        <option value="3">Expert</option>
                      </select>
                        </div>
                        <div class="form-group">
                            <label> Votre motif </label>
                            <textarea name="motif" class="form-control" id="" cols="30" rows="10"></textarea>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>-->
            <div class="card">
                <div class="card-body">

            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Code</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Heure</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Metier</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Specialité</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    while($infos = $getAllMyQuestions->fetch()){
                  ?>
                    <tr>
                      <td >
                      <span class="badge badge-sm bg-gradient-success"><?=  $infos['idDem'] ?></span>
                      </td>
                      <td>
                        <p ><?= $infos['date'] ?></p>
                      </td>
                      <td>
                        <p ><?= $infos['heure'] ?></p>
                      </td>
                      <td >
                        <?php 
                        $sql = $bdd->prepare("SELECT * FROM metier INNER JOIN demande ON metier.idMet = demande.idMetier WHERE idCb =? AND idDem=? ");
                        $idDe=$infos['idDem'];
                        $sql->execute(array($_SESSION['id'],$idDe));
                        if($sql->rowCount()>0){
                          while($info = $sql->fetch()){
                        ?>
                        <span ><?= $info['nomMet'] ?></span>
                        <?php }} ?>
                      </td>
                      <td >
                      <?php 
                        $sql = $bdd->prepare("SELECT * FROM specialite INNER JOIN demande ON specialite.idMetS = demande.idMetier WHERE idCb =? AND idSp=? AND idDem =? ");
                        $sql->execute(array($_SESSION['id'],$infos['idSpecialite'],$infos['idDem']));
                        if($sql->rowCount()>0){
                          while($info = $sql->fetch()){
                        ?>
                      
                        <p ><?= $info['nomSp'] ?></span>
                        <?php }} ?>
                      </td>
                      
                      <td >
                      <a href="factureC.php?id=<?= $id?>&idc=<?= $idDe?>" type="button" class="btn btn-success editbtn">Voir facture </a>
                       
                      </td>
                      
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script>
    $(document).ready(function () {

        $('.editbtn').on('click', function () {

            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            $('#update_id').val(data[0]);
            $('#fname').val(data[1]);
            $('#lname').val(data[2]);
            $('#course').val(data[3]);
            $('#contact').val(data[4]);
        });
    });
</script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>
<?php
include('../../action/dba.php');
session_start();
if(!isset($_SESSION['auth'])){
    header('Location: ../../connexion.php');
}
$id = $_SESSION['id'];
$idc = $_GET['idc'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>

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
  <center><div id="my-modal" class="modal" style="width: 500px; margin:200px 550px ;">
    <div class="modal-content">
      <div class="modal-header">
        <span class="close" style="float: right; font-size: 30px;     cursor: default; color: black;">&times;</span>
        <h2><center >chapbara</center></h2>
      </div>
      <div class="modal-body">
        <h1><center style="color: black;">Merci pour cette operation</center></h1>
      </div>
      <div class="modal-footer">
        <h3><center >chapbara</center></h3>
      </div>
    </div>
  </div></center>
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
              <?php 
              
   
              $requtte =$bdd->prepare('SELECT * from client INNER JOIN demande ON client.idCb = demande.idCb  AND demande.idDem = ? ');
              $requtte->execute(array($idc));
              if($requtte->rowCount()>0){
                while($affi = $requtte->fetch()){
              
                        $addd = $bdd->prepare('SELECT *FROM facture WHERE Ndemande = ?');
                        $addd->execute(array($affi['codeD']));
                        if($addd->rowCount()>0){
                            while($fact=$addd->fetch()){


                        
                            $requtte =$bdd->prepare('SELECT * from adh where idAd = ?');
                            $requtte->execute(array($fact['idAd']));
                            if($requtte->rowCount()>0){
                              while($adhe = $requtte->fetch()){
                               
                          ?>
              <h2 >Facture n°<?= $fact['nFacture']?>  </h2>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
<!-- debut -->
<div class="container">
    <div class="row gutters">
    	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    		<div class="cards">
    			<div class="card-body p-0">
    				<div class="invoice-container">
    					<div class="invoice-header">
    
    
    						<!-- Row start -->
    						<div class="row gutters">
    							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
    								<a href="index.html" class="invoice-logo">
    									ChapBara.com
    								</a>
    							</div>
    							<div class="col-lg-6 col-md-6 col-sm-6">
    								<address class="text-right">
    									Abidjan, Côte d'ivoire<br>
    									Port bouet, Rue caraïbe<br>
    									
    								</address>
    							</div>
    						</div>
    						<!-- Row end -->
    
    						<!-- Row start -->
    						<div class="row gutters">
    							<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
    								<div class="invoice-details">
    									<address>
    								    	N°Adherent:    <?= $adhe['codeAd']?><br>
    										Nom adherent:    <?= $adhe['nomAd']?> <?= $adhe['prenomAd']?>
    									</address>
    								</div>
    							</div>
    							<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
    								<div class="invoice-details">
    									<div>
                                            <address>
    										<div>N°Client:    <?= $affi['codeCb']?></div>
    										<div>Nom du client:    <?= $affi['nomCb']?></div>
                                            <div>Nom telephone:    <?= $affi['prenomCb']?></div>
                                            </address>
    									</div>
    								</div>													
    							</div>
    						</div>
    						<!-- Row end -->
    
    					</div>
    
    					<div class="invoice-body">
    
    						<!-- Row start -->
    						<div class="row gutters">
    							<div class="col-lg-12 col-md-12 col-sm-12">
    								<div class="table-responsive">
    									<table class="table custom-table m-0">
    										<thead>
    											<tr>
    												<th>Motif de la demande</th>
    												<th>N° de la demande</th>
    												<th>Transport</th>
                                                    <th>Main d'oeuvre</th>
    												<th>Montant</th>
    											</tr>
    										</thead>
    										<tbody>
    											<tr>
    												<td>
                                                        <?= $affi['motif'] ?>
    												</td>
    												<td> <?= $affi['codeD']?> </td>
    												<td><?php
                                                            $grad = $adhe['gradeAd'];
                                                            if($grad == "1"){
                                                                $tp = "7000";                                                
                                                            }elseif($grad =="2"){
                                                                $tp ="6000";
                                                            }else{
                                                                $tp="5000";
                                                            }
                                                            echo '<center>'. $tp ." FCFA".'</center>';
                                                        ?>
                                                    <td ><?php
                                                    $Md=2500;

                                                            if($Md < "0"){
                                                                echo "Montant non valide";                                                
                                                            }elseif($Md>10000){
                                                                echo "Montant non valide";
                                                            }else{
                                                                echo '<center>'.$Md.' FCFA</center>';
                                                            }
                                                        ?></td>
                                                        <td>
                                                          <?php $montant = $Md+$tp;
                                                          echo '<center>'. $montant ." FCFA".'</center>';
                                                         ?></td>
    											</tr>
    											
    											
    											<tr>
    												<td>&nbsp;</td>
    												<td colspan="2">
    													<p class="text-success">
    														Montant<br>
    													</p>
    												</td>			
    												<td>
    													<p class="text-success">
    														<?= $montant ." FCFA"?><br>
    													</p>
    												</td>
    											</tr>
    										</tbody>
    									</table>
                                        <br><br>
                        <center><button id="modal-btn" class="btn btn-danger btn-sm w-30 mb-3 payer">Payer</button></center>
                                     </div>
    							</div>
    						</div>
    						<!-- Row end -->
    
    					</div>
    
    
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
<!-- fin -->
             
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
  
  <style>
    body{
    margin: 0;
    padding: 0;
    font: 400 .875rem 'Open Sans', sans-serif;
    color: #bcd0f7;
    background: #1A233A;
    position: relative;
    height: 100%;
    }
    .invoice-container {
        padding: 1rem;
    }
    .invoice-container .invoice-header .invoice-logo {
        margin: 0.8rem 0 0 0;
        display: inline-block;
        font-size: 1.6rem;
        font-weight: 700;
        color: #bcd0f7;
    }
    .invoice-container .invoice-header .invoice-logo img {
        max-width: 130px;
    }
    .invoice-container .invoice-header address {
        font-size: 0.8rem;
        color: #8a99b5;
        margin: 0;
    }
    .invoice-container .invoice-details {
        margin: 1rem 0 0 0;
        
        padding: 1rem;
        line-height: 180%;
        background: #1a233a;
    }
    .invoice-container .invoice-details .invoice-num {
        text-align: right;
        font-size: 0.8rem;
    }
    .invoice-container .invoice-body {
        padding: 1rem 0 0 0;
    }
    .invoice-container .invoice-footer {
        text-align: center;
        font-size: 0.7rem;
        margin: 5px 0 0 0;
    }

    .invoice-status {
        text-align: center;
        padding: 1rem;
        background: #272e48;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        margin-bottom: 1rem;
    }
    .invoice-status h2.status {
        margin: 0 0 0.8rem 0;
    }
    .invoice-status h5.status-title {
        margin: 0 0 0.8rem 0;
        color: #8a99b5;
    }
    .invoice-status p.status-type {
        margin: 0.5rem 0 0 0;
        padding: 0;
        line-height: 150%;
    }
    .invoice-status i {
        font-size: 1.5rem;
        margin: 0 0 1rem 0;
        display: inline-block;
        padding: 1rem;
        background: #1a233a;
        -webkit-border-radius: 50px;
        -moz-border-radius: 50px;
        border-radius: 50px;
    }
    .invoice-status .badge {
        text-transform: uppercase;
    }

    @media (max-width: 767px) {
        .invoice-container {
            padding: 1rem;
        }
    }

    .cards {
        background: #272E48;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        border: 0;
        margin-bottom: 1rem;
    }

    .custom-table {
        border: 1px solid #2b3958;
    }
    .custom-table thead {
        background: #2f71c1;
    }
    .custom-table thead th {
        border: 0;
        color: #ffffff;
    }
    .custom-table > tbody tr:hover {
        background: #172033;
    }
    .custom-table > tbody tr:nth-of-type(even) {
        background-color: #1a243a;
    }
    .custom-table > tbody td {
        border: 1px solid #2e3d5f;
    }

    .table {
        background: #1a243a;
        color: #bcd0f7;
        font-size: .75rem;
    }
    .text-success {
        color: #c0d64a !important;
    }
    .custom-actions-btns {
        margin: auto;
        display: flex;
        justify-content: flex-end;
    }
    .custom-actions-btns .btn {
        margin: .3rem 0 .3rem .3rem;
    }

  </style>
  <script>
    // Get DOM Elements
const modal = document.querySelector('#my-modal');
const modalBtn = document.querySelector('#modal-btn');
const closeBtn = document.querySelector('.close');

// Events
modalBtn.addEventListener('click', openModal);
closeBtn.addEventListener('click', closeModal);
window.addEventListener('click', outsideClick);

// Open
function openModal() {
  modal.style.display = 'block';
}

// Close
function closeModal() {
  modal.style.display = 'none';
}

// Close If Outside Click
function outsideClick(e) {
  if (e.target == modal) {
    modal.style.display = 'none';
  }
}

  </script>
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
<?php
if(isset($_POST['validate'])){
  $insertion = $bdd->prepare("INSERT INTO `facture`( `Ndemande`, `transport`, `MainO`, `Montant`, `idAd`, `idCb`, `nFacture`) VALUES (?,?,?,?,?,?,?)");
  $insertion->execute(array($affi['codeD'],$tp,$Md,$montant,$idA,$ids,$facture));
  echo'<h1><center>Facture envoyée</center></h1>';
  }
?><?php }}  }}else{echo '<h1 ><center style="color="red";"> Aucune facture disponible</center></h1>' ;}  }}?>
</html>
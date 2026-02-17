<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sidebar fixe Bootstrap 5</title>
  
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/bootstrap-icons.min.css">
   <script src="/assets/js/bootstrap.bundle.min.js"></script>
   <link rel="stylesheet" href="/assets/css/home.css">
   
</head>
<body class="d-flex">

  <!-- SIDEBAR FIXE (toujours visible) -->
<div class="row">
    <div class="col-3">
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white">
                
                    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-4 fw-bold">BNGRC</span>
                    </a>
                    
                    <hr class="border-secondary">

                    <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="/bngrc/list-cities" class="nav-link" aria-current="page">
                        <i class="bi bi-house-door-fill me-2"></i> List of cities
                        </a>
                    </li>
                    <li>
                        <a href="/bngrc/list-gifts" class="nav-link">
                        <i class="bi bi-speedometer2 me-2"></i> List of gifts
                        </a>
                    </li>
                    <li>
                        <a href="/bngrc/list-donations" class="nav-link">
                        <i class="bi bi-cart-fill me-2"></i> List of donations
                        </a>
                    </li>
                    <li>
                        <a href="/bngrc/form-need" class="nav-link">
                        <i class="bi bi-box-seam-fill me-2"></i> Form of needs
                        </a>
                    </li>
                    <li>
                        <a href="/bngrc/list-needs" class="nav-link">
                        <i class="bi bi-people-fill me-2"></i> List of needs
                        </a>
                    </li>
                    </ul>
        </div>
    </div>
    <div class="col-9">
                <div class="map-container">
                    <img src="/assets/images/madagascar.svg" class="img-fluid" alt="Carte de Madagascar" width= "200%">
                 </div>
    </div>       
</div>

 

  
 
</body>
</html>




 <!-- <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="sidebar">
                    <a href="/bngrc/list-cities" class="btn">List of cities</a>
                    <a href="/bngrc/list-gifts" class="btn">List of gifts</a>
                    <a href="/bngrc/list-donations" class="btn">List of donations</a>
                    <a href="/bngrc/form-need" class="btn">Form of needs</a>
                    <a href="/bngrc/list-needs" class="btn">List of needs</a>
                </div>
            </div>

            <div class="col-6">
                <div class="map-container">
                    <img src="/assets/images/madagascar.svg" class="img-fluid" alt="Carte de Madagascar">
                </div>
            </div>
        </div>
    </div> -->
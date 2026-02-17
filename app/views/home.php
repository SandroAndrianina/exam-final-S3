<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/map-interactive.css">

    
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="sidebar">
                    <a href="/bngrc/reset" class="btn" style="background-color: #dc3545; color: white; font-weight: 400;">Reset Data</a>
                    <hr style="margin: 12px 0; border: 1px solid rgba(255,255,255,0.3);">
                    <a href="/bngrc/list-cities" class="btn">List of cities</a>
                    <a href="/bngrc/list-gifts" class="btn">List of gifts</a>

                    <a href="/bngrc/form-need" class="btn">Form of needs</a>
                    <a href="/bngrc/list-needs" class="btn">List of needs</a>
                    <a href="/bngrc/form-distribution" class="btn">Form of distribution</a>
                    <a href="/bngrc/form-purchase" class="btn">Purchase materials</a>
                    <a href="/bngrc/list-purchases" class="btn">List of purchases</a>
                    <a href="/bngrc/dashboard" class="btn">Dashboard</a>
                </div>
            </div>

            <div class="col-6">
                <div class="map-container">
                    <img src="/assets/images/madagascar.svg" class="img-fluid" alt="Carte de Madagascar">
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/map-interactive.js"></script>
</body>


</html>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">

    <title>Resultados</title>
</head>

<body>
    <header>
        <div class="nav-div">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#"><i class="fab fa-instagram"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-globe-americas"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="row justify-content-center aling-itens-center">
            <div class="col-4" style="text-align: right;">
                <img src="img/logo_3.png" alt="" style="max-width: 100%;">
            </div>
            <div class="col-8 d-flex align-items-center">
                <input disabled class="form-control " type="text" placeholder="Parematro de busca" aria-label="default input example"
                    value="<?php echo "$search_type - $search_param" ?>"
                >
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row aling-itens-center">
            <div class="d-grid col-12 mx-auto">
                <?php foreach($result as $row): ?>
                    <div class="row bg-light m-2">
                        <p class="text-dark"><?php echo $row['Nome_Fantasia']; ?></p>
                    </div>
                <?php endforeach ?>
                <!-- <button class="btn btn-primary" type="button">Nome do provedor<i class="fas fa-comment-alt"></i></button> -->
            </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/afc7c9c072.js" crossorigin="anonymous"></script>

</html>

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

<?php include_once "header.php"?>

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
                        <form action="/result_provider.php" method="post" target="_blank">
                            <input type="hidden" name="provider" value="<?php echo $row['id']; ?>" />
                            <button type="submit" class="normal btn btn-light btn-link"><?php echo $row['Nome_Fantasia'] . ' - ' . $row["NomeRazão_Social"]; ?></button>
                        </form>
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

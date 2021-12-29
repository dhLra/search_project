<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/custom.css">

  <title>TURING</title>
</head>

<body>

  <?php include_once "header.php" ?>

  <div class="container front-form">
    <div class="row justify-content-center align-items-center">
      <div class="col col-md-8 col-lg-6">
        <img class="img-fluid" src="img/logo_1.png">
        <form action="/turing-fbr/connection.php" method="POST">
          <div class="row">
            <div class="col-12">
              <input type="text" name="param" id="busca" class="form-control" placeholder="Informe os dados aqui">
            </div>
            <div class="col-12">
              <select class="form-select" arial-label="Default select exemple" name="type">
                <option>Escolha o tipo</option>
                <option value="0">ASN</option>
                <option value="1">CNPJ/CPF</option>
                <option value="2">Razão Social</option>
                <option value="3">Serviço</option>
                <option value="4">Municipio</option>
                <option value="5">UF</option>
                <option value="6">CEP</option>
              </select>
            </div>
            <div class="col-12">
              <button type="submit" name="submit" class="btn btn-primary btn-search w-100">Buscar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/afc7c9c072.js" crossorigin="anonymous"></script>

</html>

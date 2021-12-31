<?php
    require __DIR__ . '/statistics.php';
?>
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
    <div class="row">
      <div class="col col-md-5 col-lg-5">
        <img class="img-fluid" src="img/logo_1.png">
        <form action="/connection.php" method="POST">
          <div class="row">
            <div class="col-12">
              <input type="text" name="param" id="busca" class="form-control" placeholder="Informe os dados aqui">
            </div>
            <div class="col-12 pt-2">
              <select class="form-select" arial-label="Default select exemple" name="type">
                <option>Escolha o tipo</option>
                <option value="0">ASN</option>
                <option value="1">CNPJ/CPF</option>
                <option value="2">Razão Social</option>
                <option value="7">Nome fantasia</option>
                <option value="3">Serviço</option>
                <option value="4">Municipio</option>
                <option value="5">UF</option>
                <option value="8">Região</option>
                <option value="6">CEP</option>
              </select>
            </div>
            <div class="col-12">
              <button type="submit" name="submit" class="btn btn-primary btn-search w-100">Buscar</button>
            </div>
          </div>

          <datalist id="cities">
            <?php foreach (getAllCities() as $row): ?>
                <option value="<?php echo $row['cidade']; ?>" >
            <?php endforeach ?>
          </datalist>

          <datalist id="providers">
            <?php foreach (getAllProviders() as $row): ?>
                <option value="<?php echo $row['nome']; ?>" >
            <?php endforeach ?>
          </datalist>

          <datalist id="razao-social">
            <?php foreach (getAllProvidersRazaoSocial() as $row): ?>
                <option value="<?php echo $row['nome']; ?>" >
            <?php endforeach ?>
          </datalist>
        </form>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col col-md-5 col-lg-5">
        <div class="bg-light statistics">
          <table class="table table-bordered">
              <tbody>
                <tr>
                  <th scope="row">Total de provedores</th>
                  <td><?php echo $statistics['total']; ?></td>
                </tr>
              </tbody>
          </table>

          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Região</th>
                <th scope="col">Provedores</th>
              </tr>
            </thead
            <tbody>
              <?php foreach($statistics['by_region'] as $row): ?>
                <tr>
                  <td><?php echo $row['regiao']; ?></td>
                  <td><?php echo $row['total']; ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>

          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Estado</th>
                <th scope="col">Provedores</th>
              </tr>
            </thead
            <tbody>
              <?php foreach($statistics['by_state'] as $row): ?>
                <tr>
                  <td><?php echo $row['estado']; ?></td>
                  <td><?php echo $row['total']; ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>

<script type="text/javascript" src="/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script src="https://kit.fontawesome.com/afc7c9c072.js" crossorigin="anonymous"></script>

</html>

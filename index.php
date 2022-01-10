<?php
    require __DIR__ . '/statistics.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/css/custom.css">

  <title>TURING</title>
</head>

<body>

  <?php include_once "header.php" ?>
    <div class="container front-form">
        <div class="row">
            <div class="col col-12 col-md-5 col-lg-5">
                <div class="row">
                    <div class="col">
                        <img class="img-fluid" src="img/logo_1.png">
                        <form action="/connection.php" method="POST">
                            <div class="row">
                                <div class="col col-9">
                                <select name="regiao" class="form-select">
                                    <option value="">Regiao</option>
                                    <option value="Norte">Norte</option>
                                    <option value="Nordeste">Nordeste</option>
                                    <option value="Centro-Oeste">Centro-Oeste</option>
                                    <option value="Sudeste">Sudeste</option>
                                    <option value="Sul">Sul</option>
                                </select>
                                </div>
                                <div class="col col-3">
                                    <select name="uf" class="form-select">
                                        <option value="">UF</option>
                                        <?php foreach (getAllStates() as $row): ?>
                                            <option value="<?php echo $row['estado'] ?>">
                                                <?php echo $row['estado'] ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col col-9">
                                    <input
                                        list="cities"
                                        type="text"
                                        name="cidade"
                                        class="form-control"
                                        placeholder="Cidade"
                                    >
                                </div>
                                <div class="col col-3">
                                    <input
                                        list="cnpj"
                                        type="text"
                                        name="cnpj"
                                        class="form-control"
                                        placeholder="CNPJ"
                                    >
                                </div>
                            </div>

                            <div>
                                <button
                                    type="submit"
                                    name="submit"
                                    class="btn btn-primary btn-search w-100"
                                >
                                    Buscar
                                </button>
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
            </div>

            <div class="col col-12 col-md-7 col-lg-7">
                <div class="row justify-content-center">
                    <div class="col col-12 col-md-8 col-lg-8 map">
                        <?php echo file_get_contents("./img/brazil.svg"); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4 front-cards">
            <div class="col col-12 col-md-6 col-lg-6">
                <div class="row">
                    <div class="col col-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total de <wbr/>provedores: <wbr/><span id="provider-total"></span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="col col-6" id="second-provider-total-card" style="visibility: hidden">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><span id="second-provider-total"></span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col col-12 col-md-3 col-lg-3">
                <canvas id="provider-chart" width="200" height="200"></canvas>
            </div>
            <div class="col col-12 col-md-9">
                <div class="row justify-content-end">
                    <div class="col col-12 col-md-9">
                        <canvas id="active-circuit-chart" width="500" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="container mt-4">
    </footer>
</body>

<script>
    var totalASN = <?php echo totalASN()["provedores"] ?>;
    var totalISP = <?php echo totalISP()["provedores"] ?>;
    var totalProvider = totalASN + totalISP;

    var allCities = <?php echo json_encode(getAllCitiesWithStates()) ?>;
</script>
<script src="https://kit.fontawesome.com/afc7c9c072.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/svg-z-order@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
</html>

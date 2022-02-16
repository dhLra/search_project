<?php
require __DIR__ . '/auth.php';
require __DIR__ . '/statistics.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/custom.css">

    <title>TURING</title>
</head>

<body>

    <?php include_once "./header.php" ?>


    <!-- <div class="container front-form pb-5">
        <div class="row text-center">
            <a href="/">
                <img class="img-fluid" src="img/FBR_logo.png" width="50%">
            </a>
        </div>
        <form action="./connection.php" method="POST">
            <div class="row justify-content-center pb-3">
                <div class="col-9">
                    <input list="cnpj" type="text" name="cnpj" class="form-control" style=" background-color: #E5E5E5;" >
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-3">
                    <select name="regiao" class="form-select" style=" background-color: #E5E5E5;">
                        <option value="">FILTRO GEOGRÁFICOS</option>
                        <option value="Norte">Norte</option>
                        <option value="Nordeste">Nordeste</option>
                        <option value="Centro-Oeste">Centro-Oeste</option>
                        <option value="Sudeste">Sudeste</option>
                        <option value="Sul">Sul</option>
                    </select>
                </div>
                <div class="col-3">
                    <select name="" class="form-select" style=" background-color: #E5E5E5;">
                        <option value="">FILTRO ADMINISTRATIVO</option>
                        <option value="cidade">ENDEREÇO DA SEDE</option>
                        <option value="cnpj">CNPJ</option>
                        <option value="#">RAZÃO SOCIAL</option>
                        <option value="nome">NOME FANTASIA</option>
                    </select>
                </div>
                <div class="col-3">
                    <select name="" class="form-select" style=" background-color: #E5E5E5;">
                        <option value="">FILTROS OPERACIONAIS</option>
                        <option value="#">PLANO</option>
                        <option value="#">TECNOLOGIA</option>
                        <option value="#">PRAZOS</option>
                        <option value="#">SLA</option>
                        <option value="#">ASN</option>
                    </select>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-3 pt-3">
                    <div>
                        <button type="submit" name="submit" class="btn btn-primary btn-search w-100">
                            Buscar
                        </button>
                    </div>
                </div>
            </div>
            <datalist id="cities">
                <?php foreach (getAllCities() as $row) : ?>
                    <option value="<?php echo $row['cidade']; ?>">
                    <?php endforeach ?>
            </datalist>

            <datalist id="providers">
                <?php foreach (getAllProviders() as $row) : ?>
                    <option value="<?php echo $row['nome']; ?>">
                    <?php endforeach ?>
            </datalist>

            <datalist id="razao-social">
                <?php foreach (getAllProvidersRazaoSocial() as $row) : ?>
                    <option value="<?php echo $row['nome']; ?>">
                    <?php endforeach ?>
            </datalist>
        </form>
    </div>-->


    <div class="container front-form pb-5">
        <div class="row text-center">
            <a href="/">
                <img class="img-fluid" src="img/FBR_logo.png" width="50%">
            </a>
        </div>
        <form action="/connection.php" method="POST">
          <!--  <div class="row justify-content-center pb-3">
                <div class="col-9">
                    <input list="cnpj" type="hidden" name="cnpj" class="form-control" style=" background-color: #E5E5E5;">
                </div>
            </div>-->

            <div class="row justify-content-center">
                <div class="col-3">
                    <select name="regiao" class="form-select">
                        <option value="">Região</option>
                        <option value="Norte">Norte</option>
                        <option value="Nordeste">Nordeste</option>
                        <option value="Centro-Oeste">Centro-Oeste</option>
                        <option value="Sudeste">Sudeste</option>
                        <option value="Sul">Sul</option>
                    </select>
                </div>
                <div class="col-3">
                    <select name="uf" class="form-select">
                        <option value="">UF</option>
                        <?php foreach (getAllStates() as $row) : ?>
                            <option value="<?php echo $row['estado'] ?>">
                                <?php echo $row['estado'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-3">
                    <input list="cities" type="text" name="cidade" class="form-control" placeholder="Cidade">
                </div>
                <div class="col-3">
                    <input list="cnpj" type="text" name="cnpj" class="form-control" placeholder="CNPJ">
                </div>
            </div>
            <div class="row justify-content-center">
            <button type="submit" name="submit" class="btn btn-primary btn-search w-50">
                Buscar
            </button>
            </div>
    </div>
    <datalist id="cities">
        <?php foreach (getAllCities() as $row) : ?>
            <option value="<?php echo $row['cidade']; ?>">
            <?php endforeach ?>
    </datalist>

    <datalist id="providers">
        <?php foreach (getAllProviders() as $row) : ?>
            <option value="<?php echo $row['nome']; ?>">
            <?php endforeach ?>
    </datalist>

    <datalist id="razao-social">
        <?php foreach (getAllProvidersRazaoSocial() as $row) : ?>
            <option value="<?php echo $row['nome']; ?>">
            <?php endforeach ?>
    </datalist>
    </form>
    </div>
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total de <wbr />provedores: <wbr /><span id="provider-total"></span></h5>
                    </div>
                </div>
                <div class="card mt-2" id="second-provider-total-card" style="visibility: hidden">
                    <div class="card-body">
                        <h5 class="card-title "><span id="second-provider-total"></span></h5>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="map">
                    <?php echo file_get_contents("./img/brazil.svg"); ?>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col col-12 col-md-4 col-lg-3 loader-parent" id="provider-chart-loader">
                    <div class="loader"></div>
                    <canvas id="provider-chart" width="200" height="200"></canvas>
                </div>
                <div class="col col-12 col-md-8 col-lg-9">
                    <div class="row justify-content-end">
                        <div class="col col-12 col-md-9 loader-parent" id="active-circuit-chart-loader">
                            <div class="loader"></div>
                            <canvas id="active-circuit-chart" width="500" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col col-12 col-md-4 col-lg-3">
                    <h5 class="bg-light rounded p-2 text-center">Fornecedores homologados</h4>
                        <div class="list-wrapper bg-light loader-parent" id="homologated-provider-list-loader">
                            <div class="loader"></div>
                            <ul class="list-unstyled" style="padding-left: 10px;" id="homologated-provider-list">
                            </ul>
                        </div>
                </div>
                <div class="col col-12 col-md-8">
                    <div class="row justify-content-end">
                        <div class="col col-12 col-md-9 loader-parent" id="area-coverage-chart-loader">
                            <div class="loader"></div>
                            <canvas class="portrait" id="area-coverage-chart" width="500" height="500"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once "footer.php" ?>
</body>

<script>
    var totalASN = <?php echo totalASN()["provedores"] ?>;
    var totalISP = <?php echo totalISP()["provedores"] ?>;
    var totalProvider = totalASN + totalISP;

    var allCities = <?php echo json_encode(getAllCitiesWithStates()) ?>;
</script>
<script src="https://kit.fontawesome.com/afc7c9c072.js" crossorigin="anonymous"></script>
<script src="/js/svg-z-order.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>

</html>
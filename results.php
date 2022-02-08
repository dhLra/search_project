<?php
require __DIR__ . '/auth.php';

function formatTelephone($tel) {
    return preg_replace("/[^0-9]/", "", $tel);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/custom.css">

    <title>Resultados</title>
</head>

<body>

    <?php include_once "header.php" ?>

    <div class="container">
        <div class="row justify-content-center aling-itens-center">
            <div class="col-4" style="text-align: right;">
                <a href="/">
                    <img src="img/logo_1.png" alt="" style="max-width: 100%;">
                </a>
            </div>
            <!--div class="col-8 d-flex align-items-center">
                <input disabled class="form-control " type="text" placeholder="Parematro de busca" aria-label="default input example" value="<?php echo "$search_type - $search_param" ?>">
            </div-->
        </div>
    </div>

    <div class="container">
        <div class="row aling-itens-center">
            <div class="d-grid col-12 mx-auto">

                <table class="table bg-light provedores" style="overflow: hidden">
                    <thead>
                        <tr>
                            <th
                                scope="col"
                                style="width: 50%;"
                                <?php
                                    if ($_POST["order_by"] == "nome") {
                                        echo "order='$order_by_direction_invertion'";
                                    }
                                ?>
                            >
                                <form action="/connection.php" method="post">
                                    <?php echo join(" ", $formInputs) ?>
                                    <input type="hidden" name="order_by" value="nome" />
                                    <input
                                        type="hidden"
                                        name="order_by_direction"
                                        value="<?php echo $order_by_direction_invertion ?>"
                                    />
                                </form>
                                Nome Fantasia
                            </th>
                            <th
                                scope="col"
                                style="width: 30%;"
                                <?php
                                    if ($_POST["order_by"] == "cidade") {
                                        echo "order='$order_by_direction_invertion'";
                                    }
                                ?>
                            >
                                <form action="/connection.php" method="post">
                                    <?php echo join(" ", $formInputs) ?>
                                    <input type="hidden" name="order_by" value="cidade" />
                                    <input
                                        type="hidden"
                                        name="order_by_direction"
                                        value="<?php echo $order_by_direction_invertion ?>"
                                    />
                                </form>
                                Municipio / UF
                            </th>
                            <th
                                scope="col"
                                style="width: 20%;"
                                <?php
                                    if ($_POST["order_by"] == "telefone") {
                                        echo "order='$order_by_direction_invertion'";
                                    }
                                ?>
                            >
                                <form action="/connection.php" method="post">
                                    <?php echo join(" ", $formInputs) ?>
                                    <input type="hidden" name="order_by" value="telefone" />
                                    <input
                                        type="hidden"
                                        name="order_by_direction"
                                        value="<?php echo $order_by_direction_invertion ?>"
                                    />
                                </form>
                                Telefone
                            </th>
                        </tr>
                    </thead>
                </table>

                <table class="provedores">
                    <tbody>
                        <?php foreach ($result as $row) : ?>
                            <tr>
                            <?php if ($adaQuery): ?>
                                <td class="bg-light" style="width: 50%;">
                                    <?php echo $row['Nome_Fantasia']; ?>
                                </td>
                                <td class="separator"></td>
                                <td class="bg-light" style="width: 30%;">
                                    <?php echo $row['Municipio']?>
                                </td>
                                <td class="separator"></td>
                                <td class="bg-light" style="width: 20%;">
                                    <a href="tel:<?php
                                        echo formatTelephone($row["Telefone_Principal"])
                                    ?>">
                                        <?php echo $row['Telefone_Principal']?>
                                    </a>
                                </td>
                            <?php else: ?>
                                <td class="bg-light" style="width: 50%;">
                                <form action="/result_provider.php" method="post" target="_blank">
                                    <input type="hidden" name="provider" value="<?php echo $row['id']; ?>" />
                                    <button type="submit" class="normal btn btn-light btn-link"><?php echo $row['Nome_Fantasia'] . ' - ' . $row["NomeRazão_Social"]; ?></button>
                                </form>
                                </td>
                                <td class="separator"></td>
                                <td class="bg-light" style="width: 30%;">
                                <form action="/result_provider.php" method="post" target="_blank">
                                    <input type="hidden" name="provider" value="<?php echo $row['id']; ?>" />
                                    <button type="submit" class="normal btn btn-light btn-link"><?php echo $row['Municipio'] . ' / ' . $row['UF_Sede']?></button>
                                </form>
                                </td>
                                <td class="separator"></td>
                                <td class="bg-light" style="width: 20%;">
                                    <a href="tel:<?php
                                        echo formatTelephone($row["Telefone_Principal"])
                                    ?>">
                                        <?php echo $row['Telefone_Principal']?>
                                    </a>
                                </td>
                            <?php endif ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <!-- <button class="btn btn-primary" type="button">Nome do provedor<i class="fas fa-comment-alt"></i></button> -->
            </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="/js/results.js"></script>
<script src="https://kit.fontawesome.com/afc7c9c072.js" crossorigin="anonymous"></script>

</html>

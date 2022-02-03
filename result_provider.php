<?php
require __DIR__ . "/database.php";
require __DIR__ . "/external_data.php";

$sth = $conn->prepare('SELECT * FROM `provedores` WHERE `id` = :nome');
$sth->bindParam(':nome', $_POST['provider']);
$sth->execute();
$result = $sth->fetch(PDO::FETCH_ASSOC);

function formatTelephone($tel) {
    return preg_replace("/[^0-9]/", "", $tel);
}

$upstreams = searchASNUpstreams($result["ASN"]);
sleep(1);
$ixs = searchASNIXs($result["ASN"]);
sleep(2);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">

    <title>Resultado do Provedor</title>
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
            <div class="col-8 d-flex align-items-center">
                <input disabled class="form-control " type="text" placeholder="Parematro de busca" aria-label="default input example"
                    value="<?php echo $result['id'] ." - ". $result['Nome_Fantasia']?>"
                >
            </div>
        </div>
    </div>

    <div class="row container">
        <div class="col col-sm-1 col-md-1"></div>
        <div class="col col-sm-11 col-md-8">
            <div class="container bg-light rounded provider-info pt-3 pb-3">
                <table>
                    <tbody>
                    <tr>
                            <th scope="row">Nome:</th>
                            <td>
                            <?php echo $result["Nome_Fantasia"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Razão Social:</th>
                            <td>
                            <?php echo $result["NomeRazão_Social"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">ASN:</th>
                            <td>
                                <?php echo $result["ASN"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Interesse:</th>
                            <td>
                            <?php echo $result["Interesse"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Tipo de Identificação:</th>
                            <td>
                            <?php echo $result["Tipo_de_Identificação"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">CNPJ/CPF:</th>
                            <td>
                            <?php echo $result["CNPJCPF"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Número do Fistel:</th>
                            <td>
                            <?php echo $result["Número_do_Fistel"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Número do Fistel do Serviço Pricipal:</th>
                            <td>
                            <?php echo $result["Número_de_FISTEL_do_Serviço_Principal"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Código do Serviço:</th>
                            <td>
                            <?php echo $result["Código_do_Serviço"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Nome do Serviço:</th>
                            <td>
                            <?php echo $result["Nome_do_Serviço"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Processo:</th>
                            <td>
                            <?php echo str_replace(",", ".", number_format(intval(str_replace(",", ".", $result["Processo"])), 0)); ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Data de Inclusão:</th>
                            <td>
                            <?php echo $result["Data_de_Inclusão"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Logradouro:</th>
                            <td>
                            <?php echo $result["Logradouro_Sede"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Número:</th>
                            <td>
                            <?php echo $result["Número"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Complemento:</th>
                            <td>
                            <?php echo $result["Complemento"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Bairro:</th>
                            <td>
                            <?php echo $result["Bairro"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Municipio:</th>
                            <td>
                            <?php echo $result["Municipio"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">UF:</th>
                            <td>
                            <?php echo $result["UF_Sede"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">CEP:</th>
                            <td>
                            <?php echo $result["CEP_Sede"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Telefone:</th>
                            <td>
                                <a href="tel:<?php
                                    echo formatTelephone($result["Telefone_Principal"])
                                ?>">
                                    <?php echo $result["Telefone_Principal"]; ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Email:</th>
                            <td>
                                <a href="mailto:<?php
                                    echo $result["Endereço_Eletrônico_Principal"];
                                ?>">
                                    <?php echo $result["Endereço_Eletrônico_Principal"]; ?>
                                </a>
                            </td>
                        </tr>

                        <?php if ($upstreams): ?>
                            <?php $i = 0; foreach ($upstreams['ipv4_upstreams'] as $upstream): $i++ ?>
                                <tr>
                                    <th scope="row">Upstream IPV4 <?php echo $i ?></th>
                                    <td>
                                        <label>Nome: <?php echo $upstream['name'] ?></label><br />
                                        <label>ASN: <?php echo $upstream['asn'] ?></label><br />
                                        <label>País: <?php echo $upstream['country_code'] ?></label>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                            <?php $i = 0; foreach ($upstreams['ipv6_upstreams'] as $upstream): $i++ ?>
                                <tr>
                                    <th scope="row">Upstream IPV6 <?php echo $i ?></th>
                                    <td>
                                        <label>Nome: <?php echo $upstream['name'] ?></label><br />
                                        <label>ASN: <?php echo $upstream['asn'] ?></label><br />
                                        <label>País: <?php echo $upstream['country_code'] ?></label>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>

                        <?php if ($ixs): ?>
                            <?php $i = 0; foreach ($ixs as $ix): $i++ ?>
                                <tr>
                                    <th scope="row">IX <?php echo $i ?></th>
                                    <td>
                                        <label>Nome: <?php echo $ix['name'] ?></label><br />
                                        <label>IPV4: <?php echo $ix['ipv4_address'] ?></label><br />
                                        <?php if ($ix['ipv6_address']): ?>
                                            <label>IPV6: <?php echo $ix['ipv6_address'] ?></label><br />
                                        <?php endif ?>
                                        <label>País: <?php echo $ix['country_code'] ?></label><br />
                                        <label>Velocidade: <?php echo $ix['speed'] ?></label>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>

                <?php if ($upstreams): ?>
                    <div class="container">
                        <div>
                            <label for="ipv4-graph">Gráfico upstream IPV4</label>
                            <img id="ipv4-graph" style="width: 100%;" src="<?php echo $upstreams['ipv4_graph']; ?>" />
                        </div>

                        <?php if ($upstreams['ipv6_graph']): ?>
                            <div class="mt-2">
                                <label for="ipv6-graph">Gráfico upstream IPV6</label>
                                <img id="ipv6-graph" style="width: 100%;" src="<?php echo $upstreams['ipv6_graph']; ?>" />
                            </div>
                        <?php endif ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
        <div class="col col-sm-1 col-md-2"></div>
        <div class="col col-sm-1 col-md-1"></div>
    <div>

    <footer class="mt-4"></footer>
</body>

<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/afc7c9c072.js" crossorigin="anonymous"></script>

</html>

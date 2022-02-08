<?php
require __DIR__ . '/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = logUser($_POST['username'], $_POST['password']);

    if ($user) {
        session_start();
        $_SESSION['user'] = $user;
        header("Location: /index.php", true);
        die();
    } else {
        $incorrectLogin = true;
    }
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

  <title>TURING</title>
</head>

<body>
  <?php include_once "header.php" ?>

  <div class="container">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh">
        <div>
            <form action="/login.php" method="POST">

                    <?php if (isset($incorrectLogin)): ?>
                        <div class="mb-4">
                            <span class="">
                                <p class="rounded bg-danger text-white p-1 text-center">O login inserido está incorreto!</p>
                            </span>
                        </div>
                    <?php endif ?>

                <div class="row">
                    <div class="col-12">
                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            placeholder="Usuário"
                        />
                    </div>
                    <div class="col-12">
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Senha"
                        />
                    </div>
                    <div class="col-12">
                        <input
                            type="submit"
                            class="form-control btn btn-primary"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>

  <?php include_once "footer.php" ?>
<script type="text/javascript" src="/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
</body>

</html>

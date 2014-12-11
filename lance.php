<html>
<?php require './head.php'; ?>
<body>
  <div class="ink-grid">

  <?php
    require_once('./globals.php');

    // inicia sessão para passar variaveis entre ficheiros php
    session_start();

    $nif = $_SESSION['nif'];

    // Carregamento das variáveis username e pin do form HTML através do metodo POST;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $leilao = test_input($_POST["leilao"]);
      $valor = test_input($_POST["valor"]);
    }

    if($_SESSION['nif']=='') {
      header("Location: login.html"); /* Redirect browser */
      exit();
    }

    // regista a pessoa no leilão. Exemplificativo apenas.....
    $sql = "INSERT INTO lance (pessoa,leilao,valor) VALUES ($nif,$leilao,$valor)";
    $result = $connection->query($sql);
    if (!$result) {
      echo("<div class=\"ink-alert basic error\" role=\"alert\">
              <p><b>Erro!</b> Provalvemente já tinha feito este lance anteriormente.</p>
            </div>");
    }
    else {
      echo("<div class=\"ink-alert basic success\" role=\"alert\">
              <p><b>Sucesso!</b> Lance feito!</p>
            </div>");
    }
    //termina a sessão
    //session_destroy();
  ?>
  </div>
</body>
</html>

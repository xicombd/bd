<html>
<body>
  <?php
    require_once('./globals.php');

    $nif = $_SESSION['nif'];
    // Função para limpar os dados de entrada
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    // Carregamento das variáveis username e pin do form HTML através do metodo POST;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $leilao = test_input($_POST["leilao"]);
      $valor = test_input($_POST["valor"]);
    }
    //regista a pessoa no leilão. Exemplificativo apenas.....
    $sql = "INSERT INTO lance (pessoa,leilao,valor) VALUES ($nif,$leilao,$valor)";
    $result = $connection->query($sql);
    if (!$result) {
      echo("<p> Pessoa nao registada: Erro na Query:($sql) <p>");
      exit();
    }
    echo("<p> Lance feito </p>\n");

    //termina a sessão
    session_destroy();
  ?>
</body>
</html>

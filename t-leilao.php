<html>
<body>
  <?php
    require_once('./globals.php');

    // inicia sessão para passar variaveis entre ficheiros php
    session_start();

    $username = $_SESSION['username'];
    $nif = $_SESSION['nif'];
    // Carregamento das variáveis username e pin do form HTML através do metodo POST;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if(isset($_POST['concorre'])) {
      	$failed = false;
      	$connection->query("START TRANSACTION");

      	foreach($_POST['concorre'] as $value) {
      	  $sql = "INSERT INTO concorrente VALUES ($value)";
      	  $result = $connection->query($sql);
      	  if (!$result) {
      	    $failed = true;
      	  }
      	}

      	if ($failed) {
      	  $connection->query("ROLLBACK");
      	} else {
      	  $connection->query("COMMIT");
      	}
      }
    }

    if($_SESSION['nif']=='') {
      header("Location: login.html"); /* Redirect browser */
      exit();
    }

    echo("<p> Leiloes em que este individuo esta a concorrer: </p>\n");

    $sql = "SELECT leilao,leilao.dia,leilao.nrleilaonodia,nome,valorbase,tipo
            FROM concorrente,leilaor,leilao
            WHERE concorrente.leilao=leilaor.lid AND leilaor.dia = leilao.dia
              AND leilaor.nrleilaonodia = leilao.nrleilaonodia AND leilao.nif=leilaor.nif
              AND pessoa = ". $_SESSION['nif'];
    $result = $connection->query($sql);

    echo("<table border=\"1\">\n");
    echo("<tr><td>leilao</td><td>dia</td><td>nrleilaonodia</td><td>nome</td><td>valorbase</td><td>tipo</td></tr>\n");
    $idleilao = 0;

    foreach($result as $row) {
      echo("<tr><td>");
      echo($row["leilao"]);
      echo("</td><td>");
      echo($row["dia"]);
      echo("</td><td>");
      echo($row["nrleilaonodia"]);
      echo("</td><td>");
      echo($row["nome"]);
      echo("</td><td>");
      echo($row["valorbase"]);
      echo("</td><td>");
      echo($row["tipo"]);
      echo("</td></tr>");
      $idleilao = $idleilao + 1;
      $leilao[$idleilao]= array($row["leilao"]);
    }
    echo("</table>\n");

  ?>
  <form action="lance.php" method="post">
    <h2>Comprar cenas</h2>
    <p>ID: <input type="text" name="leilao" /></p>
    <p>Valor: <input type="text" name="valor" /></p>
    <p><input type="submit" /></p>
  </form>
</body>
</html>

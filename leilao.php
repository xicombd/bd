<html>
<?php require './head.php'; ?>
<body>
  <div class="ink-grid">

  <?php
    require_once('./globals.php');

    // inicia sessão para passar variaveis entre ficheiros php
    session_start();

    $username = $_SESSION['username'];
    $nif = $_SESSION['nif'];

    // Carregamento das variáveis username e pin do form HTML através do metodo POST;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $lid = test_input($_POST["lid"]);

      //regista a pessoa no leilão. Exemplificativo apenas.....
      $sql = "INSERT INTO concorrente (pessoa,leilao) VALUES ($nif,$lid)";
      $result = $connection->query($sql);

      if (!$result) {
        echo("<div class=\"ink-alert basic error\" role=\"alert\">
                <p><b>Erro!</b> Provalvemente já estava registado neste leilão.</p>
              </div>");
      }
      else {
        echo("<div class=\"ink-alert basic success\" role=\"alert\">
                <p><b>Sucesso!</b> Pessoa ($username), nif ($nif) Registada no leilão ($lid)</p>
              </div>");
      }
    }

    if($_SESSION['nif']=='') {
      header("Location: login.html"); /* Redirect browser */
      exit();
    }

    echo("<h5> Leilões em que este individuo esta a concorrer: </h5>\n");

    $sql = "SELECT leilao,leilao.dia,leilao.nrleilaonodia,nome,valorbase,tipo
            FROM concorrente,leilaor,leilao
            WHERE concorrente.leilao=leilaor.lid AND leilaor.dia = leilao.dia
              AND leilaor.nrleilaonodia = leilao.nrleilaonodia AND leilao.nif=leilaor.nif
              AND pessoa = ". $_SESSION['nif'];
    $result = $connection->query($sql);

    echo("<table class=\"ink-table alternating\">\n");
    echo("<thead><tr>
            <th>ID Leilão</th>
            <th>Data</th>
            <th>Nº do Dia</th>
            <th>Nome</th>
            <th>Valor Base</th>
            <th>Tipo</th>
          </tr></thead>");

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
    <h2>Fazer um lance</h2>
    <p>ID: <input type="text" name="leilao" /></p>
    <p>Valor: <input type="text" name="valor" /></p>
    <p><input class="ink-button" type="submit" /></p>
  </form>
  </div>
</body>
</html>

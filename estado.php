<html>
<?php require './head.php'; ?>
<body>
  <div class="ink-grid">

  <?php
    require_once('./globals.php');

    // inicia sessão para passar variaveis entre ficheiros php
    session_start();

    if($_SESSION['nif']=='') {
      header("Location: login.php"); /* Redirect browser */
      exit();
    }

    echo "<p>Leilões em que o utilizador participa: </p>\n";

    // Apresenta os leilões
    $sql = "SELECT *, DATEDIFF(DATE_ADD(leilaor.dia, INTERVAL leilaor.nrdias DAY), CURDATE()) as diasrestantes, MAX(lance.valor) as valormax
			FROM leilao, leilaor, concorrente, lance
			WHERE leilaor.lid = concorrente.leilao AND concorrente.pessoa = " . $_SESSION['nif'] . "
			  AND lance.leilao = leilaor.lid
			  AND leilaor.nif = leilao.nif AND leilaor.dia = leilao.dia AND leilaor.nrleilaonodia = leilao.nrleilaonodia
			  GROUP BY leilaor.lid
			ORDER BY leilaor.lid ASC";
    $result = $connection->query($sql);
    if(!$result) {
      echo("<div class=\"ink-alert basic error\" role=\"alert\">
              <p><b>Erro!</b></p>
            </div>");
  		exit();
    }
    echo("<table class=\"ink-table alternating\">\n");
    echo("<thead><tr>
            <th>ID</th>
            <th>NIF</th>
            <th>Data</th>
            <th>Nº do Dia</th>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Valor Base</th>
            <th>Nº Dias</th>
            <th>Dias Restantes</th>
            <th>Valor Max</th>
          </tr>");

    foreach($result as $row){
  		if ($row["diasrestantes"] > 0) {
        $data1 = strtotime($row["dia"]);
        $fim = $data1 + ($row["nrdias"] * 3600 * 24);

        echo("<tr><td>");
        echo($row["lid"]); echo("</td><td>");
        echo($row["nif"]); echo("</td><td>");
        echo($row["dia"]); echo("</td><td>");
        echo($row["nrleilaonodia"]); echo("</td><td>");
        echo($row["nome"]); echo("</td><td>");
        echo($row["tipo"]); echo("</td><td>");
        echo($row["valorbase"]); echo("</td><td>");
        echo($row["nrdias"]); echo("</td><td>");
        echo($row["diasrestantes"]);echo("</td><td>");
        echo($row["valormax"]);
      }
    }
    echo("</table>\n");

  ?>
  </div>
</body>
</html>

<html>
<body>
  <?php
    require_once('./globals.php');

    // inicia sessão para passar variaveis entre ficheiros php
    session_start();

    if($_SESSION['nif']=='') {
      header("Location: login.html"); /* Redirect browser */
      exit();
    }

    echo "<p>Leiloes em que o utilizador participa: </p>\n";

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
  		echo("<p> Erro na Query:($sql) <p>");
  		exit();
    }
    echo("<table border=\"1\">\n");
    echo("<tr><td>lid</td><td>nif</td><td>dia</td><td>NrDoDia</td><td>nome</td><td>tipo</td><td>valorbase</td><td>nrdias</td><td>diasrestantes</td><td>valormax</td></tr>\n");
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
</body>
</html>

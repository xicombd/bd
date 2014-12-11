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

    echo "<p>Leiloes em curso ou a iniciar: </p>\n";
    // Apresenta os leilões
    $sql = "
      SELECT *
      FROM leilaor, leilao
      WHERE leilaor.nif = leilao.nif AND leilaor.dia = leilao.dia AND leilaor.nrleilaonodia = leilao.nrleilaonodia AND leilaor.dia = cast('".$_REQUEST['dia']."' as DATE )
      HAVING DATEDIFF(DATE_ADD(leilaor.dia, INTERVAL leilaor.nrdias DAY), CURDATE()) > 0
      ORDER BY leilaor.lid ASC;";
    $result = $connection->query($sql);
    if(!$result) {
  		echo("<p> Erro na Query:($sql) <p>");
  		exit();
    }

    echo("<form method='post' action='t-leilao.php'>\n");

    echo("<table border=\"1\">\n");
    echo("<tr><td>concorrer</td><td>lid</td><td>nif</td><td>dia</td><td>NrDoDia</td><td>nome</td><td>tipo</td><td>valorbase</td><td>nrdias</td></tr>\n");
    foreach($result as $row){
      echo("<tr><td>");
      echo("<input type='checkbox' name='concorre[]' value= '" . $_SESSION['nif'] . "," . $row['lid'] . "'>"); echo("</td><td>");

      echo($row["lid"]); echo("</td><td>");
      echo($row["nif"]); echo("</td><td>");
      echo($row["dia"]); echo("</td><td>");
      echo($row["nrleilaonodia"]); echo("</td><td>");
      echo($row["nome"]); echo("</td><td>");
      echo($row["tipo"]); echo("</td><td>");
      echo($row["valorbase"]); echo("</td><td>");
      echo($row["nrdias"]);
    }
    echo("</table>\n");
    echo("<input type='submit' name='submit' value='submit'>");

 ?>
</body>
</html>

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

    echo "<h5>Leilões em curso ou a iniciar: </h5>\n";
    // Apresenta os leilões
    $sql = "
      SELECT *
      FROM leilaor, leilao
      WHERE leilaor.nif = leilao.nif AND leilaor.dia = leilao.dia AND leilaor.nrleilaonodia = leilao.nrleilaonodia AND leilaor.dia = cast('".$_REQUEST['dia']."' as DATE )
      HAVING DATEDIFF(DATE_ADD(leilaor.dia, INTERVAL leilaor.nrdias DAY), CURDATE()) > 0
      ORDER BY leilaor.lid ASC;";
    $result = $connection->query($sql);
    if(!$result) {
      echo("<div class=\"ink-alert basic error\" role=\"alert\">
              <p><b>Erro!</b></p>
            </div>");
  		exit();
    }

    echo("<form method='post' action='t-leilao.php'>\n");

    echo("<table class=\"ink-table alternating\">\n");
    echo("<thead><tr>
            <th></th>
            <th>ID</th>
            <th>NIF</th>
            <th>Data</th>
            <th>Nº do Dia</th>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Valor Base</th>
            <th>Nº dias</th>
          </tr></thead>");

    foreach($result as $row){
      echo("<tr><td>");
      echo("<input type='checkbox' name='concorre[]' value= '" . $_SESSION['nif'] . "," . $row['lid'] . "'>");
      echo("</td><td>");
      echo($row["lid"]);
      echo("</td><td>");
      echo($row["nif"]);
      echo("</td><td>");
      echo($row["dia"]);
      echo("</td><td>");
      echo($row["nrleilaonodia"]);
      echo("</td><td>");
      echo($row["nome"]);
      echo("</td><td>");
      echo($row["tipo"]);
      echo("</td><td>");
      echo($row["valorbase"]);
      echo("</td><td>");
      echo($row["nrdias"]);
    }
    echo("</table>");

    echo("<input class='ink-button' type='submit' name='submit' value='submit'>");

 ?>
  </div>
</body>
</html>

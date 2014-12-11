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

    echo "<h5>Escolha o dia do leilao em que pretende concorrer: </h5>\n";

    // Apresenta os dias
    $sql = "SELECT DISTINCT dia
      FROM leilaor
      ORDER BY dia ASC";
    $result = $connection->query($sql);
    if(!$result) {
      echo("<div class=\"ink-alert basic error\" role=\"alert\">
              <p><b>Erro!</b></p>
            </div>");
      exit();
    }

    echo("<div class=\"ink-navigation\">");
    echo("<ul class=\"dropdown\">");
    foreach($result as $row){
      echo("<li><a href='t-registo-dia.php?dia=" . $row['dia'] . "'>" . $row['dia'] . "</a></li>");
    }
    echo("</ul>");
    echo("</div>");

 ?>
  </div>
</body>
</html>
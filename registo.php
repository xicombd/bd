<html>
<?php require './head.php'; ?>
<body>
  <div class="ink-grid">

  <?php
    require_once('./globals.php');

    // inicia sessão para passar variaveis entre ficheiros php
    session_start();

    // Carregamento das variáveis username e pin do form HTML através do metodo POST;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = test_input($_POST["username"]);
      $pin = test_input($_POST["pin"]);
      // echo("<h5>Valida Pin da Pessoa $username</h5>\n");
      // obtem o pin da tabela pessoa
      $sql = "SELECT * FROM pessoa WHERE nif=" . $username;
      $result = $connection->query($sql);
      if (!$result) {
        echo("<div class=\"ink-alert basic error\" role=\"alert\">
                <p><b>Erro!</b></p>
              </div>");
        exit();
      }
      foreach($result as $row){
        $safepin = $row["pin"];
        $nif = $row["nif"];
      }
      if ($safepin != $pin ) {
        echo("<div class=\"ink-alert basic error\" role=\"alert\">
                <p><b>Pin inválido!</b></p>
              </div>");
        $connection = null;
        exit;
      }

      echo("<div class=\"ink-alert basic success\" role=\"alert\">
              <p><b>Pin válido!</b></p>
            </div>");

      // passa variaveis para a sessao;
      $_SESSION['username'] = $username;
      $_SESSION['nif'] = $nif;
    }

    if($_SESSION['nif']=='') {
      header("Location: login.php"); /* Redirect browser */
      exit();
    }

    echo "<h5>Leilões em curso ou a iniciar: </h5>";

    // Apresenta os leilões
    $sql = "SELECT *
      FROM leilaor, leilao
      WHERE leilaor.nif = leilao.nif AND leilaor.dia = leilao.dia AND leilaor.nrleilaonodia = leilao.nrleilaonodia
      HAVING DATEDIFF(DATE_ADD(leilaor.dia, INTERVAL leilaor.nrdias DAY), CURDATE()) > 0
      ORDER BY leilaor.lid ASC";

    $result = $connection->query($sql);
    if(!$result) {
      echo("<div class=\"ink-alert basic error\" role=\"alert\">
              <p><b>Erro!</b></p>
            </div>");
  		exit();
    }
    echo("<table class=\"ink-table alternating\">\n");
    echo("<thead>
           <tr><th>ID</th>
           <th>NIF</th>
           <th>Data</th>
           <th>Nº do Dia</th>
           <th>Nome</th>
           <th>Tipo</th>
           <th>Valor Base</th>
           <th>Nº dias</th>
           </tr>
         </thead>");

    foreach($result as $row){
  		// if ($row["diasrestantes"] > 0) {
  		echo("<tr><td>");
  		echo($row["lid"]); echo("</td><td>");
  		echo($row["nif"]); echo("</td><td>");
  		echo($row["dia"]); echo("</td><td>");
  		echo($row["nrleilaonodia"]); echo("</td><td>");
  		echo($row["nome"]); echo("</td><td>");
  		echo($row["tipo"]); echo("</td><td>");
  		echo($row["valorbase"]); echo("</td><td>");
  		echo($row["nrdias"]);
      // }
    }
    echo("</table>\n");

  ?>
  <form action="leilao.php" method="post">
    <h2>Escolha o ID do leilão que pretende concorrer</h2>
    <p>ID: <input type="text" name="lid" /></p>
    <p><input class="ink-button" type="submit" /></p>
  </form>
  </div>
</body>
</html>

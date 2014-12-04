<html>
<body>
  <?php
    require_once('./globals.php');

    // inicia sessão para passar variaveis entre ficheiros php
    session_start();

    // Função para limpar os dados de entrada
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    // Carregamento das variáveis username e pin do form HTML através do metodo POST;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = test_input($_POST["username"]);
      $pin = test_input($_POST["pin"]);

      echo("<p>Valida Pin da Pessoa $username</p>\n");
      // obtem o pin da tabela pessoa
      $sql = "SELECT * FROM pessoa WHERE nif=" . $username;
      $result = $connection->query($sql);
      if (!$result) {
        echo("<p> Erro na Query:($sql)<p>");
        exit();
      }
      foreach($result as $row){
        $safepin = $row["pin"];
        $nif = $row["nif"];
      }
      if ($safepin != $pin ) {
        echo "<p>Pin Invalido! Exit!</p>\n";
        $connection = null;
        exit;
      }
      echo "<p>Pin Valido! </p>\n";

      

      // passa variaveis para a sessao;
      $_SESSION['username'] = $username;
      $_SESSION['nif'] = $nif;
    }

    echo "<p>Leiloes em que o utilizador participa: </p>\n";
    
    // Apresenta os leilões em que o utilizador esta inscrito
    $sql = "SELECT *, DATEDIFF(DATE_ADD(l.dia, INTERVAL lr.nrdias DAY), CURDATE()) as diasrestantes
			FROM leilao as l, leilaor as lr, concorrente as c, lance as l
			WHERE l.nif = lr.nif AND l.dia = lr.dia AND l.nrleilaonodia = lr.nrleilaonodia AND c.leilao = lr.lid AND c.pessoa = " . $username .
			" ORDER BY lr.lid ASC";
    $result = $connection->query($sql);
    if(!$result) {
  		echo("<p> Erro na Query:($sql) <p>");
  		exit();
    }
    echo("<table border=\"1\">\n");
    echo("<tr><td>lid</td><td>nif</td><td>dia</td><td>NrDoDia</td><td>nome</td><td>tipo</td><td>valorbase</td><td>nrdias</td><td>diasrestantes</td></tr>\n");
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
    		echo($row["diasrestantes"]);
      }
    }
    echo("</table>\n");
    
    
    echo "<p>Leiloes em curso ou a iniciar: </p>\n";
    
    // Apresenta os leilões
    $sql = "SELECT *, DATEDIFF(DATE_ADD(l.dia, INTERVAL lr.nrdias DAY), CURDATE()) as diasrestantes FROM leilao as l, leilaor as lr
	      WHERE l.nif = lr.nif AND l.dia = lr.dia AND l.nrleilaonodia = lr.nrleilaonodia
	      ORDER BY lr.lid ASC";
    $result = $connection->query($sql);
    if(!$result) {
  		echo("<p> Erro na Query:($sql) <p>");
  		exit();
    }
    echo("<table border=\"1\">\n");
    echo("<tr><td>lid</td><td>nif</td><td>dia</td><td>NrDoDia</td><td>nome</td><td>tipo</td><td>valorbase</td><td>nrdias</td></tr>\n");
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
    		echo($row["nrdias"]);
      }
    }
    echo("</table>\n");
    
  ?>
  <form action="leilao.php" method="post">
    <h2>Escolha o ID do leilão que pretende concorrer</h2>
    <p>ID : <input type="text" name="lid" /></p>
    <p><input type="submit" /></p>
  </form>
</body>
</html>

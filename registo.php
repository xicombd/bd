<html>
<body>
  <?php
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
    }
    echo("<p>Valida Pin da Pessoa $username</p>\n");
    // Variáveis de conexão à BD
    $host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
    $user="ist175735"; // -> substituir pelo nome de utilizador
    $password="dakn7512"; // -> substituir pela password dada pelo mysql_reset
    $dbname = $user; // a BD tem nome identico ao utilizador
    echo("<p>Projeto Base de Dados Parte II</p>\n");
    $connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    echo("<p>Connected to MySQL database $dbname on $host as user $user</p>\n");
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
    
    echo "<p>Leiloes em curso ou a iniciar: </p>\n";
    
    // passa variaveis para a sessao;
    $_SESSION['username'] = $username;
    $_SESSION['nif'] = $nif;
    // Apresenta os leilões
    $sql = "SELECT * FROM leilao as l, leilaor as lr 
	      WHERE l.nif = lr.nif AND l.dia = lr.dia AND l.nrleilaonodia = lr.nrleilaonodia";
    $result = $connection->query($sql);
    echo("<table border=\"1\">\n");
    echo("<tr><td>ID</td><td>nif</td><td>diahora</td><td>NrDoDia</td><td>nome</td><td>tipo</td><td>valorbase</td><td>nrdias</td><td>lid</td></tr>\n");
    $idleilao = 0;
    foreach($result as $row){
		/*if (date_add(strtotime($row["dia"], date_interval_create_from_date_string($row["nrdias"] . " days")))) {
			
		}*/
		/*$data1 = strtotime($row["dia"]);
		$fim = $data1 + ($row["nrdias"] * 3600 * 24);
		
		if(!coiso) {
			echo "erro";
		}
		echo $fim;
		echo "\n";*/
		
		
      $idleilao = $idleilao +1;
      echo("<tr><td>");
      echo($idleilao); echo("</td><td>");
      echo($row["nif"]); echo("</td><td>");
      echo($row["diahora"]); echo("</td><td>");
      echo($row["nrleilaonodia"]); echo("</td><td>");
      echo($row["nome"]); echo("</td><td>");
      echo($row["tipo"]); echo("</td><td>");
      echo($row["valorbase"]); echo("</td><td>");
      echo($row["nrdias"]); echo("</td><td>");
      echo($row["lid"]); echo("</td><td>");
      $leilao[$idleilao]= array($row["nif"],$row["diahora"],$row["nrleilaonodia"],$row["nrdias"],$row["lid"]);
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

<html>
<body>
  <?php
    require_once('./globals.php');

    // inicia sessão para passar variaveis entre ficheiros php
    session_start();

    $username = $_SESSION['username'];
    $nif = $_SESSION['nif'];
    // Função para limpar os dados de entrada
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    // Carregamento das variáveis username e pin do form HTML através do metodo POST;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      //$lid = test_input($_POST["lid"]);

      
      
    if(isset($_POST['concorre']))
    {
      $connection->query("START TRANSACTION");
      foreach($_POST['concorre'] as $value){
	$sql = "INSERT INTO concorrente VALUES ($value)";
	$result = $connection->query($sql);
	if (!$result) {
        echo("<p> Pessoa nao registada: Erro na Query:($sql) <p>");
        exit();
      }
      }
      
      $connection->query("COMMIT");
    }
    
    
      //regista a pessoa no leilão. Exemplificativo apenas.....
      /*$sql = "INSERT INTO concorrente (pessoa,leilao) VALUES ($nif,$lid)";
      $result = $connection->query($sql);
      if (!$result) {
        echo("<p> Pessoa nao registada: Erro na Query:($sql) <p>");
        exit();
      }
      echo("<p> Pessoa ($username), nif ($nif) Registada no leilao ($lid)</p>\n");*/
      

      
      
    }
    
    if($_SESSION['nif']=='') {
      header("Location: login.html"); /* Redirect browser */
      exit();
    }

    echo("<p> Leiloes em que este individuo esta a concorrer: </p>\n");


    $sql = "SELECT * FROM concorrente WHERE pessoa = ". $_SESSION['nif'];
    $result = $connection->query($sql);

    echo("<table border=\"1\">\n");
    echo("<tr><td>leilao</td></tr>\n");
    $idleilao = 0;
    foreach($result as $row){
      echo("<tr><td>");
      echo($row["leilao"]); echo("</td><td>");
      $idleilao = $idleilao + 1;
      $leilao[$idleilao]= array($row["leilao"]);
    }
    echo("</table>\n");

  ?>
  <form action="lance.php" method="post">
    <h2>Comprar cenas</h2>
    <p>ID : <input type="text" name="leilao" /></p>
    <p>Valor : <input type="text" name="valor" /></p>
    <p><input type="submit" /></p>
  </form>
</body>
</html>

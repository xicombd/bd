<html>
<body>
  <?php
    // inicia sessão para passar variaveis entre ficheiros php
    session_start();
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
      $leilao = test_input($_POST["leilao"]);
      $valor = test_input($_POST["valor"]);
    }
    // Conexão à BD
    $host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
    $user="ist175735"; // -> substituir pelo nome de utilizador
    $password="dakn7512"; // -> substituir pela password dada pelo mysql_reset
    $dbname = $user; // a BD tem nome identico ao utilizador
    $connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    echo("<p>Connected to MySQL database $dbname on $host as user $user</p>\n");
    //regista a pessoa no leilão. Exemplificativo apenas.....
    $sql = "INSERT INTO lance (pessoa,leilao,valor) VALUES ($nif,$leilao,$valor)";
    $result = $connection->query($sql);
    if (!$result) {
      echo("<p> Pessoa nao registada: Erro na Query:($sql) <p>");
      exit();
    }
    echo("<p> Lance feito </p>\n");
    
    //termina a sessão
    session_destroy();
  ?>
</body>
</html>

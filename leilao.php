<html>
<body>
  <?php
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
      $lid = test_input($_POST["lid"]);
    }
    // Conexão à BD
    $host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
    $user="XXXXX"; // -> substituir pelo nome de utilizador
    $password="XXXXX"; // -> substituir pela password dada pelo mysql_reset
    $dbname = $user; // a BD tem nome identico ao utilizador
    $connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    echo("<p>Connected to MySQL database $dbname on $host as user $user</p>\n");
    //regista a pessoa no leilão. Exemplificativo apenas.....
    $sql = "INSERT INTO concorrente (pessoa,leilao) VALUES ($nif,$lid)";
    $result = $connection->query($sql);
    if (!$result) {
      echo("<p> Pessoa nao registada: Erro na Query:($sql) <p>");
      exit();
    }
    echo("<p> Pessoa ($username), nif ($nif) Registada no leilao ($lid)</p>\n");
    // to be continued….
    //termina a sessão
    session_destroy();
  ?>
</body>
</html>
<br>
<?php
  // Variáveis de conexão à BD
  $host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
  $user="ist175735"; // -> substituir pelo nome de utilizador
  $password="dakn7512"; // -> substituir pela password dada pelo mysql_reset
  $dbname = $user; // a BD tem nome identico ao utilizador
  echo("<h1>Projeto Base de Dados Parte II</h1>\n");
  $connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password,
  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

  echo("<div class=\"ink-alert basic info\" role=\"alert\">");
  echo("<p><b>Connection:</b> Connected to MySQL database $dbname on $host as user $user</p>");
  echo("</div>");

  // Função para limpar os dados de entrada
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  // session_start();
?>

<nav class="ink-navigation">
  <ul class="menu horizontal grey">
    <li><a href='registo'>Registo</a></li>
    <li><a href='t-registo'>Registo Atómico</a></li>
    <li><a href='leilao'>Leilões</a></li>
    <li><a href='estado'>Estado</a></li>
  </ul>
</nav>

<br>
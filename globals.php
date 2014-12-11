<?php
  // Variáveis de conexão à BD
  $host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
  $user="ist175735"; // -> substituir pelo nome de utilizador
  $password="dakn7512"; // -> substituir pela password dada pelo mysql_reset
  $dbname = $user; // a BD tem nome identico ao utilizador
  echo("<h1>Projeto Base de Dados Parte II</h1>\n");
  $connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password,
  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
  echo("<p><i>Connected to MySQL database $dbname on $host as user $user</i></p>\n");

  echo("<h3>");
  echo("<a href='registo'>Registo</a> \n");
  echo("<a href='t-registo'>Registo Atomico</a> \n");
  echo("<a href='leilao'>Leiloes</a> \n");
  echo("<a href='estado'>Estado</a> \n");
  echo("</h3>");

  // Função para limpar os dados de entrada
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  // session_start();
?>
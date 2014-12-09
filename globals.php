<?php
  // Variáveis de conexão à BD
  $host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
  $user="ist175735"; // -> substituir pelo nome de utilizador
  $password="dakn7512"; // -> substituir pela password dada pelo mysql_reset
  $dbname = $user; // a BD tem nome identico ao utilizador
  echo("<p>Projeto Base de Dados Parte II</p>\n");
  $connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password,
  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
  echo("<p>Connected to MySQL database $dbname on $host as user $user</p>\n");
  
  
  echo("<a href='registo'>Registo</a> \n");
  echo("<a href='leilao'>Leiloes</a> \n");
  echo("<a href='estado'>Estado</a> \n");
  
  session_start();
?>
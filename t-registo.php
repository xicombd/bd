<html>
<body>
  <?php
    require_once('./globals.php');

    // inicia sessão para passar variaveis entre ficheiros php
    session_start();
    
   if($_SESSION['nif']=='') {
      header("Location: login.html"); /* Redirect browser */
      exit();
    }
    
    echo "<p>Escolha o dia do leilao em que pretende concorrer: </p>\n";
    
    // Apresenta os dias
    $sql = "SELECT DISTINCT dia
	    FROM leilaor
	    ORDER BY dia ASC";
    $result = $connection->query($sql);
    if(!$result) {
  		echo("<p> Erro na Query:($sql) <p>");
  		exit();
    }
    
    
    foreach($result as $row){	
       echo("<a href='t-registo-dia.php?dia=" . $row['dia'] . "'>" . $row['dia'] . "</a><br>");
    }
    
    
 ?>
</body>
</html>

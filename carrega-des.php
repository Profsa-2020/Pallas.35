<?php   
     $sta = 0;
     $des = '';
     session_start();
     $tab_w = array();     
     include "lerinformacao.inc";
     include_once "funcoes.php";
     if (isset($_REQUEST['term']) == true) { $des = $_REQUEST['term']; }    // term é o nome fixo
     if (strlen($des) >= 3) { 
          $com = "Select idproduto, prodescricao from tb_produto where prostatus = 0 and proempresa = " .  $_SESSION['wrkcodemp'] . " and prodescricao like '%" . $des . "%' order by prodescricao Limit 50";
          $sql = $mysqli->prepare($com);
          $sql->execute();
          $sql->bind_result($cod, $des);
          while ($sql->fetch()) {    
               $tab_w[] = trim($des) . ' [' . $cod . ']';
          }
     }
     echo json_encode($tab_w);     
?>    

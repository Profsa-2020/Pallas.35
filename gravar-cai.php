<?php
     $sta = 0;
     $tip = '';
     session_start();
     $tab = array();
     $tab['men'] = '';
     include "lerinformacao.inc";
     include_once "funcoes.php";
     if (isset($_REQUEST['tip']) == true) { $tip = $_REQUEST['tip']; }
     if (isset($_REQUEST['val']) == true) { $val = $_REQUEST['val']; }
     if (isset($_REQUEST['obs']) == true) { $obs = $_REQUEST['obs']; }
     if ($val == "" || $val == "," || $val == ".," || $val == "0")  {
          $tab['men'] = 'Não foi informado valor para movimento de caixa';
     }
     if ($tip == "") {
          $tab['men'] = 'Não foi informado tipo de movimento sângria ou supirimento';
     }
     if ($obs == "") {
          $tab['men'] = 'Não foi informado histórico para movimento de caixa';
     }
     if ($tab['men'] == "") {
          $sal = apura_sal();
          $val = str_replace(".", "", $val); $val = str_replace(",", ".", $val);
          if ($tip == 1) {
               $sal = $sal - $val;
          } else if ($tip == 2) {
               $sal = $sal + $val;
          }
          $sql  = "insert into tb_movto_b (";
          $sql .= "movempresa, ";
          $sql .= "movstatus, ";
          $sql .= "movtipo, ";
          $sql .= "movdata, ";
          $sql .= "movcliente, ";
          $sql .= "movfavorecido, ";
          $sql .= "movcnpj, ";
          $sql .= "movserienot, ";
          $sql .= "movnumeronot, ";
          $sql .= "movvalormov, ";
          $sql .= "movvalorsal, ";
          $sql .= "movobservacao, ";
          $sql .= "keyinc, ";
          $sql .= "datinc ";
          $sql .= ") value ( ";
          $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . $tip . "',";
          $sql .= "'" . date("Y-m-d H:i:s") . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . 'Movimento Manual de Caixa' . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . $val . "',";
          $sql .= "'" . $sal . "',";
          $sql .= "'" . str_replace("'", "´", $obs) . "',";
          $sql .= "'" . $_SESSION['wrkideusu'] . "',";
          $sql .= "'" . date("Y/m/d H:i:s") . "')";
          $ret = mysqli_query($conexao,$sql);
          if ($ret == false) {
               $tab['men'] == "Erro na gravação do movimento de caixa solicitado !";
          }
          $ret = desconecta_bco();     
     }
     echo json_encode($tab);     

function apura_sal() {
     $sal = 0;
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select movtipo, Sum(movvalormov) as movvalor from tb_movto_b where movempresa = " . $_SESSION['wrkcodemp'] . " group by movtipo");
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['movtipo'] == 1) { $sal = $sal - $reg['movvalor']; }
          if ($reg['movtipo'] == 2) { $sal = $sal + $reg['movvalor']; }
          if ($reg['movtipo'] == 3) { $sal = $sal + $reg['movvalor']; }
     }
     return $sal;
}     

?>
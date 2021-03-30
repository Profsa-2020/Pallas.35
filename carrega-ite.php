<?php
     $ope = 0;
     $cod = 0;
     session_start();
     $tab = array();
     $tab['sta'] = 0;
     include "lerinformacao.inc";
     include_once "funcoes.php";
     if (isset($_REQUEST['ope']) == true) { $ope = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $cod = $_REQUEST['cod']; }
     if ($ope == "") {$ope = 0;}
     if ($cod == "") {$cod = 0;}
     if (isset($_SESSION['wrkiteped']['cod']) == true) {
          $nro = count($_SESSION['wrkiteped']['cod']);
          $ind = array_search($cod, $_SESSION['wrkiteped']['cod']);
          if ($ind !==  false) {
               $tab['sta'] = 1;
               $tab['seq'] = $_SESSION['wrkiteped']['seq'][$ind];
               $tab['cod'] = $_SESSION['wrkiteped']['cod'][$ind];
               $tab['des'] = $_SESSION['wrkiteped']['des'][$ind];
               $tab['uni'] = $_SESSION['wrkiteped']['med'][$ind];
               $tab['qtd'] = $_SESSION['wrkiteped']['qtd'][$ind];
               $tab['pre'] = number_format($_SESSION['wrkiteped']['liq'][$ind], 2, ',', '.');
               $tab['sit'] = $_SESSION['wrkiteped']['sit'][$ind];
               $tab['ncm'] = $_SESSION['wrkiteped']['ncm'][$ind];
               $tab['bar'] = $_SESSION['wrkiteped']['bar'][$ind];
               $tab['cfo'] = $_SESSION['wrkiteped']['cfo'][$ind];     
               $tab['val'] = 'R$ ' . number_format($_SESSION['wrkiteped']['val'][$ind], 2, ',', '.');      
          }
     }
     echo json_encode($tab);     
?>
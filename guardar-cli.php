<?php
     $cpf = 0;
     $nom = 0;
     session_start();
     $tab = array();
     $tab['men'] = '';
     include "lerinformacao.inc";
     include_once "funcoes.php";
     if (isset($_REQUEST['cpf']) == true) { $cpf = $_REQUEST['cpf']; }
     if (isset($_REQUEST['nom']) == true) { $nom = $_REQUEST['nom']; }
     if (isset($_REQUEST['end']) == true) { $end = $_REQUEST['end']; }
     if (isset($_REQUEST['num']) == true) { $num = $_REQUEST['num']; }
     if (isset($_REQUEST['com']) == true) { $com = $_REQUEST['com']; }
     if (isset($_REQUEST['cep']) == true) { $cep = $_REQUEST['cep']; }
     if (isset($_REQUEST['bai']) == true) { $bai = $_REQUEST['bai']; }
     if (isset($_REQUEST['cid']) == true) { $cid = $_REQUEST['cid']; }
     if (isset($_REQUEST['est']) == true) { $est = $_REQUEST['est']; }
     if (isset($_REQUEST['ema']) == true) { $ema = $_REQUEST['ema']; }
     if (isset($_REQUEST['cel']) == true) { $cel = $_REQUEST['cel']; }
     
     $_SESSION['wrkiteped']['cli']['cpf'] = $cpf;
     $_SESSION['wrkiteped']['cli']['nom'] = $nom;
     $_SESSION['wrkiteped']['cli']['end'] = $end;
     $_SESSION['wrkiteped']['cli']['num'] = $num;
     $_SESSION['wrkiteped']['cli']['com'] = $com;
     $_SESSION['wrkiteped']['cli']['cep'] = $cep;
     $_SESSION['wrkiteped']['cli']['bai'] = $bai;
     $_SESSION['wrkiteped']['cli']['cid'] = $cid;
     $_SESSION['wrkiteped']['cli']['est'] = $est;
     $_SESSION['wrkiteped']['cli']['ema'] = $ema;
     $_SESSION['wrkiteped']['cli']['cel'] = $cel;

     echo json_encode($tab);     

?>
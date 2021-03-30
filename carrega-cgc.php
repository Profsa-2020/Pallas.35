<?php
     $cgc = '';
     session_start();
     $tab = array();
     include_once "funcoes.php";
     $dad['emi']['cod'] = 0;
     use NFePHP\NFe\Tools;
     use NFePHP\Common\Certificate;
     use NFePHP\NFe\Common\Standardize;
     if (isset($_REQUEST['cgc']) == true) { $cgc = limpa_nro($_REQUEST['cgc']); }
     include_once "inclusao.php";
     include_once "lerinformacao.inc";
     error_reporting(E_ALL);
     ini_set('display_errors', 'On'); 
     $com = "Select * from tb_emitente where idemite = " . $_SESSION['wrkcodemp'];
     $sql = mysqli_query($conexao,$com);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $dad['emi']['cod'] = $lin['idemite'];
          $dad['emi']['raz'] = $lin['emirazao'];
          $dad['emi']['cgc'] = $lin['emicnpj'];
          $dad['emi']['est'] = $lin['emiestado'];
          $dad['emi']['csc'] = $lin['eminumerocsc'];
          $dad['emi']['amb'] = $lin['emitipoamb'];
          $dad['emi']['cer'] = $lin['emicamcertif'];
          $dad['emi']['sen'] = $lin['emisencertif'];
          $dad['emi']['val'] = $lin['emidatcertif'];
          $dad['emi']['emi'] = date('Y-m-d H:i:s');
          $dad['not']['con'] = configura_not($dad);
     }
     $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['cer']; 
     $cer = file_get_contents($dir);
     $tools = new Tools($dad['not']['con'], Certificate::readPfx($cer, $dad['emi']['sen']));
     $tools->model('55');
     $est = $dad['emi']['est'];
     $ins = '';
     $cpf = '';

     $ret = $tools->sefazCadastro($est, $cgc, $ins, $cpf);
 
     $stdCl = new Standardize($ret);
     $std = $stdCl->toStd();
     $tab['sta'] = $std->infCons->cStat;    
     $tab['mot'] = $std->infCons->xMotivo;
     $tab['cgc'] = $std->infCons->CNPJ;       
     if (isset($std->infCons->infCad->IE) == false) {  
          $tab['ins'] = 'ISENTO';
     } else {
          $tab['ins'] = $std->infCons->infCad->IE;
          $tab['raz'] = $std->infCons->infCad->xNome;
          $tab['cna'] = $std->infCons->infCad->CNAE;     
     }
     
     echo json_encode($tab);     

?>

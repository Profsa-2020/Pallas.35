<?php
     $sta = 0;
     $txt = '';
     $men = '';
     session_start();
     $tab = array();
     $tab['men'] = '';
     include "lerinformacao.inc";
     include_once "funcoes.php";
     if (isset($_REQUEST['cpf']) == true) { $cpf = $_REQUEST['cpf']; }
     if (isset($_REQUEST['cep']) == true) { $cep = $_REQUEST['cep']; }
     if (isset($_REQUEST['pag']) == true) { $pag = $_REQUEST['pag']; }
     if (isset($_REQUEST['tot']) == true) { $tot = $_REQUEST['tot']; }
     if (isset($_REQUEST['inf']) == true) { $inf = $_REQUEST['inf']; }
     if (isset($_REQUEST['dsc']) == true) { $dsc = $_REQUEST['dsc']; }
     if (isset($_REQUEST['tro']) == true) { $tro = $_REQUEST['tro']; }

     $sta = pagto_exi(limpa_nro($pag), $des, $dad);
     if (isset($_SESSION['wrkiteped']['cli']['cpf']) == true) {
          $txt .= '<strong><h5>' . 'C.p.f.: ' . $_SESSION['wrkiteped']['cli']['cpf'] . '</strong></h5>';
          $txt .= '<strong><h5>' . 'Nome: ' . $_SESSION['wrkiteped']['cli']['nom'] . '</strong></h5>';
          $txt .= '<h5>' . 'C.e.p.: ' . $_SESSION['wrkiteped']['cli']['cep'] . '</h5>';
          $txt .= '<h5>' . 'Endereço: ' . $_SESSION['wrkiteped']['cli']['end'] . ', ' . $_SESSION['wrkiteped']['cli']['num'] . ' ' . $_SESSION['wrkiteped']['cli']['com'] . '</h5>';
          $txt .= '<h5>' . 'Bairro: ' . $_SESSION['wrkiteped']['cli']['bai'] . ' - Cidade: ' . $_SESSION['wrkiteped']['cli']['cid'] . ' - Estado: ' . $_SESSION['wrkiteped']['cli']['est'] . '</h5>';
          $txt .= '<h5>' . 'E-Mail: ' . $_SESSION['wrkiteped']['cli']['ema'] . ' - Telefone: ' . $_SESSION['wrkiteped']['cli']['cel'] . '</h5>';
          $txt .= '<br />';
     }
     $txt .= '<strong><h5>' . 'Forma de Pagamento: ' . $des . '</strong></h5>';
     $txt .= '<h5>' . 'Valor Total: ' . $tot . '</h5>';
     $txt .= '<h5>' . 'Informado: ' . $inf . '</h5>';
     $txt .= '<h5>' . 'Desconto: ' . $dsc . '</h5>';
     $txt .= '<h5>' . 'Troco: ' . $tro . '</h5>';
     $txt .= '<br />';

     $tab['txt'] = $txt;
     echo json_encode($tab);     

?>
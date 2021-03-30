<?php
    $ant = "";
    $rec = 00;
    $pag = 00;
    $com = "";
    session_start();
    $tab_w = array();    
    include_once "funcoes.php";
    $dat = date("d-m-Y");
    $dti = '01' . '-' . '01' . '-' . substr($dat,6,4);
    $dtf = '31' . '-' . '12' . '-' . substr($dat,6,4);
    for ($ind = 1; $ind <= 12; $ind++) {
        $tab_w['val'][] = 0;
        $tab_w['tit'][] = substr(mes_ano($ind),0,3) . '/' . substr($dat,6,4);
    }
    if (isset($_REQUEST['dti']) == true) { $dti = $_REQUEST['dti']; }
    if (isset($_REQUEST['dtf']) == true) { $dtf = $_REQUEST['dtf']; }
    if ($dti != "" && $dtf != "") {
        $dti = substr($dti,6,4) . "-" . substr($dti,3,2) . "-" . substr($dti,0,2);
        $dtf = substr($dtf,6,4) . "-" . substr($dtf,3,2) . "-" . substr($dtf,0,2);
    }
    include "lerinformacao.inc";
    $com .= " Select notdatemissao as dat, Sum(notvalnota) as tot from tb_nota_e ";
    $com .= " where notempresa = " . $_SESSION['wrkcodemp'] . " and notdatemissao between '" . $dti . "' and '" . $dtf . "'"; 
    $com .= " and notstatus = 0 group by dat order by dat";
    $sql = $mysqli->prepare($com);
	$sql->execute();
    $sql->bind_result($ven, $val);
	while ($sql->fetch()) {
        $mes = (int) date('m', strtotime($ven)) - 1;
        $tab_w['val'][$mes] += $val;
    }
    echo json_encode($tab_w);
?>
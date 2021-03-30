<?php
     $sta = 0;
     $pag = 0;
     $inf = 0;
     $dsc = 0;
     $tro = 0;
     $cpf = 0;
     $nom = '';
     $ema = '';
     $tab = array();
     session_start();

     $tab['txt'] = ''; $tab['men'] = '';  $tab['rec'] = '';  $tab['ret'] = ''; $tab['xml'] = ''; $tab['pdf'] = '';

     include "lerinformacao.inc";
     include_once "funcoes.php";

     $dad = array();
     $dad['men'] = '';

     use NFePHP\NFe\Convert;
     use NFePHP\NFe\Tools;
     use NFePHP\Common\Certificate;
     use NFePHP\NFe\Common\Standardize;
     use NFePHP\NFe\Complements;     
     use NFePHP\Common\Validator;
     use NFePHP\DA\NFe\Danfce;
     use NFePHP\DA\Legacy\FilesFolders;

     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['pag']) == true) { $pag = $_REQUEST['pag']; }
     if (isset($_REQUEST['inf']) == true) { $inf = $_REQUEST['inf']; }
     if (isset($_REQUEST['dsc']) == true) { $dsc = $_REQUEST['dsc']; }
     if (isset($_REQUEST['tro']) == true) { $tro = $_REQUEST['tro']; }
     if (isset($_REQUEST['cpf']) == true) { $cpf = $_REQUEST['cpf']; }
     if (isset($_REQUEST['nom']) == true) { $nom = $_REQUEST['nom']; }
     if (isset($_REQUEST['ema']) == true) { $ema = $_REQUEST['ema']; }

    if (isset($_SESSION['wrknumdoc']) == false) { $_SESSION['wrknumdoc'] = 0; }
    if (isset($_SESSION['wrknumcha']) == false) { $_SESSION['wrknumcha'] = 0; }
    if (isset($_SESSION['wrkrecnot']) == false) { $_SESSION['wrkrecnot'] = ''; }
    if (isset($_SESSION['wrkchanot']) == false) { $_SESSION['wrkchanot'] = ''; }

    $dad['cli']['cgc'] = $cpf;
    $dad['cli']['raz'] = $nom;
    $dad['cli']['ema'] = $ema;

    if (isset($dad['emi']['cod']) == false) {
        $ret = carrega_emp($dad); 
        $ret = carrega_emi($dad); 
        $ret = carrega_des($dad); 
    }

    $dad['ped']['tra'] = 0;
    $dad['ven']['qtd'] = 0;
    $dad['ped']['liq'] = 0;
    $dad['ped']['bru'] = 0;
    $dad['ped']['cli'] = 0;
    $dad['pag']['cod'] = 0;
    $dad['pag']['par'] = 0;
    $dad['tra']['cod'] = 0;
    $dad['ped']['men'] = '';
    $dad['ped']['cod'] = 999999;
    $dad['ped']['pag'] = limpa_nro($pag); $dad['not']['qtd'] = 0;
    $dad['ped']['dsc'] = str_replace(",", ".", str_replace(".", "", $dsc));
    $dad['ped']['tro'] = str_replace(",", ".", str_replace(".", "", $tro));
    if ($dad['ped']['dsc'] == '') { $dad['ped']['dsc'] = 0; }
    if ($dad['ped']['tro'] == '') { $dad['ped']['tro'] = 0; }
    if (isset($_SESSION['wrkiteped']['cod']) == true) {
          $dad['not']['qtd'] = count($_SESSION['wrkiteped']['cod']);
    }
    if ($dad['not']['qtd'] > 0) {
        for ($ind = 0; $ind < $dad['not']['qtd']; $ind++) {
            if ($_SESSION['wrkiteped']['cod'][$ind] != 0) {
                if ($_SESSION['wrkiteped']['sta'][$ind] != 3) { 
                    $dad['seq'][] = $ind;
                    $dad['sta'][] = $_SESSION['wrkiteped']['sta'][$ind];
                    $dad['cod'][] = $_SESSION['wrkiteped']['cod'][$ind];
                    $dad['des'][] = $_SESSION['wrkiteped']['des'][$ind];
                    $dad['med'][] = $_SESSION['wrkiteped']['med'][$ind];
                    $dad['qua'][] = $_SESSION['wrkiteped']['qtd'][$ind];
                    $dad['qtd'][] = number_format($_SESSION['wrkiteped']['qtd'][$ind], 0, ',', '.');
                    $dad['pre'][] = number_format($_SESSION['wrkiteped']['bru'][$ind], 2, ',', '.');
                    $dad['uni'][] = $_SESSION['wrkiteped']['liq'][$ind];
                    $dad['bru'][] = $_SESSION['wrkiteped']['bru'][$ind];
                    $dad['liq'][] = $_SESSION['wrkiteped']['liq'][$ind];
                    $dad['val'][] = $_SESSION['wrkiteped']['val'][$ind];
                    $ret = ler_produto($_SESSION['wrkiteped']['cod'][$ind], $sit, $ref, $ncm, $bar, $icm, $ipi, $iva);
                    $dad['sit'][] = $sit;
                    $dad['ref'][] = $ref;
                    $dad['ncm'][] = $ncm;
                    $dad['bar'][] = $bar;
                    $dad['pcc'][] = $icm;
                    $dad['pcp'][] = $ipi;
                    $dad['pcv'][] = $iva;
                    $dad['pai'][] = '0.00';  // Percentual de aproveitamento de Icms
                    $dad['vci'][] = '0.00';  // Valor de crédito de Icms
                    $dad['bst'][] = '0.00';  // Base de calculo ST
                    $dad['vst'][] = '0.00';  // Valor de ST
                    $dad['pst'][] = '0.00';  // Percentual de ST
                    $dad['cfo'][] = $dad['par']['cfo'];                              
                    $dad['ped']['liq'] = $dad['ped']['liq'] + $_SESSION['wrkiteped']['val'][$ind];
                    $dad['ped']['bru'] = $dad['ped']['bru'] + $_SESSION['wrkiteped']['val'][$ind];
                  }
             }
         }
     }
     $ret = consiste_cup($dad);    
     if ($dad['men'] != "")  { $tab['men'] = $dad['men']; }
     if ($ret == 0) {
          $ret = calcular_val($dad);
          $ret = gravar_xml($dad);
          $ret = assinar_xml($dad);
          if ($dad['men'] != "")  {
               $tab['men'] = $dad['men'];
          } else {
               $tab['xml'] = $dad['not']['dir'];
               $ret = validar_xml($dad);
               if ($ret > 0)  {
                    $tab['men'] = $dad['men'];
               } else {
                    $ret = enviar_xml($dad);
                    include "lerinformacao.inc";
                    $tab['rec'] =  $dad['not']['sta'] . '-' . $dad['not']['men'];
                    $tab['ret'] =  $dad['not']['ret'] . '-' . $dad['not']['mot'];
                    if ($dad['not']['ret'] == '100') {
                         $ret = gravar_nfe($dad);
                         $ret = gravar_ite($dad);
                         $tab['pdf'] = $dad['not']['pdf'];
                         $_SESSION['wrkrecnot'] = 0;
                         $_SESSION['wrkchanot'] = 0;
                         $_SESSION['wrkvaltot'] = 0;
                         $_SESSION['wrkqtdtot'] = 0;
                         $_SESSION['wrknumcha'] = 999998;
                         $dad['emi']['not'] = $dad['emi']['not'] + 1;
                         $sql  = "update tb_emitente set ";
                         $sql .= "emicupomnum = '". $dad['emi']['not'] . "', ";
                         $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
                         $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
                         $sql .= "where idemite = " . $_SESSION['wrkcodemp'];
                         $ret = mysqli_query($conexao,$sql);
                         if ($ret == false) {
                              $tab['men'] = "Erro na regravação do próximo número de cupom !";
                         }
                         $_SESSION['wrkiteped'] = array(); 
                         $_SESSION['wrkqtdtot'] = 0; $_SESSION['wrkvaltot'] = 0;
                    }  
                    if ($dad['not']['ret'] == '204') {
                         $ret = gravar_nfe($dad);
                         $ret = gravar_ite($dad);
                         $tab['pdf'] = $dad['not']['pdf'];
                         $_SESSION['wrkiteped'] = array(); 
                         $_SESSION['wrkqtdtot'] = 0; $_SESSION['wrkvaltot'] = 0;
                    }
               }     
          }
     }

     echo json_encode($tab);     



function carrega_emp(&$dad) {
        $sta = 0;
        $dad['emp']['cod'] = 0;
        include "lerinformacao.inc";
        $com = "Select * from tb_empresa where idempresa = 1";
        $sql = mysqli_query($conexao,$com);
        if (mysqli_num_rows($sql) == 1) {
             $lin = mysqli_fetch_array($sql);
             $dad['emp']['cod'] = $lin['idempresa'];
             $dad['emp']['raz'] = $lin['emprazao'];
             $dad['emp']['cgc'] = $lin['empcnpj'];
             $dad['emp']['ema'] = $lin['empemail'];
             $dad['emp']['con'] = $lin['empcontato'];
             $dad['emp']['tel'] = limpa_nro($lin['emptelefone']);
             $dad['emp']['cel'] = limpa_nro($lin['empcelular']);
        }
        return $sta;
}
 
function carrega_emi(&$dad) {
        $sta = 0;
        include "lerinformacao.inc";
        $dad['emi']['par'] = 0;
        $dad['par']['cod'] = 0;
        $dad['emi']['nro'] = $_SESSION['wrkcodemp'];
        $com = "Select * from tb_emitente where idemite = " . $_SESSION['wrkcodemp'];
        $sql = mysqli_query($conexao,$com);
        if (mysqli_num_rows($sql) == 1) {
             $lin = mysqli_fetch_array($sql);
             $dad['emi']['cod'] = $lin['idemite'];
             $dad['emi']['raz'] = $lin['emirazao'];
             $dad['emi']['fan'] = $lin['emifantasia'];
             $dad['emi']['end'] = $lin['emiendereco'];
             $dad['emi']['num'] = $lin['eminumeroend'];
             $dad['emi']['com'] = $lin['emicomplemento'];
             $dad['emi']['bai'] = $lin['emibairro']; 
             $dad['emi']['cep'] = $lin['emicep'];
             $dad['emi']['cid'] = $lin['emicidade'];
             $dad['emi']['est'] = $lin['emiestado'];
             $dad['emi']['mun'] = $lin['emicodmunic'];
             $dad['emi']['cgc'] = $lin['emicnpj'];
             $dad['emi']['ins'] = $lin['emiinscricao'];
             $dad['emi']['imu'] = $lin['emiinsmunic'];
             $dad['emi']['cna'] = $lin['emicnae'];
             $dad['emi']['reg'] = $lin['emiregime'] + 1;    // 1-Simples 2-Simples-Excessão 3-Normal        
             $dad['emi']['pes'] = $lin['emipessoa'];
             $dad['emi']['tel'] = $lin['emitelefone'];
             $dad['emi']['cel'] = $lin['emicelular'];
             $dad['emi']['con'] = $lin['emicontato'];
             $dad['emi']['ema'] = $lin['emiemail'];
             $dad['emi']['ver'] = $lin['emiverao'];
             $dad['emi']['ser'] = $lin['emicupomser'];
             $dad['emi']['not'] = $lin['emicupomnum'];
             $dad['emi']['amb'] = $lin['emitipoamb'];
             $dad['emi']['log'] = $lin['emicamlogo'];
             $dad['emi']['cer'] = $lin['emicamcertif'];
             $dad['emi']['sen'] = $lin['emisencertif'];
             $dad['emi']['val'] = $lin['emidatcertif'];
             $dad['emi']['csc'] = $lin['eminumerocsc'];
             $dad['emi']['par'] = $lin['emiparametro'];
             $dad['emi']['emi'] = date('Y-m-d H:i:s');
             $dad['not']['con'] = configura_not($dad);             
        }
        $com = "Select * from tb_parametro where idparametro = " . $dad['emi']['par'];
        $sql = mysqli_query($conexao,$com);
        if (mysqli_num_rows($sql) == 1) {
            $lin = mysqli_fetch_array($sql);
            $dad['par']['cod'] = $lin['idparametro'];
            $dad['par']['nom'] = $lin['parnome'];
            $dad['par']['des'] = $lin['pardanfe'];
            $dad['par']['tip'] = $lin['partiponota'];
            $dad['par']['fin'] = $lin['parfinalidade'];
            $dad['par']['mod'] = $lin['parmodelo'];
            $dad['par']['sit'] = $lin['parsittributaria'];
            $dad['par']['icm'] = $lin['paricmsfixo'];
            $dad['par']['ipi'] = $lin['paripifixo'];
            $dad['par']['ric'] = $lin['parredicms'];
            $dad['par']['rip'] = $lin['parredipi'];
            $dad['par']['fun'] = $lin['parfundoper'];
            $dad['par']['fim'] = $lin['parfinalcfop'];
            $dad['par']['cfo'] = '5' . $lin['parfinalcfop'];
            if ($dad['par']['tip'] == 0) { $dad['par']['tpo'] = 1; }
            if ($dad['par']['tip'] == 1) { $dad['par']['tpo'] = 0; }
            if ($dad['par']['tip'] == 2) { $dad['par']['tpo'] = 0; }
            if ($dad['par']['tip'] == 3) { $dad['par']['tpo'] = 1; }
            if ($dad['par']['tip'] == 4) { $dad['par']['tpo'] = 0; }
            if ($dad['par']['tip'] == 5) { $dad['par']['tpo'] = 1; }
            if ($dad['par']['tip'] == 6) { $dad['par']['tpo'] = 0; }
            if ($dad['par']['tip'] == 7) { $dad['par']['tpo'] = 1; }
        }
        return $sta;
}

function carrega_des(&$dad) {
     $sta = 0;
     $dad['cli']['mun'] = "";
     $dad['cli']['ins'] = "";
     $dad['cli']['imu'] = "";
     $dad['cli']['con'] = 9;
     $dad['cli']['pes'] = 0; // 0 - Físca 1 - Jurídica
     $dad['cli']['tip'] = 3;  // Consumidor final 0-Normal 1-Consumidor Final
     if (isset($_SESSION['wrkiteped']['cli']['cpf']) == true) {         
          $dad['cli']['cod'] = 0;
          $dad['cli']['raz'] = $_SESSION['wrkiteped']['cli']['nom'];
          $dad['cli']['fan'] = $_SESSION['wrkiteped']['cli']['nom'];
          $dad['cli']['end'] = $_SESSION['wrkiteped']['cli']['end'];
          $dad['cli']['num'] = $_SESSION['wrkiteped']['cli']['num'];
          $dad['cli']['com'] = $_SESSION['wrkiteped']['cli']['com'];
          $dad['cli']['bai'] = $_SESSION['wrkiteped']['cli']['bai'];
          $dad['cli']['cep'] = $_SESSION['wrkiteped']['cli']['cep'];
          $dad['cli']['cid'] = $_SESSION['wrkiteped']['cli']['cid'];
          $dad['cli']['est'] = $_SESSION['wrkiteped']['cli']['est'];
          $dad['cli']['cgc'] = $_SESSION['wrkiteped']['cli']['cpf'];
          $dad['cli']['ins'] = 'Isento';
          $dad['cli']['imu'] = '';
          if (strlen(limpa_nro($_SESSION['wrkiteped']['cli']['cpf'])) <= 11) {
               $dad['cli']['pes'] = 0; // 0 - Física 1 - Jurídica
          } else {
               $dad['cli']['pes'] = 1; 
          }
         $dad['cli']['con'] = 9;  // 1-Contribuinte Icms 2-Contribuinte Isento 9-Não contribuinte
         $dad['cli']['tip'] = 3; // Consumidor final 0-Normal 1-Consumidor Final
          $dad['cli']['fre'] = 0;
          $dad['cli']['tel'] = $_SESSION['wrkiteped']['cli']['cel'];
          $dad['cli']['cel'] = $_SESSION['wrkiteped']['cli']['cel'];
          $dad['cli']['nom'] = $_SESSION['wrkiteped']['cli']['nom'];
          $dad['cli']['ema'] = $_SESSION['wrkiteped']['cli']['ema'];
          $dad['cli']['mun'] = "";
          if ($dad['cli']['est'] != "") {
               $dad['cli']['mun'] = cidade_exi($dad['cli']['est'], $dad['cli']['cid']); 
          } else {
               $dad['cli']['mun'] = cidade_exi($dad['emi']['est'], $dad['emi']['cid']); 
          }
     }
     if ($dad['cli']['mun'] == "") {
          $dad['cli']['mun'] = cidade_exi($dad['emi']['est'], $dad['emi']['cid']); 
     }
     return $sta;        
}

function consiste_cup(&$dad) {
    $sta = 0;
    if ( $dad['emi']['cer'] == "") {
         $dad['men'] = "Não há certificado cadastrado no emitente para emissão";
         return 1; 
    }
    if ( $dad['not']['qtd'] == 0 ) {
         $dad['men'] = "Não há item de produto informado para pré-nota informada";
         return 2; 
    }
    if ($dad['emi']['mun'] == "" || $dad['emi']['mun'] == "0") {
         $dad['men'] = "Código do município no emitente não pode estar em branco";
         return 3; 
    }
    if ($dad['cli']['mun'] == "" || $dad['cli']['mun'] == "0") {
         $dad['men'] = "Código do município no destinatário não pode estar em branco";
         return 4; 
    }
    if ($dad['emi']['not'] == 0) {
         $dad['men'] = "Número do cupom fiscal para o emitente não pode estar zerado";
         return 5; 
    }
    if ( $dad['emi']['par'] == 0) {
        $dad['men'] = "Parâmetro fiscal não foi informado no emitente do cupom";
        return 1; 
   }
   if ($_SESSION['wrkvaltot'] == 0) {
     $dad['men'] = "Valor total do copom fiscal não pode ser igual a Zero ";
     return 1; 
   }
   if (count($dad['cod']) == 0) {
         $dad['men'] = "Não há itens de produto informados para emissão do cupom";
         return 6; 
    }
    $cam = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['cer']; 
    if (file_exists($cam) == false) {
         $dad['men'] = "Caminho para o certificado digital não encontrado no sistema";
         return 7;
    }
    return $sta;
}

function ler_produto(&$cod, &$sit, &$ref, &$ncm, &$bar, &$icm, &$ipi, &$iva) {
    $sta = 0;
    include "lerinformacao.inc";
    $sql = mysqli_query($conexao,"Select * from tb_produto where idproduto = " . $cod);
    if (mysqli_num_rows($sql) == 1) {
        $lin = mysqli_fetch_array($sql);
        $sta = $lin['prostatus'];
        $des = $lin['prodescricao'];
        $ref = $lin['procodigo'];
        $ncm = $lin['pronumeroncm'];
        $bar = $lin['procodbarras'];
        $icm = $lin['propercentualicm'];
        $ipi = $lin['propercentualipi'];
        $iva = $lin['propercentualiva'];
        $sit = str_pad($lin['prosittributaria'], 4, "0",STR_PAD_LEFT);
    }
    return $sta;
}

function calcular_val(&$dad) {
     $sta = 0;
     $dad['ven']['qtd'] = 0;
     $dad['pag']['par'] = 0;
     $nro = count($dad['cod']);
     $bru = $dad['ped']['bru'];
     $des = $dad['ped']['dsc'];
     $liq = $dad['ped']['bru'] - $dad['ped']['dsc'];
     for ($ind = 0; $ind < $nro; $ind++) {
          $dad['bsc'][$ind] = $dad['val'][$ind];
          $dad['bss'][$ind] = $dad['val'][$ind];
        $dad['vlc'][$ind] = round($dad['val'][$ind] * $dad['pcc'][$ind] / 100, 2);
        $dad['vls'][$ind] = round($dad['val'][$ind] * $dad['pcv'][$ind] / 100, 2);
        $dad['vld'][$ind] = round($des * $dad['val'][$ind] / $bru, 2);   // Proporcionaliza desconto pelos itens
     }
     $dad['not']['bic'] = 0;
     $dad['not']['vic'] = 0;
     $dad['not']['ide'] = 0;
     $dad['not']['fcp'] = 0;
     $dad['not']['bst'] = 0;
     $dad['not']['vst'] = 0;
     $dad['not']['fst'] = 0;
     $dad['not']['fcr'] = 0;
     $dad['not']['val'] = $dad['ped']['bru'];
     $dad['not']['fre'] = 0;
     $dad['not']['seg'] = 0;
     $dad['not']['des'] = $dad['ped']['dsc'];
     $dad['not']['imp'] = 0;
     $dad['not']['vip'] = 0;
     $dad['not']['ipd'] = 0;
     $dad['not']['pis'] = 0;
     $dad['not']['cof'] = 0;
     $dad['not']['out'] = 0;
     $dad['not']['tpd'] = 1; // 1-Dentro Uf 2-Fora UF 3-Exterior    

     $dad['not']['not'] = $dad['ped']['bru'] - $dad['ped']['dsc'];
     $_SESSION['wrkqtdtot'] = $nro;
     $_SESSION['wrkvaltot'] = $dad['ped']['bru'] - $dad['ped']['dsc'];
}

function gravar_xml(&$dad) {
    $sta = 0;
    include_once "funcoes.php";
    if (file_exists('xml') == false) { mkdir('xml'); }
    $err = 'xml/' . 'NFC_' .  str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfc.err';
    $deb = 'xml/' . 'NFC_' .  str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfc.deb';
    if (file_exists($err) == true) { unlink($err); }
    if (file_exists($deb) == true) { unlink($deb); }

    $cha  = substr($dad['emi']['mun'], 0, 2);
    $cha .= substr($dad['emi']['emi'], 2, 2) . substr($dad['emi']['emi'], 5, 2);
    $cha .= $dad['emi']['cgc'];
    $cha .= $dad['par']['mod'];   // Modelo da NF-e eletrônica
    $cha .= str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT);
    $cha .= str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT);
    $cha .= '1' ;     // Contingencia - 1: Normal, 2: Contingência Off , 3: Contingência Scan 
    $cha .= numero_cha(substr(str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT), 1, 8)); 
    $cha .= digito_cha($cha);
    $dad['not']['cha'] = $cha; $_SESSION['wrkchanot'] = $cha;

    $ret = gravar_log(50, "Geração de XML para nota " . $dad['emi']['ser'] . "-" . $dad['emi']['not'] . " - Chave: " . $dad['not']['cha']); 

    $sai = 'NFC_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfc.xml';  
    $txt =  'xml/' . 'NFC_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfc.xml';

    $dad['not']['sai'] = $sai;
    $dad['not']['cam'] = $txt;
    $dad['not']['par'] = $dad['emi']['cgc'] . '.json';

    $fil = fopen($txt, 'w');

    $linha  = '<?xml version="1.0" encoding="UTF-8"?>';
    $linha .= '<NFe xmlns="http://www.portalfiscal.inf.br/nfe">';    
    $linha .= '<infNFe Id="NFe' . $cha . '" versao="4.00">';
    $linha .= '<ide>';
    $linha .= '<cUF>' . substr($dad['emi']['mun'], 0, 2) . '</cUF>';
    $linha .= '<cNF>' . numero_cha(substr(str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT), 1, 8)) . '</cNF>';
    $linha .= '<natOp>' . $dad['par']['des'] . '</natOp>';
    $linha .= '<mod>' . $dad['par']['mod'] . '</mod>';
    $linha .= '<serie>' . $dad['emi']['ser'] . '</serie>';
    $linha .= '<nNF>' . $dad['emi']['not'] . '</nNF>';

    $verao = ($dad['emi']['ver'] == 1 ? '-02:00' : '-03:00');   // 02:00 horário de verão
    $linha .= '<dhEmi>' . substr($dad['emi']['emi'], 0, 10) . "T" . substr($dad['emi']['emi'], 11) . $verao. '</dhEmi>';
    if ($dad['emi']['emi'] != "" && $dad['par']['mod'] == "55") {    
         $linha .= '<dhSaiEnt>' . substr($dad['emi']['emi'], 0, 10) . "T" . substr($dad['emi']['emi'], 11)  . $verao . '</dhSaiEnt>';    
    }
    $linha .= '<tpNF>' . $dad['par']['tpo'] . '</tpNF>';    
    $linha .= '<idDest>' . $dad['not']['tpd'] . '</idDest>';    // 1-Dentro Uf 2-Fora UF 3-Exterior    
    $linha .= '<cMunFG>' . $dad['emi']['mun'] . '</cMunFG>';
    if ($dad['par']['mod'] == "55") {    
         $linha .= '<tpImp>' . '1' . '</tpImp>';
    } else {
         $linha .= '<tpImp>' . '4' . '</tpImp>';     // Tipo de impressão 0-Sem Danfe, 1-Retrato, 2-Paisagem, 3-Simplificada, 4-Danfe NFC-e, 5-Danfe NFC-e em mensagem eletrônica
    }
    $linha .= '<tpEmis>' . '1' . '</tpEmis>';   //  = 1-Emissão normal (não em contingência) 2=Contingência FS-IA, com impressão do DANFE em formulário de segurança 3=Contingência SCAN (Sistema de Contingência do Ambiente Nacional) 4=Contingência DPEC (Declaração Prévia da Emissão em Contingência) 5=Contingência FS-DA, com impressão do DANFE em formulário de segurança 6=Contingência SVC-AN (SEFAZ Virtual de Contingência do AN) 7=Contingência SVC-RS (SEFAZ Virtual de Contingência do RS)
    $linha .= '<cDV>' . substr($dad['not']['cha'], 43, 1) . '</cDV>';
    $linha .= '<tpAmb>' . $dad['emi']['amb'] . '</tpAmb>';   // 1-Produção ou 2-Homologação
    $linha .= '<finNFe>' . $dad['par']['fin'] . '</finNFe>';  // Finalidade da Nfe
    $linha .= '<indFinal>' . ($dad['cli']['tip'] == 3 ? '1' : '0') . '</indFinal>';  // Consumidor final 0-Normal 1-Consumidor Final
    if ($dad['par']['mod'] == "55") {    
         $linha .= '<indPres>'  . '0' . '</indPres>'; 
    } else {
         $linha .= '<indPres>'  . '1' . '</indPres>'; // 0-Não se Aplica,1-Venda Presencial,2-Internet,3-Teleatendimento,9-Outros
    }
    $linha .= '<procEmi>'  . '0' . '</procEmi>'; // Programa de emissão 0-Profsa/1-Avulsa Fisco/2-Avulsa Fisco com Certificado Digital Site Fisco/3-Aplicativo do Fisco
    $linha .= '<verProc>'  . '4.35' . '</verProc>';
    $linha .= '</ide>';    

    $linha .= '<emit>';
    $linha .= '<CNPJ>' . $dad['emi']['cgc'] . '</CNPJ>';        
    $linha .= '<xNome>' . limpa_cpo(trim($dad['emi']['raz'])) . '</xNome>';        
    $linha .= '<xFant>' . limpa_cpo(trim($dad['emi']['fan'])) . '</xFant>';        
    $linha .= '<enderEmit>';
    $linha .= '<xLgr>' . limpa_cpo(trim($dad['emi']['end'])) . '</xLgr>';   
    $linha .= '<nro>' . $dad['emi']['num'] . '</nro>';   
    if ($dad['emi']['com'] != "") {    
         $linha .= '<xCpl>' . limpa_cpo($dad['emi']['com']) . '</xCpl>'; 
    }
    $linha .= '<xBairro>' . limpa_cpo($dad['emi']['bai']) . '</xBairro>';        
    $linha .= '<cMun>' . $dad['emi']['mun'] . '</cMun>';
    $linha .= '<xMun>' . limpa_cpo($dad['emi']['cid']) . '</xMun>';    
    $linha .= '<UF>' . limpa_cpo($dad['emi']['est']) . '</UF>';        
    $linha .= '<CEP>' . $dad['emi']['cep'] . '</CEP>';        
    $linha .= '<cPais>' . '1058' . '</cPais>';
    $linha .= '<xPais>' . 'Brasil' . '</xPais>';
    if ($dad['emi']['tel'] != "") {
         $linha .= '<fone>' . limpa_nro($dad['emi']['tel']) . '</fone>';    
    }
    $linha .= '</enderEmit>';
    if (limpa_nro($dad['emi']['ins']) == "0") {
         $linha .= '<IE>' . 'ISENTO' . '</IE>';        
    } else {
         $linha .= '<IE>' . limpa_nro($dad['emi']['ins']) . '</IE>';        
    }
    if ($dad['emi']['imu'] != "") {
         $linha .= '<IM>' . limpa_nro($dad['emi']['imu']) . '</IM>';  
    }
    if ($dad['emi']['cna'] != "" && $dad['emi']['cna'] != "0") {
         $linha .= '<CNAE>' . limpa_nro($dad['emi']['cna']) . '</CNAE>';     
    }
    $linha .= '<CRT>' . $dad['emi']['reg'] . '</CRT>';     // 1-Simples 2-Simples-Excessão 3-Normal        
    $linha .= '</emit>';    

    if ($dad['cli']['raz'] != "" || $dad['cli']['cgc'] != "") {
               $linha .= '<dest>';    
               if ($dad['cli']['pes'] == "1") {
                    $linha .= '<CNPJ>' . limpa_nro($dad['cli']['cgc']) . '</CNPJ>';
               }else{
                    $linha .= '<CPF>' . limpa_nro($dad['cli']['cgc']) . '</CPF>';
               }
               if ($dad['emi']['amb'] == 1) {
                    if ($dad['cli']['raz'] != "") {
                         $linha .= '<xNome>' . limpa_cpo(trim($dad['cli']['raz'])) . '</xNome>';        
                    }
               }else{
                    $linha .= '<xNome>' . 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL' . '</xNome>';        
               }

               if (isset($dad['cli']['end']) == true) {
                    $linha .= '<enderDest>';
                    $linha .= '<xLgr>' . limpa_cpo(trim($dad['cli']['end'])) . '</xLgr>';        
                    $linha .= '<nro>' . $dad['cli']['num'] . '</nro>';   
                    if ($dad['cli']['com'] != "") {    
                         $linha .= '<xCpl>' . limpa_cpo($dad['cli']['com']) . '</xCpl>'; 
                    }
                    $linha .= '<xBairro>' . limpa_cpo($dad['cli']['bai']) . '</xBairro>';        
                    $linha .= '<cMun>' . $dad['cli']['mun'] . '</cMun>';
                    $linha .= '<xMun>' . limpa_cpo($dad['cli']['cid']) . '</xMun>';    
                    $linha .= '<UF>' . limpa_cpo($dad['cli']['est']) . '</UF>';        
                    $linha .= '<CEP>' . limpa_nro($dad['cli']['cep']) . '</CEP>';        
                    $linha .= '<cPais>' . '1058' . '</cPais>';
                    $linha .= '<xPais>' . 'Brasil' . '</xPais>';
                    if ($dad['cli']['tel'] != "") {
                         $linha .= '<fone>' . limpa_nro($dad['cli']['tel']) . '</fone>';    
                    }
                    $linha .= '</enderDest>';
               }
          $linha .= '<indIEDest>' . $dad['cli']['con'] . '</indIEDest>';   // 1-Contribuinte Icms 2-Contribuinte Isento 9-Não contribuinte       
          if (limpa_nro($dad['cli']['ins']) != "0") {
               if ($dad['cli']['pes'] == 1) {
                    $linha .= '<IE>' . limpa_nro($dad['cli']['ins']) . '</IE>';        
               }
          }
          if ($dad['cli']['imu'] != "") {
               $linha .= '<IM>' . limpa_nro($dad['cli']['imu']) . '</IM>';    
          }
          if ($dad['cli']['ema'] != "")  {   
               $linha .= '<email>' . limpa_cpo($dad['cli']['ema']) . '</email>';            
          }
          $linha .= '</dest>';    
     }

    $nro  = count($dad['cod']);
    for ($ind = 0; $ind < $nro; $ind++) {
         if ($dad['cod'][$ind] != '' and $dad['cod'][$ind] != '') {
              $linha .= '<det nItem="' . ($ind + 1) . '">';   
              $linha .= '<prod>';
              $linha .= '<cProd>' . $dad['cod'][$ind] . '</cProd>';
              $linha .= '<cEAN>' . $dad['bar'][$ind] . '</cEAN>';
              if ($dad['emi']['amb'] == 1 || $dad['par']['mod'] == "55") {
                   $linha .= '<xProd>' . limpa_cpo(trim($dad['des'][$ind])) . '</xProd>';
              } else {
                   $linha .= '<xProd>' . 'NOTA FISCAL EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL' . '</xProd>';
              }
              $linha .= '<NCM>' . $dad['ncm'][$ind] . '</NCM>';
              $linha .= '<CFOP>' . $dad['cfo'][$ind] . '</CFOP>';
              $linha .= '<uCom>' . $dad['med'][$ind] . '</uCom>';
              $linha .= '<qCom>' . str_replace(".", "", $dad['qtd'][$ind]) . '</qCom>';
              $linha .= '<vUnCom>' . $dad['uni'][$ind] . '</vUnCom>';
              $linha .= '<vProd>' . number_format($dad['val'][$ind],2,".","") . '</vProd>';
              $linha .= '<cEANTrib>' . $dad['bar'][$ind] . '</cEANTrib>';
              $linha .= '<uTrib>' . $dad['med'][$ind] . '</uTrib>';
              $linha .= '<qTrib>' . str_replace(".", "", $dad['qtd'][$ind]) . '</qTrib>';
              $linha .= '<vUnTrib>' . $dad['uni'][$ind] . '</vUnTrib>';
              if ($dad['vld'][$ind] != 0) {
                   $linha .= '<vDesc>' . $dad['vld'][$ind] . '</vDesc>';
              }
              $linha .= '<indTot>' . '1' . '</indTot>';
              $linha .= '<xPed>' . $_SESSION['wrknumcha'] . '</xPed>';
              $linha .= '<nItemPed>' . ($dad['seq'][$ind] + 1) . '</nItemPed>';    
              $linha .= '</prod>';
              $linha .= '<imposto>';
              if (substr($dad['sit'][$ind],1,3) == "101") {
                   $linha .= situacao_101($dad, $ind); 
              }
              if (substr($dad['sit'][$ind],1,3) == "102" || substr($dad['sit'][$ind],1,3) == "103" || substr($dad['sit'][$ind],1,3) == "300" || substr($dad['sit'][$ind],1,3) == "400") {
                   $linha .= situacao_102($dad, $ind); 
              }
              if (substr($dad['sit'][$ind],1,3) == "201") {
                   $linha .= situacao_201($dad, $ind); 
              }
              if (substr($dad['sit'][$ind],1,3) == "202" || substr($dad['sit'][$ind],1,3) == "203") {
                   $linha .= situacao_202($dad, $ind); 
              }
              if (substr($dad['sit'][$ind],1,3) == "500") {
                   $linha .= situacao_500($dad, $ind); 
              }
              if (substr($dad['sit'][$ind],1,3) == "900") {
                   $linha .= situacao_900($dad, $ind); 
              }
              $linha .= '<PIS>';
           $linha .= '<PISNT>';
           $linha .= '<CST>' . '07' . '</CST>';
           $linha .= '</PISNT>';
           $linha .= '</PIS>';   

           $linha .= '<COFINS>';
           $linha .= '<COFINSNT>';
           $linha .= '<CST>' . '07' . '</CST>';
           $linha .= '</COFINSNT>';
           $linha .= '</COFINS>';   

           $linha .= '</imposto>';
           $linha .= '</det>';
         }
    }
    $linha .= '<total>';    
    $linha .= '<ICMSTot>';    
    $linha .= '<vBC>' . number_format($dad['not']['bic'],2,".","") . '</vBC>';    
    $linha .= '<vICMS>' . number_format($dad['not']['vic'],2,".","") . '</vICMS>';    
    $linha .= '<vICMSDeson>' . number_format($dad['not']['ide'],2,".","") . '</vICMSDeson>';    
    $linha .= '<vFCP>' . number_format($dad['not']['fcp'],2,".","") . '</vFCP>';    
    $linha .= '<vBCST>' . number_format($dad['not']['bst'],2,".","") . '</vBCST>';    
    $linha .= '<vST>' . number_format($dad['not']['vst'],2,".","") . '</vST>';
    $linha .= '<vFCPST>' . number_format($dad['not']['fst'],2,".","") . '</vFCPST>';
    $linha .= '<vFCPSTRet>' . number_format($dad['not']['fcr'],2,".","") . '</vFCPSTRet>';
    $linha .= '<vProd>' . number_format($dad['not']['val'],2,".","") . '</vProd>';    
    $linha .= '<vFrete>' . number_format($dad['not']['fre'],2,".","") . '</vFrete>';    
    $linha .= '<vSeg>' . number_format($dad['not']['seg'],2,".","") . '</vSeg>';    
    $linha .= '<vDesc>' . number_format($dad['not']['des'],2,".","") . '</vDesc>';    
    $linha .= '<vII>' . number_format($dad['not']['imp'],2,".","") . '</vII>';    
    $linha .= '<vIPI>' . number_format($dad['not']['vip'],2,".","") . '</vIPI>';    
    $linha .= '<vIPIDevol>' . number_format($dad['not']['ipd'],2,".","") . '</vIPIDevol>';
    $linha .= '<vPIS>' . number_format($dad['not']['pis'],2,".","") . '</vPIS>';    
    $linha .= '<vCOFINS>' . number_format($dad['not']['cof'],2,".","") . '</vCOFINS>';    
    $linha .= '<vOutro>' . number_format($dad['not']['out'],2,".","") . '</vOutro>';    
    $linha .= '<vNF>' . number_format($dad['not']['not'],2,".","") . '</vNF>';    
    $linha .= '</ICMSTot>';    
    $linha .= '</total>'; 

    $linha .= '<transp>';
    // 0=Contratação do Frete por conta do Remetente (CIF); 1=Contratação do Frete por conta do Destinatário (FOB); 2=Contratação do Frete por conta de Terceiros; 3=Transporte Próprio por conta do Remetente; 4=Transporte Próprio por conta do Destinatário; 9=Sem Ocorrência de Transporte.
    if ($dad['ped']['tra'] == 0) {
         $linha .= '<modFrete>' . '9' . '</modFrete>';    
    }else{
         $linha .= '<modFrete>' .  $dad['tra']['tip'] . '</modFrete>';
         $linha .= '<transporta>';     
         if ($dad['tra']['pes'] == "1") {
              $linha .= '<CNPJ>' . limpa_nro($dad['tra']['cgc']) . '</CNPJ>';
         }else{
              $linha .= '<CPF>' . limpa_nro($dad['tra']['cgc']) . '</CPF>';
         }
         $linha .= '<xNome>' . limpa_cpo($dad['tra']['raz']) . '</xNome>';
         if (limpa_nro($dad['tra']['ins']) != "0") {
              $linha .= '<IE>' . limpa_nro($dad['tra']['ins']) . '</IE>';        
         }
         $linha .= '<xEnder>' . limpa_cpo($dad['tra']['end']) . '</xEnder>';
         $linha .= '<xMun>' . $dad['tra']['cid'] . '</xMun>';
         $linha .= '<UF>' . $dad['tra']['est'] . '</UF>';
         $linha .= '</transporta>';     
         if ($dad['ped']['psl'] != 0 || $dad['ped']['psb'] != 0) {
              $linha .= '<vol>';     
              $linha .= '<qVol>' . $dad['ped']['qtd'] . '</qVol>';
              $linha .= '<esp>' . $dad['ped']['esp'] . '</esp>';
              $linha .= '<marca>' . $dad['ped']['mar'] . '</marca>';
              $linha .= '<nVol>' . $dad['ped']['nro'] . '</nVol>';
              $linha .= '<pesoL>' . str_replace(",", ".", $dad['ped']['psl']) . '</pesoL>';
              $linha .= '<pesoB>' . str_replace(",", ".", $dad['ped']['psb']) . '</pesoB>';
              $linha .= '</vol>';     
         }
    }
    $linha .= '</transp>';   

    if ($dad['ven']['qtd'] > 0) {
         $linha .= '<cobr>';   
         $linha .= '<fat>';   
         $linha .= '<nFat>' . str_pad($dad['emi']['ser'], 3, "0", STR_PAD_LEFT) . '-' . str_pad($dad['emi']['not'], 9, "0", STR_PAD_LEFT) . '</nFat>';
         $linha .= '<vOrig>' . number_format($dad['not']['not'] + $dad['not']['des'],2,".","") . '</vOrig>';
         $linha .= '<vDesc>' . number_format($dad['not']['des'],2,".","") . '</vDesc>';
         $linha .= '<vLiq>' . number_format($dad['not']['not'],2,".","") . '</vLiq>';
         $linha .= '</fat>';   
         for ($ind = 0; $ind < $dad['ven']['qtd']; $ind++) {
              $linha .= '<dup>';   
              $linha .= '<nDup>' . str_pad(($ind + 1), 3, "0", STR_PAD_LEFT) . '</nDup>';
              $venct  = substr($dad['pag']['dtp'][$ind],6,4) . '-' . substr($dad['pag']['dtp'][$ind],3,2) . '-' . substr($dad['pag']['dtp'][$ind],0,2);
              $linha .= '<dVenc>' . $venct . '</dVenc>';
              $linha .= '<vDup>'  .  str_replace(",", ".", $dad['pag']['vlp'][$ind]) . '</vDup>';
              $linha .= '</dup>';   
         }
         $linha .= '</cobr>';   
    }

    $linha .= '<pag>';
    $linha .= '<detPag>';   // 01=Dinheiro 02=Cheque 03=Cartão de Crédito 04=Cartão de Débito 05=Crédito Loja 10=Vale Alimentação 11=Vale Refeição 12=Vale Presente 13=Vale Combustível 14=Duplicata Mercantil 15=Boleto Bancário 90= Sem pagamento 99=Outros
    if ($dad['ven']['qtd'] == 0) {
         if ($dad['par']['mod'] == "65") {    
              $linha .= '<tPag>' . str_pad($dad['ped']['pag'], 2, "0", STR_PAD_LEFT) . '</tPag>';  
              $linha .= '<vPag>' . number_format($dad['not']['not'],2,".","") . '</vPag>';
         } else {
              $linha .= '<tPag>' . '90' . '</tPag>';  
              $linha .= '<vPag>' . "0.00" . '</vPag>';
         }
    }else{
         $linha .= '<tPag>' . '15' . '</tPag>';  
         $linha .= '<vPag>' . number_format($dad['not']['not'],2,".","") . '</vPag>';
    }
    $linha .= '</detPag>';     
    $linha .= '</pag>';         

    if ($dad['ped']['men'] != "" || $dad['cli']['ema'] != "") {
         $linha .= '<infAdic>';
         if ($dad['ped']['men'] != "") {
              $linha .= '<infCpl>' . limpa_cpo($dad['ped']['men']) . '</infCpl>';    
         }
         if ($dad['cli']['ema'] != "") {
              $linha .= '<obsCont xCampo="Email_Destinatario">';
              $linha .= '<xTexto>' . limpa_cpo($dad['cli']['ema']) . '</xTexto>';
              $linha .= '</obsCont>';
         }
         $linha .= '</infAdic>';
    }

    if ( $dad['emp']['con'] != "") {
         $linha .= '<infRespTec>';
         $linha .= '<CNPJ>' . $dad['emp']['cgc'] . '</CNPJ>';
         $linha .= '<xContato>' . $dad['emp']['con'] . '</xContato>';
         $linha .= '<email>' . $dad['emp']['ema'] . '</email>';
         $linha .= '<fone>' . $dad['emp']['tel'] . '</fone>';
         $linha .= '</infRespTec>';
    }

    $linha .= '</infNFe>';  
    $linha .= '</NFe>';        
    fwrite($fil, $linha);
    fclose($fil); 
    return $sta;
}

function situacao_101($dad, $ind) {
    $txt  = '<ICMS>';   
    $txt .= '<ICMSSN101>';
    $txt .= '<orig>' . substr($dad['sit'][$ind],0,1) . '</orig>';
    $txt .= '<CSOSN>' . substr($dad['sit'][$ind],1,3) . '</CSOSN>';
    $txt .= '<pCredSN>' . $dad['pai'][$ind] . '</pCredSN>';      // Percentual de aproveitamento de Icms
    $txt .= '<vCredICMSSN>' . $dad['vci'][$ind] . '</vCredICMSSN>';
    $txt .= '</ICMSSN101>';
    $txt .= '</ICMS>';   
    return $txt;
}

function situacao_102($dad, $ind) {
    $txt  = '<ICMS>';   
    $txt .= '<ICMSSN102>';
    $txt .= '<orig>' . substr($dad['sit'][$ind],0,1) . '</orig>';
    $txt .= '<CSOSN>' . substr($dad['sit'][$ind],1,3) . '</CSOSN>';
    $txt .= '</ICMSSN102>';
    $txt .= '</ICMS>';   
    return $txt;
}

function situacao_201($dad, $ind) {
    $txt  = '<ICMS>';   
    $txt .= '<ICMSSN201>';
    $txt .= '<orig>' . substr($dad['sit'][$ind],0,1) . '</orig>';
    $txt .= '<CSOSN>' . substr($dad['sit'][$ind],1,3) . '</CSOSN>';
    $txt .= '<modBCST>' . '0' . '</modBCST>'; // 0=Preço tabelado ou máximo sugerido; 1=Lista Negativa (valor);
    $txt .= '<pMVAST>' . '0' . '</pMVAST>';  // Percentual da margem de valor Adicionado do ICMS ST
    $txt .= '<pRedBCST>' . '0.00' . '</pRedBCST>';
    $txt .= '<vBCST>' . '0.00' . '</vBCST>';
    $txt .= '<pICMSST>' . '0.00' . '</pICMSST>';
    $txt .= '<vICMSST>' . '0.00' . '</vICMSST>';     
    $txt .= '<vBCFCPST>' . '0.00' . '</vBCFCPST>';
    $txt .= '<pFCPST>' . '0.00' . '</pFCPST>';
    $txt .= '<vFCPST>' . '0.00' . '</vFCPST>';     
    $txt .= '<pCredSN>' . '0.00' . '</pCredSN>';  // Alíquota aplicável de cálculo do crédito (Simples Nacional).
    $txt .= '<vCredICMSSN>' . '0.00' . '</vCredICMSSN>';
    $txt .= '</ICMSSN201>';
    $txt .= '</ICMS>';   
    return $txt;
}

function situacao_202($dad, $ind) {
    $txt  = '<ICMS>';   
    $txt .= '<ICMSSN202>';
    $txt .= '<orig>' . substr($dad['sit'][$ind],0,1) . '</orig>';
    $txt .= '<CSOSN>' . substr($dad['sit'][$ind],1,3) . '</CSOSN>';
    $txt .= '<modBCST>' . '0' . '</modBCST>';
    $txt .= '<pMVAST>' . '0' . '</pMVAST>';
    $txt .= '<pRedBCST>' . '0.00' . '</pRedBCST>';
    $txt .= '<vBCST>' . '0.00' . '</vBCST>';
    $txt .= '<pICMSST>' . '0.00' . '</pICMSST>';
    $txt .= '<vICMSST>' . '0.00' . '</vICMSST>';
    
    $txt .= '<vBCFCPST>' . '0.00' . '</vBCFCPST>';
    $txt .= '<pFCPST>' . '0.00' . '</pFCPST>';
    $txt .= '<vFCPST>' . '0.00' . '</vFCPST>';
    
    $txt .= '</ICMSSN202>';
    $txt .= '</ICMS>';   

    return $txt;
}

function situacao_500($dad, $ind) {
    $txt  = '<ICMS>';   
    $txt .= '<ICMSSN500>';
    $txt .= '<orig>' . substr($dad['sit'][$ind],0,1) . '</orig>';
    $txt .= '<CSOSN>' . substr($dad['sit'][$ind],1,3) . '</CSOSN>';
    $txt .= '<vBCSTRet>' . '0' . '</vBCSTRet>';  //  Valor da BC do ICMS ST cobrado anteriormente por ST (v2.0)
    $txt .= '<pST>' . $dad['pst'][$ind] . '</pST>';
    $txt .= '<vICMSSTRet>' . '0.00' . '</vICMSSTRet>';  //  Valor do ICMS ST cobrado anteriormente por ST (v2.0). 
    
    $txt .= '<vBCFCPSTRet>' . '0.00' . '</vBCFCPSTRet>';
    $txt .= '<pFCPSTRet>' . '0.00' . '</pFCPSTRet>';
    $txt .= '<vFCPSTRet>' . '0.00' . '</vFCPSTRet>';
    
    $txt .= '</ICMSSN500>';
    $txt .= '</ICMS>';   

    return $txt;
}

function situacao_900($dad, $ind) {
    $txt  = '<ICMS>';   
    $txt .= '<ICMSSN900>';
    $txt .= '<orig>' . substr($dad['sit'][$ind],0,1) . '</orig>';
    $txt .= '<CSOSN>' . substr($dad['sit'][$ind],1,3) . '</CSOSN>';
    $txt .= '<modBC>' . '3' . '</modBC>';  // 0=Margem Valor Agregado (%); 1=Pauta (Valor); 2=Preço Tabelado Máx. (valor); 3=Valor da operação.
    $txt .= '<vBC>' . '0' . '</vBC>';
    $txt .= '<pRedBC>' . $dad['par']['ric'] . '</pRedBC>';
    $txt .= '<pICMS>' . $dad['pcc'][$ind] . '</pICMS>';
    $txt .= '<vICMS>' . $dad['vlc'][$ind] . '</vICMS>';
    $txt .= '<modBCST>' . '0' . '</modBCST>';  // 0=Preço tabelado ou máximo sugerido; 1=Lista Negativa (valor);
    $txt .= '<pMVAST>' . '0.00' . '</pMVAST>';  // Percentual da margem de valor Adicionado do ICMS ST
    $txt .= '<pRedBCST>' . $dad['par']['ric'] . '</pRedBCST>';
    $txt .= '<vBCST>' . $dad['bst'][$ind] . '</vBCST>';
    $txt .= '<pICMSST>' . $dad['pst'][$ind] . '</pICMSST>';
    $txt .= '<vICMSST>' . $dad['vst'][$ind] . '</vICMSST>';
    if ($dad['par']['fun'] != 0) {    
         $txt .= '<vBCFCPST>' . '0.00' . '</vBCFCPST>';
         $txt .= '<pFCPST>' . '0.00' . '</pFCPST>';
         $txt .= '<vFCPST>' . '0.00' . '</vFCPST>';
    }
    $txt .= '<pCredSN>' . '0.00' . '</pCredSN>';   // Alíquota aplicável de cálculo do crédito (Simples Nacional).
    $txt .= '<vCredICMSSN>' . '0.00' . '</vCredICMSSN>';

    $txt .= '</ICMSSN900>';
    $txt .= '</ICMS>';   
    return $txt;
}

function assinar_xml(&$dad) {
     $sta = 0;
     $dad['men'] = '';
     include_once "inclusao.php";
     error_reporting(E_ALL);
     ini_set('display_errors', 'On'); 
     $cam = $dad['not']['cam'];
     if (file_exists($cam) == false) {
          $dad['men'] =  "Caminho para assinar XML da Pré-Nota não encontrado no sistema";
          $sta = 1; return $sta;
     }
     $dad['not']['con'] = configura_not($dad);

     $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['cer']; 
     $cer = file_get_contents($dir);
     $tools = new Tools($dad['not']['con'], Certificate::readPfx($cer, $dad['emi']['sen']));
     $tools->model($dad['par']['mod']);

try {
     $arq = file_get_contents($cam);
     $xml = $tools->signNFe($arq);     
     $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['not']['sai']; 
     file_put_contents($dir, $xml);
     $dad['not']['dir'] = $dir;

} catch (\Exception $e) {
     $dad['men'] = $e->getMessage();
     $sta = $sta + 1;
     $err = 'xml/' . 'NFC_' .  str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfc.err';
     file_put_contents($err, $dad['men']);
}

     return $sta;
}

function validar_xml(&$dad) {
     $sta = 0; $dad['men'] = '';
     include_once "inclusao.php";
     error_reporting(E_ALL);
     ini_set('display_errors', 'On'); 
     $cam = $dad['not']['dir'];
     if (file_exists($cam) == false) {
          $dad['men'] =  "Caminho para assinar XML da Pré-Nota não encontrado no sistema";
          $sta = 1; return $sta;
     }
     $xml = file_get_contents($cam);
     $xsd = __DIR__ . "/" . "sped-nfe-master/schemes/PL_009_V4/leiauteNFe_v4.00.xsd";
     if (file_exists($xsd) == false) {
          $dad['men'] =  "Caminho do XSD para validação do XML não encontrado no sistema";
          $sta = 2; return $sta;
     }
     try {
          $ret = Validator::isValid($xml, $xsd); 

     } catch (\Exception $e) {
          $dad['men'] = $e->getMessage();
          if (strpos($dad['men'],"No matching") == 0) {
               $sta = $sta + 1;
               $err = 'xml/' . 'NFC_' .  str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfc.err';
               file_put_contents($err, $dad['men']);     
     }
}
     return $sta;
}

function enviar_xml(&$dad) {
     $sta = 0; $log = ''; $dad['men'] = ''; $dad['not']['sta'] = ''; $dad['not']['nrr'] = '';
     include_once "inclusao.php";
     error_reporting(E_ALL);
     ini_set('display_errors', 'On'); 
     $cam = $dad['not']['dir'];
     if (file_exists($cam) == false) {
          $dad['men'] =  "Caminho para XML assinado não encontrado no sistema para envio";
          $sta = 1; return $sta;
     }
     $xml = file_get_contents($cam);

     $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['cer']; 
     $cer = file_get_contents($dir);
     $tools = new Tools($dad['not']['con'], Certificate::readPfx($cer, $dad['emi']['sen']));
     $tools->model($dad['par']['mod']);     // Define modelo para envio 55: NF-e e 65: NFC-e
try {     
     $dad['not']['nrl'] = str_pad($dad['emi']['not'], 15, '0', STR_PAD_LEFT);
     $ret = $tools->sefazEnviaLote([$xml], $dad['not']['nrl']);
     $vol = new Standardize();
     $std = $vol->toStd($ret);
     if ($std->cStat != 103) {
          $dad['not']['sta'] = $std->cStat;
          $dad['not']['men'] = $std->xMotivo;
          $dad['not']['ret'] = $std->cStat;
          $dad['not']['mot'] = $std->xMotivo;
     } else {
          $dad['not']['sta'] = $std->cStat;
          $dad['not']['men'] = $std->xMotivo;
          $dad['not']['ret'] = $std->cStat;
          $dad['not']['mot'] = $std->xMotivo;
          $dad['not']['dtr'] = $std->dhRecbto;     
          $dad['not']['nrr'] = $std->infRec->nRec;    
          $_SESSION['wrkrecnot'] = $std->infRec->nRec;    

          sleep(2.5); // Efetua uma pausa no programa por N segundos 

          $ret = consulta_rec($dad);
          if($ret == '100') {
               $pro = Complements::toAuthorize($xml, $dad['not']['pro']); // Adiciona o protocolo ao XML assinado
               $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['not']['sai']; 
               $dir = str_replace("-nfc.xml","-procNFc.xml",$dir);   
               file_put_contents($dir, $pro);         
               $dad['not']['dan'] = $dir;   
               $doc = FilesFolders::readFile($dir);
               $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFC_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfc.pdf';  
               $danfce = new Danfce($doc, $log, 0);
               $id = $danfce->monta();
               $pdf = $danfce->render();
               file_put_contents($dir, $pdf);
               $dad['not']['pdf'] = $dir;     
          }
          if($ret == '204') {
               $pdf = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFC_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfc.pdf';  
               $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFC_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-procNFc.xml';  
               $dad['not']['pdf'] = $pdf; $dad['not']['dan'] = $dir;
               if (file_exists($dir) == true && file_exists($pdf) == false) { 
                    $vol = gravar_pdf($dad); 
               }
          }
     }
} catch (\Exception $e) {
     $sta = $sta + 1;
     $dad['men'] = $e->getMessage();
     $err = 'xml/' . 'NFC_' .  str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfc.err';
     file_put_contents($err, $dad['men']);     
}
     return $sta;
}

function consulta_rec(&$dad) {
     $sta = 0;  $dad['not']['ret'] = '';  $dad['not']['mot'] = '';
     if (isset($dad['not']['nrr']) == false) { return 1; }
     if ($dad['not']['nrr'] == "" || $dad['not']['nrr'] == "0") { return 2; }
     include_once "inclusao.php";
     error_reporting(E_ALL);
     ini_set('display_errors', 'On'); 

     $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['cer']; 
     $cer = file_get_contents($dir);
     $tools = new Tools($dad['not']['con'], Certificate::readPfx($cer, $dad['emi']['sen']));
     $tools->model($dad['par']['mod']);     // Define modelo para envio 55: NF-e e 65: NFC-e

     $xml = $tools->sefazConsultaRecibo($dad['not']['nrr'], (int) $dad['emi']['amb']);
     $dad['not']['pro'] = $xml;
     $dir =  'xml/' . 'NFC_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-rec.xml';
     file_put_contents($dir, $xml);               

     $ret = new Standardize();
     $std = $ret->toStd($xml);

     $dad['not']['sta'] = $std->cStat;
     $dad['not']['men'] = $std->xMotivo;
     if (isset($std->protNFe->infProt->cStat) == true) {
          $dad['not']['ret'] = $std->protNFe->infProt->cStat;
          $dad['not']['mot'] = $std->protNFe->infProt->xMotivo;
     }
     if($std->cStat == '104'){ // lote processado (tudo ok)
          $sta = $std->protNFe->infProt->cStat;
          if($std->protNFe->infProt->cStat == '100') { // Autorizado o uso da NF-e 204: número em duplicidade 217: NF-e não consta na base da Sefaz
               $ret = gravar_mov($dad);
               $dad['not']['dtp'] = $std->protNFe->infProt->dhRecbto;     
               $dad['not']['nrp'] = $std->protNFe->infProt->nProt;         
          }
          if($std->protNFe->infProt->cStat == '204') { //  204: Duplicidade de NF-e [nRec:411000003582560]
               $ret = gravar_mov($dad);
          }
          if($std->protNFe->infProt->cStat == '539') { //  539: Duplicidade de chave na Sefaz
               $ret = gravar_mov($dad);
          }
     } else {
          $sta = $dad['not']['sta'];
     }
     return $sta;
}

function consulta_cha(&$dad) {
     $sta = 0;
     if (isset($dad['not']['sai']) == false) {
          $dad['not']['sai'] = 'NFC_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfc.xml';  
          $dad['not']['cam'] =  'xml/' . 'NFC_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfc.xml';
          $dad['not']['dir'] = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['not']['sai']; 
     }
     if (isset($dad['not']['cha']) == false) { return 1; }
     if ($dad['not']['cha'] == "" || $dad['not']['cha'] == "0") { return 2; }
     include_once "inclusao.php";
     error_reporting(E_ALL);
     ini_set('display_errors', 'On'); 

     $dad['not']['con'] = configura_not($dad);
     $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['cer']; 
     $cer = file_get_contents($dir);
     $tools = new Tools($dad['not']['con'], Certificate::readPfx($cer, $dad['emi']['sen']));
     $tools->model($dad['par']['mod']);     // Define modelo para envio 55: NF-e e 65: NFC-e

     $xml = $tools->sefazConsultaChave($dad['not']['cha']);
     $dad['not']['pro'] = $xml;
     $dir =  'xml/' . 'NFC_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-cha.xml';
     file_put_contents($dir, $xml);               

     $ret = new Standardize();
     $std = $ret->toStd($xml);

     $dad['not']['sta'] = $std->cStat;
     $dad['not']['men'] = $std->xMotivo;

     if (isset($std->protNFe->infProt->cStat) == true) {
          $dad['not']['ret'] = $std->protNFe->infProt->cStat;
          $dad['not']['mot'] = $std->protNFe->infProt->xMotivo;
     }

     if($std->cStat == '100' || $std->cStat == '104'){ // lote processado (tudo ok)
          $sta = $std->protNFe->infProt->cStat;
          if($std->protNFe->infProt->cStat == '100') { //Autorizado o uso da NF-e 204: número em duplicidade 217: NF-e não consta na base da Sefaz
               $dad['not']['dtp'] = $std->protNFe->infProt->dhRecbto;     
               $dad['not']['nrp'] = $std->protNFe->infProt->nProt;     
               if (file_exists($dad['not']['dir']) == true) {
                    $arq = file_get_contents($dad['not']['dir']);
                    $pro = Complements::toAuthorize($arq, $xml); 
                    $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['not']['sai']; 
                    $dir = str_replace("-nfc.xml","-procNFc.xml",$dir);   
                    file_put_contents($dir, $pro);    
                    $dad['not']['dan'] = $dir;
               }
          }
     }
     return $sta;
}

function gravar_pdf(&$dad) {
     $sta = 0; $log = '';
     include_once "inclusao.php";
     error_reporting(E_ALL);
     ini_set('display_errors', 'On'); 
     if (file_exists($dad['not']['dan']) == false) { return 1; }

     $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFC_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfc.pdf';  

     $xml = $dad['not']['dan'];
     $doc = FilesFolders::readFile($xml);

     if ($dad['emi']['log'] != "") {
          $cam = __DIR__ . "/" . "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['log'];
          $log = 'data://text/plain;base64,'. base64_encode(file_get_contents($cam));
     }
     try {
          $danfce = new Danfce($doc, $log, 0);
          $id = $danfce->monta();
          $pdf = $danfce->render();

          file_put_contents($dir, $pdf);
          $dad['not']['pdf'] = $dir;
     } catch (InvalidArgumentException $e) {
          $dad['not']['pdf'] = "Erro: " . $e->getMessage();
          $sta = $sta + 1;
     }    
     return $sta;
}

function gravar_mov(&$dad) {
     $sta = 0;
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao, "Select * from tb_movto_b where movempresa = '" . $_SESSION['wrkcodemp'] . "' and movserienot = " .  $dad['emi']['ser'] . " and movnumeronot = " . $dad['emi']['not']);
     if (mysqli_num_rows($sql) == 0) {
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
          $sql .= "movchave, ";
          $sql .= "movrecibo, ";
          $sql .= "movobservacao, ";
          $sql .= "keyinc, ";
          $sql .= "datinc ";
          $sql .= ") value ( ";
          $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . '3' . "',";
          $sql .= "'" . date("Y-m-d H:i:s") . "',";
          $sql .= "'" . '0' . "',";
          if ($dad['cli']['raz'] != "") {
               $sql .= "'" . $dad['cli']['raz'] . "',";
          } else {
               $sql .= "'" . 'Emissão de Cupom Fiscal Eletrônico' . "',";
          }
          if ($dad['cli']['cgc'] == "" || $dad['cli']['cgc'] == "0") {
               $sql .= "'" . '0' . "',";
          } else {
               $sql .= "'" . limpa_nro($dad['cli']['cgc']) . "',";
          }
          $sql .= "'" . $dad['emi']['ser'] . "',";
          $sql .= "'" . $dad['emi']['not'] . "',";
          $sql .= "'" . $dad['not']['not'] . "',";
          $sql .= "'" . $dad['not']['not'] . "',";
          $sql .= "'" . $dad['not']['cha'] . "',";
          $sql .= "'" . $dad['not']['nrr'] . "',";
          $sql .= "'" . 'Processo de emissão de NFC-e -> ' .  $dad['not']['ret'] . '-' .  $dad['not']['mot'] . "',";
          $sql .= "'" . $_SESSION['wrkideusu'] . "',";
          $sql .= "'" . date("Y/m/d H:i:s") . "')";
          $ret = mysqli_query($conexao,$sql);
          if ($ret == false) {
               $tab['men'] == "Erro na gravação do movimento de caixa solicitado !";
          }
          $ret = desconecta_bco();     
     }
     return $sta;
}

function gravar_nfe(&$dad) {
     $sta = 0;
     include "lerinformacao.inc";
     $dad['not']['key'] = $dad['emi']['not']; 
     $sql = mysqli_query($conexao, "Select * from tb_nota_e where notempresa = '" . $_SESSION['wrkcodemp'] . "' and notserie = " .  $dad['emi']['ser'] . " and notnumero = " . $dad['emi']['not']);
     if (mysqli_num_rows($sql) == 0) {
         $sql  = "insert into tb_nota_e (";
         $sql .= "notempresa, ";
         $sql .= "notdestino, ";
         $sql .= "notstatus, ";
         $sql .= "notserie, ";
         $sql .= "notnumero, ";
         $sql .= "notpedido, ";
         $sql .= "notdatemissao, ";
         $sql .= "notdatsaida, ";
         $sql .= "nottiponota, ";
         $sql .= "notpagto, ";     
         $sql .= "nottransporte, ";
         $sql .= "notparametro, ";
         $sql .= "notqtdparcela, ";   
         $sql .= "notcfop, ";
         $sql .= "notqtditem, ";
         $sql .= "nottipoaten, ";  
         $sql .= "notnatureza, ";
         $sql .= "nottipocons, ";
         $sql .= "nottipodest, ";
         $sql .= "notvalprod, ";
         $sql .= "notvalnota, ";
         $sql .= "notbasicms, ";
         $sql .= "notvalicms, ";
         $sql .= "notbassubs, ";
         $sql .= "notvalsubs, ";
         $sql .= "notnumeroeve, ";
         $sql .= "notvaltrib, ";
         $sql .= "notchavenfe, ";
         $sql .= "notnumerorec, ";
         $sql .= "notnumeropro, ";
         $sql .= "notnumerolot, ";
         $sql .= "notdatarec, ";
         $sql .= "notdatapro, ";
         $sql .= "notmodelo, ";
         $sql .= "notobservacao, ";
         $sql .= "keyinc, ";
         $sql .= "datinc ";
         $sql .= ") value ( ";
         $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
         $sql .= "'" .  $dad['ped']['cli'] . "',";         
         $sql .= "'" . '0' . "',"; 
         $sql .= "'" . $dad['emi']['ser'] . "',";
         $sql .= "'" . $dad['emi']['not'] . "',";
         $sql .= "'" . $dad['ped']['cod'] . "',";
         $sql .= "'" . $dad['emi']['emi'] . "',";
         $sql .= "'" . $dad['emi']['emi'] . "',";
         $sql .= "'" . $dad['par']['tip'] . "',";
         $sql .= "'" . $dad['pag']['cod'] . "',";
         $sql .= "'" . $dad['tra']['cod'] . "',";
         $sql .= "'" . $dad['par']['cod'] . "',";
         $sql .= "'" . $dad['pag']['par'] . "',";
         $sql .= "'" . $dad['par']['cfo'] . "',"; 
         $sql .= "'" . $dad['not']['qtd'] . "',"; 
         $sql .= "'" . '0' . "',"; 
         $sql .= "'" . $dad['par']['des'] . "',"; 
         $sql .= "'" . $dad['cli']['tip'] . "',"; // Consumidor final 0-Normal 1-Consumidor Final
         $sql .= "'" . $dad['cli']['con']  . "',";     
         $sql .= "'" . $dad['not']['val'] . "',";
         $sql .= "'" . $dad['not']['not'] . "',";
         $sql .= "'" . $dad['not']['bic'] . "',";
         $sql .= "'" . $dad['not']['vic'] . "',";
         $sql .= "'" . $dad['not']['bst'] . "',";
         $sql .= "'" . $dad['not']['vst'] . "',";
         $sql .= "'" . '0' . "',";
         $sql .= "'" . $dad['not']['imp'] . "',";
         $sql .= "'" . $dad['not']['cha'] . "',";
         $sql .= "'" . ( isset($dad['not']['nrr']) == false ? '0' : $dad['not']['nrr'] ) . "',";
         $sql .= "'" . ( isset($dad['not']['nrp']) == false ? '0' : $dad['not']['nrp'] ) . "',";
         $sql .= "'" . ( isset($dad['not']['nrl']) == false ? '0' : $dad['not']['nrl'] ) . "',"; 
         $sql .= "'" . ( isset($dad['not']['dtr']) == false ? '0' : $dad['not']['dtr'] ) . "',";
         $sql .= "'" . ( isset($dad['not']['dtp']) == false ? '0' : $dad['not']['dtp'] ) . "',";         
         $sql .= "'" . $dad['par']['mod'] . "',";
         $sql .= "'" . $dad['ped']['men'] . "',";
         $sql .= "'" . $_SESSION['wrkideusu'] . "',";
         $sql .= "'" . date("Y/m/d H:i:s") . "')";
          $retorno = mysqli_query($conexao,$sql);
          $dad['not']['key'] = mysqli_insert_id($conexao); 
          if ($retorno == false) {
               print_r($sql); $sta = 2; echo '<br/>';
               echo '<script>alert("Erro na atualização de nota fiscal eletrônica !");</script>';
          }
          $retorno = desconecta_bco(); 
     }
     return $sta;
}

function gravar_ite($dad) {
     $sta = 0;
     include "lerinformacao.inc";
     $nro  = count($dad['cod']);
      for ($ind = 0; $ind < $nro; $ind++) {
         if ($dad['des'][$ind] != '' and $dad['sta'][$ind] <= 1) { 
             $sql = mysqli_query($conexao,"Select * from tb_nota_i where iteempresa = '" . $_SESSION['wrkcodemp'] . "' and iteserie = " . $dad['emi']['ser'] . " and itenumero = " . $dad['emi']['nro'] . " and itesequencia = " . $dad['seq'][$ind]);
             if (mysqli_num_rows($sql) == 0) {
                 $sql  = "insert into tb_nota_i (";
                 $sql .= "iteempresa, ";
                 $sql .= "itestatus, ";
                 $sql .= "iteserie, ";
                 $sql .= "itenumero, ";
                 $sql .= "itesequencia, ";
                 $sql .= "iteseqproduto, ";
                 $sql .= "itecodproduto, ";
                 $sql .= "itedescricao, ";
                 $sql .= "itemedcomercial, ";
                 $sql .= "itemedtributaria, ";
                 $sql .= "itequantidade, ";
                 $sql .= "iteunitario, ";
                 $sql .= "itencm, ";
                 $sql .= "iteean, ";
                 $sql .= "itecfop, ";
                 $sql .= "iteorigem, ";
                 $sql .= "itesubst, ";
                 $sql .= "iteportrib, ";
                 $sql .= "iteporicms, ";
                 $sql .= "itebasicms, ";
                 $sql .= "itevalicms, ";
                 $sql .= "itebassubs, ";
                 $sql .= "itevalsubs, ";
                 $sql .= "keyinc, ";
                 $sql .= "datinc ";
                 $sql .= ") value ( ";
                 $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
                 $sql .= "'" . $dad['sta'][$ind] . "',";
                 $sql .= "'" . $dad['emi']['ser'] . "',";
                 $sql .= "'" . $dad['emi']['nro'] . "',";
                 $sql .= "'" . $dad['seq'][$ind] . "',";
                 $sql .= "'" . $dad['cod'][$ind] . "',";
                 $sql .= "'" . $dad['ref'][$ind] . "',";
                 $sql .= "'" . $dad['des'][$ind] . "',";
                 $sql .= "'" . $dad['med'][$ind] . "',";
                 $sql .= "'" . $dad['med'][$ind] . "',";
                 $sql .= "'" . $dad['qua'][$ind] . "',";
                 $sql .= "'" . $dad['uni'][$ind] . "',";
                 $sql .= "'" . $dad['ncm'][$ind] . "',";
                 $sql .= "'" . $dad['bar'][$ind] . "',";
                 $sql .= "'" . $dad['cfo'][$ind] . "',";
                 $sql .= "'" . substr($dad['sit'][$ind],0,1) . "',";
                 $sql .= "'" . substr($dad['sit'][$ind],1,3) . "',";
                 $sql .= "'" . $dad['pai'][$ind] . "',";
                 $sql .= "'" . $dad['pcc'][$ind] . "',";
                 $sql .= "'" . $dad['bsc'][$ind] . "',";
                 $sql .= "'" . $dad['vlc'][$ind] . "',";
                 $sql .= "'" . $dad['bss'][$ind] . "',";
                 $sql .= "'" . $dad['vls'][$ind] . "',";
                 $sql .= "'" . $_SESSION['wrkideusu'] . "',";
                 $sql .= "'" . date("Y/m/d H:i:s") . "')";
                 $retorno = mysqli_query($conexao,$sql);
                 if ($retorno == false) {
                     print_r($sql); $sta = 2; echo '<br/>';
                     echo '<script>alert("Erro na atualização de item da nota eletrônica !");</script>';
                 }
             }
         }
     }
     $retorno = desconecta_bco();
     return $sta;
 }

?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <meta name="description"
          content="Profsa Informática - Emissão de NF-e e NFC-e - Gold Software Soluções Inteligentes" />
     <meta name="author" content="Paulo Rogério Souza" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />

     <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet" type="text/css" />
     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" type="text/css" />
     <link href="https://fonts.googleapis.com/css?family=Nunito:300,400&display=swap" rel="stylesheet">

     <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">

     <link rel="shortcut icon"
          href="http://sistema.goldinformatica.com.br/site/wp-content/uploads/2019/04/favicon.png" />

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
          integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
     </script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
          integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
     </script>

     <script type="text/javascript" src="js/profsa.js"></script>

     <link href="css/pallas35.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Emissão de NF-e e NFC-e - Gold Software Soluções Inteligentes - Profsa Informática Ltda - Login</title>
</head>

<script>
$(document).ready(function() {
     $(window).scroll(function() {
          if ($(this).scrollTop() > 100) {
               $(".subir").fadeIn(500);
          } else {
               $(".subir").fadeOut(250);
          }
     });

     $(".subir").click(function() {
          $topo = $("#box00").offset().top;
          $('html, body').animate({
               scrollTop: $topo
          }, 1500);
     });

     $('.lit-7').click(function() {
          var err = $('#erros').val();
          if (err != "") {
               $('#dad_err').empty().html(err);
               $('#mos-err').modal('show');
          }
     });
});

</script>

<?php
     $ret = 0;
     $err = 0;
     $txt = '';
     $avi = '';
     $dad = array();
     $dad['emi']['not'] = 0;
     $dad['not']['pdf'] = "";
     $dad['not']['err'] = "";
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;
     $_SESSION['wrknomide'] = get_current_user();
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(15,"Entrada na página de emissão de danfe do sistema Pallas.35 - Emissão NF-e e NFC-e");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }

     use NFePHP\NFe\Convert;
     use NFePHP\NFe\Tools;
     use NFePHP\Common\Certificate;
     use NFePHP\NFe\Common\Standardize;
     use NFePHP\NFe\Complements;     
     use NFePHP\Common\Validator;
     use NFePHP\DA\NFe\Danfe;
     use NFePHP\DA\Legacy\FilesFolders;

     if (isset($_SESSION['wrknomemp']) == false) { $_SESSION['wrknomemp'] = ''; } 
     if (isset($_SESSION['wrknumcha']) == false) { $_SESSION['wrknumcha'] = 0; }
     if (isset($_SESSION['wrkrecnot']) == false) { $_SESSION['wrkrecnot'] = ''; }
     if (isset($_SESSION['wrkchanot']) == false) { $_SESSION['wrkchanot'] = ''; }
     if (isset($dad['emi']['cod']) == false) {
          $ret = carrega_emp($dad); 
          $ret = carrega_emi($dad); 
     }
     if ($_SESSION['wrkopereg'] == "4" && $_SESSION['wrkcodreg'] != "0") {
          $_SESSION['wrknumcha'] = $_SESSION['wrkcodreg'];
     }
     if ($_SESSION['wrkopereg'] == "6" && isset($_REQUEST['lista']) == true) {
          $_SESSION['wrknumcha'] = 0;
          $_SESSION['wrkrecnot'] = 0;
          $_SESSION['wrkchanot'] = 0;
     }
     if ($_SESSION['wrknumcha'] != 0) {
          $txt = carrega_ped($dad);
          $ret = carrega_ite($dad);  
     }
     if ($_SESSION['wrkrecnot'] != '' && $_SESSION['wrkchanot'] != '') {
          $ret = verifica_xml($dad);
          if ($ret == 8 || $ret == 9) {
               $ret = gravar_pdf($dad);
          }
     }
     if ($_SESSION['wrkopereg'] == "5" && isset($_REQUEST['danfe']) == true) {
          $ret = consiste_ped($dad);
          if ($ret == 0) {
               $ret = calcular_val($dad);
               $ret = gravar_xml($dad);
               if ($ret == 0) {
                    $ret = assinar_xml($dad);
                    if ($ret == 0) {
                         $ret = validar_xml($dad);
                         if ($ret == 0) {
                              $ret = enviar_xml($dad);
                              if ($dad['not']['ret'] != '100') {
                                   $ret = $dad['not']['ret'];
                              } else {
                                   $ret = gravar_nfe($dad);
                                   $ret = gravar_ite($dad);             
                                   $ret = email_not($dad['not']['key']);             
                                   include "lerinformacao.inc";
                                   $sql  = "update tb_pedido set ";
                                   $sql .= "pedstatus = '". '1' . "', ";
                                   $sql .= "pedserie = '". $dad['emi']['ser'] . "', ";
                                   $sql .= "pednotafis = '". $dad['emi']['not'] . "', ";
                                   $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
                                   $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
                                   $sql .= "where idpedido = " . $_SESSION['wrknumcha'];
                                   $ret = mysqli_query($conexao,$sql);
                                   if ($ret == false) {
                                        print_r($sql);
                                        echo '<script>alert("Erro na regravação da pré-nota solicitada !");</script>';
                                   }           
                                   $txt = '';                   
                                   $_SESSION['wrkrecnot'] = 0;
                                   $_SESSION['wrkchanot'] = 0;
                                   $_SESSION['wrknumcha'] = 999999;
                                   $dad['emi']['not'] = $dad['emi']['not'] + 1;
                                   $sql  = "update tb_emitente set ";
                                   $sql .= "emiserie = '". $dad['emi']['ser'] . "', ";
                                   $sql .= "eminumeronot = '". $dad['emi']['not'] . "', ";
                                   $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
                                   $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
                                   $sql .= "where idemite = " . $_SESSION['wrkcodemp'];
                                   $ret = mysqli_query($conexao,$sql);
                                   if ($ret == false) {
                                        print_r($sql);
                                        echo '<script>alert("Erro na regravação do emitente solicitado !");</script>';
                                   }                              
                              }
                         }
                    } else {
                         $avi = $dad['not']['err'];
                         $err = substr_count($dad['not']['err'],"Element");   
                    }
               }   
          }
     }
?>

<body id="box00">
     <h1 class="cab-0">Emissão de Danfe no Sistema Emissão NF-e e NFC-e - Gold Solution- Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10 text-left">
               <div class="qua-5 container">
                    <div class="row lit-3">
                         <div class="col-md-9">
                              <label>Emissão de Nota Fiscal Eletrônica</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmLisPed" action="emi-danfe.php?ope=6" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="lis" name="lista"
                                             title="Mostra lista de pré-notas em aberto para ser faturada no sistema"><i
                                                  class="fa fa-search fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                         <div class="col-md-1">
                              <?php
                              if ($_SESSION['wrknumcha'] == 0 || $_SESSION['wrknumcha'] == 999999) {                              
                                   echo '<form name="frmTelPed" action="con-pedido.php" method="POST">';
                              } else {
                                   echo '<form name="frmTelPed" action="man-pedido.php?ope=2&cod=' . $_SESSION['wrknumcha'] . '" method="POST">';
                              }
                              ?>
                              <div class="text-center">
                                   <button type="submit" class="bot-3" id="nov" name="novo"
                                        title="Leva usuário para página de pré-notas para efetuar manutenção dos dados"><i
                                             class="fa fa-shopping-bag fa-1g" aria-hidden="true"></i></button>
                              </div>
                              </form>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelDan" action="emi-danfe.php?ope=5" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="dan" name="danfe"
                                             title="Inicia processo de impressão de Nota Fiscal Eletrônica (Danfe) no sistema"><i class="fa fa-print fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-12 text-center">
                              <?php if ($txt != "") { echo $txt; } ?>
                         </div>
                    </div>
               </div>
               <br />
               <div class="row">
                    <div class="col-md-4"></div>
                    <div class="lit-7 col-md-3 text-center">
                         <?php 
                              $_SESSION['wrknumdoc'] = $dad['emi']['not'];
                              if ($err != 0) { 
                                   echo 'Erros na Validação: ' . $err . '<br/>'; 
                              } 
                              if (isset($dad['not']['nrp']) == true) {
                                   echo 'NF-e Autorizada -> ' . $dad['not']['nrp'] . '<br/>'; 
                              }
                              if ($dad['not']['err'] != "") {
                                   echo 'Erro Ocorrido: ' . $dad['not']['err'] . '<br/>'; 
                              }
                              if (isset($dad['not']['sta']) == true) {
                                   if ($dad['not']['sta'] != '100' && $dad['not']['sta'] != '103' && $dad['not']['sta'] != '104') {
                                        echo 'Rejeição Recibo: ' . $dad['not']['sta'] . ' - ' . $dad['not']['men'] . '<br/>'; 
                                        $ret = gravar_log(21, 'Rejeição Recibo: ' . $dad['not']['sta'] . ' - ' . $dad['not']['men']);      
                                   }
                              }
                              if (isset($dad['not']['ret']) == true) {
                                   if ($dad['not']['ret'] != '100') {
                                        echo 'Rejeição pela Sefaz: ' . $dad['not']['ret'] . ' - ' . $dad['not']['mot'] . '<br/>'; 
                                        $ret = gravar_log(22, 'Rejeição pela Sefaz: ' . $dad['not']['ret'] . ' - ' . $dad['not']['mot']);      
                                   }
                              }
                         ?>
                    </div>
                    <div class="col-md-1 text-left">
                         <?php if (isset($dad['not']['cam']) == true) { echo '<a href="' . $dad['not']['cam'] . '" title="Visualização do XML gerado para a pré-nota." target="_blank">' . '<i class="fa fa-search fa-2x" aria-hidden="true"></i>' . '</a>'; } ?>
                    </div>
                    <div class="col-md-4"></div>
               </div>
               <br />
               <div class="container">
               <?php if ($_SESSION['wrknumcha'] == 0 || $_SESSION['wrknumcha'] == 999999) { ?>
                    <div class="row">
                         <div class="col-md-12">
                              <div class="tab-1 table-responsive-md">
                                   <table id="tab-0" class="table table-sm table-striped">
                                        <thead class="thead-dark">
                                             <tr>
                                                  <th scope="col">Selecionar</th>
                                                  <th scope="col">Número</th>
                                                  <th scope="col">Status</th>
                                                  <th scope="col">Emissão</th>
                                                  <th scope="col">Entrega</th>
                                                  <th scope="col">Parâmetro</th>
                                                  <th scope="col">Pagamento</th>
                                                  <th scope="col">Nome do Destinatário</th>
                                                  <th scope="col">Transportadora</th>
                                                  <th scope="col">Valor Liquido</th>
                                                  <th scope="col">Observação</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php $ret = demonstra_ped();  ?>
                                        </tbody>
                                   </table>
                                   <br />
                              </div>
                         </div>
                    </div>
               <?php } ?>

               <?php if ($_SESSION['wrknumcha'] != 0 && $_SESSION['wrknumcha'] != 999999) { ?>
               <br />
                    <div class="row lis-ite">
                         <div class="tab-1 table-responsive-md">
                              <table id="tab-0" class="table table-sm tab-2">
                                   <thead class="thead-dark">
                                        <tr>
                                             <th>Ordem</th>
                                             <th>Código</th>
                                             <th>Descrição do Produto</th>
                                             <th>U. M.</th>
                                             <th>S. T.</th>
                                             <th>C.F.O.P.</th>
                                             <th>N.C.M.</th>
                                             <th>Barras</th>
                                             <th>Quantidade</th>
                                             <th>Preço Unitário</th>
                                             <th>Valor do Item</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php $ret = demonstra_ite($dad);  ?>
                                   </tbody>
                              </table>
                         </div>
                    </div>
                    <hr />
               <?php } ?>
                    <div class="row text-center">
                         <?php
                              if (isset($dad['not']['pdf']) == true) {
                                   if (file_exists($dad['not']['pdf']) == true) { 
                                        echo '<embed src="' . $dad['not']['pdf'] . '" width="100%" height="1100" type="application/pdf">';
                                   }
                              }
                         ?>
                    </div>
               </div>
               <form name="frmTelCpo" action="emi-danfe.php?ope=6" method="POST">
                    <input type="hidden" id="erros" name="erros" value="<?php echo $avi; ?>" />
               </form>
          </div>
     </div>

     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>

     <!----------------------------------------------------------------------------------->
     <div class="modal fade" id="mos-err" tabindex="-1" role="dialog" aria-labelledby="tel-err" aria-hidden="true"
          data-backdrop="true">
          <div class="modal-dialog modal-lg" role="document"> <!-- modal-sm modal-lg modal-xl -->
               <form id="frmMosErr" name="frmMosErr" action="emi-danfe.php" method="POST">
                    <div class="qua-2 modal-content">
                         <div class="modal-header">
                              <h5 class="modal-title" id="tel-err">Demonstração de Erros Ocorridos</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                   <span aria-hidden="true">&times;</span>
                              </button>
                         </div>
                         <div class="modal-body">
                              <div class="form-row text-left">
                                   <div class="col-md-12">
                                        <div id="dad_err"></div>
                                   </div>
                              </div>
                              <br />
                         </div>
                         <div class="modal-footer">
                              <button type="button" id="clo" name="close" class="btn btn-outline-danger"
                                   data-dismiss="modal">Fechar</button>
                         </div>
                    </div>
               </form>
          </div>
     </div>
     <!----------------------------------------------------------------------------------->

</body>
<?php
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
          $dad['emi']['reg'] = $lin['emiregime'] + 1;  // 1-Simples 2-Simples-Excessão 3-Normal        
          $dad['emi']['pes'] = $lin['emipessoa'];
          $dad['emi']['tel'] = $lin['emitelefone'];
          $dad['emi']['cel'] = $lin['emicelular'];
          $dad['emi']['con'] = $lin['emicontato'];
          $dad['emi']['ema'] = $lin['emiemail'];
          $dad['emi']['ver'] = $lin['emiverao'];
          $dad['emi']['ser'] = $lin['emiserie'];
          $dad['emi']['not'] = $lin['eminumeronot'];
          $dad['emi']['amb'] = $lin['emitipoamb'];
          $dad['emi']['log'] = $lin['emicamlogo'];
          $dad['emi']['cer'] = $lin['emicamcertif'];
          $dad['emi']['sen'] = $lin['emisencertif'];
          $dad['emi']['val'] = $lin['emidatcertif'];
          $dad['emi']['csc'] = $lin['eminumerocsc'];
          $dad['emi']['emi'] = date('Y-m-d H:i:s');
          $dad['not']['con'] = configura_not($dad);
     }
     return $sta;
}

function carrega_ped(&$dad) {
     $txt = '';
     include "lerinformacao.inc";
     $dad['ped']['nro'] = $_SESSION['wrknumcha'];
     $com = "Select P.*, D.*, N.*, T.*, X.* from ((((tb_pedido P left join tb_destino D on P.peddestino = D.iddestino) left join tb_parametro N on P.pedparametro = N.idparametro) left join tb_transporte T on P.pedtransporte = T.idtransporte) left join tb_pagto X on P.pedpagto = X.idpagto) where idpedido = " . $_SESSION['wrknumcha'];
     $sql = mysqli_query($conexao,$com);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          if ($lin['pedstatus'] == 1) {
               echo '<script>alert("Pré-Nota Número: ' . $_SESSION['wrknumcha'] . ', já está processada no sistema");</script>';
          } else {
               $txt .= '<div class="lit-6">' . 'EMITENTE: ' . $dad['emi']['raz'] . '</div>';
               $txt .= '<div class="lit-6">' . 'Número da Pré-Nota: ' . $lin['idpedido'] . '</div>' . '<br />';
               $txt .= 'Emissão: ' . date('d/m/Y',strtotime($lin['pedemissao'])) . ' - Entrega: ' . date('d/m/Y',strtotime($lin['pedentrega'])) . '<br />';
               $txt .= 'Parâmetro Fiscal: ' . $lin['parnome'] . '<br />';
               $txt .= 'Condição de Pagto: ' . $lin['pagdescricao'] . '<br />';
               if ($lin['pedvalorbru'] == $lin['pedvalorliq']) {
                    $txt .= 'Valor Líquido: R$ ' . number_format($lin['pedvalorliq'], 2, ',', '.') . '<br />';
               } else {
                    $txt .= 'Valor Bruto: R$ ' . number_format($lin['pedvalorbru'], 2, ',', '.') . ' - Liquido: R$ ' . number_format($lin['pedvalorliq'], 2, ',', '.') . '<br />';
               }
               $txt .= 'Destinatário: ' . $lin['desrazao'] . '<br />';
               $txt .= 'Endereço: ' . $lin['desendereco'] . ', ' . $lin['desnumeroend'] . ' ' . $lin['descomplemento'] . ' - ' . $lin['desbairro'] . '<br />';
               $txt .= 'Cep - Cidade - Estado: ' . mascara_cpo($lin['descep'],"     -   ") . ' - ' . $lin['descidade'] . ' - ' . $lin['desestado'] . '<br />';
               if ($lin['despessoa'] == 0) {
                    $txt .= 'C.p.f. - R.G.: ' . $lin['descnpj'] . " - " . $lin['desinscricao'] . '<br />';
               } else {
                    $txt .= 'C.n.p.j. - Inscrição: ' . $lin['descnpj'] . " - " . $lin['desinscricao'] . '<br />';
               }
               $txt .= 'Transportador: ' . $lin['trarazao'] . '<br />';
               $txt .= 'Observação: ' . $lin['pedobservacao'] . '<br />';
               $txt .= '<br />';
               $txt .= '<div class="lit-6">' . 'Série da Danfe: ' . $dad['emi']['ser'] . ' - Número: ' . number_format($dad['emi']['not'], 0, ',', '.') . '</div>';
               $txt .= '<div>' . 'Certificado: ' . date('d/m/Y H:i:s', strtotime($dad['emi']['val'])) . '</div>';
               $txt .= '<br />';

               $dad['ped']['cod'] = $lin['idpedido'];
               $dad['ped']['emi'] = $lin['pedemissao'];
               $dad['ped']['ent'] = $lin['pedentrega'];
               $dad['ped']['cli'] = $lin['peddestino'];
               $dad['ped']['par'] = $lin['pedparametro'];
               $dad['ped']['pag'] = $lin['pedpagto'];
               $dad['ped']['tra'] = $lin['pedtransporte'];
               $dad['ped']['bru'] = $lin['pedvalorbru'];
               $dad['ped']['val'] = $lin['pedvalorliq'];
               $dad['ped']['fre'] = $lin['pedfrete'];
               $dad['ped']['seg'] = $lin['pedseguro'];
               $dad['ped']['out'] = $lin['pedoutras'];
               $dad['ped']['dan'] = $lin['pedopcdanfe'];
               $dad['ped']['pcd'] = $lin['pedpordesconto'];
               $dad['ped']['vld'] = $lin['pedvaldesconto'];
               $dad['ped']['psl'] = $lin['pedpesoliq'];
               $dad['ped']['psb'] = $lin['pedpesobru'];
               $dad['ped']['qtd'] = $lin['pedqtde'];
               $dad['ped']['mar'] = $lin['pedmarca'];
               $dad['ped']['esp'] = $lin['pedespecie'];
               $dad['ped']['num'] = $lin['pednumero'];               
               $dad['ped']['obs'] = $lin['pedobservacao'];
               $dad['ped']['dat'] = date('d/m/Y');
               if ($lin['pedopcdanfe'] == 0) {
                    $dad['ped']['men'] = '';
               } else {
                    $dad['ped']['men'] = $lin['pedobservacao'];
               }

               $dad['cli']['cod'] = $lin['iddestino'];
               $dad['cli']['raz'] = $lin['desrazao'];
               $dad['cli']['fan'] = $lin['desfantasia'];
               $dad['cli']['end'] = $lin['desendereco'];
               $dad['cli']['num'] = $lin['desnumeroend'];
               $dad['cli']['com'] = $lin['descomplemento'];
               $dad['cli']['bai'] = $lin['desbairro'];
               $dad['cli']['cep'] = $lin['descep'];
               $dad['cli']['cid'] = $lin['descidade'];
               $dad['cli']['est'] = $lin['desestado'];
               $dad['cli']['cgc'] = $lin['descnpj'];
               $dad['cli']['ins'] = $lin['desinscricao'];
               $dad['cli']['imu'] = $lin['desinsmunic'];
               $dad['cli']['pes'] = $lin['despessoa'];
               $dad['cli']['con'] = $lin['descontribuinte'];
               $dad['cli']['tip'] = $lin['destipconsumo'];
               $dad['cli']['fre'] = $lin['destipfrete'];
               $dad['cli']['tel'] = $lin['destelefone'];
               $dad['cli']['cel'] = $lin['descelular'];
               $dad['cli']['nom'] = $lin['descontato'];
               $dad['cli']['ema'] = $lin['desemail'];
               $dad['cli']['mun'] = $lin['descodmunic'];

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
               if ($dad['par']['tip'] == 0) { $dad['par']['tpo'] = 1; }
               if ($dad['par']['tip'] == 1) { $dad['par']['tpo'] = 0; }
               if ($dad['par']['tip'] == 2) { $dad['par']['tpo'] = 0; }
               if ($dad['par']['tip'] == 3) { $dad['par']['tpo'] = 1; }
               if ($dad['par']['tip'] == 4) { $dad['par']['tpo'] = 0; }
               if ($dad['par']['tip'] == 5) { $dad['par']['tpo'] = 1; }
               if ($dad['par']['tip'] == 6) { $dad['par']['tpo'] = 0; }
               if ($dad['par']['tip'] == 7) { $dad['par']['tpo'] = 1; }

               $dad['pag']['cod'] = 0;
               if ($lin['pedpagto'] >= 1) {
                    $dad['pag']['cod'] = $lin['idpagto'];
                    $dad['pag']['des'] = $lin['pagdescricao'];
                    $dad['pag']['par'] = $lin['pagparcela'];
                    $dad['pag']['dia'] = $lin['pagdiafixo'];
                    $dad['pag']['d00'] = $lin['pagdias00'];
                    $dad['pag']['d01'] = $lin['pagdias01'];
                    $dad['pag']['d02'] = $lin['pagdias02'];
                    $dad['pag']['d03'] = $lin['pagdias03'];
                    $dad['pag']['d04'] = $lin['pagdias04'];
                    $dad['pag']['d05'] = $lin['pagdias05'];
                    $dad['pag']['d06'] = $lin['pagdias06'];
                    $dad['pag']['d07'] = $lin['pagdias07'];
                    $dad['pag']['d08'] = $lin['pagdias08'];
                    $dad['pag']['d09'] = $lin['pagdias09'];
                    $dad['pag']['d10'] = $lin['pagdias10'];
                    $dad['pag']['d11'] = $lin['pagdias11'];
                    $dad['pag']['d12'] = $lin['pagdias12'];
               }

               $dad['tra']['cod'] = 0;
               if ($lin['pedtransporte'] >= 1) {
                    $dad['tra']['cod'] = $lin['idtransporte'];
                    $dad['tra']['raz'] = $lin['trarazao'];
                    $dad['tra']['end'] = $lin['traendereco'];
                    $dad['tra']['num'] = $lin['tranumeroend'];
                    $dad['tra']['bai'] = $lin['trabairro'];
                    $dad['tra']['cep'] = $lin['tracep'];
                    $dad['tra']['cid'] = $lin['tracidade'];
                    $dad['tra']['est'] = $lin['traestado'];
                    $dad['tra']['cgc'] = $lin['tracnpj'];
                    $dad['tra']['ins'] = $lin['trainscricao'];
                    $dad['tra']['pes'] = $lin['trapesfisica'];
                    $dad['tra']['con'] = $lin['tracontato'];
                    $dad['tra']['ema'] = $lin['traemail'];
                    $dad['tra']['tel'] = $lin['tratelefone'];
                    $dad['tra']['cel'] = $lin['tracelular'];
                    $dad['tra']['tip'] = $lin['tratipotransp'];
               }
          }
     }

     $dad['not']['tpd'] = 0;
     if (isset($dad['cli']['est']) == true) {
          if ($dad['emi']['est'] == $dad['cli']['est']) {
               $dad['not']['tpd'] = 1;  // Dentro do estado
          } else if ($dad['cli']['est'] == "EX") {
               $dad['not']['tpd'] = 3;  // Exterior
          } else if ($dad['emi']['est'] != $dad['cli']['est']) {
               $dad['not']['tpd'] = 2;  // Fora do estado
          }
     }
     
     if ($dad['not']['pdf'] == "") {
          $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfe.pdf';  
          if (file_exists($dir) == true) { 
               $dad['not']['pdf'] = $dir;
          }     
     }

     return $txt;
}

function carrega_ite(&$dad) {
     $sta = 0;
     $dad['not']['qtd'] = 0;
     $dad['par']['cfo'] = '';
     include "lerinformacao.inc";
     $com  = "Select I.*, P.* from (tb_pedido_i I left join tb_produto P on I.iteproduto = P.idproduto) where itepedido = " . $_SESSION['wrknumcha'] . " order by iditem";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $dad['seq'][] = $reg['itesequencia'];
          $dad['sta'][] = $reg['itestatus'];
          $dad['cod'][] = $reg['iteproduto'];
          $dad['des'][] = $reg['itedescricao'];
          $dad['med'][] = $reg['itemedida'];
          $dad['qua'][] = $reg['itequantidade'];
          $dad['qtd'][] = number_format($reg['itequantidade'], 0, ',', '.');
          $dad['pre'][] = number_format($reg['itepreco'], 2, ',', '.');
          $dad['uni'][] = $reg['itepreco'];
          $dad['bru'][] = $reg['itepreco'];
          $dad['liq'][] = $reg['itepreco'];
          $dad['val'][] = $reg['itequantidade'] * $reg['itepreco'];
          $dad['sit'][] = str_pad($reg['prosittributaria'], 4, "0",STR_PAD_LEFT);
          $dad['ref'][] = $reg['proreferencia'];
          $dad['ncm'][] = $reg['pronumeroncm'];
          $dad['bar'][] = $reg['procodbarras'];
          $dad['pcc'][] = $reg['propercentualicm'];
          $dad['pcp'][] = $reg['propercentualipi'];
          $dad['pcv'][] = $reg['propercentualiva'];
          $dad['cfo'][] = $reg['itenumerocfo'];
          $dad['pai'][] = '0.00';  // Percentual de aproveitamento de Icms
          $dad['vci'][] = '0.00';  // Valor de crédito de Icms
          $dad['bst'][] = '0.00';  // Base de calculo ST
          $dad['vst'][] = '0.00';  // Valor de ST
          $dad['pst'][] = '0.00';  // Percentual de ST
          $dad['not']['qtd'] = $dad['not']['qtd'] + 1;
          if ($dad['par']['cfo'] == "") { $dad['par']['cfo'] = $reg['itenumerocfo']; }
     }    
     return $sta;
}

function demonstra_ped() {
     $nro = 0;
     include "lerinformacao.inc";
     $com = "Select P.*, D.desrazao, N.parnome, T.trarazao, X.pagdescricao from ((((tb_pedido P left join tb_destino D on P.peddestino = D.iddestino) left join tb_parametro N on P.pedparametro = N.idparametro) left join tb_transporte T on P.pedtransporte = T.idtransporte) left join tb_pagto X on P.pedpagto = X.idpagto) where pedstatus = 0 and pedempresa = " . $_SESSION['wrkcodemp'] . " order by pedemissao, idpedido";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $lin =  '<tr>';
          $lin .= '<td class="bot-3 text-center"><a href="emi-danfe.php?ope=4&cod=' . $reg['idpedido'] . '" title="Carrega pré-nota para usuário efetuar impressão da Nota Fiscal Eletrônica da linha"><i class="fa fa-search fa-2x" aria-hidden="true"></i></a></td>';
          $lin .= '<td class="text-center">' . $reg['idpedido'] . '</td>';
          if ($reg['pedstatus'] == 0) {$lin .= "<td>" . "Aberto" . "</td>";}
          if ($reg['pedstatus'] == 1) {$lin .= "<td>" . "Processadoo" . "</td>";}
          if ($reg['pedstatus'] == 2) {$lin .= "<td>" . "Suspenso" . "</td>";}
          if ($reg['pedstatus'] == 3) {$lin .= "<td>" . "Cancelado" . "</td>";}
          $lin .= '<td class="text-center">' . date('d/m/Y',strtotime($reg['pedemissao'])) . "</td>";
          $lin .= '<td class="text-center">' . date('d/m/Y',strtotime($reg['pedentrega'])) . "</td>";
          $lin .= "<td>" . $reg['parnome'] . "</td>";
          $lin .= "<td>" . $reg['pagdescricao'] . "</td>";
          $lin .= "<td>" . $reg['desrazao'] . "</td>";
          $lin .= "<td>" . $reg['trarazao'] . "</td>";
          $lin .= '<td class="text-right">' . number_format($reg['pedvalorliq'], 2, ",", ".") . '</td>';
          $lin .= "<td>" . $reg['pedobservacao'] . "</td>";
          $lin .= "</tr>";
          echo $lin;
     }
     return $nro;
}

function demonstra_ite(&$dad) {
     $sta = 0;
     if (isset($dad['cod']) == true && isset($dad['des']) == true) {         
          $nro = count($dad['cod']);
          for ($ind = 0; $ind < $nro; $ind++) {
               if ($dad['cod'][$ind] != 0) {
                    $txt  = '<tr>';
                    $txt .= '<td class="text-center">' . ($dad['seq'][$ind] + 1) . '</td>';
                    $txt .= '<td class="text-center">' . $dad['cod'][$ind] . '</td>';
                    $txt .= '<td>' . $dad['des'][$ind] . '</td>';
                    $txt .= '<td>' . $dad['med'][$ind] . '</td>';
                    $txt .= '<td>' . str_pad($dad['sit'][$ind], 4, "0",STR_PAD_LEFT) . '</td>';
                    $txt .= '<td>' . $dad['cfo'][$ind] . '</td>';
                    $txt .= '<td>' . $dad['ncm'][$ind] . '</td>';
                    $txt .= '<td>' . $dad['bar'][$ind] . '</td>';
                    $txt .= '<td class="text-center">' . number_format($dad['qtd'][$ind], 0, ',', '.') . '</td>';
                    $txt .= '<td class="text-center">' . number_format($dad['uni'][$ind], 2, ',', '.') . '</td>';
                    $txt .= '<td class="text-center">' . number_format($dad['val'][$ind], 2, ',', '.') . '</td>';
                    $txt .= '</tr>';
                    echo $txt;
               }
          }
     }    
     return $sta;
}

function consiste_ped(&$dad) {
     $sta = 0;

     if ( $dad['emi']['cer'] == "") {
          echo '<script>alert("Não há certificado cadastrado no emitente para emissão");</script>';
          return 1; 
     }
     if ( $dad['not']['qtd'] == 0) {
          echo '<script>alert("Não há item de produto informado para pré-nota informada");</script>';
          return 1; 
     }
     if ($dad['emi']['mun'] == "" || $dad['emi']['mun'] == "0") {
          echo '<script>alert("Código do município no emitente não pode estar em branco");</script>';
          return 1; 
     }
     if ($dad['cli']['mun'] == "" || $dad['cli']['mun'] == "0") {
          echo '<script>alert("Código do município no destinatário não pode estar em branco");</script>';
          return 2; 
     }
     if ($dad['emi']['not'] == 0) {
          echo '<script>alert("Número da nota fiscal para o emitente não pode estar zerado");</script>';
          return 1; 
     }
     if (count($dad['cod']) == 0) {
          echo '<script>alert("Não há itens de produto na pré-nota informada para emissão");</script>';
          return 1; 
     }
     if ($dad['not']['tpd'] == 1 && substr($dad['par']['cfo'],0,1) == '6' ) {
          echo '<script>alert("Identificação do destinatário é incompativel com de Cfop da pré-nota");</script>';
          return 1; 
     }
     if ($dad['not']['tpd'] == 2 && substr($dad['par']['cfo'],0,1) == '5' ) {
          echo '<script>alert("Identificação do destinatário é incompativel com de C.f.o.p. da nota");</script>';
          return 1; 
     }
     $cam = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['cer']; 
     if (file_exists($cam) == false) {
          echo '<script>alert("Caminho para o certificado digital não encontrado no sistema");</script>';
          return 1;
     }
     return $sta;
}

function calcular_val(&$dad) {
     $sta = 0;
     $dad['ven']['qtd'] = 0;
     $dad['pag']['par'] = 0;
     $nro = count($dad['cod']);
     $bru = $dad['ped']['bru'];
     $des = $dad['ped']['bru'] - $dad['ped']['val'];
     for ($ind = 0; $ind < $nro; $ind++) {
          $dad['bsc'][$ind] = $dad['val'][$ind];
          $dad['bss'][$ind] = $dad['val'][$ind];
          $dad['vlc'][$ind] = round($dad['val'][$ind] * $dad['pcc'][$ind] / 100, 2);
          $dad['vls'][$ind] = round($dad['val'][$ind] * $dad['pcv'][$ind] / 100, 2);
          $dad['vld'][$ind] = round($des * $dad['val'][$ind] / $bru, 2);   // Proporcionaliza desconto pelos itens
     }

     if ( $dad['ped']['pag'] >= 1) {
          $dia = 0; 
          $dif = $dad['ped']['val'];
          $val = $dad['ped']['val'];
          $par = $dad['pag']['par'];
          $dad['ven']['qtd'] = $dad['pag']['par'];
          if ($par != 0) {
               $val = round($val / $par, 2);
          }
          for ($ind = 0; $ind <= 12; $ind++) {
               $nro = str_pad($ind, 2, "0",STR_PAD_LEFT);
               if ($dad['pag']['d' . $nro] != 0) {
                    $dia = $dia + 1;
               }               
          }
          if ($dia >= 1) {
               for ($ind = 0; $ind < $par; $ind++) {
                    $dif = round($dif - $val, 2);
                    $nro = str_pad($ind, 2, "0",STR_PAD_LEFT);
                    $dia = $dad['pag']['d' . $nro];
                    $dat = date('d/m/Y', strtotime('+' . $dia . ' days'));
                    $dad['pag']['nrp'][] = $ind;
                    $dad['pag']['vlp'][] = $val;
                    $dad['pag']['dtp'][] = $dat;
               }
          } else {
               for ($ind = 0; $ind < $par; $ind++) {
                    $dia = $ind * 30;
                    $dif = round($dif - $val, 2);
                    $dat = date('d/m/Y', strtotime('+' . $dia . ' days'));
                    $dad['pag']['nrp'][] = $ind;
                    $dad['pag']['vlp'][] = $val;
                    $dad['pag']['dtp'][] = $dat;
               }
          }
          if (isset($dad['pag']['vlp'][0]) == true) {
               if ($dif != 0) { $dad['pag']['vlp'][0] = $dad['pag']['vlp'][0] + $dif; }
          }
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
     $dad['not']['des'] = $dad['ped']['bru'] - $dad['ped']['val'];
     $dad['not']['imp'] = 0;
     $dad['not']['vip'] = 0;
     $dad['not']['ipd'] = 0;
     $dad['not']['pis'] = 0;
     $dad['not']['cof'] = 0;
     $dad['not']['out'] = 0;
     $dad['not']['not'] = $dad['ped']['val'];

     return $sta;
}

function gravar_xml(&$dad) {
     $sta = 0;
     include_once "funcoes.php";
     if (file_exists('xml') == false) { mkdir('xml'); }
     $err = 'xml/' . 'NFE_' .  str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfe.err';
     $deb = 'xml/' . 'NFE_' .  str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfe.deb';
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

     $sai = 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfe.xml';  
     $txt =  'xml/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfe.xml';

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

     $linha .= '<dest>';    
     if ($dad['cli']['pes'] == "1") {
          $linha .= '<CNPJ>' . $dad['cli']['cgc'] . '</CNPJ>';
     }else{
          $linha .= '<CPF>' . $dad['cli']['cgc'] . '</CPF>';
     }
     if ($dad['emi']['amb'] == 1) {
          $linha .= '<xNome>' . limpa_cpo(trim($dad['cli']['raz'])) . '</xNome>';        
     }else{
          $linha .= '<xNome>' . 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL' . '</xNome>';        
     } 
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
               $linha .= '<qCom>' . $dad['qtd'][$ind] . '</qCom>';
               $linha .= '<vUnCom>' . $dad['uni'][$ind] . '</vUnCom>';
               $linha .= '<vProd>' . number_format($dad['val'][$ind],2,".","") . '</vProd>';
               $linha .= '<cEANTrib>' . $dad['bar'][$ind] . '</cEANTrib>';
               $linha .= '<uTrib>' . $dad['med'][$ind] . '</uTrib>';
               $linha .= '<qTrib>' . $dad['qtd'][$ind] . '</qTrib>';
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
               $linha .= '<tPag>' . '01' . '</tPag>';  
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
     include_once "inclusao.php";
     $dad['not']['err'] = '';
     error_reporting(E_ALL);
     ini_set('display_errors', 'On'); 
     $cam = $dad['not']['cam'];
     if (file_exists($cam) == false) {
          echo '<script>alert("Caminho para assinar XML da Pré-Nota não encontrado no sistema");</script>';
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
     $dad['not']['err'] = $e->getMessage();
     $sta = $sta + 1;
}

     return $sta;
}

function validar_xml(&$dad) {
     $sta = 0; $dad['not']['err'] = '';
     include_once "inclusao.php";
     error_reporting(E_ALL);
     ini_set('display_errors', 'On'); 
     $cam = $dad['not']['dir'];
     if (file_exists($cam) == false) {
          echo '<script>alert("Caminho para XML assinado não encontrado no sistema");</script>';
          $sta = 1; return $sta;
     }
     $xml = file_get_contents($cam);
     $xsd = __DIR__ . "/" . "sped-nfe-master/schemes/PL_009_V4/leiauteNFe_v4.00.xsd";
     if (file_exists($xsd) == false) {
          echo '<script>alert("Caminho do XSD para validação do XML não encontrado no sistema");</script>';
          $sta = 2; return $sta;
     }
     try {
          $ret = Validator::isValid($xml, $xsd); 

     } catch (\Exception $e) {
          $dad['not']['err'] = $e->getMessage();
          if (strpos($dad['not']['err'],"No matching") == 0) {
               $sta = $sta + 1;
          }
     }
     return $sta;
}

function enviar_xml(&$dad) {
     $sta = 0; $dad['not']['err'] = ''; $dad['not']['sta'] = '';
     include_once "inclusao.php";
     error_reporting(E_ALL);
     ini_set('display_errors', 'On'); 
     $cam = $dad['not']['dir'];
     if (file_exists($cam) == false) {
          echo '<script>alert("Caminho para XML assinado não encontrado no sistema");</script>';
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

          sleep(5); // Efetua uma pausa no programa por N segundos 

          $ret = consulta_rec($dad);
          if($ret == '100') {
               $pro = Complements::toAuthorize($xml, $dad['not']['pro']); // Adiciona o protocolo ao XML assinado
               $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['not']['sai']; 
               $dir = str_replace("-nfe.xml","-procNFe.xml",$dir);   
               file_put_contents($dir, $pro);         
               $dad['not']['dan'] = $dir;   

               $doc = FilesFolders::readFile($dir);
               if ($dad['emi']['log'] != "") {
                    $cam = __DIR__ . "/" . "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['log'];
                    $log = 'data://text/plain;base64,'. base64_encode(file_get_contents($cam));
               }
               $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfe.pdf';  
               $danfe = new Danfe($doc, 'P', 'A4', $log, 'I', '');
               $ret = $danfe->montaDANFE();
               $pdf = $danfe->render();
               file_put_contents($dir, $pdf);
               $dad['not']['pdf'] = $dir;     
          }
     }
} catch (\Exception $e) {
     $dad['not']['err'] = $e->getMessage();
     $sta = $sta + 1;
}
     return $sta;
}

function consulta_rec(&$dad) {
     $sta = 0;
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
     $dir =  'xml/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-rec.xml';
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
               $dad['not']['dtp'] = $std->protNFe->infProt->dhRecbto;     
               $dad['not']['nrp'] = $std->protNFe->infProt->nProt;         

          }
          if($std->protNFe->infProt->cStat == '539') { //  539: Duplicidade de chave na Sefaz

          }
     } else {
          $sta = $dad['not']['sta'];
     }
     return $sta;
}

function consulta_cha(&$dad) {
     $sta = 0;
     if (isset($dad['not']['sai']) == false) {
          $dad['not']['sai'] = 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfe.xml';  
          $dad['not']['cam'] =  'xml/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfe.xml';
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
     $dir =  'xml/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-cha.xml';
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
                    $dir = str_replace("-nfe.xml","-procNFe.xml",$dir);   
                    file_put_contents($dir, $pro);    
                    $dad['not']['dan'] = $dir;
               }
          }
     }
     return $sta;
}

function verifica_xml(&$dad) {
     $sta = 0;
     include_once "inclusao.php";
     error_reporting(E_ALL);
     ini_set('display_errors', 'On'); 

     $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['cer']; 
     $cer = file_get_contents($dir);
     $tools = new Tools($dad['not']['con'], Certificate::readPfx($cer, $dad['emi']['sen']));

     $ass = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfe.xml';  
     $pro =  'xml/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-rec.xml';
     $dan = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-procNFe.xml';  
     $pdf = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfe.pdf';  

     if (file_exists($pdf) == true) {
          $sta = 7;
          $dad['not']['pdf'] = $pdf;
          $dad['not']['dan'] = $dan;
     }else  if (file_exists($dan) == true) {
          $sta = 8;
          $dad['not']['dan'] = $dan;
     }
     if (file_exists($ass) == true) {
          if (file_exists($pro) == true) {
               if (file_exists($dan) == false) {
                    $dig_2 = ""; $sta_3 = ""; $des_3 = ""; 
                    $ass = file_get_contents($ass);
                    $pro = file_get_contents($pro);
                    $ret_1 = simplexml_load_string($ass);
                    $dig_1 = $ret_1->Signature->SignedInfo->Reference->DigestValue;
                    $ret_2 = new DOMDocument();
                    $ret_2->loadXML($pro);
                    $sta_2 = $ret_2->getElementsByTagName('cStat')->item(0)->nodeValue;
                    if (isset($ret_2->getElementsByTagName('cStat')->item(1)->nodeValue) == true ) {
                         $sta_3 = $ret_2->getElementsByTagName('cStat')->item(1)->nodeValue;
                    }
                    $des_2 = $ret_2->getElementsByTagName('xMotivo')->item(0)->nodeValue;
                    if (isset($ret_2->getElementsByTagName('xMotivo')->item(1)->nodeValue) == true ) {
                         $des_3 = $ret_2->getElementsByTagName('xMotivo')->item(1)->nodeValue;
                    }
                    if (isset($ret_2->getElementsByTagName('digVal')->item(0)->nodeValue) == true) {
                         $dig_2 = $ret_2->getElementsByTagName('digVal')->item(0)->nodeValue;
                    }
                    if ($sta_3 == '100') {
                         $xml = Complements::toAuthorize($ass, $pro); 
                         file_put_contents($dan, $xml);     
                         $dad['not']['dan'] = $dan;
                         $sta = 9; 
                    }
               }
          }
     }
     if (file_exists($ass) == true) {
          if (file_exists($pro) == false) {
               if ($_SESSION['wrkrecnot'] != "") {
                    $dad['not']['nrr'] = $_SESSION['wrkrecnot'];
                    $ret = consulta_rec($dad);
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

     $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfe.pdf';  

     $xml = $dad['not']['dan'];
     $doc = FilesFolders::readFile($xml);

     if ($dad['emi']['log'] != "") {
          $cam = __DIR__ . "/" . "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['log'];
          $log = 'data://text/plain;base64,'. base64_encode(file_get_contents($cam));
     }
     try {
          $danfe = new Danfe($doc, 'P', 'A4', $log, 'I', '');
          $ret = $danfe->montaDANFE();
          $pdf = $danfe->render();
          file_put_contents($dir, $pdf);
          $dad['not']['pdf'] = $dir;
     } catch (InvalidArgumentException $e) {
          $dad['not']['pdf'] = "Erro: " . $e->getMessage();
          $sta = $sta + 1;
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
         $sql .= "'" . '0' . "',";      //
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
         $sql .= "'" . ( isset($dad['not']['nrr']) == false ? '0' : $dad['not']['nrp'] ) . "',";
         $sql .= "'" . ( isset($dad['not']['nrr']) == false ? '0' : $dad['not']['nrl'] ) . "',"; 
         $sql .= "'" . ( isset($dad['not']['nrr']) == false ? '0' : $dad['not']['dtr'] ) . "',";
         $sql .= "'" . ( isset($dad['not']['nrr']) == false ? '0' : $dad['not']['dtp'] ) . "',";         
         $sql .= "'" . $dad['par']['mod'] . "',";
         $sql .= "'" . $dad['ped']['men'] . "',";
         $sql .= "'" . $_SESSION['wrkideusu'] . "',";
         $sql .= "'" . date("Y/m/d H:i:s") . "')";
     }else{
         $sql  = "update tb_nota_e set ";
         $sql .= "notdestino = '" . $dad['ped']['cli'] . "', ";
         $sql .= "notpedido = '" . $dad['ped']['cod'] . "', ";
         $sql .= "notdatemissao = '" . $dad['emi']['emi'] . "', ";
         $sql .= "notdatsaida = '" . $dad['emi']['emi'] . "', ";
         $sql .= "nottiponota = '" . $dad['par']['tip'] . "', ";
         $sql .= "notpagto = '" . $dad['ven']['qtd'] . "', ";
         $sql .= "notpagto = '" . $dad['pag']['cod'] . "', ";
         $sql .= "nottransporte = '" . $dad['tra']['cod'] . "', ";
         $sql .= "notparametro = '" . $dad['par']['cod'] . "', ";
         $sql .= "notqtdparcela = '" . $dad['ven']['qtd'] . "', ";
         $sql .= "notcfop = '" . $dad['par']['cfo'] . "', ";
         $sql .= "notqtditem = '" . $dad['not']['qtd'] . "', ";
         $sql .= "nottipoaten = '" . '0' . "', ";
         $sql .= "notnatureza = '" . $dad['par']['des'] . "', ";
         $sql .= "nottipocons = '" . $dad['cli']['tip'] . "', ";
         $sql .= "nottipodest = '" . $dad['par']['des'] . "', ";
         $sql .= "notvalprod = '" . $dad['not']['val'] . "', ";
         $sql .= "notvalnota = '" . $dad['not']['not'] . "', ";
         $sql .= "notbasicms = '" . $dad['not']['bic'] . "', ";
         $sql .= "notvalicms = '" . $dad['not']['vic'] . "', ";
         $sql .= "notbassubs = '" . $dad['not']['bst'] . "', ";
         $sql .= "notvalsubs = '" . $dad['not']['vst'] . "', ";
         $sql .= "notvaltrib = '" . '0' . "', ";
         $sql .= "notchavenfe = '" . $dad['not']['cha'] . "', ";
         $sql .= "notnumerorec = '" . ( isset($dad['not']['nrr']) == false ? '0' : $dad['not']['nrr'] ) . "', ";
         $sql .= "notnumeropro = '" . ( isset($dad['not']['nrr']) == false ? '0' : $dad['not']['nrp'] ) . "', ";
         $sql .= "notnumerolot = '" . ( isset($dad['not']['nrr']) == false ? '0' : $dad['not']['nrl'] ) . "', ";
         $sql .= "notdatarec = '" . ( isset($dad['not']['nrr']) == false ? '0' : $dad['not']['dtr'] ) . "', ";
         $sql .= "notdatapro = '" . ( isset($dad['not']['nrr']) == false ? '0' : $dad['not']['dtp'] ) . "', ";
         $sql .= "notobservacao = '" . $dad['ped']['men'] . "', ";
         $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
         $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
         $sql .= "where notempresa = '" . $_SESSION['wrkcodemp'] . "' and notserie = " . $dad['emi']['ser'] . " and notnumero = " . limpa_nro($dad['emi']['nro']);
     }
     $retorno = mysqli_query($conexao,$sql);
     $dad['not']['key'] = mysqli_insert_id($conexao); 
     if ($retorno == false) {
          print_r($sql); $sta = 2; echo '<br/>';
          echo '<script>alert("Erro na atualização de nota fiscal eletrônica !");</script>';
     }

     $retorno = desconecta_bco(); 
     return $sta;
}

function gravar_ite($dad) {
     $sta = 0;
     include "lerinformacao.inc";
     $nro  = count($dad['cod']);
      for ($ind = 0; $ind < $nro; $ind++) {
         if ($dad['des'][$ind] != '' and $dad['sta'][$ind] == 1) { 
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

function email_not($cha) {
     $sta = 0; $xml = ""; $pdf = "";
     include "lerinformacao.inc";
     $nom = retorna_dad('emirazao', 'tb_emitente', 'idemite', $_SESSION['wrkcodemp']);    
     $ema = retorna_dad('emiemail', 'tb_emitente', 'idemite', $_SESSION['wrkcodemp']);    
     $com  = "Select N.*, D.desrazao, D.desemail, P.parnome, T.trarazao, T.traemail, X.pagdescricao from ((((tb_nota_e N left join tb_destino D on N.notdestino = D.iddestino) left join tb_parametro P on N.notparametro = P.idparametro) left join tb_transporte T on N.nottransporte = T.idtransporte) left join tb_pagto X on N.notpagto = X.idpagto) where idnota = " . $cha;
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {       
         $txt = '
         <p align="center">
         <img border="0" src="http://www.profsa.com.br/pallas35/img/logo02.jpg"></p>
         <p align="center">&nbsp;</p>
         <p align="center"><b><font size="7" face="Verdana" color="">
         NF-e</font><font face="Verdana" color=""><br>
         </font><font size="5" face="Verdana" color="">
         Nota Fiscal Eletrônica - Danfe</font></b></p>
         <p align="center">&nbsp;</p>
         <p align=""left""><b><font face="Verdana">Prezado cliente (AAAAA),</font></b></p>
         <p align="justify"><font face="Verdana">Você está recebendo a Nota Fiscal 
         Eletrônica número BBBBB, série CCCCC de DDDDD, no 
         valor de R$ EEEEE, emitida em FFFFF. Além disso, junto com a mercadoria seguirá a DANFE 
         (Documento Auxiliar da Nota Fiscal Eletrônica), impresso em papel que acompanha 
         o transporte das mesmas.<br>
         <br>
         Anexo à este e-mail você está recebendo também o arquivo XML da Nota Fiscal 
         Eletrônica. Este arquivo deve ser armazenado eletronicamente por sua empresa 
         pelo prazo de 05 (cinco) anos, conforme previsto na legislação tributária (Art. 
         173 do Código Tributário Nacional e § 4º da Lei 5.172 de 25/10/1966).<br>
         <br>
         A DANFE em papel pode ser arquivado para apresentação ao fisco quando 
         solicitado. Todavia, se sua empresa também for emitente de NF-e, o arquivamento 
         eletrônico do XML de seus fornecedores é obrigatório, sendo passível de 
         fiscalização.<br>
         <br>
         Para se certificar que esta NF-e é válida, queira por favor consultar sua 
         autenticidade no site nacional do projeto NF-e (www.nfe.fazenda.gov.br), 
         utilizando a chave de acesso contida na DANFE.<br>
         <br>
         Atenciosamente,<br>
         <b>GGGGG</b></font></p>
         <p align=""right""><b><font color="" face="Verdana">Powered by Gold SoftWare - 
         <a href=""http://www.goldinformatica.com.br"">www.goldinformatica.com.br</a></font></b></p>
         <p>&nbsp;</p>&nbsp;';
         $txt = str_replace('AAAAA', $reg['desrazao'] , $txt);  
         $txt = str_replace('BBBBB', number_format($reg['notnumero'], 0, ",", ".") , $txt);  
         $txt = str_replace('CCCCC', str_pad($reg['notserie'], 3, "0",STR_PAD_LEFT) , $txt);  
         $txt = str_replace('DDDDD', $_SESSION['wrknomemp'], $txt);  
         $txt = str_replace('EEEEE', number_format($reg['notvalnota'], 2, ",", ".") , $txt);  
         $txt = str_replace('FFFFF', date('d/m/Y',strtotime($reg['notdatemissao'])) , $txt);  
         $txt = str_replace('GGGGG', $nom , $txt);  
 
         $asu = "Gold Informática - Envio de XML e PDF de NF-e de " . $nom . " Nº " . str_pad($reg['notserie'], 3, "0",STR_PAD_LEFT) . " / " . number_format($reg['notnumero'], 0, ",", ".");
         $xml = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($reg['notserie'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($reg['notnumero'], 9, "0",STR_PAD_LEFT) . "-procNFe.xml";   
         if (file_exists($xml) == false) { $xml = ''; }
         $pdf = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($reg['notserie'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($reg['notnumero'], 9, "0",STR_PAD_LEFT) . "-nfe.pdf";   
         if (file_exists($pdf) == false) { $pdf = ''; }
     
         $sta = manda_email($reg['desemail'], $asu, $txt, $nom, $xml, $pdf);
         if ($reg['traemail'] != "" && $reg['traemail'] != null) {
             $sta = manda_email($reg['traemail'], $asu, $txt, $nom, $xml, $pdf);
         }        
     }
     return $sta;
}

?>

</html>
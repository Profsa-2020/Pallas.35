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

     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

     <script type="text/javascript" language="javascript"
          src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
     <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

     <script type="text/javascript" src="js/datepicker-pt-BR.js"></script>

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <script type="text/javascript" src="js/profsa.js"></script>

     <link href="css/pallas35.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Emissão de NF-e e NFC-e - Gold Software Soluções Inteligentes - Profsa Informática Ltda - Pré-Notas</title>
</head>

<script>
$(document).ready(function() {
     $(function() {
          $("#dti").mask("99/99/9999");
          $("#dtf").mask("99/99/9999");
          $("#dti").datepicker($.datepicker.regional["pt-BR"]);
          $("#dtf").datepicker($.datepicker.regional["pt-BR"]);
     });

     $('#dti').change(function() {
          $('#tab-0 tbody').empty();
     });
     $('#dtf').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('#tab-0').DataTable({
          "pageLength": 25,
          "aaSorting": [
               [5, 'asc'],
               [2, 'asc'],
               [3, 'asc']
          ],
          "language": {
               "lengthMenu": "Demonstrar _MENU_ linhas por páginas",
               "zeroRecords": "Não existe registros a demonstar ...",
               "info": "Mostrada página _PAGE_ de _PAGES_",
               "infoEmpty": "Sem registros de Log",
               "sSearch": "Buscar:",
               "infoFiltered": "(Consulta de _MAX_ total de linhas)",
               "oPaginate": {
                    sFirst: "Primeiro",
                    sLast: "Último",
                    sNext: "Próximo",
                    sPrevious: "Anterior"
               }
          }
     });

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

});
</script>

<?php
     $ret = 0;
     $txt = '';
     $men = '';
     $dad = array();
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(10,"Entrada na página de consulta de Cancelamento de Nota do sistema Pallas.35 - Emissão NF-e e NFC-e");  
          }
     }

     use NFePHP\NFe\Convert;
     use NFePHP\NFe\Tools;
     use NFePHP\Common\Certificate;
     use NFePHP\NFe\Common\Standardize;
     use NFePHP\NFe\Complements;     
     use NFePHP\Common\Validator;
     use NFePHP\DA\NFe\Danfe;
     use NFePHP\DA\Legacy\FilesFolders;

     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_REQUEST['salvar']) == false) {
          if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
          if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     }
     $dti = date('d/m/Y', strtotime('-6 days'));
     $dtf = date('d/m/Y');
     $dti = (isset($_REQUEST['dti']) == false ? $dti : $_REQUEST['dti']);
     $dtf = (isset($_REQUEST['dtf']) == false ? $dtf : $_REQUEST['dtf']);
     $sta = (isset($_REQUEST['sta']) == false ? 0 : $_REQUEST['sta']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : trim($_REQUEST['obs']));

     if ($_SESSION['wrkopereg'] == 7 && $_SESSION['wrkcodreg'] != 0) {
          if (isset($_REQUEST['salvar']) == true) {
               if (strlen($obs) > 15) {
                    $ret = cancelar_not($dad); 
                    if ($ret != "") {
                         echo '<script>alert("' . $ret . ' !");</script>';
                    } else {
                         
                         $_SESSION['wrkcodreg'] = 0; $_SESSION['wrkopereg'] = 0;
                         echo '<script>alert("Sucesso - ' . $dad['not']['ret']. ' - ' . $dad['not']['mot'] . ' !");</script>';
                    }
               } else {
                    echo '<script>alert("Nº de caracteres do motivo de cancelamento deve ser maior que 15 !");</script>';
               }
          }
          if (isset($_REQUEST['salvar']) == false) {
               $txt = carrega_dad($men, $dad);
               if ($men == "") {
                    $ret = consulta_rec($dad);
                    $ret = consulta_cha($dad);
               } else {
                    echo '<script>alert("' . $men . ' !");</script>';
               }
          }
     }

?>

<body id="box00">
     <h1 class="cab-0">Cancelamento Sistema Emissão NF-e e NFC-e - Gold Solution- Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10 text-left">
               <div class="qua-5 container-fluid">

                    <div class="row lit-3">
                         <div class="col-md-12">
                              <label>Processo de Cancelamento de Danfe</label>
                         </div>
                    </div>

                    <form name="frmTelMan" action="can-danfe.php?ope=0&cod=0" method="POST">
                         <div class="row">
                              <div class="col-md-3"></div>
                              <div class="col-md-2">
                                   <label>Data Inicial</label>
                                   <input type="text" class="form-control text-center" maxlength="10" id="dti"
                                        name="dti" value="<?php echo $dti; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Data Final</label>
                                   <input type="text" class="form-control text-center" maxlength="10" id="dtf"
                                        name="dtf" value="<?php echo $dtf; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Status</label>
                                   <select name="sta" class="form-control">
                                        <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>Todos
                                        </option>
                                        <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>Em
                                             Aberto</option>
                                        <option value="2" <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                             Processado</option>
                                        <option value="3" <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>
                                             Suspenso</option>
                                        <option value="4" <?php echo ($sta != 4 ? '' : 'selected="selected"'); ?>>
                                             Cancelado</option>
                                   </select>
                              </div>
                              <div class="col-md-2 text-center">
                                   <br />
                                   <button type="submit" id="con" name="consulta" class="bot-3"
                                        title="Carrega ocorrências conforme periodo solicitado pelo usuário."><i
                                             class="fa fa-search fa-3x" aria-hidden="true"></i></button>
                              </div>
                              <div class="col-md-1"></div>
                         </div>
                         <br />
                         <div class="container qua-6">
                              <div class="row">
                                   <div class="col-md-12 text-center">
                                        <?php if ($txt != "") { echo $txt; } ?>
                                   </div>
                              </div>

                              <?php if ($txt != "") { ?>
                                   <div class="row">
                                        <div class="col-md-12">
                                             <label>Motivo do Cancelamento</label>
                                             <textarea class="form-control" rows="5" id="obs"
                                                  name="obs"><?php echo $obs ?></textarea>
                                        </div>
                                   </div>

                                   <br />
                                   <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6 text-center">
                                             <button type="submit" id="can" name="salvar"
                                                  class="bot-1">Cancelar</button>
                                        </div>
                                        <div class="col-md-3"></div>
                                   </div>
                                   <br />
                                   <?php } ?>
                         </div>
                    </form>
                    <hr />                                   
                    <div class="row">
                         <div class="col-md-12">
                              <br />
                              <div class="tab-1 table-responsive">
                                   <table id="tab-0" class="table table-sm table-striped">
                                        <thead>
                                             <tr>
                                                  <th scope="col">Cancelar</th>
                                                  <th scope="col">Série</th>
                                                  <th scope="col">Número</th>
                                                  <th scope="col">Status</th>
                                                  <th scope="col">Emissão</th>
                                                  <th scope="col">Cancelamento</th>
                                                  <th scope="col">Pré-Nota</th>
                                                  <th scope="col">Nome do Destinatário</th>
                                                  <th scope="col">Parâmetro</th>
                                                  <th scope="col">Pagamento</th>
                                                  <th scope="col">Transporte</th>
                                                  <th scope="col">Cfop</th>
                                                  <th scope="col">Valor</th>
                                                  <th scope="col">Protocolo</th>
                                                  <th scope="col">Observação</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php $ret = carrega_not($sta, $dti, $dtf);  ?>
                                        </tbody>
                                   </table>
                                   <br />
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>

</body>
<?php
function carrega_not($sta, $dti, $dtf) {
     $nro = 0;
     include "lerinformacao.inc";
     $dti = substr($dti,6,4) . "-" . substr($dti,3,2) . "-" . substr($dti,0,2) . " 00:00:00";
     $dtf = substr($dtf,6,4) . "-" . substr($dtf,3,2) . "-" . substr($dtf,0,2) . " 23:59:59";
     $com  = "Select N.*, D.desrazao, P.parnome, T.trarazao, X.pagdescricao from ((((tb_nota_e N left join tb_destino D on N.notdestino = D.iddestino) left join tb_parametro P on N.notparametro = P.idparametro) left join tb_transporte T on N.nottransporte = T.idtransporte) left join tb_pagto X on N.notpagto = X.idpagto) ";
     $com .= " where notempresa = " . $_SESSION['wrkcodemp'] . " and notdatemissao between '" . $dti . "' and '" . $dtf . "' ";
     if ($sta != 0) { $com .= " and notstatus = " . ($sta - 1); }
     $com .= " order by notdatemissao, idnota";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $lin =  '<tr>';
          $lin .= '<td class="bot-3 text-center"><a href="can-danfe.php?ope=7&cod=' . $reg['idnota'] . '" title="Efetua solicitação de dados para cancelamento de Danfe da Nota"><i class="fa fa-times-circle-o fa-2x" aria-hidden="true"></i></a></td>';
          $lin .= '<td class="text-center">' . str_pad($reg['notserie'], 3, "0",STR_PAD_LEFT) . '</td>';
          $lin .= '<td class="text-center">' . number_format($reg['notnumero'], 0, ",", ".") . '</td>';
          if ($reg['notstatus'] == 0) {$lin .= "<td>" . "Normal" . "</td>";}
          if ($reg['notstatus'] == 1) {$lin .= "<td>" . "Processado" . "</td>";}
          if ($reg['notstatus'] == 2) {$lin .= "<td>" . "Suspenso" . "</td>";}
          if ($reg['notstatus'] == 3) {$lin .= "<td>" . "Cancelado" . "</td>";}
          $lin .= '<td class="text-center">' . date('d/m/Y',strtotime($reg['notdatemissao'])) . "</td>";
          if ($reg['notdatcancela'] == null) {
               $lin .= '<td class="text-center">' . '' . "</td>";
          } else {
               $lin .= '<td class="text-center">' . date('d/m/Y',strtotime($reg['notdatcancela'])) . "</td>";
          }
          $lin .= "<td>" . $reg['notpedido'] . "</td>";
          $lin .= "<td>" . $reg['desrazao'] . "</td>";
          $lin .= "<td>" . $reg['parnome'] . "</td>";
          $lin .= "<td>" . $reg['pagdescricao'] . "</td>";
          $lin .= "<td>" . $reg['trarazao'] . "</td>";
          $lin .= "<td>" . $reg['notcfop'] . "</td>";
          $lin .= '<td class="text-right">' . number_format($reg['notvalnota'], 2, ",", ".") . '</td>';
          $lin .= "<td>" . $reg['notnumeropro'] . "</td>";
          $lin .= "<td>" . $reg['notobservacao'] . "</td>";
          $lin .= "</tr>";
          echo $lin;
     }
     return $nro;
}

function carrega_dad(&$men, &$dad) {
     $txt = ''; $men = '';
     include "lerinformacao.inc";
     $com = "Select Y.*, D.*, N.*, T.*, X.* from ((((tb_nota_e Y left join tb_destino D on Y.notdestino = D.iddestino) left join tb_parametro N on Y.notparametro = N.idparametro) left join tb_transporte T on Y.nottransporte = T.idtransporte) left join tb_pagto X on Y.notpagto = X.idpagto) where idnota = " . $_SESSION['wrkcodreg'];
     $sql = mysqli_query($conexao,$com);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $txt .= '<div class="lit-6">' . 'Número da Nota Fiscal: ' . $lin['notserie'] . '-' . $lin['notnumero'] . '</div>' . '<br />';
          $txt .= 'Emissão: ' . date('d/m/Y',strtotime($lin['notdatemissao'])) . ' - Saída: ' . date('d/m/Y',strtotime($lin['notdatsaida'])) . '<br />';
          $txt .= 'Parâmetro Fiscal: ' . $lin['parnome'] . '<br />';
          $txt .= 'Condição de Pagto: ' . $lin['pagdescricao'] . '<br />';
          $txt .= 'Valor da Nota: R$ ' . number_format($lin['notvalnota'], 2, ',', '.') . '<br />';
          $txt .= 'Destinatário: ' . $lin['desrazao'] . '<br />';
          $txt .= 'Endereço: ' . $lin['desendereco'] . ', ' . $lin['desnumeroend'] . ' ' . $lin['descomplemento'] . ' - ' . $lin['desbairro'] . '<br />';
          $txt .= 'Cep - Cidade - Estado: ' . mascara_cpo($lin['descep'],"     -   ") . ' - ' . $lin['descidade'] . ' - ' . $lin['desestado'] . '<br />';
          if ($lin['despessoa'] == 0) {
               $txt .= 'C.p.f. - R.G.: ' . $lin['descnpj'] . " - " . $lin['desinscricao'] . '<br />';
          } else {
               $txt .= 'C.n.p.j. - Inscrição: ' . $lin['descnpj'] . " - " . $lin['desinscricao'] . '<br />';
          }
          $txt .= 'Transportador: ' . $lin['trarazao'] . '<br />';
          $txt .= 'Número de Protocolo: ' . $lin['notnumeropro'] . '<br />';
          $txt .= 'Chave de Acesso: ' . $lin['notchavenfe'] . '<br />';
          $txt .= 'Observação: ' . $lin['notobservacao'] . '<br />';
          $txt .= '<br />';
          $dad['not']['cha'] = $lin['notchavenfe'];
          $dad['not']['rec'] = $lin['notnumerorec'];
          $dad['not']['pro'] = $lin['notnumeropro'];
          if ($lin['notchavenfe'] == "" || $lin['notchavenfe'] == '0') {
               $men = 'Chave de Acesso para a Nota Fiscal não está informada no registro';
          }
          if ($lin['notnumeropro'] == "" || $lin['notnumeropro'] == '0') {
               $men = 'Nº do Protocolo para a Nota Fiscal não está informada no registro';
          }
          $dia = diferenca_dat('', date('d/m/Y',strtotime($lin['notdatemissao'])));
          if (abs($dia) >= 7) {
               $men = 'Data de emissão de nota fiscal informada supera os 7 dias';
          }
     }
     return $txt;
}

function cancelar_not(&$dad) {
     $sta = '';
     $dad['emi']['cod'] = 0;
     $dad['not']['cha'] = '';
     include "lerinformacao.inc";
     include_once "inclusao.php";     
     error_reporting(E_ALL);
     ini_set('display_errors', 'On');
     $com = "Select * from tb_nota_e where idnota = " . $_SESSION['wrkcodreg'];
     $sql = mysqli_query($conexao,$com);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $dad['not']['ser'] = $lin['notserie'];
          $dad['not']['num'] = $lin['notnumero'];
          $dad['not']['cha'] = $lin['notchavenfe'];
          $dad['not']['rec'] = $lin['notnumerorec'];
          $dad['not']['pro'] = $lin['notnumeropro'];
          $_SESSION['wrknumcha'] = $lin['notchavenfe'];
          $_SESSION['wrknumdoc'] = $lin['notnumero'];
     }
     $com = "Select * from tb_emitente where idemite = " . $_SESSION['wrkcodemp'];
     $sql = mysqli_query($conexao,$com);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $dad['emi']['cod'] = $lin['idemite'];
          $dad['emi']['raz'] = $lin['emirazao'];
          $dad['emi']['est'] = $lin['emiestado'];
          $dad['emi']['cgc'] = $lin['emicnpj'];
          $dad['emi']['tel'] = $lin['emitelefone'];
          $dad['emi']['cel'] = $lin['emicelular'];
          $dad['emi']['con'] = $lin['emicontato'];
          $dad['emi']['ema'] = $lin['emiemail'];
          $dad['emi']['amb'] = $lin['emitipoamb'];
          $dad['emi']['csc'] = $lin['eminumerocsc'];
          $dad['emi']['cer'] = $lin['emicamcertif'];
          $dad['emi']['sen'] = $lin['emisencertif'];
          $dad['emi']['val'] = $lin['emidatcertif'];
          $dad['emi']['emi'] = date('Y-m-d H:i:s');
     }
     $par = configura_not($dad);

     $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['cer']; 
     $cer = file_get_contents($dir);
     $tools = new Tools($par, Certificate::readPfx($cer, $dad['emi']['sen']));

try {
     $chave = $dad['not']['cha'];
     $xJust = limpa_cpo(trim($_REQUEST['obs']));
     $nProt = $dad['not']['pro'];
     $xml = $tools->sefazCancela($chave, $xJust, $nProt);

     $stdCl = new Standardize($xml);
     $std = $stdCl->toStd();

     $dad['not']['ret'] = '';
     $dad['not']['mot'] = '';
     $dad['not']['sta'] = $std->cStat;
     $dad['not']['men'] = $std->xMotivo;

     if (isset($std->retEvento->infEvento->cStat) == true) {
          $dad['not']['ret'] = $std->retEvento->infEvento->cStat;
          $dad['not']['mot'] = $std->retEvento->infEvento->xMotivo;
          $ret = gravar_log(25, 'Processo Cancelar: ' . $dad['not']['ret'] . ' - ' . $dad['not']['mot']);      
     }
     if ($dad['not']['sta'] != '128') {
          $sta = $dad['not']['sta'] . ' - ' . $dad['not']['men'];
          $ret = gravar_log(26, 'Retorno de Cancelamento: ' . $dad['not']['sta'] . ' - ' . $dad['not']['men']);      
     }
     if ($dad['not']['ret'] != '101' && $dad['not']['ret'] != '135' && $dad['not']['ret'] != '155') {     // Ocorreu um erro no cancelamento
          $sta = $dad['not']['ret']. ' - ' . $dad['not']['mot'];
     } else {
          $can = Complements::toAuthorize($tools->lastRequest, $xml);
          $dad['not']['can'] = $can;
          $dad['not']['xml'] = $xml;

          $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['not']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['not']['num'], 9, "0",STR_PAD_LEFT) . '-can.xml';  
          file_put_contents($dir, $xml);
          $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['not']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['not']['num'], 9, "0",STR_PAD_LEFT) . '-canNFe.xml';  
          file_put_contents($dir, $can);

          $sql  = "update tb_nota_e set ";
          $sql .= "notstatus = '" . '3' . "', ";
          $sql .= "notstaretorno = '" . $dad['not']['ret'] . "', ";
          $sql .= "notdesretorno = '" . $dad['not']['mot'] . "', ";
          $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
          $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
          $sql .= "where idnota = " . $_SESSION['wrkcodreg'];
          $ret = mysqli_query($conexao,$sql);
          if ($ret == false) {
               print_r($sql); $sta = 2; 
               echo '<script>alert("Erro no cancelamento de nota fiscal eletrônica !");</script>';
          }
     }
} catch (InvalidArgumentException $e) {
     $sta = "Retorno: " . $e->getMessage();
}    

     return $sta;
}

function consulta_cha(&$dad) {
     $sta = 0;
     if (isset($dad['not']['cha']) == false) { return 1; }
     if ($dad['not']['cha'] == "" || $dad['not']['cha'] == "0") { return 2; }
     include_once "inclusao.php";
     error_reporting(E_ALL);
     ini_set('display_errors', 'On'); 

     include "lerinformacao.inc";
     $com = "Select * from tb_emitente where idemite = " . $_SESSION['wrkcodemp'];
     $sql = mysqli_query($conexao,$com);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $dad['emi']['cod'] = $lin['idemite'];
          $dad['emi']['raz'] = $lin['emirazao'];
          $dad['emi']['est'] = $lin['emiestado'];
          $dad['emi']['cgc'] = $lin['emicnpj'];
          $dad['emi']['amb'] = $lin['emitipoamb'];
          $dad['emi']['csc'] = $lin['eminumerocsc'];
          $dad['emi']['cer'] = $lin['emicamcertif'];
          $dad['emi']['sen'] = $lin['emisencertif'];
          $dad['emi']['val'] = $lin['emidatcertif'];
          $dad['emi']['emi'] = date('Y-m-d H:i:s');
     }

     $par = configura_not($dad);
     $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['cer']; 
     $cer = file_get_contents($dir);
     $tools = new Tools($par, Certificate::readPfx($cer, $dad['emi']['sen']));

     $xml = $tools->sefazConsultaChave($dad['not']['cha']);

     $ret = new Standardize();
     $std = $ret->toStd($xml);

     $dad['not']['sta'] = $std->cStat;  // 101-Cancelamento homologado
     $dad['not']['men'] = $std->xMotivo;

     if (isset($std->protNFe->infProt->cStat) == true) {
          $dad['not']['ret'] = $std->protNFe->infProt->cStat;
          $dad['not']['mot'] = $std->protNFe->infProt->xMotivo;
     }

     return $sta;
}

function consulta_rec(&$dad) {
     $sta = 0;
     if (isset($dad['not']['rec']) == false) { return 1; }
     if ($dad['not']['rec'] == "" || $dad['not']['rec'] == "0") { return 2; }
     include_once "inclusao.php";
     error_reporting(E_ALL);
     ini_set('display_errors', 'On'); 

     include "lerinformacao.inc";
     $com = "Select * from tb_emitente where idemite = " . $_SESSION['wrkcodemp'];
     $sql = mysqli_query($conexao,$com);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $dad['emi']['raz'] = $lin['emirazao'];
          $dad['emi']['est'] = $lin['emiestado'];
          $dad['emi']['cgc'] = $lin['emicnpj'];
          $dad['emi']['amb'] = $lin['emitipoamb'];
          $dad['emi']['csc'] = $lin['eminumerocsc'];
          $dad['emi']['cer'] = $lin['emicamcertif'];
          $dad['emi']['sen'] = $lin['emisencertif'];
          $dad['emi']['emi'] = date('Y-m-d H:i:s');
     }

     $par = configura_not($dad);

     $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['cer']; 
     $cer = file_get_contents($dir);
     $tools = new Tools($par, Certificate::readPfx($cer, $dad['emi']['sen']));

     $xml = $tools->sefazConsultaRecibo($dad['not']['rec'], (int) $dad['emi']['amb']);

     $ret = new Standardize();
     $std = $ret->toStd($xml);

     $dad['not']['sta'] = $std->cStat;
     $dad['not']['men'] = $std->xMotivo;
     if (isset($std->protNFe->infProt->cStat) == true) {
          $dad['not']['ret'] = $std->protNFe->infProt->cStat;
          $dad['not']['mot'] = $std->protNFe->infProt->xMotivo;
     }

     return $sta;
}

function juntar_xml(&$dad) {
     $sta = 0;
     include "lerinformacao.inc";
     include_once "inclusao.php";     
     error_reporting(E_ALL);
     ini_set('display_errors', 'On');
     $com = "Select * from tb_nota_e where idnota = " . $_SESSION['wrkcodreg'];
     $sql = mysqli_query($conexao,$com);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $dad['not']['ser'] = $lin['notserie'];
          $dad['not']['num'] = $lin['notnumero'];
          $_SESSION['wrknumcha'] = $lin['notchavenfe'];
          $_SESSION['wrknumdoc'] = $lin['notnumero'];
     }
     $com = "Select * from tb_emitente where idemite = " . $_SESSION['wrkcodemp'];
     $sql = mysqli_query($conexao,$com);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $dad['emi']['raz'] = $lin['emirazao'];
          $dad['emi']['est'] = $lin['emiestado'];
          $dad['emi']['cgc'] = $lin['emicnpj'];
          $dad['emi']['csc'] = $lin['eminumerocsc'];
          $dad['emi']['amb'] = $lin['emitipoamb'];
          $dad['emi']['cer'] = $lin['emicamcertif'];
          $dad['emi']['sen'] = $lin['emisencertif'];
          $dad['emi']['emi'] = date('Y-m-d H:i:s');
     }
     $xml = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['not']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['not']['num'], 9, "0",STR_PAD_LEFT) . '-cancNFe.xml';  
     $dan = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['not']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['not']['num'], 9, "0",STR_PAD_LEFT) . '-procNFe.xml';  
     $can = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['not']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['not']['num'], 9, "0",STR_PAD_LEFT) . '-can.xml';  
     if (file_exists($dan) == true) { $sta = $sta + 1; }
     if (file_exists($can) == true) { $sta = $sta + 2; }     
     if (file_exists($xml) == true) { $sta = $sta + 4; }     
     if ($sta == 3) {
          $dan = file_get_contents($dan);
          $can = file_get_contents($can);
          $par = configura_not($dad);
          $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . $dad['emi']['cer']; 
          $cer = file_get_contents($dir);
          $tools = new Tools($par, Certificate::readPfx($cer, $dad['emi']['sen']));

          $pro = Complements::toAuthorize($dan, $can); 
          $dir = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['not']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['not']['num'], 9, "0",STR_PAD_LEFT) . '-cancNFe.xml';  
          file_put_contents($dir, $pro);    
          $dad['not']['dan'] = $dir;     

     }
     return $sta;
}
?>

</html>
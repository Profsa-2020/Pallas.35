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
            [1, 'asc'],
            [2, 'desc']
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
               $ret = gravar_log(10,"Entrada na página de envio de e-mails do sistema Pallas.35 - Emissão NF-e e NFC-e");  
          }
     }

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

    if ($_SESSION['wrkopereg'] == 7 && $_SESSION['wrkcodreg'] != 0) {
        $ret = email_not($_SESSION['wrkcodreg']);
        $_SESSION['wrkopereg'] = 0; $_SESSION['wrkcodreg'] = 0;
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
                        <label>Processo de Envio de E-Mail</label>
                    </div>
                </div>

                <form name="frmTelMan" action="env-email.php?ope=0&cod=0" method="POST">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            <label>Data Inicial</label>
                            <input type="text" class="form-control text-center" maxlength="10" id="dti" name="dti"
                                value="<?php echo $dti; ?>" required />
                        </div>
                        <div class="col-md-2">
                            <label>Data Final</label>
                            <input type="text" class="form-control text-center" maxlength="10" id="dtf" name="dtf"
                                value="<?php echo $dtf; ?>" required />
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
                </form>
                <hr />
                <div class="row">
                    <div class="col-md-12">
                        <br />
                        <div class="tab-1 table-responsive">
                            <table id="tab-0" class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Enviar</th>
                                        <th scope="col">Série</th>
                                        <th scope="col">Número</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Emissão</th>
                                        <th scope="col">Cancelamento</th>
                                        <th scope="col">Pré-Nota</th>
                                        <th scope="col">Nome do Destinatário</th>
                                        <th scope="col">E-Mail</th>
                                        <th scope="col">Parâmetro</th>
                                        <th scope="col">Pagamento</th>
                                        <th scope="col">Transporte</th>
                                        <th scope="col">Cfop</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Protocolo</th>
                                        <th scope="col">XML</th>
                                        <th scope="col">PDF</th>
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
     $com  = "Select N.*, D.desrazao, D.desemail, P.parnome, T.trarazao, X.pagdescricao from ((((tb_nota_e N left join tb_destino D on N.notdestino = D.iddestino) left join tb_parametro P on N.notparametro = P.idparametro) left join tb_transporte T on N.nottransporte = T.idtransporte) left join tb_pagto X on N.notpagto = X.idpagto) ";
     $com .= " where notempresa = " . $_SESSION['wrkcodemp'] . " and notdatemissao between '" . $dti . "' and '" . $dtf . "' ";
     if ($sta != 0) { $com .= " and notstatus = " . ($sta - 1); }
     $com .= " order by notdatemissao, idnota";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $lin =  '<tr>';
          $lin .= '<td class="bot-3 text-center"><a href="env-email.php?ope=7&cod=' . $reg['idnota'] . '" title="Efetua envio de e-mail de XML e PDF da Danfe da Nota para clientes e transportadores"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></a></td>';
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
          $lin .= "<td>" . $reg['desemail'] . "</td>";
          $lin .= "<td>" . $reg['parnome'] . "</td>";
          $lin .= "<td>" . $reg['pagdescricao'] . "</td>";
          $lin .= "<td>" . $reg['trarazao'] . "</td>";
          $lin .= "<td>" . $reg['notcfop'] . "</td>";
          $lin .= '<td class="text-right">' . number_format($reg['notvalnota'], 2, ",", ".") . '</td>';
          $lin .= "<td>" . $reg['notnumeropro'] . "</td>";
          $ret = existe_arq($reg['notserie'], $reg['notnumero'], $opc_1, $opc_2, $cam_1, $cam_2);
          $lin .= '<td class="text-center">' . ($opc_1 == 1 ? '<a href="' . $cam_1 . '" target="_blank">' . 'Sim' . '</a>'  : 'Não') . "</td>";
          $lin .= '<td class="text-center">' . ($opc_2 == 1 ? '<a href="' . $cam_2 . '" target="_blank">' . 'Sim' . '</a>'  : 'Não') . "</td>";
          $lin .= "<td>" . $reg['notobservacao'] . "</td>";
          $lin .= "</tr>";
          echo $lin;
     }
     return $nro;
}

function existe_arq($ser, $num, &$opc_1, &$opc_2, &$cam_1, &$cam_2) {
    $sta = 0;
    $opc_1 = 0; $opc_2 = 0;
    $xml = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($ser, 3, "0",STR_PAD_LEFT) . "_" . str_pad($num, 9, "0",STR_PAD_LEFT) . "-procNFe.xml";   
    if (file_exists($xml) == true) { $opc_1 = 1; }
    $pdf = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFE_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($ser, 3, "0",STR_PAD_LEFT) . "_" . str_pad($num, 9, "0",STR_PAD_LEFT) . "-nfe.pdf";   
    if (file_exists($pdf) == true) { $opc_2 = 1; }
    $cam_1 = $xml; $cam_2 = $pdf; 
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
        Nota Fiscal Eletrônica</font></b></p>
        <p align="center">&nbsp;</p>
        <p align=""left""><b><font face="Verdana">Prezado cliente (AAAAA),</font></b></p>
        <p align="justify"><font face="Verdana">Você está recebendo a Nota Fiscal 
        Eletrônica número BBBBB, série CCCCC de DDDDD, no 
        valor de R$ EEEEE, emitida em FFFFF. Além disso, junto com a mercadoria seguirá o DANFE 
        (Documento Auxiliar da Nota Fiscal Eletrônica), impresso em papel que acompanha 
        o transporte das mesmas.<br>
        <br>
        Anexo à este e-mail você está recebendo também o arquivo XML da Nota Fiscal 
        Eletrônica. Este arquivo deve ser armazenado eletronicamente por sua empresa 
        pelo prazo de 05 (cinco) anos, conforme previsto na legislação tributária (Art. 
        173 do Código Tributário Nacional e § 4º da Lei 5.172 de 25/10/1966).<br>
        <br>
        O DANFE em papel pode ser arquivado para apresentação ao fisco quando 
        solicitado. Todavia, se sua empresa também for emitente de NF-e, o arquivamento 
        eletrônico do XML de seus fornecedores é obrigatório, sendo passível de 
        fiscalização.<br>
        <br>
        Para se certificar que esta NF-e é válida, queira por favor consultar sua 
        autenticidade no site nacional do projeto NF-e (www.nfe.fazenda.gov.br), 
        utilizando a chave de acesso contida no DANFE.<br>
        <br>
        Atenciosamente,<br>
        <b>GGGGG</b></font></p>
        <p align=""right""><b><font color="" face="Verdana">Powered by Gold Informática - 
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
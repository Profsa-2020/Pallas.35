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
        $("#nri").mask("999.999.999");
        $("#nrf").mask("999.999.999");
    });

    $('#nri').change(function() {
        $('#tab-0 tbody').empty();
    });
    $('#nrf').change(function() {
        $('#tab-0 tbody').empty();
    });

    $('#tab-0').DataTable({
        "pageLength": 25,
        "aaSorting": [
            [5, 'asc'],
            [3, 'asc']
        ],
        "language": {
            "lengthMenu": "Demonstrar _MENU_ linhas por páginas",
            "zeroRecords": "Não existe registros a demonstar ...",
            "info": "Mostrada página _PAGE_ de _PAGES_",
            "infoEmpty": "Sem registros de Nota Fiscal",
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
    $per = '';
    $dad = array();
    include_once "funcoes.php";
    $_SESSION['wrknompro'] = __FILE__;
    date_default_timezone_set("America/Sao_Paulo");
    $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
    $_SESSION['wrknomide'] = get_current_user();
    if (isset($_SERVER['HTTP_REFERER']) == true) {
        if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
            $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
            $ret = gravar_log(10,"Entrada na página de inutilização de números Nota do sistema Pallas.35 - Emissão NF-e e NFC-e");  
        }
    }

    use NFePHP\NFe\Tools;
    use NFePHP\Common\Certificate;
    use NFePHP\NFe\Common\Standardize;
    use NFePHP\NFe\Complements;

    if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
    if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }

    $nri = (isset($_REQUEST['nri']) == false ? '' : $_REQUEST['nri']);
    $nrf = (isset($_REQUEST['nrf']) == false ? '' : $_REQUEST['nrf']);
    $obs = (isset($_REQUEST['obs']) == false ? '' : trim($_REQUEST['obs']));

    if (isset($_REQUEST['salvar']) == true) {
        $ret = 0; $nri = limpa_nro($nri); $nrf = limpa_nro($nrf);
        $_SESSION['wrknumcha'] = $nri; $_SESSION['wrknumdoc'] = $nrf;
        if ($nri == 0 || $nrf == 0) {
            $ret = 1;
            echo '<script>alert("Número inicial e final não pode ser igual a zero !");</script>';
        }
        if ($ret == 0) {
            if ($nri > $nrf) {
                $ret = 1;
                echo '<script>alert("Número inicial não pode ser maior que número final !");</script>';
            }    
        }
        if (strlen($obs) <= 15) {
            $ret = 1;
            echo '<script>alert("Número de caracteres para a justificativa deve ter mais de 15 !");</script>';
        }
        if ($ret == 0) {
            $qtd = numero_not($nri, $nrf);
            if ($qtd > 0) {
                $ret = 1;
                echo '<script>alert("Existem [' . $qtd . '] notas fiscais no sistema nesta faixa de números !");</script>';
            }    
        }  
        if ($ret == 0) {
            $ret = inutiliza_nro($nri, $nrf, $obs, $dad);
            if ($dad['emi']['men'] != "") {
                echo '<script>alert("' . $dad['emi']['men'] . ' !!");</script>';
            } else {
                echo '<script>alert("Processamento de inutilização efetuado com Sucesso !!!");</script>';
                $ret = gravar_log(31,"Processamento de inutilização de números: " . $nri . " até " . $nrf . " processado ");  
                $nri = ''; $nrf = ''; $obs = ''; $_SESSION['wrkcodreg'] = 0; $_SESSION['wrkopereg'] = 0;

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
                        <label>Inutilização de Faixa de Números</label>
                    </div>
                </div>

                <form name="frmTelMan" action="inu-numero.php?ope=7&cod=0" method="POST">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            <label>Número Inicial</label>
                            <input type="text" class="form-control text-center" maxlength="11" id="nri" name="nri"
                                value="<?php echo $nri; ?>" required />
                        </div>
                        <div class="col-md-2">
                            <label>Número Final</label>
                            <input type="text" class="form-control text-center" maxlength="11" id="nrf" name="nrf"
                                value="<?php echo $nrf; ?>" required />
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
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <label>Jutificativa da Inutilização</label>
                            <textarea class="form-control" rows="5" id="obs" name="obs"><?php echo $obs ?></textarea>
                        </div>
                        <div class="col-md-2"></div>
                    </div>

                    <br /><br />
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6 text-center">
                            <button type="submit" id="pro"
                                onclick="return confirm('Confirma inutilização de faixa de números informada em tela ?')"
                                name="salvar" class="bot-1">Processar</button>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <br /><br />

                    <div class="container">
                        <div class="row">
                            <div class="tab-1 table-responsive">
                                <table class="table table-sm ">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Hora</th>
                                            <th>Usuário</th>
                                            <th>Tip</th>
                                            <th>Número</th>
                                            <th>Docto</th>
                                            <th>IP</th>
                                            <th>Cidade/UF</th>
                                            <th>Histórico de Inutilizações de Números</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $ret = carrega_log();  ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <br /><br />
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
                                <?php $ret = carrega_not($nri, $nrf);  ?>
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
function carrega_not($nri, $nrf) {
     $nro = 0;
     if ($nri == '' || $nrf == '') { return 1; }
     include "lerinformacao.inc";
     $com  = "Select N.*, D.desrazao, P.parnome, T.trarazao, X.pagdescricao from ((((tb_nota_e N left join tb_destino D on N.notdestino = D.iddestino) left join tb_parametro P on N.notparametro = P.idparametro) left join tb_transporte T on N.nottransporte = T.idtransporte) left join tb_pagto X on N.notpagto = X.idpagto) ";
     $com .= " where notempresa = " . $_SESSION['wrkcodemp'] . " and notnumero between " . $nri . " and " . $nrf . " ";
     $com .= " order by notdatemissao, idnota";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $lin =  '<tr>';
          $lin .= '<td class="text-center">' . str_pad($reg['notserie'], 3, "0",STR_PAD_LEFT) . '</td>';
          $lin .= '<td class="text-center">' . number_format($reg['notnumero'], 0, ",", ".") . '</td>';
          if ($reg['notstatus'] == 0) {$lin .= "<td>" . "Aberto" . "</td>";}
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

function numero_not($nri, $nrf) {
    $qtd = 0;
    include "lerinformacao.inc";
    $ser = retorna_dad('emiserie', 'tb_emitente', 'idemite', $_SESSION['wrkcodemp']);    
    $com  = "Select count(*) as notqtde from tb_nota_e where notempresa = " . $_SESSION['wrkcodemp'] . " and notserie = " . $ser . " and notnumero between " . $nri . " and " . $nrf . " ";
    $sql = mysqli_query($conexao, $com);
    while ($reg = mysqli_fetch_assoc($sql)) {        
        $qtd = $reg['notqtde'];
    }
    return $qtd;
}

function carrega_log() {
    $nro = 0;
    include "lerinformacao.inc";
    $com = "Select logdatahora, logoperacao, logusuario, logtipo, logidsenha, lognumero, logdocto, logip, logcidade, logestado, lognavegador, logprovedor, logprograma, logobservacao from tb_log ";
    $com .= " where  logempresa = " . $_SESSION['wrkcodemp'] . " and logoperacao in (31, 32) order by logdatahora, idlog Limit 15";
    $sql = $mysqli->prepare($com);
    $sql->execute();
    $sql->bind_result($dat, $ope, $usu, $tip, $sen, $num, $doc, $ip, $cid, $est, $nav, $pro, $prg, $obs);
    while ($sql->fetch()) {        
        $linha =  '<tr>';
        $linha .= "<td>" . date('d/m/Y',strtotime($dat)) . "</td>";
        $linha .= "<td>" . date('H:m:s',strtotime($dat)) . "</td>";
        $linha .= "<td>$usu</td>";
        $linha .= "<td>$tip</td>";
        $linha .= "<td>$num</td>";
        $linha .= "<td>$doc</td>";
        $linha .= "<td>$ip </td>";
        $linha .= '<td>' . $cid . "-" . $est . '</td>';
        $linha .= "<td>$obs</td>";
        $linha .= "</tr>";
        echo $linha;
    }
    return $nro;
}

function inutiliza_nro($nri, $nrf, $obs,  &$dad) {
    $sta = 0;
    $dad = array();
    $dad['emi']['men'] = "";
    $dad['emi']['ret'] = '';
    $dad['emi']['mot'] = '';
    include "lerinformacao.inc";
    include_once "inclusao.php";     
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
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

        $nSerie = retorna_dad('emiserie', 'tb_emitente', 'idemite', $_SESSION['wrkcodemp']);    
        $nIni = $nri;
        $nFin = $nrf;
        $xJust = $obs;
        $xml = $tools->sefazInutiliza($nSerie, $nIni, $nFin, $xJust);
    
        $stdCl = new Standardize($xml);
        $std = $stdCl->toStd();  

        if (isset($std->infInut->cStat) == true) {
            $dad['emi']['ret'] = $std->infInut->cStat;
            $dad['emi']['mot'] = $std->infInut->xMotivo;
            if (isset($std->infInut->nProt) == true) {
                $dad['emi']['pro'] = $std->infInut->nProt;
                $dad['emi']['rec'] = $std->infInut->dhRecbto;
                $ret = gravar_log(32,"Processamento de inutilização - Protocolo: " . $dad['emi']['pro'] . " - Recibo: " . $dad['emi']['rec'] . " - Sucesso !!!");     
            }
        }
        if ($dad['emi']['ret'] != '102') {
            $dad['emi']['men'] = "Retorno: " . $dad['emi']['ret'] . "-" . $dad['emi']['mot'];
        }
    } catch ( \Exception $e) {
        $dad['emi']['men'] = "Retorno: " . $e->getMessage();
    }

    return $sta;
}
?>

</html>
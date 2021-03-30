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
          $("#dti").datepicker( $.datepicker.regional[ "pt-BR" ] ); 
          $("#dtf").datepicker( $.datepicker.regional[ "pt-BR" ] ); 
     });

     $('#sta').change(function() {
          $('#tab-0 tbody').empty();
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
     $ret = 00;
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;

     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(10,"Entrada na página de consulta de Pré-Notas do sistema Pallas.35 - Emissão NF-e e NFC-e");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrknomemp']) == false) { $_SESSION['wrknomemp'] = ''; } 
     $dti = date('d/m/Y', strtotime('-6 days'));
     $dtf = date('d/m/Y');
     $dti = (isset($_REQUEST['dti']) == false ? $dti : $_REQUEST['dti']);
     $dtf = (isset($_REQUEST['dtf']) == false ? $dtf : $_REQUEST['dtf']);
     $sta = (isset($_REQUEST['sta']) == false ? 0 : $_REQUEST['sta']);

?>

<body id="box00">
     <h1 class="cab-0">Pré-Notas Sistema Emissão NF-e e NFC-e - Gold Solution- Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10 text-left">
               <div class="qua-5 container-fluid">

                    <div class="row lit-3">
                         <div class="col-md-11">
                              <label>Consulta de Pré-Notas</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-pedido.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar novo usuário no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>

                    <form name="frmTelMan" action="" method="POST">
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
                                   <select id="sta" name="sta" class="form-control">
                                        <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>Todos</option>
                                        <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>Em Aberto</option>
                                        <option value="2" <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>Processado</option>
                                        <option value="3" <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>Suspenso</option>
                                        <option value="4" <?php echo ($sta != 4 ? '' : 'selected="selected"'); ?>>Cancelado</option>
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

                    <div class="row">
                         <div class="col-md-12">
                              <br />
                              <div class="tab-1 table-responsive-md">
                                   <table id="tab-0" class="table table-sm table-striped">
                                        <thead>
                                             <tr>
                                                  <th scope="col">Alterar</th>
                                                  <th scope="col">Excluir</th>
                                                  <th scope="col">Duplicar</th>
                                                  <th scope="col">Número</th>
                                                  <th scope="col">Status</th>
                                                  <th scope="col">Emissão</th>
                                                  <th scope="col">Entrega</th>
                                                  <th scope="col">Parâmetro</th>
                                                  <th scope="col">Nome do Destinatário</th>
                                                  <th scope="col">Pagamento</th>
                                                  <th scope="col">Valor Liquido</th>
                                                  <th scope="col">% Desconto</th>
                                                  <th scope="col">Valor Desconto</th>
                                                  <th scope="col">Peso Liquido</th>
                                                  <th scope="col">Peso Bruto</th>
                                                  <th scope="col">Observação</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php $ret = carrega_ped($sta, $dti, $dtf);  ?>
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
function carrega_ped($sta, $dti, $dtf) {
     $nro = 0;
     include "lerinformacao.inc";
     $com  = " Select P.*, D.desrazao, N.parnome, T.trarazao, X.pagdescricao from ((((tb_pedido P left join tb_destino D on P.peddestino = D.iddestino) left join tb_parametro N on P.pedparametro = N.idparametro) left join tb_transporte T on P.pedtransporte = T.idtransporte) left join tb_pagto X on P.pedpagto = X.idpagto) ";
     $com .= " where pedempresa = " . $_SESSION['wrkcodemp'];
     if ($sta != 0)  { $com .= " and pedstatus = " . ($sta - 1); }
     $com .= " order by pedemissao, idpedido";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $lin =  '<tr>';
          $lin .= '<td class="bot-3 text-center"><a href="man-pedido.php?ope=2&cod=' . $reg['idpedido'] . '" title="Efetua alteração do registro informado na linha"><i class="large material-icons">healing</i></a></td>';
          $lin .= '<td class="lit-d bot-3 text-center"><a href="man-pedido.php?ope=3&cod=' . $reg['idpedido'] . '" title="Efetua exclusão do registro informado na linha"><i class="large material-icons">delete_forever</i></a></td>';
          $lin .= '<td class="bot-3 text-center"><a href="man-pedido.php?ope=5&cod=' . $reg['idpedido'] . '" title="Duplica dados do registro informado na linha"><i class="large material-icons">content_copy</i></a></td>';
          $lin .= '<td class="text-center">' . $reg['idpedido'] . '</td>';
          if ($reg['pedstatus'] == 0) {$lin .= "<td>" . "Aberto" . "</td>";}
          if ($reg['pedstatus'] == 1) {$lin .= "<td>" . "Processado" . "</td>";}
          if ($reg['pedstatus'] == 2) {$lin .= "<td>" . "Suspenso" . "</td>";}
          if ($reg['pedstatus'] == 3) {$lin .= "<td>" . "Cancelado" . "</td>";}
          $lin .= '<td class="text-center">' . date('d/m/Y',strtotime($reg['pedemissao'])) . "</td>";
          $lin .= '<td class="text-center">' . date('d/m/Y',strtotime($reg['pedentrega'])) . "</td>";
          $lin .= "<td>" . $reg['parnome'] . "</td>";
          $lin .= "<td>" . $reg['desrazao'] . "</td>";
          $lin .= "<td>" . $reg['pagdescricao'] . "</td>";
          $lin .= '<td class="text-right">' . number_format($reg['pedvalorliq'], 2, ",", ".") . '</td>';
          $lin .= '<td class="text-center">' . number_format($reg['pedpordesconto'], 2, ",", ".") . '</td>';
          $lin .= '<td class="text-right">' . number_format($reg['pedvaldesconto'], 2, ",", ".") . '</td>';
          $lin .= '<td class="text-right">' . number_format($reg['pedpesoliq'], 4, ",", ".") . '</td>';
          $lin .= '<td class="text-right">' . number_format($reg['pedpesobru'], 4, ",", ".") . '</td>';
          $lin .= "<td>" . $reg['pedobservacao'] . "</td>";
          $lin .= "</tr>";
          echo $lin;
     }
     return $nro;
}
?>

</html>
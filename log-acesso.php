<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <meta name="description" content="Profsa Informática - Emissão de NF-e e NFC-e - Gold Software Soluções Inteligentes" />
     <meta name="author" content="Paulo Rogério Souza" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />

     <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet" type="text/css" />
     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" type="text/css" />

     <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">

     <link rel="shortcut icon" href="http://sistema.goldinformatica.com.br/site/wp-content/uploads/2019/04/favicon.png" />

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
          integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
     </script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
          integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
     </script>

     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

     <script type="text/javascript" language="javascript"
          src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
     <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

     <script type="text/javascript" src="js/datepicker-pt-BR.js"></script>

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <script type="text/javascript" src="js/profsa.js"></script>

     <link href="css/pallas35.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Emissão de NF-e e NFC-e - Gold Software Soluções Inteligentes - Profsa Informática Ltda - Pré-Nota</title>
</head>

<script>
$(document).ready(function() {
     $(function() {
          $("#dti").mask("99/99/9999");
          $("#dtf").mask("99/99/9999");
          $("#dti").datepicker( $.datepicker.regional[ "pt-BR" ] ); 
          $("#dtf").datepicker( $.datepicker.regional[ "pt-BR" ] ); 
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
               [4, 'asc'],
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
     if ( $_SESSION['wrktipusu'] <= 2) {
          echo '<script>alert("Nível de usuário não permite acesso a essa opção");</script>';
          echo '<script>history.go(-1);</script>';
     }

     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(1,"Entrada na página de menu principal do sistema Pallas.35 - Emissão NF-e e NFC-e");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrknomemp']) == false) { $_SESSION['wrknomemp'] = ''; } 
     $hoj = date('d/m/Y'); $_SESSION['wrkmostel'] = 0;
     $dti = date('d/m/Y', strtotime('-6 days'));
     $dtf = date('d/m/Y');
     $dti = (isset($_REQUEST['dti']) == false ? $dti : $_REQUEST['dti']);
     $dtf = (isset($_REQUEST['dtf']) == false ? $dtf : $_REQUEST['dtf']);
  
?>

<body id="box00">
     <h1 class="cab-0">Log de Acesso Sistema Emissão NF-e e NFC-e - Gold Solution- Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10 text-left">
               <div class="qua-5 container-fluid">
                    <div class="row lit-3">
                         <div class="col-md-12">
                              <label>Log de Acesso dos Usuários</label>
                         </div>
                    </div>
                    <form name="frmTelMan" action="" method="POST">
                         <div class="row">
                              <div class="col-md-4"></div>
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
                              <div class="col-md-1 text-center">
                                   <br />
                                   <button type="submit" id="con" name="consulta" class="bot-3"
                                        title="Carrega ocorrências conforme periodo solicitado pelo usuário."><i
                                             class="fa fa-search fa-3x" aria-hidden="true"></i></button>
                              </div>
                              <div class="col-md-3"></div>
                         </div>
                         <br />
                    </form>
               </div>
               <br />
               <div class="row">
                    <div class="tab-1 table-responsive">
                         <table id="tab-0" class="table table-sm table-striped">
                              <thead>
                                   <tr>
                                        <th>Data</th>
                                        <th>Hora</th>
                                        <th>Ope</th>
                                        <th>Usuário</th>
                                        <th>Tip</th>
                                        <th>Página</th>
                                        <th>IP</th>
                                        <th>Número</th>
                                        <th>Documento</th>
                                        <th>Cidade/UF</th>
                                        <th>Navegador</th>
                                        <th>Provedor</th>
                                        <th>Histórico do Log</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php $ret = carrega_log($dti, $dtf);  ?>
                              </tbody>
                         </table>
                    </div>
               </div>

          </div>
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>
<?php
function carrega_log($dti, $dtf) {
     $nro = 0;
     include "lerinformacao.inc";
     $dti = substr($dti,6,4) . "-" . substr($dti,3,2) . "-" . substr($dti,0,2) . " 00:00:00";
     $dtf = substr($dtf,6,4) . "-" . substr($dtf,3,2) . "-" . substr($dtf,0,2) . " 23:59:59";
     $com = "Select logdatahora,logoperacao,logusuario,logtipo,logidsenha,logip,lognumero,logdocto,logcidade, logestado,lognavegador,logprovedor,logprograma,logobservacao from tb_log ";
     $com .= " where logdatahora between '" . $dti . "' and '" . $dtf . "' ";
     $com .= " order by logdatahora desc, idlog ";
     $sql = $mysqli->prepare($com);
     $sql->execute();
     $sql->bind_result($dat, $ope, $usu, $tip, $sen, $ip, $num, $doc, $cid, $est, $nav, $pro, $prg, $obs);
     while ($sql->fetch()) {        
         $linha =  '<tr>';
         $linha .= "<td>" . date('d/m/Y',strtotime($dat)) . "</td>";
         $linha .= "<td>" . date('H:m:s',strtotime($dat)) . "</td>";
         $linha .= "<td>$ope</td>";
         $linha .= "<td>$usu</td>";
         $linha .= "<td>$tip</td>";
         $linha .= "<td>$prg</td>";
         $linha .= "<td>$ip </td>";
         $linha .= "<td>$num</td>";
         $linha .= "<td>$doc</td>";
         $linha .= '<td>' . $cid . "-" . $est . '</td>';
         $linha .= "<td>$nav</td>";
         $linha .= "<td>$pro</td>";
         $linha .= "<td>$obs</td>";
         $linha .= "</tr>";
         echo $linha;
     }
     return $nro;
}


?>

</html>
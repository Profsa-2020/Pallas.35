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

     <script type="text/javascript" src="js/profsa.js"></script>

     <link href="css/pallas35.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Emissão de NF-e e NFC-e - Gold Software Soluções Inteligentes - Profsa Informática Ltda - Parâmetro</title>
</head>
<script>
$(document).ready(function() {
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
               $ret = gravar_log(10,"Entrada na página de consulta de parâmetros do sistema Pallas.35 - Emissão NF-e e NFC-e");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrknomemp']) == false) { $_SESSION['wrknomemp'] = ''; } 
 
?>

<body>
     <h1 class="cab-0">Parâmetros Sistema Emissão NF-e e NFC-e - Gold Solution- Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10 text-left">
               <div class="qua-5 container">
                    <div class="form-row lit-3">
                         <div class="col-md-11">
                              <label>Consulta de Parâmetros</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-parametro.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar novo parâmetro fiscal no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>
                    <div class="form-row">
                         <div class="col-md-12">
                              <br />
                              <div class="tab-1 table-responsive">
                                   <table id="tab-0" class="table table-sm table-striped">
                                        <thead>
                                             <tr>
                                                  <th>Alterar</th>
                                                  <th>Excluir</th>
                                                  <th>Duplicar</th>
                                                  <th>Código</th>
                                                  <th>Descrição Parâmetro</th>
                                                  <th>Descrição Danfe</th>
                                                  <th>Status</th>
                                                  <th>Tipo Nota</th>
                                                  <th>Final Cfop</th>
                                                  <th>Espécie</th>
                                                  <th>Modelo</th>
                                                  <th>Finalidade</th>
                                                  <th>Icms</th>
                                                  <th>Ipi</th>
                                                  <th>Pis</th>
                                                  <th>Cofins</th>
                                                  <th>Cssl</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php $ret = carrega_par();  ?>
                                        </tbody>
                                   </table>
                                   <br />
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>

</body>
<?php
function carrega_par() {
     $nro = 0;
     include "lerinformacao.inc";
     $com = "Select * from tb_parametro where parempresa = " . $_SESSION['wrkcodemp'] . " order by parnome, idparametro";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
         $lin =  '<tr>';
         $lin .= '<td class="bot-3 text-center"><a href="man-parametro.php?ope=2&cod=' . $reg['idparametro'] . '" title="Efetua alteração do registro informado na linha"><i class="large material-icons">healing</i></a></td>';
         $lin .= '<td class="lit-d bot-3 text-center"><a href="man-parametro.php?ope=3&cod=' . $reg['idparametro'] . '" title="Efetua exclusão do registro informado na linha"><i class="large material-icons">delete_forever</i></a></td>';
         $lin .= '<td class="bot-3 text-center"><a href="man-parametro.php?ope=5&cod=' . $reg['idparametro'] . '" title="Duplica dados do registro informado na linha"><i class="large material-icons">content_copy</i></a></td>';
         $lin .= '<td class="text-center">' . $reg['idparametro'] . '</td>';
         $lin .= "<td>" . $reg['parnome'] . "</td>";
         $lin .= "<td>" . $reg['pardanfe'] . "</td>";
         if ($reg['parstatus'] == 0) {$lin .= "<td>" . "Normal" . "</td>";}
         if ($reg['parstatus'] == 1) {$lin .= "<td>" . "Bloqueado" . "</td>";}
         if ($reg['parstatus'] == 2) {$lin .= "<td>" . "Suspenso" . "</td>";}
         if ($reg['parstatus'] == 3) {$lin .= "<td>" . "Cancelado" . "</td>";}
         if ($reg['partiponota'] == 0) {$lin .= "<td>" . "Saída" . "</td>";}
         if ($reg['partiponota'] == 1) {$lin .= "<td>" . "Entrada" . "</td>";}
         if ($reg['partiponota'] == 2) {$lin .= "<td>" . "Complem-Ent" . "</td>";}
         if ($reg['partiponota'] == 3) {$lin .= "<td>" . "Complem-Sai" . "</td>";}
         if ($reg['partiponota'] == 4) {$lin .= "<td>" . "Devolução-Ent" . "</td>";}
         if ($reg['partiponota'] == 5) {$lin .= "<td>" . "Devolução-Saí" . "</td>";}
         if ($reg['partiponota'] == 6) {$lin .= "<td>" . "Retorno-Ent" . "</td>";}
         if ($reg['partiponota'] == 7) {$lin .= "<td>" . "Retorno-Saí" . "</td>";}
         $lin .= "<td>" . $reg['parfinalcfop'] . "</td>";
         $lin .= "<td>" . $reg['parespecie'] . "</td>";
         $lin .= "<td>" . $reg['parmodelo'] . "</td>";
         if ($reg['parfinalidade'] == 1) {$lin .= "<td>" . "Normal" . "</td>";}
         if ($reg['parfinalidade'] == 2) {$lin .= "<td>" . "Complementar" . "</td>";}
         if ($reg['parfinalidade'] == 3) {$lin .= "<td>" . "Nota de Ajuste" . "</td>";}
         if ($reg['parfinalidade'] == 4) {$lin .= "<td>" . "Devolução/Retorno" . "</td>";}
         $lin .= "<td>" . number_format($reg['paricmsfixo'],2,".",",") . "</td>";
         $lin .= "<td>" . number_format($reg['paripifixo'],2,".",",") . "</td>";
         $lin .= "<td>" . number_format($reg['parperpis'],2,".",",") . "</td>";
         $lin .= "<td>" . number_format($reg['parpercofins'],2,".",",") . "</td>";
         $lin .= "<td>" . number_format($reg['parpercssl'],2,".",",") . "</td>";
          $lin .= "</tr>";
         echo $lin;
     }
}
?>

</html>
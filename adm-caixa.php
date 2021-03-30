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

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <script type="text/javascript" src="js/profsa.js"></script>

     <link href="css/pallas35.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Emissão de NF-e e NFC-e - Gold Software Soluções Inteligentes - Profsa Informática Ltda - Login</title>
</head>

<script>
$(function() {
     $("#num").mask("999.999");
     $("#dat").mask("99/99/9999");
     $("#val").mask("999.999,99", {
          reverse: true
     });
});


$(document).ready(function() {
     $('#sal').click(function() {
          var dad = $('#frmTelCai').serialize();
          $.post("gravar-cai.php", dad, function(data) {
               if (data.men != "") {
                    alert(data.men);
                    return false;
               }
               if (data.men == "") {
                    $('#val').val('');
                    $('#obs').val('');
                    $('#tip_n').val('');
                    $('#tip_p').val('');
               }
          }, "json"); // ou “text”
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
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;
     $_SESSION['wrknomide'] = get_current_user();
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(18,"Entrada na página de movimento de caixa do NFC-e Pallas.35 - Emissão NF-e e NFC-e");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }

     $dat = (isset($_REQUEST['dat']) == false ? '' : $_REQUEST['dat']);
     $val = (isset($_REQUEST['val']) == false ? '' : $_REQUEST['val']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : $_REQUEST['obs']);

     $dti = date('d/m/Y'); $dtf = date('d/m/Y');
     if (isset($_REQUEST['salvar']) == true) {
          $val = ''; $obs = '';
     }
     $sal = apura_sal();
?>

<body id="box00">
     <h1 class="cab-0">Gerenciamento de Caixa no Sistema Emissão NF-e e NFC-e - Gold Solution- Profsa Informática</h1>
     <div class="caixa">
          <?php include_once "cabecalho-3.php"; ?>
          <div class="containter-fluid">
               <div class="row">
                    <div class="col-md-5">
                         <br />
                         <form class="tel-a" id="frmTelCai" name="frmTelCai" action="" method="POST">
                              <div class="row">
                                   <div class="col-md-1"></div>
                                   <div class="lit-a col-md-10 text-center">
                                        <?php 
                                   echo 'Data: ' . date('d/m/Y') . '<br />';
                                   echo 'Hora: ' . date('H:i:s') . '<br />';
                                   ?>
                                   </div>
                                   <div class="col-md-1"></div>
                              </div>
                              <hr />
                              <div class="row">
                                   <div class="col-md-1"></div>
                                   <div class="col-md-3">
                                        <input type="radio" id="tip_p" name="tip" value="1" /> <label for="tip_p">
                                             Sângria (-) </label><br />
                                        <input type="radio" id="tip_n" name="tip" value="2" /> <label
                                             for="tip_n">Suprimento (+) </label>
                                   </div>
                                   <div class="col-md-4"></div>
                                   <div class="col-md-3">
                                        <label>Valor</label><br />
                                        <input type="text" class="form-control text-center" maxlength="10" id="val"
                                             name="val" value="<?php echo $val; ?>" required />
                                   </div>
                                   <div class="col-md-1"></div>
                              </div>
                              <div class="row">
                                   <div class="col-md-1"></div>
                                   <div class="col-md-10">
                                        <label for="obs">Histórico do Lançamento</label>
                                        <textarea class="form-control" rows="3" id="obs" name="obs"
                                             required><?php echo $obs ?></textarea>
                                   </div>
                                   <div class="col-md-1"></div>
                              </div>
                              <br />
                              <div class="row">
                                   <div class="col-md-1"></div>
                                   <div class="col-md-10 text-center">
                                        <button type="submit" id="sal" name="salvar" class="bot-1">Gravar</button>
                                   </div>
                                   <div class="col-md-1"></div>
                              </div>
                              <br />
                         </form>
                         <br />
                         <div class="row">
                              <div class="col-md-1"></div>
                              <div class="lit-b col-md-10 text-center">
                                   <?php echo 'Saldo R$ ' . number_format($sal, 2, ",", "."); ?>
                              </div>
                              <div class="col-md-1"></div>
                         </div>
                         <hr />
                    </div>

                    <div class="col-md-7">
                         <div class="qua-c">
                              <br />
                              <h3 class="text-center"><strong>Movimento na Data - <?php echo $dti; ?></strong></h3>
                              <br />
                              <div class="row">
                                   <div class="tab-1 table-responsive-md">
                                        <table id="tab-0" class="table table-sm table-striped">
                                             <thead>
                                                  <tr>
                                                       <th>Cupom</th>
                                                       <th>Ordem</th>
                                                       <th>Status</th>
                                                       <th>Data</th>
                                                       <th>Hora</th>
                                                       <th>C. P. F.</th>
                                                       <th>Nome do Cliente</th>
                                                       <th>Tipo</th>
                                                       <th>Valor</th>
                                                       <th>Saldo</th>
                                                       <th>Histórico do Movimento</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <?php $ret = carrega_mov($dti, $dtf);  ?>
                                             </tbody>
                                        </table>
                                        <br />
                                   </div>
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
function carrega_mov($dti, $dtf) {
     $sta = 0;
     include "lerinformacao.inc";
     $dti = substr($dti,6,4) . "-" . substr($dti,3,2) . "-" . substr($dti,0,2) . " 00:00:00";
     $dtf = substr($dtf,6,4) . "-" . substr($dtf,3,2) . "-" . substr($dtf,0,2) . " 23:59:59";
     $com  = "Select *  from tb_movto_b where movempresa = " . $_SESSION['wrkcodemp'] . " and movdata between '" . $dti . "' and '" . $dtf . "' ";
     $com .= " order by movdata desc, idmovto";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $lin =  '<tr>';
          $cam = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFC_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($reg['movserienot'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($reg['movnumeronot'], 9, "0",STR_PAD_LEFT) . '-nfc.pdf';  
          if (file_exists($cam) == false) { 
               $lin .= '<td class="text-center">' . '***' . '</td>';
          } else {
               $lin .= '<td class="text-center">' . '<a href="' . $cam . '" target="_blank">' . '<i class="fa fa-print fa-2x" aria-hidden="true"></i>' . '</a>'. '</td>';
          }
          $lin .= '<td class="text-center">' . $reg['idmovto'] . '</td>';
          if ($reg['movstatus'] == 0) {$lin .= "<td>" . "Normal" . "</td>";}
          if ($reg['movstatus'] == 1) {$lin .= "<td>" . "Bloqueado" . "</td>";}
          if ($reg['movstatus'] == 2) {$lin .= "<td>" . "Suspenso" . "</td>";}
          if ($reg['movstatus'] == 3) {$lin .= "<td>" . "Cancelado" . "</td>";}
          $lin .= '<td class="text-center">' . date('d/m/Y',strtotime($reg['movdata'])) . "</td>";
          $lin .= '<td class="text-center">' . date('H:i:s',strtotime($reg['movdata'])) . "</td>";
          if ($reg['movcnpj'] == "" || $reg['movcnpj'] == "0") {
               $lin .= "<td>" . '' . "</td>";
          } else {
               $lin .= "<td>" . mascara_cpo($reg['movcnpj'], '   .   .   -  ') . "</td>";
          }
          $lin .= "<td>" . $reg['movfavorecido'] . "</td>";
          if ($reg['movtipo'] == 0) {$lin .= "<td>" . "Nulo(*)" . "</td>";}
          if ($reg['movtipo'] == 1) {$lin .= "<td>" . "Sângria(-)" . "</td>";}
          if ($reg['movtipo'] == 2) {$lin .= "<td>" . "Suprimento(+)" . "</td>";}
          if ($reg['movtipo'] == 3) {$lin .= "<td>" . "Cupom(+)" . "</td>";}
          $lin .= '<td class="text-right">' . number_format($reg['movvalormov'], 2, ",", ".") . '</td>';
          $lin .= '<td class="text-right">' . number_format($reg['movvalorsal'], 2, ",", ".") . '</td>';
          $lin .= "<td>" . $reg['movobservacao'] . "</td>";
          $lin .= "</tr>";
          echo $lin;
     }
     return $sta;
}

function apura_sal() {
     $sal = 0;
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select movtipo, Sum(movvalormov) as movvalor from tb_movto_b where movempresa = " . $_SESSION['wrkcodemp'] . " group by movtipo");
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['movtipo'] == 1) { $sal = $sal - $reg['movvalor']; }
          if ($reg['movtipo'] == 2) { $sal = $sal + $reg['movvalor']; }
          if ($reg['movtipo'] == 3) { $sal = $sal + $reg['movvalor']; }
     }
     return $sal;
}

?>
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

     <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">

     <link rel="shortcut icon"
          href="http://sistema.goldinformatica.com.br/site/wp-content/uploads/2019/04/favicon.png" />

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

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <script type="text/javascript" src="js/profsa.js"></script>

     <link href="css/pallas35.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Emissão de NF-e e NFC-e - Gold Software Soluções Inteligentes - Profsa Informática Ltda - Login</title>
</head>
<script>
$(function() {
     $("#ser").mask("999");
     $("#num").mask("999.999", {
          reverse: true
     });
});

$(document).ready(function() {

     $(window).scroll(function() {
          if ($(this).scrollTop() > 100) {
               $(".subir").fadeIn(500);
          } else {
               $(".subir").fadeOut(250);
          }
     });

     $(".subir").click(function() {
          $topo = $("#box01").offset().top;
          $('html, body').animate({
               scrollTop: $topo
          }, 1500);
     });

});
</script>
<?php
     $ret = 00;
     $per = "";
     $bot = "Salvar";
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(10,"Entrada na página de manutenção de condição de pagamento do sistema Pallas.35 - Gold Solutions");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknumvol']) == false) { $_SESSION['wrknumvol'] = 1; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? 00 : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 00 : $_REQUEST['sta']);
     $par = (isset($_REQUEST['par']) == false ? 00 : $_REQUEST['par']);
     $cai = (isset($_REQUEST['cai']) == false ? 00 : $_REQUEST['cai']);
     $din = (isset($_REQUEST['din']) == false ? 00 : $_REQUEST['din']);
     $dia = (isset($_REQUEST['dia']) == false ? 00 : $_REQUEST['dia']);
     $dia0 = (isset($_REQUEST['dia0']) == false ? 00 : $_REQUEST['dia0']);
     $dia1 = (isset($_REQUEST['dia1']) == false ? 00 : $_REQUEST['dia1']);
     $dia2 = (isset($_REQUEST['dia2']) == false ? 00 : $_REQUEST['dia2']);
     $dia3 = (isset($_REQUEST['dia3']) == false ? 00 : $_REQUEST['dia3']);
     $dia4 = (isset($_REQUEST['dia4']) == false ? 00 : $_REQUEST['dia4']);
     $dia5 = (isset($_REQUEST['dia5']) == false ? 00 : $_REQUEST['dia5']); 
     $des = (isset($_REQUEST['des']) == false ? '' : str_replace("'", "´", $_REQUEST['des']));

if ($_SESSION['wrkopereg'] == 1) { 
     $cod = ultimo_cod();
     $_SESSION['wrkmostel'] = 1;
}
if ($_SESSION['wrkopereg'] == 3) { 
     $bot = 'Deletar'; 
     $per = ' onclick="return confirm(\'Confirma exclusão de condição informado em tela ?\')" ';
}  
if ($_SESSION['wrkopereg'] >= 2) {
     if (isset($_REQUEST['salvar']) == false) { 
          $cha = $_SESSION['wrkcodreg']; $_SESSION['wrkmostel'] = 1;
          $ret = ler_pagto($cha, $des, $sta, $par, $dia, $cai, $din, $dia0, $dia1, $dia2, $dia3, $dia4, $dia5); 
     }
 }
 if (isset($_REQUEST['salvar']) == true) {
     $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
     if ($_SESSION['wrkopereg'] == 1) {
         $ret = consiste_pag();
         if ($ret == 0) {
             $ret = incluir_pag();
             $ret = gravar_log(11,"Inclusão de nova condição: " . $des);
             $cod = ultimo_cod(); $_SESSION['wrkcodreg'] = $cod; 
             $des = ''; $sta = 00;  $par = 00; $dia = 0; $cai = 0; $din = 0; $dia0 = 0; $dia1 = 0; $dia2 = 0; $dia3 = 0; $dia4 = 0; $dia5 = 0; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = $cod;
          }
     }
     if ($_SESSION['wrkopereg'] == 2) {
         $ret = consiste_pag();
         if ($ret == 0) {
             $ret = alterar_pag();
             $ret = gravar_log(12,"Alteração de condição existente: " . $des);  
             $des = ''; $sta = 00;  $par = 00; $dia = 0;  $cai = 0; $din = 0; $dia0 = 0; $dia1 = 0; $dia2 = 0; $dia3 = 0; $dia4 = 0; $dia5 = 0; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = $cod;
             echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
         }
     }
     if ($_SESSION['wrkopereg'] == 3) {
         $ret = excluir_pag();
         $ret = gravar_log(13,"Exclusão de condição existente: " . $des); 
         $des = ''; $sta = 00;  $par = 00; $dia = 0; $cai = 0; $din = 0; $dia0 = 0; $dia1 = 0; $dia2 = 0; $dia3 = 0; $dia4 = 0; $dia5 = 0; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = $cod;
         echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
     }
 }
?>

<body id="box01">
     <h1 class="cab-0">Condição - Sistema Gold Software - Emissão de NF-e e NFC-e - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10">
               <div class="qua-5 container">
                    <div class="row lit-3">
                         <div class="col-md-11">
                              <label>Manutenção de Condição de Pagamento</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-destino.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar novo condição no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>

                    <form class="tel-1" name="frmTelMan" action="" method="POST" enctype="multipart/form-data">

                         <div class="form-row">
                              <div class="col-md-2">
                                   <label>Código</label>
                                   <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                                        value="<?php echo $cod; ?>" disabled />
                              </div>
                              <div class="col-md-6">
                                   <label>Descrição da Condição de Pagto</label>
                                   <input type="text" class="form-control" maxlength="50" id="des" name="des"
                                        value="<?php echo $des; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Status</label><br />
                                   <select name="sta" class="form-control">
                                        <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>
                                             Normal
                                        </option>
                                        <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                             Bloqueado
                                        </option>
                                        <option value="2" <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                             Suspenso
                                        </option>
                                        <option value="3" <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>
                                             Cancelado
                                        </option>
                                   </select>
                              </div>
                              <div class="col-md-2">
                                   <label>Tipo</label><br />
                                   <select name="cai" class="form-control">
                                        <option value="0" <?php echo ($cai != 0 ? '' : 'selected="selected"'); ?>>
                                             Ambos
                                        </option>
                                        <option value="1" <?php echo ($cai != 1 ? '' : 'selected="selected"'); ?>>
                                             Danfe
                                        </option>
                                        <option value="2" <?php echo ($cai != 2 ? '' : 'selected="selected"'); ?>>
                                             Cupom
                                        </option>
                                   </select>
                              </div>
                         </div>
                         <div class="form-row">
                              <div class="col-md-2">
                                   <label>Dias 1</label><br />
                                   <input type="text" class="num form-control text-right" maxlength="3" id="dia0"
                                        name="dia0" value="<?php echo $dia0; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Dias 2</label><br />
                                   <input type="text" class="num form-control text-right" maxlength="3" id="dia1"
                                        name="dia1" value="<?php echo $dia1; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Dias 3</label><br />
                                   <input type="text" class="num form-control text-right" maxlength="3" id="dia2"
                                        name="dia2" value="<?php echo $dia2; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Dias 4</label><br />
                                   <input type="text" class="num form-control text-right" maxlength="3" id="dia3"
                                        name="dia3" value="<?php echo $dia3; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Dias 5</label><br />
                                   <input type="text" class="num form-control text-right" maxlength="3" id="dia4"
                                        name="dia4" value="<?php echo $dia4; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Dias 6</label><br />
                                   <input type="text" class="num form-control text-right" maxlength="3" id="dia5"
                                        name="dia5" value="<?php echo $dia5; ?>" required />
                              </div>
                         </div>
                         <div class="form-row">
                              <div class="col-md-6"></div>
                              <div class="col-md-2">
                                   <br />
                                   <span>Opção Dinheiro </span>
                                   <input type="checkbox" name="din" value="1"
                                        <?php echo ($din == 0 ? '': 'checked' ) ?> />
                              </div>
                              <div class="col-md-2">
                                   <label>Nº Parcelas</label><br />
                                   <input type="text" class="num form-control text-right" maxlength="2" id="par"
                                        name="par" value="<?php echo $par; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Dia Fixo</label><br />
                                   <input type="text" class="num form-control text-right" maxlength="2" id="dia"
                                        name="dia" value="<?php echo $dia; ?>" required />
                              </div>
                         </div>
                         <br />
                         <div class="form-row text-center">
                              <div class="col-md-12 text-center">
                                   <button type="submit" name="salvar" <?php echo $per; ?>
                                        class="bot-1"><?php echo $bot; ?></button>
                              </div>
                         </div>
                         <br />
                         <div class="row">
                              <div class="col-md-12 text-center">
                                   <?php
                                        echo '<a class="tit-2" href="' . $_SESSION['wrkproant'] . '.php" title="Volta a página anterior deste processamento.">Voltar</a>'
                                   ?>
                              </div>
                         </div>
                         <br />

                    </form>
               </div>
          </div>
          <div id="box10">
               <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
          </div>

     </div>
</body>
<?php
function ultimo_cod() {
     $cod = 1;
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select idpagto, pagdescricao from tb_pagto order by idpagto desc Limit 1");
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $cod = $lin['idpagto'] + 1;
     }
     return $cod;
 }

 function consiste_pag() {
     $sta = 0;
     if (trim($_REQUEST['des']) == "") {
         echo '<script>alert("Descrição da condição não pode estar em branco");</script>';
         return 1;
     }
     if (trim($_REQUEST['par']) > 12) {
          echo '<script>alert("Número de parcelas deve ser somente até 12 (Doze)");</script>';
          return 1; 
     }
     if (trim($_REQUEST['dia']) !=  0) {
          if (trim($_REQUEST['dia']) > 31) {
               echo '<script>alert("Número do dia fixo deve ser somente até 31");</script>';
               return 1; 
          }
     }
     return $sta;
 }

 function ler_pagto(&$cha, &$des, &$sta, &$par, &$dia, &$cai, &$din, &$dia0, &$dia1, &$dia2, &$dia3, &$dia4, &$dia5) {
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select * from tb_pagto where idpagto = " . $cha);
     if (mysqli_num_rows($sql) == 0) {
         echo '<script>alert("Código da condição informada não cadastrada no sistema");</script>';
     }else{
         $lin = mysqli_fetch_array($sql);
         $cha = $lin['idpagto'];
         $des = $lin['pagdescricao'];
         $sta = $lin['pagstatus'];
         $par = $lin['pagparcela'];
         $dia = $lin['pagdiafixo'];
         $din = $lin['pagdinheiro'];
         $cai = $lin['pagcaixa'];
         $dia0 = $lin['pagdias00'];
         $dia1 = $lin['pagdias01'];
         $dia2 = $lin['pagdias02'];
         $dia3 = $lin['pagdias03'];
         $dia4 = $lin['pagdias04'];
         $dia5 = $lin['pagdias05'];
     }
     return $cha;
 }

 function incluir_pag() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "insert into tb_pagto (";
     $sql .= "pagempresa, ";
     $sql .= "pagstatus, ";
     $sql .= "pagparcela, ";
     $sql .= "pagdiafixo, ";
     $sql .= "pagdias00, ";
     $sql .= "pagdias01, ";
     $sql .= "pagdias02, ";
     $sql .= "pagdias03, ";
     $sql .= "pagdias04, ";
     $sql .= "pagdias05, ";
     $sql .= "pagcaixa, ";
     $sql .= "pagdinheiro, ";
     $sql .= "pagdescricao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . ($_REQUEST['par'] == "" ? 0 : $_REQUEST['par'] ) . "',";
     $sql .= "'" . ($_REQUEST['dia'] == "" ? 0 : $_REQUEST['dia'] ) . "',";
     $sql .= "'" . ($_REQUEST['dia0'] == "" ? 0 : $_REQUEST['dia0'] ) . "',";
     $sql .= "'" . ($_REQUEST['dia1'] == "" ? 0 : $_REQUEST['dia1'] ) . "',";
     $sql .= "'" . ($_REQUEST['dia2'] == "" ? 0 : $_REQUEST['dia2'] ) . "',";
     $sql .= "'" . ($_REQUEST['dia3'] == "" ? 0 : $_REQUEST['dia3'] ) . "',";
     $sql .= "'" . ($_REQUEST['dia4'] == "" ? 0 : $_REQUEST['dia4'] ) . "',";
     $sql .= "'" . ($_REQUEST['dia5'] == "" ? 0 : $_REQUEST['dia5'] ) . "',";
     $sql .= "'" . $_REQUEST['cai'] . "',";
     $sql .= "'" . (isset($_REQUEST['din']) == false ? 0 : 1) . "',";
     $sql .= "'" . str_replace("'", "´", $_REQUEST['des']) . "',";
     $sql .= "'" . $_SESSION['wrkideusu'] . "',";
     $sql .= "'" . date("Y/m/d H:i:s") . "')";
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
         print_r($sql);
         echo '<script>alert("Erro na gravação do registro solicitado !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
}

function alterar_pag() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "update tb_pagto set ";
     $sql .= "pagstatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "pagparcela = '". $_REQUEST['par'] . "', ";
     $sql .= "pagdiafixo = '". $_REQUEST['dia'] . "', ";
     $sql .= "pagdias00 = '". $_REQUEST['dia0'] . "', ";
     $sql .= "pagdias01 = '". $_REQUEST['dia1'] . "', ";
     $sql .= "pagdias02 = '". $_REQUEST['dia2'] . "', ";
     $sql .= "pagdias03 = '". $_REQUEST['dia3'] . "', ";
     $sql .= "pagdias04 = '". $_REQUEST['dia4'] . "', ";
     $sql .= "pagdias05 = '". $_REQUEST['dia5'] . "', ";
     $sql .= "pagcaixa = '". $_REQUEST['cai'] . "', ";
     $sql .= "pagdinheiro = '". (isset($_REQUEST['din']) == false ? 0 : 1) . "', ";
     $sql .= "pagdescricao = '". $_REQUEST['des'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idpagto = " . $_SESSION['wrkcodreg'];
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
 } 

 function excluir_pag() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "delete from tb_pagto where idpagto = " . $_SESSION['wrkcodreg'] ;
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na exclusão do registro solicitado !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
 }

?>

</html>
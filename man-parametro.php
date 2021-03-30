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
     $("#icm").mask("99,99");
     $("#ipi").mask("99,99");
     $("#pis").mask("99,99");
     $("#cof").mask("99,99");
     $("#css").mask("99,99");
     $("#ric").mask("99,99");
     $("#rip").mask("99,99");
     $("#apr").mask("99,99");
     $("#iva").mask("99,99");
});

$(document).ready(function() {
     $('#des').blur(function() {
          var des = $('#des').val();
          var dan = $('#dan').val();
          if (des == "") {
               $('#des').val(dan);
          }
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
               $ret = gravar_log(10,"Entrada na página de manutenção de destinatário do sistema Pallas.35 - Gold Solutions");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknumvol']) == false) { $_SESSION['wrknumvol'] = 1; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? '' : $_REQUEST['cod']);
     $dan = (isset($_REQUEST['dan']) == false ? '' : $_REQUEST['dan']);
     $des = (isset($_REQUEST['des']) == false ? '' : $_REQUEST['des']);
     $sta = (isset($_REQUEST['sta']) == false ? 00 : $_REQUEST['sta']);
     $tip = (isset($_REQUEST['tip']) == false ? 00 : $_REQUEST['tip']);
     $fin = (isset($_REQUEST['fin']) == false ? 00 : $_REQUEST['fin']);
     $icm = (isset($_REQUEST['icm']) == false ? 00 : $_REQUEST['icm']);
     $ipi = (isset($_REQUEST['ipi']) == false ? 00 : $_REQUEST['ipi']);
     $pis = (isset($_REQUEST['pis']) == false ? 00 : $_REQUEST['pis']);
     $cof = (isset($_REQUEST['cof']) == false ? 00 : $_REQUEST['cof']);
     $css = (isset($_REQUEST['css']) == false ? 00 : $_REQUEST['css']);
     $iva = (isset($_REQUEST['iva']) == false ? 00 : $_REQUEST['iva']);
     $ric = (isset($_REQUEST['ric']) == false ? 00 : $_REQUEST['ric']);
     $rip = (isset($_REQUEST['rip']) == false ? 00 : $_REQUEST['rip']);
     $apr = (isset($_REQUEST['apr']) == false ? 00 : $_REQUEST['apr']);
     $fun = (isset($_REQUEST['fun']) == false ? 00 : $_REQUEST['fun']);
     $cst = (isset($_REQUEST['cst']) == false ? 00 : $_REQUEST['cst']);
     $sfr = (isset($_REQUEST['sfr']) == false ? 00 : $_REQUEST['sfr']);
     $esp = (isset($_REQUEST['esp']) == false ? 'Nf' : $_REQUEST['esp']);
     $mod = (isset($_REQUEST['mod']) == false ? '55' : $_REQUEST['mod']);
     $fim = (isset($_REQUEST['fim']) == false ? '' : $_REQUEST['fim']);
 
     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
          $_SESSION['wrkmostel'] = 1;
     }
if ($_SESSION['wrkopereg'] == 3) { 
     $bot = 'Deletar'; 
     $per = ' onclick="return confirm(\'Confirma exclusão de destinatário informado em tela ?\')" ';
}  
if ($_SESSION['wrkopereg'] >= 2) {
     if (isset($_REQUEST['salvar']) == false) { 
          $cha = $_SESSION['wrkcodreg']; $cod = $_SESSION['wrkcodreg']; $_SESSION['wrkmostel'] = 1;
          $ret = ler_parametro($cha, $dan, $des, $sta, $tip, $fin, $icm, $ipi, $pis, $cof, $css, $iva, $ric, $rip, $apr, $cst, $sfr, $esp, $mod, $fim, $fun); 
          if ($_SESSION['wrkopereg'] == 5) { 
               $cod = ultimo_cod();
               $_SESSION['wrkmostel'] = 1;
          }          
     }
 }
 if (isset($_REQUEST['salvar']) == true) {
     $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
     if ($_SESSION['wrkopereg'] == 1 || $_SESSION['wrkopereg'] == 5) {
          $ret = consiste_par();
         if ($ret == 0) {
             $ret = incluir_par();
             $ret = gravar_log(11,"Inclusão de novo parâmetro: " . $des);
             $cod = ultimo_cod(); $_SESSION['wrkcodreg'] = $cod; 
             $dan = ''; $des = ''; $sta = 00; $tip = 00; $fin = 1; $icm = 00; $ipi = 00; $pis = 00; $cof = 00; $css = 00; $iva = 00; $ric = 0; $rip = 00; $apr = 00; $cst = 00; $sfr = 00; $esp = ''; $mod = ''; $fim = ''; $fun = 00;
          }
     }
     if ($_SESSION['wrkopereg'] == 2) {
         $ret = consiste_par();
         if ($ret == 0) {
             $ret = alterar_par();
             $ret = gravar_log(12,"Alteração de parâmetro existente: " . $des);  
             $dan = ''; $des = ''; $sta = 00; $tip = 00; $fin = 1; $icm = 00; $ipi = 00; $pis = 00; $cof = 00; $css = 00; $iva = 00; $ric = 0; $rip = 00; $apr = 00; $cst = 00; $sfr = 00; $esp = ''; $mod = ''; $fim = ''; $fun = 00;
             echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
         }
     }
     if ($_SESSION['wrkopereg'] == 3) {
         $ret = excluir_par();
         $ret = gravar_log(13,"Exclusão de parâmetro existente: " . $des); 
         $dan = ''; $des = ''; $sta = 00; $tip = 00; $fin = 1; $icm = 00; $ipi = 00; $pis = 00; $cof = 00; $css = 00; $iva = 00; $ric = 0; $rip = 00; $apr = 00; $cst = 00; $sfr = 00; $esp = ''; $mod = ''; $fim = ''; $fun = 00;
         echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
     }
 }
?>

<body id="box01">
     <h1 class="cab-0">Emitente - Sistema Gold Software - Emissão de NF-e e NFC-e - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10">
               <div class="qua-5 container">
                    <div class="row lit-3">
                         <div class="col-md-11">
                              <label>Manutenção de Parâmetros</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-destino.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar novo parâmetro no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>

                    <form class="tel-1" name="frmTelMan" action="" method="POST">
                         <div class="row">
                              <div class="col-md-2">
                                   <label>Código</label>
                                   <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                                        value="<?php echo $cod; ?>" disabled />
                              </div>
                              <div class="col-md-8"></div>
                              <div class="col-md-2">
                                   <label>Status</label><br />
                                   <select name="sta" class="form-control">
                                        <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>Normal
                                        </option>
                                        <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                             Bloqueado</option>
                                        <option value="2" <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                             Suspenso</option>
                                        <option value="3" <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>
                                             Cancelado</option>
                                   </select>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-8">
                                   <label>Descrição para Danfe</label>
                                   <input type="text" class="form-control" maxlength="50" id="dan" name="dan"
                                        value="<?php echo $dan; ?>" required />
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-8">
                                   <label>Descrição do Parâmetro</label>
                                   <input type="text" class="form-control" maxlength="50" id="des" name="des"
                                        value="<?php echo $des; ?>" required />
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-2">
                                   <label>Tipo de Nota</label><br />
                                   <select name="tip" class="form-control">
                                        <option value="0" <?php echo ($tip != 0 ? '' : 'selected="selected"'); ?>>Danfe
                                             Saída</option>
                                        <option value="1" <?php echo ($tip != 1 ? '' : 'selected="selected"'); ?>>Danfe
                                             Entrada</option>
                                        <option value="2" <?php echo ($tip != 2 ? '' : 'selected="selected"'); ?>>
                                             Complementar-Ent</option>
                                        <option value="3" <?php echo ($tip != 3 ? '' : 'selected="selected"'); ?>>
                                             Complementar-Saí</option>
                                        <option value="4" <?php echo ($tip != 4 ? '' : 'selected="selected"'); ?>>
                                             Devolução-Entrada</option>
                                        <option value="5" <?php echo ($tip != 5 ? '' : 'selected="selected"'); ?>>
                                             Devolução-Saída</option>
                                        <option value="6" <?php echo ($tip != 6 ? '' : 'selected="selected"'); ?>>
                                             Retorno-Entrada</option>
                                        <option value="7" <?php echo ($tip != 7 ? '' : 'selected="selected"'); ?>>
                                             Retorno-Saída</option>
                                   </select>
                              </div>
                              <div class="col-md-2">
                                   <label>Finalidade</label><br />
                                   <select name="fin" class="form-control">
                                        <option value="1" <?php echo ($fin != 1 ? '' : 'selected="selected"'); ?>>Normal
                                        </option>
                                        <option value="2" <?php echo ($fin != 2 ? '' : 'selected="selected"'); ?>>
                                             Complementar</option>
                                        <option value="3" <?php echo ($fin != 3 ? '' : 'selected="selected"'); ?>>Nota
                                             de Ajuste</option>
                                        <option value="4" <?php echo ($fin != 4 ? '' : 'selected="selected"'); ?>>
                                             Devolução/Retorno</option>
                                   </select>
                              </div>
                              <div class="col-md-1">
                                   <label>Espécie</label>
                                   <input type="text" class="form-control text-center" maxlength="5" id="esp" name="esp"
                                        value="<?php echo $esp; ?>" required />
                              </div>
                              <div class="col-md-1">
                                   <label>Môdelo</label>
                                   <input type="text" class="form-control text-center" maxlength="2" id="mod" name="mod"
                                        value="<?php echo $mod; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Final Cfop</label>
                                   <input type="text" class="form-control text-center" maxlength="3" id="fim" name="fim"
                                        value="<?php echo $fim; ?>" required />
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-2">
                                   <label>% Icms</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="icm" name="icm"
                                        value="<?php echo $icm; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>% Ipi</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="ipi" name="ipi"
                                        value="<?php echo $ipi; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <br />
                                   <span>Calcular S.T. &nbsp;&nbsp;&nbsp;</span>
                                   <input type="checkbox" name="cst" value="1"
                                        <?php echo ($cst == 0 ? '': 'checked' ) ?> />
                              </div>
                              <div class="col-md-2">
                                   <br />
                                   <span>Somar Frete &nbsp;&nbsp;&nbsp;</span>
                                   <input type="checkbox" name="sfr" value="1"
                                        <?php echo ($sfr == 0 ? '': 'checked' ) ?> />
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-2">
                                   <label>% de Pis</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="pis" name="pis"
                                        value="<?php echo $pis; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>% de Cofins</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="cof" name="cof"
                                        value="<?php echo $cof; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>% de Cssl</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="css" name="css"
                                        value="<?php echo $css; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>% de Iva</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="iva" name="iva"
                                        value="<?php echo $iva; ?>" required />
                              </div>
                              <div class="col-md-2"></div>
                         </div>

                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-2">
                                   <label>% Reduz Icm</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="ric" name="ric"
                                        value="<?php echo $ric; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>% Reduz Ipi</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="rip" name="rip"
                                        value="<?php echo $rip; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>% Aproveitamento</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="apr" name="apr"
                                        value="<?php echo $apr; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>% Fundo Combate</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="fun" name="fun"
                                        value="<?php echo $fun; ?>" required />
                              </div>
                              <div class="col-md-2"></div>
                         </div>


                         <br />
                         <div class="row">
                              <div class="col-md-3"></div>
                              <div class="col-md-6 text-center">
                                   <button type="submit" id="env" name="salvar" <?php echo $per; ?>
                                        class="bot-1"><?php echo $bot; ?></button>
                              </div>
                              <div class="col-md-3"></div>
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
     $sql = mysqli_query($conexao,"Select idparametro, parnome from tb_parametro order by idparametro desc Limit 1");
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $cod = $lin['idparametro'] + 1;
     }
     return $cod;
}

function consiste_par() {
    $sta = 0;
    if (trim($_REQUEST['des']) == "") {
        echo '<script>alert("Descrição do parâmetro não pode estar em branco");</script>';
        return 1;
    }
    if (trim($_REQUEST['dan']) == "") {
        echo '<script>alert("Descrição para Danfe não pode estar em branco");</script>';
        return 3;
    }
    if (trim($_REQUEST['icm']) == "" || trim($_REQUEST['icm']) == ",") {
        echo '<script>alert("Percentual de Icms não pode estar em branco");</script>';
        return 3;
    }
    if (trim($_REQUEST['ipi']) == "" || trim($_REQUEST['ipi']) == ",") {
        echo '<script>alert("Percentual de Ipi não pode estar em branco");</script>';
        return 3;
    }
    if (trim($_REQUEST['iva']) == "" || trim($_REQUEST['iva']) == ",") {
        echo '<script>alert("Percentual de Iva não pode estar em branco");</script>';
        return 3;
    }
    if (trim($_REQUEST['pis']) == "" || trim($_REQUEST['pis']) == ",") {
        echo '<script>alert("Percentual de Pis não pode estar em branco");</script>';
        return 3;
    }
    if (trim($_REQUEST['cof']) == "" || trim($_REQUEST['cof']) == ",") {
        echo '<script>alert("Percentual de Cofins não pode estar em branco");</script>';
        return 3;
    }
    if (trim($_REQUEST['css']) == "" || trim($_REQUEST['css']) == ",") {
        echo '<script>alert("Percentual de Cssl não pode estar em branco");</script>';
        return 3;
    }
    if (trim($_REQUEST['apr']) == "" || trim($_REQUEST['apr']) == ",") {
        echo '<script>alert("Aproveitamento de Icms não pode estar em branco");</script>';
        return 3;
    }
    if (trim($_REQUEST['ric']) == "" || trim($_REQUEST['ric']) == ",") {
        echo '<script>alert("Percentual de Redução de Icms não pode estar em branco");</script>';
        return 3;
    }
    if (trim($_REQUEST['rip']) == "" || trim($_REQUEST['rip']) == ",") {
        echo '<script>alert("Percentual de Redução de Ipi não pode estar em branco");</script>';
        return 3;
    }
    if (trim($_REQUEST['mod']) != "55" && trim($_REQUEST['mod']) != "65") {
        echo '<script>alert("Môdelo da Danfe Eletrônica somente pode ser 55 ou 65");</script>';
        return 3;
    }
    $cfo = ncfop_exi($_REQUEST['fim']);
    if ($cfo == "") {
        echo '<script>alert("Final de Cfop informado não existe no cadastro de Cfop´s");</script>';
        return 3;
    }
    return $sta;
}    
    
function incluir_par() {
    $ret = 0;
    include "lerinformacao.inc";
    $sql  = "insert into tb_parametro (";
    $sql .= "parempresa, ";
    $sql .= "parstatus, ";
    $sql .= "parnome, ";
    $sql .= "pardanfe, ";
    $sql .= "partiponota, ";
    $sql .= "parcalcsubs, ";
    $sql .= "parfinalidade, ";
    $sql .= "parespecie, ";
    $sql .= "parfinalcfop, ";
    $sql .= "parmodelo, ";
    $sql .= "paricmsfixo, ";
    $sql .= "paripifixo, ";
    $sql .= "paraproveita, ";
    $sql .= "parperpis, ";
    $sql .= "parpercofins, ";
    $sql .= "parpercssl, ";
    $sql .= "parperiva, ";
    $sql .= "parredicms, ";
    $sql .= "parredipi, ";
    $sql .= "parfundoper, ";
    $sql .= "parfretnota, ";
    $sql .= "keyinc, ";
    $sql .= "datinc ";
    $sql .= ") value ( ";
    $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
    $sql .= "'" . $_REQUEST['sta'] . "',";
    $sql .= "'" . $_REQUEST['des'] . "',";
    $sql .= "'" . $_REQUEST['dan'] . "',";
    $sql .= "'" . $_REQUEST['tip'] . "',";
    $sql .= "'" . (isset($_REQUEST['cst']) == false ? 00 : $_REQUEST['cst']) . "',";
    $sql .= "'" . $_REQUEST['fin'] . "',";
    $sql .= "'" . $_REQUEST['esp'] . "',";
    $sql .= "'" . $_REQUEST['fim'] . "',";
    $sql .= "'" . $_REQUEST['mod'] . "',";
    $sql .= "'" . str_replace(",",".",$_REQUEST['icm']) . "',";
    $sql .= "'" . str_replace(",",".",$_REQUEST['ipi']) . "',";
    $sql .= "'" . str_replace(",",".",$_REQUEST['apr']) . "',";
    $sql .= "'" . str_replace(",",".",$_REQUEST['pis']) . "',";
    $sql .= "'" . str_replace(",",".",$_REQUEST['cof']) . "',";
    $sql .= "'" . str_replace(",",".",$_REQUEST['css']) . "',";
    $sql .= "'" . str_replace(",",".",$_REQUEST['iva']) . "',";
    $sql .= "'" . str_replace(",",".",$_REQUEST['ric']) . "',";
    $sql .= "'" . str_replace(",",".",$_REQUEST['rip']) . "',";
    $sql .= "'" . str_replace(",",".",$_REQUEST['fun']) . "',";
    $sql .= "'" . (isset($_REQUEST['sfr']) == false ? 00 : $_REQUEST['sfr']) . "',";
    $sql .= "'" . $_SESSION['wrkideusu'] . "',";
    $sql .= "'" . date("Y/m/d H:i:s") . "')";
    $ret = mysqli_query($conexao,$sql);
    $_SESSION['wrkcodreg'] = mysqli_insert_id($conexao); // Auto Increment Id
    if ($ret == true) {
        echo '<script>alert("Registro incluído no sistema com Sucesso !");</script>';
    }else{
        print_r($sql);
        echo '<script>alert("Erro na gravação do registro solicitado !");</script>';
    }
    $ret = desconecta_bco();
    return $ret;
}
function alterar_par() {
    $ret = 0;
    include "lerinformacao.inc";
    $sql  = "update tb_parametro set ";
    $sql .= "parstatus = '". $_REQUEST['sta'] . "', ";
    $sql .= "parnome = '". $_REQUEST['des'] . "', ";
    $sql .= "pardanfe = '". $_REQUEST['dan'] . "', ";
    $sql .= "partiponota = '". $_REQUEST['tip'] . "', ";
    $sql .= "parcalcsubs = '". (isset($_REQUEST['cst']) == false ? 00 : $_REQUEST['cst']) . "', ";
    $sql .= "parfinalidade = '". $_REQUEST['fin'] . "', ";
    $sql .= "parespecie = '". $_REQUEST['esp'] . "', ";
    $sql .= "parfinalcfop = '". $_REQUEST['fim'] . "', ";
    $sql .= "parmodelo = '". $_REQUEST['mod'] . "', ";
    $sql .= "paricmsfixo = '". str_replace(",",".",$_REQUEST['icm']) . "', ";
    $sql .= "paripifixo = '". str_replace(",",".",$_REQUEST['ipi']) . "', ";
    $sql .= "paraproveita = '". str_replace(",",".",$_REQUEST['apr']) . "', ";
    $sql .= "parperpis = '". str_replace(",",".",$_REQUEST['pis']) . "', ";
    $sql .= "parpercofins = '". str_replace(",",".",$_REQUEST['cof']) . "', ";
    $sql .= "parpercssl = '". str_replace(",",".",$_REQUEST['css']) . "', ";
    $sql .= "parperiva =  '". str_replace(",",".",$_REQUEST['iva']) . "', ";
    $sql .= "parredicms = '". str_replace(",",".",$_REQUEST['ric']) . "', ";
    $sql .= "parredipi = '". str_replace(",",".",$_REQUEST['rip']) . "', ";
    $sql .= "parfundoper = '". str_replace(",",".",$_REQUEST['fun']) . "', ";
    $sql .= "parfretnota = '". (isset($_REQUEST['sfr']) == false ? 00 : $_REQUEST['sfr']) . "', ";
    $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
    $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
    $sql .= "where idparametro = " . $_SESSION['wrkcodreg'];
    $ret = mysqli_query($conexao,$sql);
    if ($ret == true) {
        echo '<script>alert("Registro alterado no sistema com Sucesso !");</script>';
    }else{
        print_r($sql);
        echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
    }
    $ret = desconecta_bco();
    return $ret;
}   
    
function excluir_par() {
    $ret = 0;
    include "lerinformacao.inc";
    $sql  = "delete from tb_parametro where idparametro = " . $_SESSION['wrkcodreg'] ;
    $ret = mysqli_query($conexao,$sql);
    if ($ret == true) {
        echo '<script>alert("Registro excluído no sistema com Sucesso !");</script>';
    }else{
        print_r($sql);
        echo '<script>alert("Erro na exclusão do registro solicitado !");</script>';
    }
    $ret = desconecta_bco();
    return $ret;
}    

function ler_parametro(&$cha, &$dan, &$des, &$sta, &$tip, &$fin, &$icm, &$ipi, &$pis, &$cof, &$css, &$iva, &$ric, &$rip, &$apr, &$cst, &$sfr, &$esp, &$mod, &$fim, &$fun) {
    include "lerinformacao.inc";
    $sql = mysqli_query($conexao,"Select * from tb_parametro where idparametro = " . $cha);
    if (mysqli_num_rows($sql) == 0) {
        echo '<script>alert("Código do parâmetro fiscal informada não cadastrada");</script>';
        $nro = 1;
    }else{
        $linha = mysqli_fetch_array($sql);
        $cha = $linha['idparametro'];
        $dan = $linha['pardanfe'];
        $des = $linha['parnome'];
        $sta = $linha['parstatus'];
        $tip = $linha['partiponota'];
        $fin = $linha['parfinalidade'];
        $icm = str_replace(".",",",$linha['paricmsfixo']);
        $ipi = str_replace(".",",",$linha['paripifixo']);
        $pis = str_replace(".",",",$linha['parperpis']);
        $cof = str_replace(".",",",$linha['parpercofins']);
        $css = str_replace(".",",",$linha['parpercssl']);
        $iva = str_replace(".",",",$linha['parperiva']);
        $ric = str_replace(".",",",$linha['parredicms']);
        $rip = str_replace(".",",",$linha['parredipi']);
        $apr = str_replace(".",",",$linha['paraproveita']);
        $fun = str_replace(".",",",$linha['parfundoper']);
        $cst = $linha['parcalcsubs'];
        $sfr = $linha['parfretnota'];
        $esp = $linha['parespecie'];
        $mod = $linha['parmodelo'];
        $fim = $linha['parfinalcfop'];
    }
    return $cha;
}        

?>

</html>

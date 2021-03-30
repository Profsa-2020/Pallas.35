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

     <script type="text/javascript" src="js/profsa.js"></script>

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <link href="css/pallas35.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Emissão de NF-e e NFC-e - Gold Software Soluções Inteligentes - Profsa Informática Ltda - Login</title>
</head>

<script>
$(function() {
     $("#icm").mask("99,99");
     $("#ipi").mask("99,99");
     $("#sit").mask("9999");
     $("#iva").mask("99,99");
     $("#pna").mask("00,00");
     $("#pim").mask("#9,99");
     $("#ncm").mask("99999999");
     $("#psl").mask("##0,0000", {
          reverse: true
     });
     $("#psb").mask("000,0000", {
          reverse: true
     });
     $("#pre").mask("#.##0,00", {
          reverse: true
     });
});

$(document).ready(function() {

     $('#pre').blur(function() {
          var pre = $('#pre').val();
          var pos = pre.indexOf(",");
          if (pos == -1) { $('#pre').val(pre + ',00'); }
     });

     $('#fot_carrega').bind("click", function() {
          $('#fot_janela').click();
     });
     $('#fot_janela').change(function() {
          var path = $('#fot_janela').val();
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
     $ref = (isset($_REQUEST['ref']) == false ? '' : $_REQUEST['ref']);
     $sta = (isset($_REQUEST['sta']) == false ? 0 : $_REQUEST['sta']);
     $umt = (isset($_REQUEST['umt']) == false ? 'UN' : $_REQUEST['umt']);
     $umc = (isset($_REQUEST['umc']) == false ? 'UN' : $_REQUEST['umc']);
     $ncm = (isset($_REQUEST['ncm']) == false ? '' : $_REQUEST['ncm']);
     $sit = (isset($_REQUEST['sit']) == false ? 0 : $_REQUEST['sit']);
     $icm = (isset($_REQUEST['icm']) == false ? 0 : $_REQUEST['icm']);
     $ipi = (isset($_REQUEST['ipi']) == false ? 0 : $_REQUEST['ipi']);
     $iva = (isset($_REQUEST['iva']) == false ? 0 : $_REQUEST['iva']);
     $pna = (isset($_REQUEST['pna']) == false ? 0 : $_REQUEST['pna']);
     $pim = (isset($_REQUEST['pim']) == false ? 0 : $_REQUEST['pim']);
     $psl = (isset($_REQUEST['psl']) == false ? 0 : $_REQUEST['psl']);
     $psb = (isset($_REQUEST['psb']) == false ? 0 : $_REQUEST['psb']);
     $tre = (isset($_REQUEST['tre']) == false ? 02 : $_REQUEST['tre']);
     $trs = (isset($_REQUEST['trs']) == false ? 52 : $_REQUEST['trs']);
     $pre = (isset($_REQUEST['pre']) == false ? 0 : $_REQUEST['pre']);
     $bar = (isset($_REQUEST['bar']) == false ? 'SEM GTIN' : $_REQUEST['bar']);
     $ces = (isset($_REQUEST['ces']) == false ? '' : $_REQUEST['ces']);
     $enq = (isset($_REQUEST['enq']) == false ? 999 : $_REQUEST['enq']);
     $des = (isset($_REQUEST['des']) == false ? '' : str_replace("'", "´", $_REQUEST['des']));
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));

     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
          $_SESSION['wrkmostel'] = 1;
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $per = ' onclick="return confirm(\'Confirma exclusão de produto informado em tela ?\')" ';
     }  
     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; $_SESSION['wrkmostel'] = 1;
               $ret = ler_produto($cod, $des, $ref, $sta, $umt, $umc, $ncm, $sit, $icm, $ipi, $iva, $pna, $pim, $psl, $psb, $tre, $trs, $pre, $bar, $ces, $enq, $obs); 
               if ($_SESSION['wrkopereg'] == 5) { 
                    $cod = ultimo_cod();
                    $_SESSION['wrkmostel'] = 1;
               }          
          }
     }
     if (isset($_REQUEST['salvar']) == true) {
          $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
          if ($_SESSION['wrkopereg'] == 1 || $_SESSION['wrkopereg'] == 5) {
          $ret = consiste_pro();
          if ($ret == 0) {
               $ret = incluir_pro();
               $ret = upload_fot($cam, $des, $tam, $ext);
               if ($_SESSION['wrkopereg'] == 1) {
                    $ret = gravar_log(11,"Inclusão de novo produto: " . $des);
               } else {
                    $ret = gravar_log(11,"Duplicação de novo produto: " . $des);
               }
               $cod = ultimo_cod(); $_SESSION['wrkcodreg'] = $cod; 
               $des = ''; $ref = ultimo_cod(); $sta = 0; $umt = 'UN'; $umc = 'UN'; $ncm = ''; $sit = 0; $icm = 0; $ipi = 0; $iva = 0; $pna = 0; $pim = 0; $psl = 0; $psb = 0; $tre = 02; $trs = 52; $pre = 0; $bar = 'SEM GTIN'; $ces = ''; $enq = 999; $obs = '';
          }
          }
          if ($_SESSION['wrkopereg'] == 2) {
          $ret = consiste_pro();
          if ($ret == 0) {
               $ret = alterar_pro();
               $ret = upload_fot($cam, $des, $tam, $ext);
               $ret = gravar_log(12,"Alteração de produto existente: " . $des);  
               $des = ''; $ref = ultimo_cod(); $sta = 0; $umt = 'UN'; $umc = 'UN'; $ncm = ''; $sit = 0; $icm = 0; $ipi = 0; $iva = 0; $pna = 0; $pim = 0; $psl = 0; $psb = 0; $tre = 02; $trs = 52; $pre = 0; $bar = 'SEM GTIN'; $ces = ''; $enq = 999; $obs = '';
               echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
          }
          }
          if ($_SESSION['wrkopereg'] == 3) {
          $ret = excluir_pro();
          $ret = gravar_log(13,"Exclusão de produto existente: " . $des); 
          $des = ''; $ref = ultimo_cod(); $sta = 0; $umt = 'UN'; $umc = 'UN'; $ncm = ''; $sit = 0; $icm = 0; $ipi = 0; $iva = 0; $pna = 0; $pim = 0; $psl = 0; $psb = 0; $tre = 02; $trs = 52; $pre = 0; $bar = 'SEM GTIN'; $ces = ''; $enq = 999; $obs = '';
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
                              <label>Manutenção de Produtos</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-produto.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar novo produto no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>
                    <form class="tel-1" name="frmTelMan" action="" method="POST" enctype="multipart/form-data">
                         <div class="row">
                              <div class="col-md-2">
                                   <label>Número</label>
                                   <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                                        value="<?php echo $cod; ?>" disabled />
                              </div>
                              <div class="col-md-3"></div>
                              <div class="col-md-2">
                                   <label>Referência</label><br />
                                   <input type="text" class="form-control" maxlength="15" id="ref" name="ref"
                                        value="<?php echo $ref; ?>"  />
                              </div>
                              <div class="col-md-3"></div>
                              <div class="col-md-2">
                                   <label>Status</label>
                                   <select name="sta" class="form-control">
                                        <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>Ativo
                                        </option>
                                        <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                             Inativo</option>
                                        <option value="2" <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                             Suspenso</option>
                                        <option value="3" <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>
                                             Cancelado</option>
                                   </select>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-12">
                                   <label>Descrição do Produto</label>
                                   <input type="text" class="form-control" maxlength="150" id="des" name="des"
                                        value="<?php echo $des; ?>" required />
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-1">
                                   <label>Unid C</label><br />
                                   <input type="text" class="form-control text-center" maxlength="5" id="umc" name="umc"
                                        value="<?php echo $umc; ?>" required />
                              </div>
                              <div class="col-md-1">
                                   <label>Unid T</label><br />
                                   <input type="text" class="form-control text-center" maxlength="5" id="umt" name="umt"
                                        value="<?php echo $umt; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Número Ncm</label>
                                   <input type="text" class="form-control text-center" maxlength="8" id="ncm" name="ncm"
                                        value="<?php echo $ncm; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Situação Tributária</label><br />
                                   <select name="sit" class="form-control">
                                        <?php echo carrega_sit($sit); ?>
                                   </select>
                              </div>
                              <div class="col-md-2">
                                   <label>Código de Barras</label>
                                   <input type="text" class="form-control" maxlength="15" id="bar" name="bar"
                                        value="<?php echo $bar; ?>" required />
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-2">
                                   <label>Enquadramento</label>
                                   <input type="text" class="form-control text-center" maxlength="3" id="enq" name="enq"
                                        value="<?php echo $enq; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Código Cest</label>
                                   <input type="text" class="form-control text-center" maxlength="8" id="ces" name="ces"
                                        value="<?php echo $ces; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>Peso Líquido</label>
                                   <input type="text" class="form-control text-right" maxlength="10" id="psl" name="psl"
                                        value="<?php echo $psl; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>Peso Bruto</label>
                                   <input type="text" class="form-control text-right" maxlength="10" id="psb" name="psb"
                                        value="<?php echo $psb; ?>" />
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-1">
                                   <label>% Icms</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="icm" name="icm"
                                        value="<?php echo $icm; ?>" />
                              </div>
                              <div class="col-md-1">
                                   <label>% Ipi</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="ipi" name="ipi"
                                        value="<?php echo $ipi; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>% para Iva</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="iva" name="iva"
                                        value="<?php echo $iva; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>Previsão Nacional</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="pna" name="pna"
                                        value="<?php echo $pna; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Previsão Importado</label>
                                   <input type="text" class="form-control text-right" maxlength="5" id="pim" name="pim"
                                        value="<?php echo $pim; ?>" required />
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-3">
                                   <label>Tributação Entrada</label>
                                   <select name="tre" class="form-control">
                                        <option value="00" <?php echo ($tre != 0 ? '' : 'selected="selected"'); ?>>
                                             00-Entrada recupera crédito</option>
                                        <option value="01" <?php echo ($tre != 1 ? '' : 'selected="selected"'); ?>>
                                             01-Entrada tributada zero</option>
                                        <option value="02" <?php echo ($tre != 2 ? '' : 'selected="selected"'); ?>>
                                             02-Entrada isenta</option>
                                        <option value="03" <?php echo ($tre != 3 ? '' : 'selected="selected"'); ?>>
                                             03-Entrada não tributada</option>
                                        <option value="04" <?php echo ($tre != 4 ? '' : 'selected="selected"'); ?>>
                                             04-Entrada imune</option>
                                        <option value="05" <?php echo ($tre != 5 ? '' : 'selected="selected"'); ?>>
                                             05-Entrada com suspenção</option>
                                        <option value="49" <?php echo ($tre != 49 ? '' : 'selected="selected"'); ?>>
                                             49-Outras Entradas</option>
                                   </select>
                              </div>
                              <div class="col-md-3">
                                   <label>Tributação Saída</label>
                                   <select name="trs" class="form-control">
                                        <option value="50" <?php echo ($trs != 50 ? '' : 'selected="selected"'); ?>>
                                             50-Saída tributada</option>
                                        <option value="51" <?php echo ($trs != 51 ? '' : 'selected="selected"'); ?>>
                                             51-Saída tributada zero</option>
                                        <option value="52" <?php echo ($trs != 52 ? '' : 'selected="selected"'); ?>>
                                             52-Saída isenta</option>
                                        <option value="53" <?php echo ($trs != 53 ? '' : 'selected="selected"'); ?>>
                                             53-Saída não tributada</option>
                                        <option value="54" <?php echo ($trs != 54 ? '' : 'selected="selected"'); ?>>
                                             54-Saída imune</option>
                                        <option value="55" <?php echo ($trs != 55 ? '' : 'selected="selected"'); ?>>
                                             55-Saída com suspenção</option>
                                        <option value="99" <?php echo ($trs != 99 ? '' : 'selected="selected"'); ?>>
                                             99-Outras Saídas</option>
                                   </select>
                              </div>
                              <div class="col-md-2">
                                   <label>Preço Unitário</label>
                                   <input type="text" class="form-control text-right" maxlength="10" id="pre" name="pre"
                                        value="<?php echo $pre; ?>" required />
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-8">
                                   <label for="obs">Observação</label>
                                   <textarea class="form-control" rows="5" id="obs"
                                        name="obs"><?php echo $obs ?></textarea>
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
                              <div class="col-md-2"></div>
                              <div class="col-md-1 text-center">
                                   <button type="button" class="bot-3" name="fot_carrega" id="fot_carrega" title="Abre janela para carregar fotos do produto (imagens)."><i class="fa fa-camera-retro fa-3x" aria-hidden="true"></i></button>
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
                         <input name="fotos[]" type="file" id="fot_janela" class="bot-4" multiple="multiple" />
                         <br />
                    </form>
               </div>
          </div>
     </div>
</body>
<?php
function ultimo_cod() {
     $cod = 1;
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select idproduto, prodescricao from tb_produto order by idproduto desc Limit 1");
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $cod = $lin['idproduto'] + 1;
     }
     return $cod;
}

 function carrega_sit($cod) {
     $sta = 00; $txt = '';
     if (file_exists('situacao.csv') == false) {
         echo '<script>alert("Arquivo com Situações Tributárias não encontrado no sistema");</script>';
         return 1;
     }
     $txt = '<option value="0" selected="selected">Selecione CST</option>';
     $reg = retorna_dad('emiregime', 'tb_emitente', 'idemite', $_SESSION['wrkcodemp']);    
     $sit = fopen('situacao.csv', "r");  
     while (!feof ($sit)) {
         $lin = explode(";", fgets($sit));
         if (count($lin) >= 3 ) {
             if ($reg == $lin[0]) {
                 if ($lin[1] != $cod) {
                     $txt .= '<option class="text-center" value ="' . $lin[1] . '">' . str_pad($lin[1], 4, "0", STR_PAD_LEFT) . '</option>'; 
                 }else{
                     $txt .= '<option class="text-center" value ="' . $lin[1] . '" selected="selected">' . str_pad($lin[1], 4, "0", STR_PAD_LEFT) . '</option>';
                 }
             }
         }
     } 
     fclose($sit);
     return $txt;
 }

 function consiste_pro() {
     $sta = 0;
     if (trim($_REQUEST['des']) == "") {
         echo '<script>alert("Descrição do produto não pode estar em branco");</script>';
         return 1;
     }
     if (trim($_REQUEST['umt']) == "") {
         echo '<script>alert("Unidade de Medida Tributária não pode estar em branco");</script>';
         return 3;
     }
     if (trim($_REQUEST['umc']) == "") {
         echo '<script>alert("Unidade de Medida Comercial não pode estar em branco");</script>';
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
     if (trim($_REQUEST['pna']) == "" || trim($_REQUEST['pna']) == ",") {
         echo '<script>alert("Previsão de Imposto Nacional não pode estar em branco");</script>';
         return 3;
     }
     if (trim($_REQUEST['pim']) == "" || trim($_REQUEST['pim']) == ",") {
         echo '<script>alert("Previsão de Imposto Importado não pode estar em branco");</script>';
         return 3;
     }
     if (trim($_REQUEST['psl']) == "" || trim($_REQUEST['psl']) == ",") {
         echo '<script>alert("Peso Liquido do produto não pode estar em branco");</script>';
         return 3;
     }
     if (trim($_REQUEST['psb']) == "" || trim($_REQUEST['psb']) == ",") {
         echo '<script>alert("Peso Bruto do produto não pode estar em branco");</script>';
         return 3;
     }
     if (trim($_REQUEST['pre']) == "" || trim($_REQUEST['pre']) == "," || trim($_REQUEST['pre']) == ".,") {
         echo '<script>alert("Preço Unitário do produto não pode estar em branco");</script>';
         return 3;
     }
     if (strlen(trim($_REQUEST['ncm'])) != 8) {
         echo '<script>alert("Número de dígitos do NCM informado deve ser igual a 8 (oito)");</script>';
         return 3;
     }
     $cod = produto_ref($_REQUEST['cod']);
     if ($cod != '' && $_SESSION['wrkopereg'] == 1) {
         echo '<script>alert("Referência do produto informado para já existe cadastrado");</script>';
         return 6;
     }
     $reg = situacao_exi($_REQUEST['sit']);
     if ($reg == 9) {
         echo '<script>alert("Código de situação tributária não encontrada");</script>';
         return 6;
     }
     if ($reg == 2) {
         echo '<script>alert("Código de situação tributária não permitido para Simples");</script>';
         return 6;
     }
     $reg = retorna_dad('emiregime','tb_emitente','idemite',$_SESSION['wrkcodemp']);
     if ($reg == 2) {
         echo '<script>alert("Regime do emitente não permite código de situação tributária");</script>';
         return 6;
     }
     return $sta;
 }    

 function incluir_pro() {
     $ret = 0;
     $pre = str_replace(".", "", $_REQUEST['pre']); $pre = str_replace(",", ".", $pre);
     include "lerinformacao.inc";
     $sql  = "insert into tb_produto (";
     $sql .= "proempresa, ";
     $sql .= "procodigo, ";
     $sql .= "prodescricao, ";
     $sql .= "prostatus, ";
     $sql .= "promedtributaria, ";
     $sql .= "promedcomercial, ";
     $sql .= "pronumeroncm, ";
     $sql .= "prosittributaria, ";
     $sql .= "propercentualicm, ";
     $sql .= "propercentualipi, ";
     $sql .= "propercentualiva, ";
     $sql .= "proprevnacional, ";
     $sql .= "proprevimportado, ";
     $sql .= "propesoliq, ";
     $sql .= "propesobru, ";
     $sql .= "protribentrada, ";
     $sql .= "protribsaida, ";
     $sql .= "propreco, ";
     $sql .= "procodbarras, ";
     $sql .= "procodigocest, ";
     $sql .= "proenquadra, ";
     $sql .= "proobservacao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . $_REQUEST['ref'] . "',";
     $sql .= "'" . $_REQUEST['des'] . "',";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . $_REQUEST['umt'] . "',";
     $sql .= "'" . $_REQUEST['umc'] . "',";
     $sql .= "'" . $_REQUEST['ncm'] . "',";
     $sql .= "'" . $_REQUEST['sit'] . "',";
     $sql .= "'" . str_replace(",",".",$_REQUEST['icm']) . "',";
     $sql .= "'" . str_replace(",",".",$_REQUEST['ipi']) . "',";
     $sql .= "'" . str_replace(",",".",$_REQUEST['iva']) . "',";
     $sql .= "'" . str_replace(",",".",$_REQUEST['pna']) . "',";
     $sql .= "'" . str_replace(",",".",$_REQUEST['pim']) . "',";
     $sql .= "'" . str_replace(",",".",$_REQUEST['psl']) . "',";
     $sql .= "'" . str_replace(",",".",$_REQUEST['psb']) . "',";
     $sql .= "'" . str_replace(",",".",$_REQUEST['tre']) . "',";
     $sql .= "'" . str_replace(",",".",$_REQUEST['trs']) . "',";
     $sql .= "'" . $pre             . "',";
     $sql .= "'" . $_REQUEST['bar'] . "',";
     $sql .= "'" . $_REQUEST['ces'] . "',";
     $sql .= "'" . $_REQUEST['enq'] . "',";
     $sql .= "'" . $_REQUEST['obs'] . "',";
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
 function alterar_pro() {
     $ret = 0;
     $pre = str_replace(".", "", $_REQUEST['pre']); $pre = str_replace(",", ".", $pre);
     include "lerinformacao.inc";
     $sql  = "update tb_produto set ";
     $sql .= "prostatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "prodescricao = '". $_REQUEST['des'] . "', ";
     $sql .= "procodigo = '". $_REQUEST['ref'] . "', ";
     $sql .= "promedtributaria = '". $_REQUEST['umt'] . "', ";
     $sql .= "promedcomercial = '". $_REQUEST['umc'] . "', ";
     $sql .= "pronumeroncm = '". $_REQUEST['ncm'] . "', ";
     $sql .= "prosittributaria = '". $_REQUEST['sit'] . "', ";
     $sql .= "protribentrada = '". $_REQUEST['tre'] . "', ";
     $sql .= "protribsaida = '". $_REQUEST['trs'] . "', ";
     $sql .= "procodbarras = '". $_REQUEST['bar'] . "', ";
     $sql .= "proenquadra = '". $_REQUEST['enq'] . "', ";
     $sql .= "procodigocest = '". $_REQUEST['ces'] . "', ";
     $sql .= "proobservacao = '". $_REQUEST['obs'] . "', ";
     $sql .= "propercentualicm = '". str_replace(",",".",$_REQUEST['icm']) . "', ";
     $sql .= "propercentualipi = '". str_replace(",",".",$_REQUEST['ipi']) . "', ";
     $sql .= "propercentualiva = '". str_replace(",",".",$_REQUEST['iva']) . "', ";
     $sql .= "proprevnacional = '". str_replace(",",".",$_REQUEST['pna']) . "', ";
     $sql .= "proprevimportado = '". str_replace(",",".",$_REQUEST['pim']) . "', ";
     $sql .= "propesoliq = '". str_replace(",",".",$_REQUEST['psl']) . "', ";
     $sql .= "propesobru =  '". str_replace(",",".",$_REQUEST['psb']) . "', ";
     $sql .= "propreco = '". $pre . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idproduto = " . $_SESSION['wrkcodreg'];
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

 function excluir_pro() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "delete from tb_produto where idproduto = " . $_SESSION['wrkcodreg'] ;
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

 function ler_produto(&$cha, &$des, &$ref, &$sta, &$umt, &$umc, &$ncm, &$sit, &$icm, &$ipi, &$iva, &$pna, &$pim, &$psl, &$psb, &$tre, &$trs, &$pre, &$bar, &$ces, &$enq, &$obs) {
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select * from tb_produto where idproduto = " . $cha);
     if (mysqli_num_rows($sql) == 0) {
         echo '<script>alert("Código do produto informado não cadastrado");</script>';
         $nro = 1;
     }else{
         $linha = mysqli_fetch_array($sql);
         $cha = $linha['idproduto'];
         $des = $linha['prodescricao'];
         $ref = $linha['procodigo'];
         $sta = $linha['prostatus'];
         $umt = $linha['promedtributaria'];
         $umc = $linha['promedcomercial'];
         $icm = str_replace(".",",",$linha['propercentualicm']);
         $ipi = str_replace(".",",",$linha['propercentualipi']);
         $iva = str_replace(".",",",$linha['propercentualiva']);
         $pna = str_replace(".",",",$linha['proprevnacional']);
         $pim = str_replace(".",",",$linha['proprevimportado']);
         $psl = str_replace(".",",",$linha['propesoliq']);
         $psb = str_replace(".",",",$linha['propesobru']);
         $pre = number_format($linha['propreco'], 2, ",", "."); 
         $ncm = $linha['pronumeroncm'];
         $sit = $linha['prosittributaria'];
         $tre = $linha['protribentrada'];
         $trs = $linha['protribsaida'];
         $bar = $linha['procodbarras'];
         $ces = $linha['procodigocest'];
         $enq = $linha['proenquadra'];
         $obs = $linha['proobservacao'];
     }
     return $cha;
 }        

 function upload_fot(&$cam, &$res, &$tam, &$ext) {
     $sta = 0; 
     include "lerinformacao.inc";
     $arq = isset($_FILES['fotos']) ? $_FILES['fotos'] : false;
     if ($arq == false) {
          return 2;
     }else if ($arq['name'][0] == "") {
          if ($_SESSION['wrkopereg'] == 1) {
               if ($arq['name'][0] != "") {
                    return 3;
               }
          }else{
               return 0;
          }
     }            
     $num = count($arq['name']);
     $erro[0] = 'Não houve erro encontrado no Upload do arquivo';
     $erro[1] = 'O arquivo informado no upload é maior do que o limite da plataforma';
     $erro[2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
     $erro[3] = 'O upload do arquivo foi feito parcialmente, tente novamente';
     $erro[4] = 'Não foi feito o upload do arquivo corretamente !';
     $erro[5] = 'Não foi feito o upload do arquivo corretamente !!';
     $erro[6] = 'Pasta temporária ausente para Upload do arquuivo informado';
     $erro[7] = 'Falha em escrever o arquivo para upload informado em disco';
     for ($ind = 0;$ind < $num; $ind++) {
          if ($arq['error'][$ind] != 0) {
               if ($_SESSION['wrkopereg'] == 1) {
                    if ($arq['name'][$ind] != "") {
                         echo "<script>alert(" . $erro[$arq['error'][$ind]] . "')</script>";
                    }
                    $sta = 4; 
               }else{
                    return 0;
               }
          }
          if ($sta == 0) {
               $tip = array('jpg','png','jpeg','JPG','PNG','JPEG');
               $des = limpa_cpo($arq['name'][$ind]);
               $tam = $arq['size'][$ind];
               $lim = $tam / 1024;  // Byte - Kbyte - MegaByte
               $fim = explode('.', $des);
               $ext = end($fim);
               if (array_search($ext, $tip) === false) {
                    echo "<script>alert('Extensão do arquivo informado para Upload não é permitida')</script>";
                    $sta = 5; 
               }
          }
          if ($sta == 0) {
               $tip = explode('.', $des);
               $des = $tip[0] . "." . $ext;
               $nro = ultima_cha();
               $nom = "pro_" . str_pad($_SESSION['wrkcodreg'], 8, "0", STR_PAD_LEFT) . "_" . str_pad($nro, 3, "0", STR_PAD_LEFT) . "." .  $ext;
               $pas = "fotos"; 
               if (file_exists($pas) == false) {
                    mkdir($pas);
               }
               $cam = $pas . "/" . $nom;
               $ret = move_uploaded_file($arq['tmp_name'][$ind], $cam);
               if ($ret == false) {
                    echo "<script>alert('Erro na cópia do arquivo (" . $ind . ") informado para upload')</script>";
                    $sta = 6; 
               } else {
                    $sql  = "insert into tb_produto_f (";
                    $sql .= "fotstatus, ";
                    $sql .= "fotempresa, ";
                    $sql .= "fotproduto, ";
                    $sql .= "fotsequencia, ";
                    $sql .= "fotnome, ";
                    $sql .= "fotdescricao, ";
                    $sql .= "fottamanho, ";
                    $sql .= "fotextensao, ";
                    $sql .= "keyinc, ";
                    $sql .= "datinc ";
                    $sql .= ") value ( ";
                    $sql .= "'" . $_REQUEST['sta'] . "',";
                    $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
                    $sql .= "'" . $_SESSION['wrkcodreg'] . "',";
                    $sql .= "'" . $nro . "',";
                    $sql .= "'" . $des . "',";
                    $sql .= "'" . $des . "',";
                    $sql .= "'" . round($lim, 3) . "',";    // Em KByte
                    $sql .= "'" . $ext . "',";
                    $sql .= "'" . $_SESSION['wrkideusu'] . "',";
                    $sql .= "'" . date("Y/m/d H:i:s") . "')";
                    $ret = mysqli_query($conexao,$sql);
                    if ($ret == false) {
                         print_r($sql);
                         echo '<script>alert("Erro na gravação do arquivo de foto de produto solicitado !");</script>';
                    }
                    $ret = desconecta_bco();
               }      
          } 
     }   
     return $sta;
 }

 function ultima_cha() {
     $cod = 0;
     include "lerinformacao.inc";
     $com = "Select idfoto, fotstatus, fotsequencia, fotnome from tb_produto_f where fotproduto = " . $_SESSION['wrkcodreg'] . " order by idfoto desc Limit 1";
     $sql = mysqli_query($conexao,$com);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $cod = $lin['fotsequencia'] + 1;
     }
     return $cod;
}

 ?>

</html>
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

     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     <script type="text/javascript" src="js/datepicker-pt-BR.js"></script>

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <script type="text/javascript" src="js/profsa.js"></script>

     <link href="css/pallas35.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Emissão de NF-e e NFC-e - Gold Software Soluções Inteligentes - Profsa Informática Ltda - Pré-Nota</title>
</head>

<script>
$(function() {
     $("#pcd").mask("99,99");
     $("#emi").mask("99/99/9999");
     $("#ent").mask("99/99/9999");
     $("#psl").mask("999.999,999", {
          reverse: true
     });
     $("#psb").mask("999.999,999", {
          reverse: true
     });
     $("#vld").mask("999.999,99", {
          reverse: true
     });
     $("#fre").mask("999.999,99", {
          reverse: true
     });
     $("#seg").mask("999.999,99", {
          reverse: true
     });
     $("#out").mask("999.999,99", {
          reverse: true
     });
     $("#qtdi").mask("999.999", {
          reverse: true
     });
     $("#prei").mask("999.999,99", {
          reverse: true
     });
     $("#emi").datepicker($.datepicker.regional["pt-BR"]);
     $("#ent").datepicker($.datepicker.regional["pt-BR"]);
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
          $topo = $("#box00").offset().top;
          $('html, body').animate({
               scrollTop: $topo
          }, 1500);
     });

     $('#ite').click(function() {
          var des = $('#des').val();
          var par = $('#par').val();
          if (des == 0 || par == 0) {
               alert('Não foi informado para pré-nota o destinatário e/ou parametro fiscal');
          } else {
               var ord = parseInt($('#ordi').val(), 10);
               $.get("buscar-seq.php", function(data) {
                    seq = data;
                    $('#ordi').val(seq);
               });
               $('#seqi').val(ord);
               $('#ite-ped').modal('show');
          }
     });

     $('#codi').blur(function() {
          var des = $('#des').val();
          var par = $('#par').val();
          var cod = $('#codi').val();
          if (cod != "") {
               var qtd = $('#qtdi').val();
               $.getJSON("buscar-pro.php", {
                         des: des,
                         par: par,
                         cod: cod,
                         qtd: qtd
                    })
                    .done(function(data) {
                         if (data.men != "") {
                              alert(data.men);
                              $('#codi').val('');
                              $('#desi').val('');
                              $('#unii').val('');
                              $('#prei').val('');
                              $('#siti').val('');
                              $('#ncmi').val('');
                              $('#bari').val('');
                              $('#cfoi').val('');
                         } else {
                              $('#desi').val(data.cod);
                              $('#unii').val(data.uni);
                              $('#prei').val(data.pre);
                              $('#siti').val(data.sit);
                              $('#ncmi').val(data.ncm);
                              $('#bari').val(data.bar);
                              $('#cfoi').val(data.cfo);
                         }
                    }).fail(function(data) {
                         console.log(data);
                         alert(
                              "Erro ocorrido no processamento do produto para item da pré-nota fiscal"
                              );
                    });
          }
     });

     $('#desi').change(function() {
          var des = $('#des').val();
          var par = $('#par').val();
          var cod = $('#desi').val();
          var qtd = $('#qtdi').val();
          $('#codi').val(cod);
          $.getJSON("buscar-pro.php", {
                    des: des,
                    par: par,
                    cod: cod,
                    qtd: qtd
               })
               .done(function(data) {
                    if (data.men != "") {
                         alert(data.men);
                         $('#codi').val('');
                         $('#desi').val('');
                         $('#unii').val('');
                         $('#prei').val('');
                         $('#siti').val('');
                         $('#ncmi').val('');
                         $('#bari').val('');
                         $('#cfoi').val('');
                    } else {
                         $('#desi').val(data.cod);
                         $('#unii').val(data.uni);
                         $('#prei').val(data.pre);
                         $('#siti').val(data.sit);
                         $('#ncmi').val(data.ncm);
                         $('#bari').val(data.bar);
                         $('#cfoi').val(data.cfo);
                    }
               }).fail(function(data) {
                    console.log(data);
                    alert(
                         "Erro ocorrido no processamento do produto para item da pré-nota fiscal"
                         );
               });
     });

     $('#qtdi').blur(function() {
          var qtd = $('#qtdi').val().replace('.', '');
          if (qtd == '') {
               qtd = 1;
               $('#qtdi').val('1');
          }
          var pre = $('#prei').val().replace('.', '');
          pre = pre.replace(',', '.');
          if (qtd != '' && pre != '') {
               var val = qtd * pre;
               val = val.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               $('#vali').val(val);
          }
     });

     $('#prei').blur(function() {
          var qtd = $('#qtdi').val().replace('.', '');
          var pre = $('#prei').val().replace('.', '');
          pre = pre.replace(',', '.');
          if (qtd != '' && pre != '') {
               var val = qtd * pre;
               val = val.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               $('#vali').val(val);
          }
     });

     $('#gua').click(function() {
          var fix = $('#frmTelMan').serialize();
          var ite = $('#frmIteNot').serialize();
          var dad = fix + "&" + ite;
          $.post("guardar-pro.php", dad, function(data) {
               if (data.men != "") {
                    alert(data.men);
                    return false;
               } else if (data.txt != "") {
                    $('.lis-ite').empty().html(data.txt);
                    $('.val-1').empty().text(data.tot);
                    $('#seqi').val('');
                    $('#codi').val('');
                    $('#desi').val('');
                    $('#unii').val('');
                    $('#qtdi').val('');
                    $('#prei').val('');
                    $('#vali').val('');
                    $('#cfoi').val('');
                    $('#siti').val('');
                    $('#bari').val('');
                    $('#ncmi').val('');
                    $('#opei').val(0);
                    var ord = parseInt($('#ordi').val(),
                         10); // Conversãoo de string para número 10 - decimal
                    ord = ord + 1;
                    $('#seqi').val(ord);
                    $('#ordi').val(ord);
               }
          }, "json");
     });

     $('.item').click(function() {
          var seq = $(this).attr("seq");
          var cod = $(this).attr("ite");
          var ope = $(this).attr("ope");
          $('#opei').val($(this).attr("ope"));
          if (ope == 3) {
               $('#gua').empty().text('Deletar');
          }
          $.getJSON("carrega-ite.php", {
                    ope: ope, cod: cod
               })
               .done(function(data) {
                    if (data.sta == 1) {
                         $('#seqi').val(data.seq);
                         $('#codi').val(data.cod);
                         $('#desi').val(data.cod);
                         $('#unii').val(data.uni);
                         $('#qtdi').val(data.qtd);
                         $('#prei').val(data.pre);
                         $('#siti').val(data.sit);
                         $('#ncmi').val(data.ncm);
                         $('#bari').val(data.bar);
                         $('#cfoi').val(data.cfo);
                         $('#vali').val(data.val);
                    }
               }).fail(function(data) {
                    console.log(data);
                    alert(
                         "Erro ocorrido no carregamento do produto para item da pré-nota fiscal"
                         );
               });

          $('#ite-ped').modal('show');
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
               $ret = gravar_log(10,"Entrada na página de manutenção de pré-notas do sistema Pallas.35 - Gold Solutions");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknumvol']) == false) { $_SESSION['wrknumvol'] = 1; }
     if (isset($_SESSION['wrknumite']) == false) { $_SESSION['wrknumite'] = 0; }
     if (isset($_SESSION['wrknumseq']) == false) { $_SESSION['wrknumseq'] = 0; }
     if (isset($_SESSION['wrknumcha']) == false) { $_SESSION['wrknumcha'] = 0; }
     if (isset($_SESSION['wrkiteped']) == false) { $_SESSION['wrkiteped'] = array(); }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? '' : $_REQUEST['cod']);
     $emi = (isset($_REQUEST['emi']) == false ? date('d/m/Y') : $_REQUEST['emi']);
     $ent = (isset($_REQUEST['ent']) == false ? date('d/m/Y') : $_REQUEST['ent']);
     $sta = (isset($_REQUEST['sta']) == false ? 0 : $_REQUEST['sta']);
     $des = (isset($_REQUEST['des']) == false ? 0 : $_REQUEST['des']);
     $tra = (isset($_REQUEST['tra']) == false ? 0 : $_REQUEST['tra']);
     $par = (isset($_REQUEST['par']) == false ? 0 : $_REQUEST['par']);
     $pag = (isset($_REQUEST['pag']) == false ? 0 : $_REQUEST['pag']);
     $pcd = (isset($_REQUEST['pcd']) == false ? 0 : $_REQUEST['pcd']);
     $vld = (isset($_REQUEST['vld']) == false ? 0 : $_REQUEST['vld']);
     $dan = (isset($_REQUEST['dan']) == false ? 0 : $_REQUEST['dan']);
     $orc = (isset($_REQUEST['orc']) == false ? 0 : $_REQUEST['orc']);
     $qtd = (isset($_REQUEST['qtd']) == false ? '' : $_REQUEST['qtd']);
     $mar = (isset($_REQUEST['mar']) == false ? '' : $_REQUEST['mar']);
     $esp = (isset($_REQUEST['esp']) == false ? '' : $_REQUEST['esp']);
     $nro = (isset($_REQUEST['nro']) == false ? '' : $_REQUEST['nro']);
     $psl = (isset($_REQUEST['psl']) == false ? '' : $_REQUEST['psl']);
     $psb = (isset($_REQUEST['psb']) == false ? '' : $_REQUEST['psb']);
     $fre = (isset($_REQUEST['fre']) == false ? '' : $_REQUEST['fre']);
     $seg = (isset($_REQUEST['seg']) == false ? '' : $_REQUEST['seg']);
     $out = (isset($_REQUEST['out']) == false ? '' : $_REQUEST['out']);
     $proi = (isset($_REQUEST['proi']) == false ? 0 : $_REQUEST['proi']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));
     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
          $_SESSION['wrkmostel'] = 1;
          if (isset($_REQUEST['novo']) == true) {
               $_SESSION['wrkiteped'] = array();
          }
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $per = ' onclick="return confirm(\'Confirma exclusão de pré-nota informado em tela ?\')" ';
     }  
     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; $cod = $_SESSION['wrkcodreg']; $_SESSION['wrkiteped'] = array(); 
               $ret = ler_produto();
               $ret = ler_pedido($cod, $emi, $ent, $sta, $des, $tra, $par, $pag, $pcd, $vld, $dan, $orc, $qtd, $mar, $esp, $nro, $fre, $seg, $out, $psl, $psb, $obs); 
               if ($_SESSION['wrkopereg'] == 5) { 
                    $cod = ultimo_cod(); $sta = 0;
                    $_SESSION['wrkmostel'] = 1;
               }          
          }
     }

     $ret = valor_tot($bru, $tot, $pcd, $vld);

     if (isset($_REQUEST['salvar']) == true) {
          $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
          if ($_SESSION['wrkopereg'] == 1 || $_SESSION['wrkopereg'] == 5) {
               $ret = consiste_ped($tot);
               if ($ret == 0) {
                    $ret = incluir_ped($bru, $tot);
                    $ret = incluir_ite($tot);
                    $_SESSION['wrknumcha'] = $_SESSION['wrkcodreg'];
                    if ($_SESSION['wrkopereg'] == 1) {
                         $ret = gravar_log(11,"Inclusão de nova pré-nota: " . $emi);
                    } else {
                         $ret = gravar_log(11,"Duplicação de nova pré-nota: " . $emi);
                    }
                    $cod = ultimo_cod(); $_SESSION['wrkcodreg'] = $cod; 
                    $emi = ''; $ent = ''; $sta = 0; $des = ''; $tra = 0; $pcd = 0; $vld = 0; $par = 0; $dan = 0; $orc = 0; $qtd = ''; $mar = ''; $esp = ''; $nro = ''; $psb = 0; $psl = 0; $fre = 0; $seg = 0; $out = 0; $obs = '';
               }
          }
          if ($_SESSION['wrkopereg'] == 2) {
               $ret = consiste_ped($tot);
               if ($ret == 0) {
                    $ret = alterar_ped($bru, $tot);
                    $ret = alterar_ite($tot);
                    $_SESSION['wrknumcha'] = $_SESSION['wrkcodreg'];
                    $ret = gravar_log(12,"Alteração de pré-nota existente: " . $emi);  
                    $emi = ''; $ent = ''; $sta = 0; $des = ''; $tra = 0; $pcd = 0; $vld = 0; $par = 0; $dan = 0; $orc = 0; $qtd = ''; $mar = ''; $esp = ''; $nro = ''; $psb = 0; $psl = 0; $fre = 0; $seg = 0; $out = 0; $obs = '';
                    echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
               }
          }
          if ($_SESSION['wrkopereg'] == 3) {
               $ret = excluir_ped();
               $ret = gravar_log(13,"Exclusão de pré-nota existente: " . $emi); 
               $emi = ''; $ent = ''; $sta = 0; $des = ''; $tra = 0; $pcd = 0; $vld = 0; $par = 0; $dan = 0; $orc = 0; $qtd = ''; $mar = ''; $esp = ''; $nro = ''; $psb = 0; $psl = 0; $fre = 0; $seg = 0; $out = 0; $obs = '';
               echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
          }     
     }
?>

<body id="box01">
     <h1 class="cab-0">Pré-Notas - Sistema Gold Software - Emissão de NF-e e NFC-e - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row pedido">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10">
               <div class="qua-5 container">
                    <div class="row lit-3">
                         <div class="col-md-10">
                              <label>Manutenção de Pré-Notas</label>
                         </div>
                         <div class="col-md-1 text-center">
                              <form id="frmEmiDan" name="frmEmiDan" action="emi-danfe.php" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="dan" name="danfe"
                                             title="Abre página para efetuar emissão de Nota Fiscal Eletrônica da pré-nota no sistema"><i
                                                  class="fa fa-paper-plane fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                         <div class="col-md-1 text-center">
                              <form id="frmTelNov" name="frmTelNov" action="man-pedido.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar nova pré-nota (pedido) no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>
                    <form class="tel-1" id="frmTelMan" name="frmTelMan" action="" method="POST">
                         <div class="row">
                              <div class="col-md-2">
                                   <label>Número</label>
                                   <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                                        value="<?php echo $cod; ?>" disabled />
                              </div>
                              <div class="col-md-2"></div>
                              <div class="col-md-2">
                                   <label>Data de Emissão</label>
                                   <input type="text" class="form-control text-center" maxlength="10" id="emi"
                                        name="emi" value="<?php echo $emi; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Data de Entrega</label>
                                   <input type="text" class="form-control text-center" maxlength="10" id="ent"
                                        name="ent" value="<?php echo $ent; ?>" required />
                              </div>
                              <div class="col-md-2"></div>
                              <div class="col-md-2">
                                   <label>Status</label>
                                   <select name="sta" class="form-control">
                                        <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>Em
                                             Aberto
                                        </option>
                                        <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                             Processado</option>
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
                                   <label>Nome do Destinatário</label>
                                   <select id="des" name="des" class="form-control" required>
                                        <?php $ret = carrega_des($des); ?>
                                   </select>
                              </div>
                              <div class="col-md-2 text-center bot-5">
                                   <br />
                                   <a href="man-destino.php?ope=1&cod=0" title="Abre janela para efetuar inclusão de novo destinatário">
                                   <i class="icono izquierda fa fa-building fa-2x" aria-hidden="true"></i>
                                   </a>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-8">
                                   <label>Parâmetro Fiscal</label>
                                   <select id="par" name="par" class="form-control" required>
                                        <?php $ret = carrega_par($par); ?>
                                   </select>
                              </div>
                              <div class="col-md-2 text-center bot-5">
                                   <br />
                                   <a href="man-parametro.php?ope=1&cod=0" title="Abre janela para efetuar inclusão de novo parâmetro fiscal">
                                   <i class="icono izquierda fa fa-cogs fa-2x" aria-hidden="true"></i>
                                   </a>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-8">
                                   <label>Condição de Pagamento</label>
                                   <select id="paga" name="pag" class="form-control" required>
                                        <?php $ret = carrega_pag($pag); ?>
                                   </select>
                              </div>
                              <div class="col-md-2 text-center bot-5">
                              <br />
                                   <a href="man-pagto.php?ope=1&cod=0" title="Abre janela para efetuar inclusão de nova condição de pagamento">
                                   <i class="icono izquierda fa fa-money fa-2x" aria-hidden="true"></i>
                                   </a>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-8">
                                   <label>Nome do Transportador</label>
                                   <select id="tra" name="tra" class="form-control" required>
                                        <?php $ret = carrega_tra($tra); ?>
                                   </select>
                              </div>
                              <div class="col-md-2 text-center bot-5">
                              <br />
                                   <a href="man-transporte.php?ope=1&cod=0" title="Abre janela para efetuar inclusão de nova transportadora">
                                   <i class="icono izquierda fa fa-truck fa-2x" aria-hidden="true"></i>
                                   </a>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-2">
                                   <label>Valor do Frete</label>
                                   <input type="text" class="form-control text-right" maxlength="15" id="fre" name="fre"
                                        value="<?php echo $fre; ?>" />
                              </div>
                              <div class="col-md-1"></div>
                              <div class="col-md-2">
                                   <label>Valor do Seguro</label>
                                   <input type="text" class="form-control text-right" maxlength="15" id="seg" name="seg"
                                        value="<?php echo $seg; ?>" />
                              </div>
                              <div class="col-md-1"></div>
                              <div class="col-md-2">
                                   <label>Outras Despesas</label>
                                   <input type="text" class="form-control text-right" maxlength="15" id="out" name="out"
                                        value="<?php echo $out; ?>" />
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-2">
                                   <label>Quantidade</label>
                                   <input type="text" class="form-control text-left" maxlength="15" id="qtd" name="qtd"
                                        value="<?php echo $qtd; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>Marca</label>
                                   <input type="text" class="form-control text-left" maxlength="15" id="mar" name="mar"
                                        value="<?php echo $mar; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>Espécie</label>
                                   <input type="text" class="form-control text-left" maxlength="15" id="esp" name="esp"
                                        value="<?php echo $esp; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>Número</label>
                                   <input type="text" class="form-control text-left" maxlength="15" id="nro" name="nro"
                                        value="<?php echo $nro; ?>" />
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-2">
                                   <label>Peso Liquido</label>
                                   <input type="text" class="form-control text-right" maxlength="15" id="psl" name="psl"
                                        value="<?php echo $psl; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>Peso Bruto</label>
                                   <input type="text" class="form-control text-right" maxlength="15" id="psb" name="psb"
                                        value="<?php echo $psb; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>Desconto - %</label>
                                   <input type="text" class="form-control text-right" maxlength="6" id="pcd" name="pcd"
                                        value="<?php echo $pcd; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>Desconto - R$</label>
                                   <input type="text" class="form-control text-right" maxlength="10" id="vld" name="vld"
                                        value="<?php echo $vld; ?>" />
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <div class="row">
                              <div class="col-md-2 text-center">
                                   <label>Valor</label>
                                   <div class="val-1"> <?php if ($tot != 0) {echo 'R$ ' . number_format($tot, 2, ',', '.'); } ?> </div>
                              </div>
                              <div class="col-md-8">
                                   <label for="obs">Observação / Mensagem</label>
                                   <textarea class="form-control" rows="5" id="obs"
                                        name="obs"><?php echo $obs ?></textarea>
                              </div>
                              <div class="che-1 col-md-2 text-center">
                                   <span>Mensagem para Danfe</span> &nbsp;
                                   <input type="checkbox" id="dan" name="dan" value="1"
                                        <?php echo ($dan == 0 ? '': 'checked' ) ?> />
                              </div>
                         </div>
                         <br />
                         <div class="row">
                              <div class="col-md-3"></div>
                              <div class="col-md-6 text-center">
                                   <button type="submit" id="env" name="salvar" <?php echo $per; ?>
                                        class="bot-1"><?php echo $bot; ?></button>
                              </div>
                              <div class="col-md-2 text-center"></div>
                              <div class="col-md-1 text-center">
                                   <button type="button" class="bot-3" id="ite" name="item"
                                        title="Mostra janela para informar dados dos itens para pré-nota fiscal"><i
                                             class="fa fa-indent fa-2x" aria-hidden="true"></i></button>
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
                         <div class="row lis-ite">
                              <div class="tab-1 table-responsive-md">
                                   <table id="tab-0" class="table table-sm table-striped tab-2">
                                        <thead>
                                             <tr>
                                                  <th>Alterar</th>
                                                  <th>Excluir</th>
                                                  <th>Ordem</th>
                                                  <th>Código</th>
                                                  <th>Descrição do Produto</th>
                                                  <th>U. M.</th>
                                                  <th>S. T.</th>
                                                  <th>C.F.O.P.</th>
                                                  <th>N.C.M.</th>
                                                  <th>Barras</th>
                                                  <th>Quantidade</th>
                                                  <th>Preço Unitário</th>
                                                  <th>Valor do Item</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php $ret = carrega_ite();  ?>
                                        </tbody>
                                   </table>
                              </div>
                         </div>
                         <br />

                    </form>
               </div>
          </div>
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>

     <!-- Janela Modal com dados detalhados do título e pede campos para atualizar -->
     <div class="modal fade" id="ite-ped" tabindex="-1" role="dialog" aria-labelledby="tel-det" aria-hidden="true"
          data-backdrop="static">
          <div class="modal-dialog modal-lg" role="document">
               <!-- modal-sm lg xl -->
               <form id="frmIteNot" name="frmIteNot" action="" method="POST">
                    <div class="modal-content">
                         <div class="modal-header">
                              <h5 class="modal-title" id="tel-det">Item da Pré-Nota Fiscal</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                   <span aria-hidden="true">&times;</span>
                              </button>
                         </div>
                         <div class="modal-body">
                              <div class="form-row text-center">
                                   <div class="col-md-4"></div>
                                   <div class="col-md-4">
                                        <label>Sequência</label>
                                        <input type="text" class="form-control text-center" maxlength="3" id="seqi"
                                             name="seqi" value="" disabled />
                                   </div>
                                   <div class="col-md-4"></div>
                              </div>
                              <div class="form-row text-center">
                                   <div class="col-md-4"></div>
                                   <div class="col-md-4">
                                        <label>Código do Produto</label>
                                        <input type="text" class="form-control text-center" maxlength="15" id="codi"
                                             name="codi" value="" required />
                                   </div>
                                   <div class="col-md-4"></div>
                              </div>
                              <div class="form-row">
                                   <div class="col-md-12">
                                        <label>Descrição do Produto</label>
                                        <select id="desi" name="desi" class="form-control" required>
                                             <?php $ret = carrega_pro($proi); ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="form-row">
                                   <div class="col-md-5"></div>
                                   <div class="col-md-2">
                                        <label>Unidade Medida</label>
                                        <input type="text" class="form-control text-center" maxlength="5" id="unii"
                                             name="unii" value="" required />
                                   </div>
                                   <div class="col-md-5"></div>
                              </div>
                              <div class="form-row">
                                   <div class="col-md-4">
                                        <label>Quantidade</label>
                                        <input type="text" class="qtd form-control text-right" maxlength="9" id="qtdi"
                                             name="qtdi" value="" required />
                                   </div>
                                   <div class="col-md-4">
                                        <label>Preço</label>
                                        <input type="text" class="val form-control text-right" maxlength="9" id="prei"
                                             name="prei" value="" required />
                                   </div>
                                   <div class="col-md-4">
                                        <label>Valor</label>
                                        <input type="text" class="form-control text-center" maxlength="9" id="vali"
                                             name="vali" value="" disabled />
                                   </div>
                              </div>
                              <div class="form-row">
                                   <div class="col-md-3">
                                        <label>C.f.o.p.</label>
                                        <input type="text" class="form-control text-center" maxlength="4" id="cfoi"
                                             name="cfoi" value="" />
                                   </div>
                                   <div class="col-md-3">
                                        <label>Situação Tributária</label>
                                        <input type="text" class="form-control text-center" maxlength="4" id="siti"
                                             name="siti" value="" />
                                   </div>
                                   <div class="col-md-3">
                                        <label>N.C.M.</label>
                                        <input type="text" class="form-control text-center" maxlength="8" id="ncmi"
                                             name="ncmi" value="" />
                                   </div>
                                   <div class="col-md-3">
                                        <label>Barras</label>
                                        <input type="text" class="form-control text-center" maxlength="13" id="bari"
                                             name="bari" value="" />
                                   </div>
                              </div>
                              <div class="form-row">
                                   <div class="col-md-5"></div>
                                   <div class="col-md-2 text-center">
                                        <br />
                                        <div class="val-1"> <?php if ($tot != 0) {echo 'R$ ' . number_format($tot, 2, ',', '.'); } ?> </div>
                                   </div>
                                   <div class="col-md-5"></div>
                              </div>
                              <input type="hidden" id="opei" name="opei" value="0">
                              <input type="hidden" id="ordi" name="ordi" value="<?php echo $_SESSION['wrknumseq'] + 1; ?>">
                         </div>
                         <div class="modal-footer">
                              <button type="button" id="gua" name="guardar"
                                   class="btn btn-outline-success">Salvar</button>
                              <button type="button" id="fec" name="fechar" class="btn btn-outline-danger"
                                   data-dismiss="modal">Fechar</button>
                         </div>
                    </div>
               </form>

          </div>
     </div>
     <!------------------------------------------------------------------------------------------------------------------->

</body>
<?php
function ultimo_cod() {
     $cod = 1;
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select idpedido, pedemissao from tb_pedido order by idpedido desc Limit 1");
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $cod = $lin['idpedido'] + 1;
     }
     return $cod;
}

function carrega_des($des) {
     $sta = 0;
     include "lerinformacao.inc";    
    $com = "Select iddestino, desrazao from tb_destino where desstatus = 0 and desempresa = " . $_SESSION['wrkcodemp'] . " order by desrazao";
    $sql = mysqli_query($conexao, $com);
    if ($des == 0) {
         echo '<option value="0" selected="selected">Selecione nome do destinatário desejado ...</option>';
     }
    while ($reg = mysqli_fetch_assoc($sql)) {        
         if ($reg['iddestino'] != $des) {
              echo  '<option value ="' . $reg['iddestino'] . '">' . $reg['desrazao'] . '</option>'; 
          }else{
              echo  '<option value ="' . $reg['iddestino'] . '" selected="selected">' . $reg['desrazao'] . '</option>';
          }
   }
     return $sta;
}

function carrega_par($par) {
     $sta = 0;
     include "lerinformacao.inc";    
     $com = "Select idparametro, parnome from tb_parametro where parstatus = 0 and parempresa = " . $_SESSION['wrkcodemp'] . " order by parnome";
     $sql = mysqli_query($conexao, $com);
     if ($par == 0) {
          echo '<option value="0" selected="selected">Selecione parâmetro fiscal desejado ...</option>';
     }
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['idparametro'] != $par) {
               echo  '<option value ="' . $reg['idparametro'] . '">' . $reg['parnome'] . '</option>'; 
          }else{
               echo  '<option value ="' . $reg['idparametro'] . '" selected="selected">' . $reg['parnome'] . '</option>';
          }
     }
     return $sta;
}

function carrega_pag($pag) {
     $sta = 0;
     include "lerinformacao.inc";    
     $com = "Select idpagto, pagdescricao from tb_pagto where pagstatus = 0  and pagempresa = " . $_SESSION['wrkcodemp'] . " and pagcaixa in (0, 1) order by pagdescricao";
     $sql = mysqli_query($conexao, $com);
     if ($pag == 0) {
          echo '<option value="0" selected="selected">Selecione condição de pagamento desejado ...</option>';
     }
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['idpagto'] != $pag) {
               echo  '<option value ="' . $reg['idpagto'] . '">' . $reg['pagdescricao'] . '</option>'; 
          }else{
               echo  '<option value ="' . $reg['idpagto'] . '" selected="selected">' . $reg['pagdescricao'] . '</option>';
          }
     }
     return $sta;
}

function carrega_tra($tra) {
     $sta = 0;
     include "lerinformacao.inc";    
     $com = "Select idtransporte, trarazao from tb_transporte where trastatus = 0 and traempresa = " . $_SESSION['wrkcodemp'] . " order by trarazao";
     $sql = mysqli_query($conexao, $com);
     echo '<option value="0" selected="selected">Selecione transportador desejado ...</option>';
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['idtransporte'] != $tra) {
               echo  '<option value ="' . $reg['idtransporte'] . '">' . $reg['trarazao'] . '</option>'; 
          }else{
               echo  '<option value ="' . $reg['idtransporte'] . '" selected="selected">' . $reg['trarazao'] . '</option>';
          }
     }
     return $sta;
}

function carrega_pro($pro) {
     $sta = 0;
     include "lerinformacao.inc";    
     $com = "Select idproduto, prodescricao from tb_produto where prostatus = 0 and proempresa = " . $_SESSION['wrkcodemp'] . " order by prodescricao";
     $sql = mysqli_query($conexao, $com);
     echo '<option value="0" selected="selected">Selecione produto desejado ...</option>';
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['idproduto'] != $pro) {
               echo  '<option value ="' . $reg['idproduto'] . '">' . $reg['prodescricao'] . '</option>'; 
          }else{
               echo  '<option value ="' . $reg['idproduto'] . '" selected="selected">' . $reg['prodescricao'] . '</option>';
          }
     }
     return $sta;
}

function carrega_ite() {
     $sta = 0;
     if (isset($_SESSION['wrkiteped']['cod']) == true && isset($_SESSION['wrkiteped']['des']) == true) {         
          $nro = count($_SESSION['wrkiteped']['cod']);
          for ($ind = 0; $ind < $nro; $ind++) {
               if ($_SESSION['wrkiteped']['cod'][$ind] != 0) {
                    $txt  = '<tr>';
                    $txt .= '<td class="bot-3 text-center"><div class="item" ope="2" seq="' . $ind . '" ite="' . $_SESSION['wrkiteped']['cod'][$ind] . '" ><i class="large material-icons" title="Abre janela modal para efetuar alteração de item solicitado">healing</i></td>';
                    $txt .= '<td class="lit-d bot-3 text-center"><div class="item" ope="3" seq="' . $ind . '" ite="' . $_SESSION['wrkiteped']['cod'][$ind] . '" ><i class="large material-icons" title="Abre janela modal para efetuar exclusão de item solicitado">delete_forever</i></a></td>';      
                    $txt .= '<td>' . ($_SESSION['wrkiteped']['seq'][$ind] + 1) . '</td>';
                    $txt .= '<td>' . $_SESSION['wrkiteped']['cod'][$ind] . '</td>';
                    $txt .= '<td>' . $_SESSION['wrkiteped']['des'][$ind] . '</td>';
                    $txt .= '<td>' . $_SESSION['wrkiteped']['med'][$ind] . '</td>';
                    $txt .= '<td>' . $_SESSION['wrkiteped']['sit'][$ind] . '</td>';
                    $txt .= '<td>' . $_SESSION['wrkiteped']['cfo'][$ind] . '</td>';
                    $txt .= '<td>' . $_SESSION['wrkiteped']['ncm'][$ind] . '</td>';
                    $txt .= '<td>' . $_SESSION['wrkiteped']['bar'][$ind] . '</td>';
                    $txt .= '<td class="text-center">' . number_format($_SESSION['wrkiteped']['qtd'][$ind], 0, ',', '.') . '</td>';
                    $txt .= '<td class="text-center">' . number_format($_SESSION['wrkiteped']['uni'][$ind], 2, ',', '.') . '</td>';
                    $txt .= '<td class="text-center">' . number_format($_SESSION['wrkiteped']['val'][$ind], 2, ',', '.') . '</td>';
                    $txt .= '</tr>';
                    echo $txt;
               }
          }
     }    
     return $sta;
}

function consiste_ped($tot) {
     $sta = 0;
     if (trim($_REQUEST['emi']) == "") {
         echo '<script>alert("Data de emissão do pedido não pode estar em branco");</script>';
         return 1;
     }
     if (trim($_REQUEST['ent']) == "") {
          echo '<script>alert("Data de entrega do pedido não pode estar em branco");</script>';
          return 3;
     }
     if ($tot == 0) {
          echo '<script>alert("Somatória de valores de itens não pode ser igual a zero");</script>';
          return 3;
     }
     if (trim($_REQUEST['des']) == "" || trim($_REQUEST['des']) == "0") {
          echo '<script>alert("Destinatário para a emissão da Danfe não pode estar em branco");</script>';
          return 3;
     }
     if (trim($_REQUEST['par']) == "" || trim($_REQUEST['par']) == "0") {
          echo '<script>alert("Parâmetro Fiscal para a Danfe não pode estar em branco");</script>';
          return 3;
     }
     if ($_REQUEST['emi'] != "") {
          if (valida_dat($_REQUEST['emi']) != 0) {
               echo '<script>alert("Data de emissão da pré-nota informada não é valida");</script>';
               return 4;
          }
     }
     if ($_REQUEST['ent'] != "") {
          if (valida_dat($_REQUEST['ent']) != 0) {
               echo '<script>alert("Data de entrega da pré-nota informada não é valida");</script>';
               return 4;
          }
     }
     if ($_REQUEST['emi'] != "" && $_REQUEST['ent'] != "") {
          $emi = inverte_dat($_REQUEST['emi']);
          $ent = inverte_dat($_REQUEST['ent']);
          if ($emi > $ent) {
               echo '<script>alert("Data de emissão não pode ser maior que data de entrega");</script>';
               return 4; 
          }
     }
     if (trim($_REQUEST['vld']) > $tot) {
          echo '<script>alert("Valor do Desconto não pode ser maior que valor total do pedido");</script>';
          return 4;
     }
     if (strlen($_REQUEST['obs']) > 500) {
          echo '<script>alert("Observação do Pedido não pode ter mais de 500 caracteres");</script>';
          $sta = 1;
     }        
     return $sta;
 }

 function incluir_ped($bru, $tot) {
     $ret = 0;
     $emi = inverte_dat($_REQUEST['emi']); $emi = str_replace("/", "-", $emi);
     $ent = inverte_dat($_REQUEST['ent']); $ent = str_replace("/", "-", $ent);
     $vld = str_replace(".", "", $_REQUEST['vld']); $vld = str_replace(",", ".", $vld);
     $pcd = str_replace(".", "", $_REQUEST['pcd']); $pcd = str_replace(",", ".", $pcd);
     $fre = str_replace(".", "", $_REQUEST['fre']); $fre = str_replace(",", ".", $fre);
     $seg = str_replace(".", "", $_REQUEST['seg']); $seg = str_replace(",", ".", $seg);
     $out = str_replace(".", "", $_REQUEST['out']); $out = str_replace(",", ".", $out);
     $psl = str_replace(".", "", $_REQUEST['psl']); $psl = str_replace(",", ".", $psl);
     $psb = str_replace(".", "", $_REQUEST['psb']); $psb = str_replace(",", ".", $psb);
     include "lerinformacao.inc";
     $sql  = "insert into tb_pedido (";
     $sql .= "pedempresa, ";
     $sql .= "pedstatus, ";
     $sql .= "pedemissao, ";
     $sql .= "pedentrega, ";
     $sql .= "peddestino, ";
     $sql .= "pedtransporte, ";
     $sql .= "pedparametro, ";
     $sql .= "pedpagto, ";
     $sql .= "pedpordesconto, ";
     $sql .= "pedvaldesconto, ";
     $sql .= "pedvalorbru, ";
     $sql .= "pedvalorliq, ";
     $sql .= "pedfrete, ";
     $sql .= "pedseguro, ";
     $sql .= "pedoutras, ";
     $sql .= "pedopcorcamento, ";
     $sql .= "pedqtde, ";
     $sql .= "pedmarca, ";
     $sql .= "pedespecie, ";
     $sql .= "pednumero, ";
     $sql .= "pedpesoliq, ";
     $sql .= "pedpesobru, ";
     $sql .= "pedopcdanfe, ";
     $sql .= "pedobservacao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= " " . ($emi == "" || $emi == "--" ? 'null' : "'" . $emi . "'") . ",";
     $sql .= " " . ($ent == "" || $ent == "--" ? 'null' : "'" . $ent . "'") . ",";
     $sql .= "'" . $_REQUEST['des'] . "',";
     $sql .= "'" . $_REQUEST['tra'] . "',";
     $sql .= "'" . $_REQUEST['par'] . "',";
     $sql .= "'" . $_REQUEST['pag'] . "',";
     $sql .= "'" . ($pcd == "" ? '0' : $pcd) . "',";
     $sql .= "'" . ($vld == "" ? '0' : $vld) . "',";
     $sql .= "'" . $bru . "',";
     $sql .= "'" . $tot . "',";
     $sql .= "'" . ($fre == "" ? '0' : $fre) . "',";
     $sql .= "'" . ($seg == "" ? '0' : $seg) . "',";
     $sql .= "'" . ($out == "" ? '0' : $out) . "',";
     $sql .= "'" . '0' . "',";
     $sql .= "'" . trim($_REQUEST['qtd']) . "',";
     $sql .= "'" . $_REQUEST['mar'] . "',";
     $sql .= "'" . $_REQUEST['esp'] . "',";
     $sql .= "'" . $_REQUEST['nro'] . "',";
     $sql .= "'" . ($psl == "" ? '0' : $psl) . "',";
     $sql .= "'" . ($psb == "" ? '0' : $psb) . "',";
     $sql .= "'" . (isset($_REQUEST['dan']) == false ? 0 : 1 ) . "',";
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
 function alterar_ped($bru, $tot) {
     $ret = 0;
     $emi = inverte_dat($_REQUEST['emi']); $emi = str_replace("/", "-", $emi);
     $ent = inverte_dat($_REQUEST['ent']); $ent = str_replace("/", "-", $ent);
     $vld = str_replace(".", "", $_REQUEST['vld']); $vld = str_replace(",", ".", $vld);
     $pcd = str_replace(".", "", $_REQUEST['pcd']); $pcd = str_replace(",", ".", $pcd);
     $fre = str_replace(".", "", $_REQUEST['fre']); $fre = str_replace(",", ".", $fre);
     $seg = str_replace(".", "", $_REQUEST['seg']); $seg = str_replace(",", ".", $seg);
     $out = str_replace(".", "", $_REQUEST['out']); $out = str_replace(",", ".", $out);
     $psl = str_replace(".", "", $_REQUEST['psl']); $psl = str_replace(",", ".", $psl);
     $psb = str_replace(".", "", $_REQUEST['psb']); $psb = str_replace(",", ".", $psb);
     include "lerinformacao.inc";
     $sql  = "update tb_pedido set ";
     $sql .= "pedstatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "pedemissao = ". ($emi == "" || $emi == "--" ? 'null' : "'" . $emi . "'") . ", ";
     $sql .= "pedentrega = ". ($ent == "" || $ent == "--" ? 'null' : "'" . $ent . "'") . ", ";
     $sql .= "peddestino = '". $_REQUEST['des'] . "', ";
     $sql .= "pedtransporte = '". $_REQUEST['tra'] . "', ";
     $sql .= "pedpagto = '". $_REQUEST['pag'] . "', ";
     $sql .= "pedparametro = '". $_REQUEST['par'] . "', ";
     $sql .= "pedpordesconto = '". ($pcd == "" ? '0' : $pcd) . "', ";
     $sql .= "pedvaldesconto = '". ($vld == "" ? '0' : $vld) . "', ";
     $sql .= "pedvalorbru = '". $bru . "', ";
     $sql .= "pedvalorliq = '". $tot . "', ";
     $sql .= "pedfrete = '". ($fre == "" ? '0' : $fre) . "', ";
     $sql .= "pedseguro = '". ($seg == "" ? '0' : $seg) . "', ";
     $sql .= "pedoutras = '". ($out == "" ? '0' : $out) . "', ";
     $sql .= "pedopcorcamento = '". '0' . "', ";
     $sql .= "pedqtde = '". trim($_REQUEST['qtd']) . "', ";
     $sql .= "pedmarca = '". $_REQUEST['mar'] . "', ";
     $sql .= "pedespecie = '". $_REQUEST['esp'] . "', ";
     $sql .= "pednumero = '". $_REQUEST['nro'] . "', ";
     $sql .= "pedpesoliq = '". ($psl == "" ? '0' : $psl) . "', ";
     $sql .= "pedpesobru =  '". ($psb == "" ? '0' : $psb) . "', ";
     $sql .= "pedopcdanfe = '". (isset($_REQUEST['dan']) == false ? 0 : 1 ) . "', ";
     $sql .= "pedobservacao = '". $_REQUEST['obs'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idpedido = " . $_SESSION['wrkcodreg'];
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

 function excluir_ped() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "delete from tb_pedido_i where itepedido = " . $_SESSION['wrkcodreg'] ;
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na exclusão dos produtos do pedido !");</script>';
     }
     $sql  = "delete from tb_pedido where idpedido = " . $_SESSION['wrkcodreg'] ;
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

 function ler_pedido(&$cha, &$emi, &$ent, &$sta, &$des, &$tra, &$par, &$pag, &$pcd, &$vld, &$dan, &$orc, &$qtd, &$mar, &$esp, &$nro, &$fre, &$seg, &$out, &$psl, &$psb, &$obs) {
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select * from tb_pedido where idpedido = " . $cha);
     if (mysqli_num_rows($sql) == 0) {
         echo '<script>alert("Número do Pedido informado não cadastrado");</script>';
         $nro = 1;
     }else{
         $lin = mysqli_fetch_array($sql);
         $cha = $lin['idpedido'];
         $emi = date('d/m/Y',strtotime($lin['pedemissao'])); 
         $ent = date('d/m/Y',strtotime($lin['pedentrega'])); 
         $sta = $lin['pedstatus'];
         $des = $lin['peddestino'];
         $tra = $lin['pedtransporte'];
         $par = $lin['pedparametro'];
         $pag = $lin['pedpagto'];
         $pcd = str_replace(".",",",$lin['pedpordesconto']);
         $vld = str_replace(".",",",$lin['pedvaldesconto']);
         $fre = str_replace(".",",",$lin['pedfrete']);
         $seg = str_replace(".",",",$lin['pedseguro']);
         $out = str_replace(".",",",$lin['pedoutras']);
         $psl = str_replace(".",",",$lin['pedpesoliq']);
         $psb = str_replace(".",",",$lin['pedpesobru']);
         $dan = $lin['pedopcdanfe'];
         $orc = $lin['pedopcorcamento'];
         $qtd = $lin['pedqtde'];
         $mar = $lin['pedmarca'];
         $esp = $lin['pedespecie'];
         $nro = $lin['pednumero'];
         $obs = $lin['pedobservacao'];
         $_SESSION['wrknumcha'] = $lin['idpedido'];
     }
     return $cha;
 }

 function valor_tot(&$bru, &$liq, $pcd, $vld) {
     $liq = 0;
     $nro = 0;
     $pcd = str_replace(".", "", $pcd); $pcd = str_replace(",", ".", $pcd);
     $vld = str_replace(".", "", $vld); $vld = str_replace(",", ".", $vld);
     if (isset($_SESSION['wrkiteped']['cod']) == true) {         
          $nro = count($_SESSION['wrkiteped']['cod']);
          for ($ind = 0; $ind < $nro; $ind++) {
               if ($_SESSION['wrkiteped']['sta'][$ind] != 3) {
                    $liq = $liq + $_SESSION['wrkiteped']['val'][$ind];
               }
          }
     } 
     $bru = $liq;
     $des = $liq * ($pcd / 100);
     $liq = round($liq - $des - $vld, 4);
     return $nro;
}

function incluir_ite($tot) {
     $ret = 0;
     include "lerinformacao.inc";
     $nro = count($_SESSION['wrkiteped']['cod']);
     for ($ind = 0; $ind < $nro; $ind++) {
          if ($_SESSION['wrkiteped']['cod'][$ind] != 0 && $_SESSION['wrkiteped']['sta'][$ind] != 3) {
               $sql  = "insert into tb_pedido_i (";
               $sql .= "iteempresa, ";
               $sql .= "itepedido, ";
               $sql .= "itestatus, ";
               $sql .= "itesequencia, ";
               $sql .= "iteproduto, ";
               $sql .= "itedescricao, ";
               $sql .= "itemedida, ";
               $sql .= "itequantidade, ";
               $sql .= "itepreco, ";
               $sql .= "itenumerocfo, ";
               $sql .= "iteporipi, ";
               $sql .= "iteporicms, ";
               $sql .= "keyinc, ";
               $sql .= "datinc ";
               $sql .= ") value ( ";
               $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
               $sql .= "'" . $_SESSION['wrkcodreg'] . "',";
               $sql .= "'" . $_SESSION['wrkiteped']['sta'][$ind] . "',";     
               $sql .= "'" . $_SESSION['wrkiteped']['seq'][$ind] . "',";     
               $sql .= "'" . $_SESSION['wrkiteped']['cod'][$ind] . "',";     
               $sql .= "'" . $_SESSION['wrkiteped']['des'][$ind] . "',";
               $sql .= "'" . $_SESSION['wrkiteped']['med'][$ind] . "',";
               $sql .= "'" . $_SESSION['wrkiteped']['qtd'][$ind]. "',";
               $sql .= "'" . $_SESSION['wrkiteped']['uni'][$ind] . "',";
               $sql .= "'" . $_SESSION['wrkiteped']['cfo'][$ind] . "',";
               $sql .= "'" . '0' . "',";
               $sql .= "'" . '0'   .  "',";
               $sql .= "'" . $_SESSION['wrkideusu'] . "',";
               $sql .= "'" . date("Y/m/d H:i:s") . "')";
               $ret = mysqli_query($conexao,$sql);
               if ($ret == false) {
                    print_r($sql);
                    echo '<script>alert("Erro na gravação do item do pedido de venda !");</script>';
               }
          }
     }
     return $ret;
 }

 function alterar_ite($tot) {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "delete from tb_pedido_i where itepedido = " . $_SESSION['wrkcodreg'] ;
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na exclusão do item de pedido solicitado no sistema !!");</script>';
     }
     $nro = count($_SESSION['wrkiteped']['cod']);
     for ($ind = 0; $ind < $nro; $ind++) {
          if ($_SESSION['wrkiteped']['cod'][$ind] != 0 && $_SESSION['wrkiteped']['sta'][$ind] != 3) {
               $sql  = "insert into tb_pedido_i (";
               $sql .= "iteempresa, ";
               $sql .= "itepedido, ";
               $sql .= "itesequencia, ";
               $sql .= "itestatus, ";
               $sql .= "iteproduto, ";
               $sql .= "itedescricao, ";
               $sql .= "itemedida, ";
               $sql .= "itequantidade, ";
               $sql .= "itepreco, ";
               $sql .= "itenumerocfo, ";
               $sql .= "iteporipi, ";
               $sql .= "iteporicms, ";
               $sql .= "keyinc, ";
               $sql .= "datinc, ";
               $sql .= "keyalt, ";
               $sql .= "datalt ";
               $sql .= ") value ( ";
               $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
               $sql .= "'" . $_SESSION['wrkcodreg'] . "',";
               $sql .= "'" . $_SESSION['wrkiteped']['seq'][$ind] . "',";     
               $sql .= "'" . '1' . "',";
               $sql .= "'" . $_SESSION['wrkiteped']['cod'][$ind] . "',";     
               $sql .= "'" . $_SESSION['wrkiteped']['des'][$ind] . "',";
               $sql .= "'" . $_SESSION['wrkiteped']['med'][$ind] . "',";
               $sql .= "'" . $_SESSION['wrkiteped']['qtd'][$ind]. "',";
               $sql .= "'" . $_SESSION['wrkiteped']['uni'][$ind] . "',";
               $sql .= "'" . numero_cfo($_SESSION['wrkcodemp'], $_REQUEST['des'], $_REQUEST['par']) . "',";
               $sql .= "'" . '0' . "',";
               $sql .= "'" . '0'   .  "',";
               $sql .= "'" . $_SESSION['wrkiteped']['usu'][$ind] . "',";
               $sql .= "'" . $_SESSION['wrkiteped']['dat'][$ind] . "',";
               $sql .= "'" . $_SESSION['wrkideusu'] . "',";
               $sql .= "'" . date("Y/m/d H:i:s") . "')";
               $ret = mysqli_query($conexao,$sql);
               if ($ret == false) {
                    print_r($sql);
                    echo '<script>alert("Erro na regravação do item do pedido de venda !");</script>';
               }
          }
     }
     return $ret;
 }

 function ler_produto() {
     $sta = 0;
     include "lerinformacao.inc";
     $com  = "Select I.*, P.prosittributaria, P.pronumeroncm, P.procodbarras from (tb_pedido_i I left join tb_produto P on I.iteproduto = P.idproduto) where itepedido = " . $_SESSION['wrkcodreg'] . " order by iditem";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $_SESSION['wrkiteped']['seq'][] = $reg['itesequencia'];
          $_SESSION['wrkiteped']['sta'][] = $reg['itestatus'];
          $_SESSION['wrkiteped']['cod'][] = $reg['iteproduto'];
          $_SESSION['wrkiteped']['des'][] = $reg['itedescricao'];
          $_SESSION['wrkiteped']['med'][] = $reg['itemedida'];
          $_SESSION['wrkiteped']['qtd'][] = number_format($reg['itequantidade'], 0, ',', '.');
          $_SESSION['wrkiteped']['pre'][] = number_format($reg['itepreco'], 2, ',', '.');
          $_SESSION['wrkiteped']['uni'][] = $reg['itepreco'];
          $_SESSION['wrkiteped']['bru'][] = $reg['itepreco'];
          $_SESSION['wrkiteped']['liq'][] = $reg['itepreco'];
          $_SESSION['wrkiteped']['val'][] = $reg['itequantidade'] * $reg['itepreco'];
          $_SESSION['wrkiteped']['sit'][] = $reg['prosittributaria'];
          $_SESSION['wrkiteped']['ncm'][] = $reg['pronumeroncm'];
          $_SESSION['wrkiteped']['bar'][] = $reg['procodbarras'];
          $_SESSION['wrkiteped']['cfo'][] = $reg['itenumerocfo'];
          $_SESSION['wrkiteped']['usu'][] = $reg['keyinc'];
          $_SESSION['wrkiteped']['dat'][] = $reg['datinc'];
     }    
     return $sta;
}
?>

</html>
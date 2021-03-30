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
     $("#nro").mask("999.999.999", {
          reverse: true
     });
     $("#cgc").mask("00.000.000/0000-00");
     $("#cep").mask("00000-000");
     $("#num").mask("999.999", {
          reverse: true
     });
});

$(document).ready(function() {
     if ($('#pes').prop("checked") == false) {
          $('#doc_c').text('Número do C.p.f.');
          $('#doc_i').text('Registro Geral (R.G.)');
          $("#cgc").mask("000.000.000-00");
     } else {
          $('#doc_c').text('Número do C.n.p.j.');
          $('#doc_i').text('Inscrição Estadual');
          $("#cgc").mask("00.000.000/0000-00");
     }

     $('#ins').blur(function() {
          var ins = $('#ins').val();
          if (ins == "") {
               $('#ins').val('ISENTO');
          }
     });

     $('#pes').click(function() {
          if ($('#pes').prop("checked") == false) {
               $('#doc_c').text('Número do C.p.f.');
               $('#doc_i').text('Registro Geral (R.G.)');
               $("#cgc").mask("000.000.000-00");
          } else {
               $('#doc_c').text('Número do C.n.p.j.');
               $('#doc_i').text('Inscrição Estadual');
               $("#cgc").mask("00.000.000/0000-00");
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
          $topo = $("#box01").offset().top;
          $('html, body').animate({
               scrollTop: $topo
          }, 1500);
     });

     $('#cep').blur(function() {
          var cep = $('#cep').val();
          var cep = cep.replace(/[^0-9]/g, '');
          if (cep != '') {
               var url = '//viacep.com.br/ws/' + cep + '/json/';
               $.getJSON(url, function(data) {
                    if ("error" in data) {
                         return;
                    }
                    if ($('#end').val() == "") {
                         $('#end').val(data.logradouro.substring(0, 50));
                    }
                    if ($('#cep').val() == "" || $('#cep').val() == "-") {
                         $('#cep').val(data.cep.replace('.', ''));
                    }
                    if ($('#bai').val() == "") {
                         $('#bai').val(data.bairro.substring(0, 50));
                    }
                    if ($('#cid').val() == "") {
                         $('#cid').val(data.localidade);
                    }
                    if ($('#est').val() == "") {
                         $('#est').val(data.uf);
                    }
               });
          }
     });

     $('#cgc').blur(function() {
          var cgc = $('#cgc').val();
          var ins = $('#ins').val();
          var cgc = cgc.replace(/[^0-9]/g, '');
          if (cgc != '') {

               $.getJSON("carrega-cgc.php", { cgc: cgc })
               .done(function(data) {
                    if (data.sta == "111") {
                         $('#ins').val(data.ins);
                    }
               }).fail(function(data){
                    console.log('Erro: ' + JSON.stringify(data));                    
                    alert("Erro ocorrido no processamento do acesso ao Cnpj por webservice");
               });

               $.ajax({
                    url: 'https://www.receitaws.com.br/v1/cnpj/' + cgc,
                    type: 'POST',
                    dataType: 'jsonp',
                    data: cgc,
                    success: function(data) {
                         if (data.nome != "") {
                              if ($('#raz').val() == "") {
                                   $('#raz').val(data.nome.substring(0, 75));
                              }
                              if ($('#fan').val() == "") {
                                   $('#fan').val(data.fantasia.substring(0, 50));
                              }
                              if ($('#end').val() == "") {
                                   $('#end').val(data.logradouro.substring(0, 50));
                              }
                              if ($('#num').val() == "" || $('#num').val() == ".") {
                                   $('#num').val(data.numero);
                              }
                              if ($('#cep').val() == "" || $('#cep').val() == "-") {
                                   $('#cep').val(data.cep.replace('.', ''));
                              }
                              if ($('#bai').val() == "") {
                                   $('#bai').val(data.bairro.substring(0, 50));
                              }
                              if ($('#com').val() == "") {
                                   $('#com').val(data.complemento);
                              }
                              if ($('#cid').val() == "") {
                                   $('#cid').val(data.municipio);
                              }
                              if ($('#est').val() == "") {
                                   $('#est').val(data.uf);
                              }
                              if ($('#con').val() == "") {
                                   $('#con').val(data.qsa[0].nome);
                              }
                              if ($('#fon').val() == "") {
                                   $('#fon').val(data.telefone.substring(0, 15));
                              }
                              if ($('#ema').val() == "") {
                                   $('#ema').val(data.email);
                              }
                         }
                    }
               });
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
     $cod = (isset($_REQUEST['cod']) == false ? 0  : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 0  : $_REQUEST['sta']);
     $pes = (isset($_REQUEST['pes']) == false ? 0  : $_REQUEST['pes']);
     $cgc = (isset($_REQUEST['cgc']) == false ? "" : $_REQUEST['cgc']);
     $ins = (isset($_REQUEST['ins']) == false ? "" : $_REQUEST['ins']);
     $inm = (isset($_REQUEST['inm']) == false ? "" : $_REQUEST['inm']);
     $tel = (isset($_REQUEST['tel']) == false ? "" : $_REQUEST['tel']);
     $cep = (isset($_REQUEST['cep']) == false ? "" : $_REQUEST['cep']);
     $end = (isset($_REQUEST['end']) == false ? "" : $_REQUEST['end']);
     $num = (isset($_REQUEST['num']) == false ? "" : $_REQUEST['num']);
     $com = (isset($_REQUEST['com']) == false ? "" : $_REQUEST['com']);
     $con = (isset($_REQUEST['con']) == false ? "" : $_REQUEST['con']);
     $bai = (isset($_REQUEST['bai']) == false ? "" : $_REQUEST['bai']);
     $cid = (isset($_REQUEST['cid']) == false ? "" : $_REQUEST['cid']);
     $est = (isset($_REQUEST['est']) == false ? "" : $_REQUEST['est']);
     $cel = (isset($_REQUEST['cel']) == false ? '' : $_REQUEST['cel']);
     $fre = (isset($_REQUEST['amb']) == false ? 4 : $_REQUEST['amb']);
     $cns = (isset($_REQUEST['cns']) == false ? 0 : $_REQUEST['cns']);
     $ctb = (isset($_REQUEST['ctb']) == false ? 0 : $_REQUEST['ctb']);
     $ema = (isset($_REQUEST['ema']) == false ? '' : $_REQUEST['ema']);
     $sit = (isset($_REQUEST['sit']) == false ? '' : $_REQUEST['sit']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : $_REQUEST['obs']);
     $raz = (isset($_REQUEST['raz']) == false ? '' : str_replace("'", "´", $_REQUEST['raz']));
     $fan = (isset($_REQUEST['fan']) == false ? '' : str_replace("'", "´", $_REQUEST['fan']));
     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod(); $pes = 1;
          $_SESSION['wrkmostel'] = 1;
     }
if ($_SESSION['wrkopereg'] == 3) { 
     $bot = 'Deletar'; 
     $per = ' onclick="return confirm(\'Confirma exclusão de destinatário informado em tela ?\')" ';
}  
if ($_SESSION['wrkopereg'] >= 2) {
     if (isset($_REQUEST['salvar']) == false) { 
          $cha = $_SESSION['wrkcodreg']; $_SESSION['wrkmostel'] = 1;
          $ret = ler_destinatario($cha, $raz, $sta, $pes, $inm, $ema, $tel, $cel, $cep, $end, $num, $com, $bai, $cid, $est, $fan, $obs, $sit, $con, $ins, $cgc, $cns, $ctb, $fre); 
     }
}
if (isset($_REQUEST['salvar']) == true) {
     $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
     if ($_SESSION['wrkopereg'] == 1) {
         $ret = consiste_des();
         if ($ret == 0) {
             $ret = incluir_des();
             $ret = gravar_log(11,"Inclusão de novo destinatário: " . $raz);
             $cod = ultimo_cod(); $_SESSION['wrkcodreg'] = $cod; 
             $pes = 1; $raz= ''; $ema = ''; $sta = 0; $fre = 0; $cns = 0; $ctb = 0; $fan = ''; $tel = ''; $cel = ''; $end = ''; $cep = ''; $bai = ''; $cid = ''; $est = ''; $com = ''; $con = ''; $sit = ''; $obs = ''; $cgc = ''; $ins = ''; $inm = '';
         }
     }
     if ($_SESSION['wrkopereg'] == 2) {
         $ret = consiste_des();
         if ($ret == 0) {
             $ret = alterar_des();
             $ret = gravar_log(12,"Alteração de destinatário existente: " . $raz);  
             $pes = 1; $raz= ''; $ema = ''; $sta = 0; $fre = 0; $cns = 0; $ctb = 0; $fan = ''; $tel = ''; $cel = ''; $end = ''; $cep = ''; $bai = ''; $cid = ''; $est = ''; $com = ''; $con = ''; $sit = ''; $obs = ''; $cgc = ''; $ins = ''; $inm = ''; 
             echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
         }
     }
     if ($_SESSION['wrkopereg'] == 3) {
         $ret = excluir_des();
         $ret = gravar_log(13,"Exclusão de destinatário existente: " . $raz); 
         $pes = 1; $raz= ''; $ema = ''; $sta = 0; $fre = 0; $cns = 0; $ctb = 0; $fan = ''; $tel = ''; $cel = ''; $end = ''; $cep = ''; $bai = ''; $cid = ''; $est = ''; $com = ''; $con = ''; $sit = ''; $obs = ''; $cgc = ''; $ins = ''; $inm = ''; 
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
                              <label>Manutenção de Destinatários</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-destino.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar novo destinatário no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>

                    <form class="tel-1" name="frmTelMan" action="" method="POST" >
                         <div class="row">
                              <div class="col-md-2">
                                   <label>Código</label>
                                   <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                                        value="<?php echo $cod; ?>" disabled />
                              </div>
                              <div class="col-md-2"></div>
                              <div class="col-md-3">
                                   <label id="doc_c">Número do C.n.p.j.</label>
                                   <input type="text" class="form-control" maxlength="50" id="cgc" name="cgc"
                                        value="<?php echo $cgc; ?>" required />
                              </div>
                              <div class="col-md-2"></div>
                              <div class="col-md-3">
                                   <label id="doc_i">Inscrição Estadual</label>
                                   <input type="text" class="form-control" maxlength="15" id="ins" name="ins"
                                        value="<?php echo $ins; ?>" required />
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-7">
                                   <label>Razão Social</label>
                                   <input type="text" class="form-control" maxlength="75" id="raz" name="raz"
                                        value="<?php echo $raz; ?>" required />
                              </div>
                              <div class="col-md-5">
                                   <label>Nome Fantasia</label>
                                   <input type="text" class="form-control" maxlength="60" id="fan" name="fan"
                                        value="<?php echo $fan; ?>" />
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-2">
                                   <label>C.e.p.</label>
                                   <input type="text" class="form-control" maxlength="9" id="cep" name="cep"
                                        value="<?php echo $cep; ?>" required />
                              </div>
                              <div class="che-1 col-md-2 text-center">
                                   <span>Pessoa Jurídica</span> &nbsp;
                                   <input type="checkbox" id="pes" name="pes" value="1"
                                        <?php echo ($pes == 0 ? '': 'checked' ) ?> />
                              </div>
                              <div class="col-md-2">
                                   <label>Contribuinte</label>
                                   <select name="ctb" id="ctb" class="form-control">
                                        <option value="1" <?php echo ($ctb != 1 ? '' : 'selected="selected"'); ?>>Contribuinte</option>
                                        <option value="2" <?php echo ($ctb != 2 ? '' : 'selected="selected"'); ?>>Contribuinte Isento</option>
                                        <option value="9" <?php echo ($ctb != 9 ? '' : 'selected="selected"'); ?>>Não Contribuinte</option>
                                   </select>
                              </div>
                              <div class="col-md-2">
                                   <label>Consumo</label>
                                   <select name="cns" id="cns" class="form-control">
                                        <option value="0" <?php echo ($cns != 0 ? '' : 'selected="selected"'); ?>>Normal</option>
                                        <option value="1" <?php echo ($cns != 1 ? '' : 'selected="selected"'); ?>>Revenda</option>
                                        <option value="2" <?php echo ($cns != 2 ? '' : 'selected="selected"'); ?>>Industrialização</option>
                                        <option value="3" <?php echo ($cns != 3 ? '' : 'selected="selected"'); ?>>Consumo Próprio</option>
                                   </select>
                              </div>
                              <div class="col-md-2">
                                   <label>Frete</label>
                                   <select name="fre" id="fre" class="form-control">
                                        <option value="0" <?php echo ($fre != 0 ? '' : 'selected="selected"'); ?>>Emitente (Cif)</option>
                                        <option value="1" <?php echo ($fre != 1 ? '' : 'selected="selected"'); ?>>Destino/Emitente</option>
                                        <option value="2" <?php echo ($fre != 2 ? '' : 'selected="selected"'); ?>>Terceiros</option>
                                        <option value="3" <?php echo ($fre != 3 ? '' : 'selected="selected"'); ?>>Destino (Fob)</option>
                                        <option value="4" <?php echo ($fre != 4 ? '' : 'selected="selected"'); ?>>Sem Frete</option>
                                   </select>
                              </div>
                              <div class="col-md-2">
                                   <label>Inscrição Municipal</label>
                                   <input type="text" class="form-control" maxlength="10" id="inm" name="inm"
                                        value="<?php echo $inm; ?>" />
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-10">
                                   <label>Endereço</label>
                                   <input type="text" class="form-control" maxlength="50" id="end" name="end"
                                        value="<?php echo $end; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>Número</label>
                                   <input type="text" class="form-control" maxlength="6" id="num" name="num"
                                        value="<?php echo $num; ?>" />
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-10">
                                   <label>Complemento</label>
                                   <input type="text" class="form-control" maxlength="50" id="com" name="com"
                                        value="<?php echo $com; ?>" />
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <div class="row">
                              <div class="col-md-6">
                                   <label>Bairro</label>
                                   <input type="text" class="form-control" maxlength="50" id="bai" name="bai"
                                        value="<?php echo $bai; ?>" />
                              </div>
                              <div class="col-md-5">
                                   <label>Município</label>
                                   <input type="text" class="form-control" maxlength="50" id="cid" name="cid"
                                        value="<?php echo $cid; ?>" required />
                              </div>
                              <div class="col-md-1">
                                   <label>Estado</label>
                                   <input type="text" class="form-control" maxlength="2" id="est" name="est"
                                        value="<?php echo $est; ?>" required />
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-4">
                                   <label>Nº de Telefone</label>
                                   <input type="text" class="form-control" maxlength="15" id="tel" name="tel"
                                        value="<?php echo $tel; ?>" />
                              </div>
                              <div class="col-md-4">
                                   <label>Nº de Celular</label>
                                   <input type="text" class="form-control" maxlength="15" id="cel" name="cel"
                                        value="<?php echo $cel; ?>" />
                              </div>
                              <div class="col-md-4">
                                   <label>Status</label>
                                   <select name="sta" class="form-control">
                                        <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>Normal</option>
                                        <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>Bloqueado</option>
                                        <option value="2" <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>Suspenso</option>
                                        <option value="3" <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>Cancelado</option>
                                   </select>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-4">
                                   <label>E-Mail de Contato</label>
                                   <input type="email" class="form-control" maxlength="75" id="ema" name="ema"
                                        value="<?php echo $ema; ?>" />
                              </div>
                              <div class="col-md-4">
                                   <label>Endereço do Site</label>
                                   <input type="text" class="form-control" maxlength="50" id="sit" name="sit"
                                        value="<?php echo $sit; ?>" />
                              </div>
                              <div class="col-md-4">
                                   <label>Nome do Contato</label>
                                   <input type="text" class="form-control" maxlength="50" id="con" name="con"
                                        value="<?php echo $con; ?>" />
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-12">
                                   <label>Observação</label>
                                   <textarea class="form-control" rows="3" id="obs"
                                        name="obs"><?php echo $obs ?></textarea>
                              </div>
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
     $sql = mysqli_query($conexao,"Select iddestino, desrazao from tb_destino order by iddestino desc Limit 1");
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $cod = $lin['iddestino'] + 1;
     }
     return $cod;
 }

 function consiste_des() {
     $sta = 0;
     $pes = (isset($_REQUEST['pes']) == false ? 0  : $_REQUEST['pes']);
     if (trim($_REQUEST['raz']) == "") {
          echo '<script>alert("Razão Social do destinatário não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['cgc']) == "" || trim($_REQUEST['cgc']) == "../-" || trim($_REQUEST['cgc']) == "..-") {
          echo '<script>alert("Número do C.n.p.j. do destinatário pode estar em branco");</script>';
          return 7;
     }
     if (valida_est(strtoupper($_REQUEST['est'])) == 0) {
          echo '<script>alert("Estado da Federação do destinatário informado não é válido");</script>';
          return 8;
     }
     if (strlen($_REQUEST['obs']) > 500) {
          echo '<script>alert("Observação do destinatário não pode ter mais de 500 caracteres");</script>';
          $sta = 1;
     }   
     if ($_REQUEST['cgc'] != "") {
          if ($pes == 1) {
               $sta = valida_cgc($_REQUEST['cgc']);
               if ($sta != 0) {
                    echo '<script>alert("Dígito de controle do C.n.p.j. não está correto");</script>';
                    return 8;
               }
          }
          if ($pes == 0) {
               $sta = valida_cpf($_REQUEST['cgc']);
               if ($sta != 0) {
                    echo '<script>alert("Dígito de controle do C.p.f. não está correto");</script>';
                    return 8;
               }
          }
     }    
     if (trim($_REQUEST['cgc']) != "") {
          $cod = cnpj_exi(1, $_REQUEST['cgc'], $nom);
          if ($cod != 0 && $cod != $_SESSION['wrkcodreg']) {
               echo '<script>alert("C.n.p.j. informado para destinatário já existe cadastrado");</script>';
               return 6;
          }    
     }
     if ($pes == 0 && $_REQUEST['ctb'] == 1) {
          echo '<script>alert("Pessoa física informada não pode ser contribuinte de Icms");</script>';
          $sta = 1; 
     }
     if ($_REQUEST['ctb'] == 9 && $_REQUEST['cns'] != 3) {
          echo '<script>alert("Operação com não contribuinte deve ser consumo próprio");</script>';
          $sta = 1; 
     }
     if ($_REQUEST['ctb'] == '1' && trim($_REQUEST['ins']) == 'ISENTO') {
          echo '<script>alert("Inscrição Estadual não pode Isento para contribuinte");</script>';
          $sta = 1; 
     }
     if (cidade_exi($_REQUEST['est'], $_REQUEST['cid']) == "") {
          echo '<script>alert("Estado e/ou Município não cadastrados no sistema para destino");</script>';
          return 8;
     }
     return $sta;
}

 function ler_destinatario(&$cha, &$raz, &$sta, &$pes, &$inm, &$ema, &$tel, &$cel, &$cep, &$end, &$num, &$com, &$bai, &$cid, &$est, &$fan, &$obs, &$sit, &$con, &$ins, &$cgc, &$cns, &$ctb, &$fre) {
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select * from tb_destino where iddestino = " . $cha);
     if (mysqli_num_rows($sql) == 0) {
         echo '<script>alert("Código do destinatário informado não cadastrado");</script>';
         $nro = 1;
     }else{
         $lin = mysqli_fetch_array($sql);
         $cha = $lin['iddestino'];
         $raz = $lin['desrazao'];
         $fan = $lin['desfantasia'];
         $sta = $lin['desstatus'];
         $cgc = $lin['descnpj'];
         $ins = $lin['desinscricao'];
         $inm = $lin['desinsmunic'];
         $con = $lin['descontato'];
         $sit = $lin['deswebsite'];
         $ema = $lin['desemail'];
         $tel = $lin['destelefone'];
         $cel = $lin['descelular'];
         $cep = $lin['descep'];
         $end = $lin['desendereco'];
         $num = $lin['desnumeroend'];
         $com = $lin['descomplemento'];
         $bai = $lin['desbairro'];
         $cid = $lin['descidade'];
         $est = $lin['desestado'];
         $ctb = $lin['descontribuinte'];
         $pes = $lin['despessoa'];
         $cns = $lin['destipconsumo'];
         $fre = $lin['destipfrete'];
         $obs = $lin['desobservacao'];
         $_SESSION['wrkcodreg'] = $lin['iddestino'];
     }
     return $cha;
 }

 function incluir_des() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "insert into tb_destino (";
     $sql .= "desempresa, ";
     $sql .= "descnpj, ";
     $sql .= "desstatus, ";
     $sql .= "desinscricao, ";
     $sql .= "desrazao, ";
     $sql .= "desfantasia, ";
     $sql .= "descep, ";
     $sql .= "desendereco, ";
     $sql .= "desnumeroend, ";
     $sql .= "descomplemento, ";
     $sql .= "desbairro, ";
     $sql .= "descidade, ";
     $sql .= "desestado, ";
     $sql .= "descelular, ";
     $sql .= "destelefone, ";
     $sql .= "desemail, ";
     $sql .= "descontato, ";
     $sql .= "deswebsite, ";
     $sql .= "desinsmunic, ";
     $sql .= "descontribuinte, ";
     $sql .= "destipconsumo, ";
     $sql .= "destipfrete, ";
     $sql .= "descodmunic, ";
     $sql .= "desobservacao, ";
     $sql .= "despessoa, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['cgc']) . "',";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . $_REQUEST['ins'] . "',";
     $sql .= "'" . $_REQUEST['raz'] . "',";
     $sql .= "'" . $_REQUEST['fan'] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['cep']) . "',";
     $sql .= "'" . $_REQUEST['end'] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['num']) . "',";
     $sql .= "'" . $_REQUEST['com'] . "',";
     $sql .= "'" . $_REQUEST['bai'] . "',";
     $sql .= "'" . $_REQUEST['cid'] . "',";
     $sql .= "'" . strtoupper($_REQUEST['est']) . "',";
     $sql .= "'" . $_REQUEST['cel'] . "',";
     $sql .= "'" . $_REQUEST['tel'] . "',";
     $sql .= "'" . $_REQUEST['ema'] . "',";
     $sql .= "'" . $_REQUEST['con'] . "',";
     $sql .= "'" . $_REQUEST['sit'] . "',";
     $sql .= "'" . $_REQUEST['inm'] . "',";
     $sql .= "'" . $_REQUEST['ctb'] . "',";
     $sql .= "'" . $_REQUEST['cns'] . "',";
     $sql .= "'" . $_REQUEST['fre'] . "',";
     $sql .= "'" . cidade_exi($_REQUEST['est'], $_REQUEST['cid']) . "',";
     $sql .= "'" . $_REQUEST['obs'] . "',";
     $sql .= "'" . (isset($_REQUEST['pes']) == false ? 0 : 1 ) . "',";
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

 function alterar_des() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "update tb_destino set ";
     $sql .= "descnpj = '". limpa_nro($_REQUEST['cgc']) . "', ";
     $sql .= "desstatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "desinscricao = '". $_REQUEST['ins'] . "', ";
     $sql .= "desinsmunic = '". $_REQUEST['inm'] . "', ";
     $sql .= "desrazao = '". $_REQUEST['raz'] . "', ";
     $sql .= "desfantasia = '". $_REQUEST['fan'] . "', ";
     $sql .= "descep = '". limpa_nro($_REQUEST['cep']) . "', ";
     $sql .= "desendereco = '". $_REQUEST['end'] . "', ";
     $sql .= "desnumeroend = '". limpa_nro($_REQUEST['num']) . "', ";
     $sql .= "descomplemento = '". $_REQUEST['com'] . "', ";
     $sql .= "desbairro = '". $_REQUEST['bai'] . "', ";
     $sql .= "descidade = '". $_REQUEST['cid'] . "', ";
     $sql .= "desestado = '". strtoupper($_REQUEST['est']) . "', ";
     $sql .= "destelefone = '". $_REQUEST['tel'] . "', ";
     $sql .= "descelular = '". $_REQUEST['cel'] . "', ";
     $sql .= "descontato =  '". $_REQUEST['con'] . "', ";
     $sql .= "desemail = '". $_REQUEST['ema'] . "', ";
     $sql .= "deswebsite = '". $_REQUEST['sit'] . "', ";
     $sql .= "descontribuinte = '". $_REQUEST['ctb'] . "', ";
     $sql .= "destipconsumo = '". $_REQUEST['cns'] . "', ";
     $sql .= "destipfrete = '". $_REQUEST['fre'] . "', ";
     $sql .= "despessoa = '". (isset($_REQUEST['pes']) == false ? 0 : 1 ) . "', ";
     $sql .= "descodmunic = '". cidade_exi($_REQUEST['est'], $_REQUEST['cid']) . "', ";
     $sql .= "desobservacao = '". $_REQUEST['obs'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where iddestino = " . $_SESSION['wrkcodreg'];
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

 function excluir_des() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "delete from tb_destino where iddestino = " . $_SESSION['wrkcodreg'] ;
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
         print_r($sql);
         echo '<script>alert("Erro na exclusão do destinatário solicitado !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
 }

?>

</html>
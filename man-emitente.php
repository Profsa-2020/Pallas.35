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
     $("#cps").mask("999");
     $("#cpn").mask("999.999.999", {
          reverse: true
     });
     $("#cgc").mask("00.000.000/0000-00");
     $("#cep").mask("00000-000");
     $("#num").mask("999.999", {
          reverse: true
     });
});

$(document).ready(function() {

     $('#bt_certifica').bind("click", function() {
          $('#bt_janela').click();
     });
     $('#bt_janela').change(function() {
          var path = $('#bt_janela').val();
          $('#cam').val(path.replace(/^.*\\/, ""));
     });
     $('#bt_logotipo').bind("click", function() {
          $('#bt_window').click();
     });
     $('#bt_window').change(function() {
          var path = $('#bt_window').val();
          $('#log').val(path.replace(/^.*\\/, ""));

          var ima = $(this)[0].files[0];     // Carrega preview da imagem em jquery para a tela do logotipo
          var fileReader = new FileReader();
          fileReader.onloadend = function(){
               $('#log-1').attr('src', fileReader.result);
          }
          fileReader.readAsDataURL(ima);

     });

     $('#pes').click(function() {
          if ($('#pes').prop("checked") == false) {
               $('#doc').text('Número do C.p.f.');
               $("#cgc").mask("000.000.000-00");
          } else {
               $('#doc').text('Número do C.n.p.j.');
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
          var cgc = cgc.replace(/[^0-9]/g, '');
          if (cgc != '') {
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
                              if ($('#cna').val() == "") {
                                   var cna = data.atividade_principal[0].code;
                                   cna = cna.replace(/[^0-9]/g, '');
                                   if (cna == "" || cna == 0) {
                                        cna = data.atividades_secundarias[0].code;
                                        cna = cna.replace(/[^0-9]/g, '');
                                   }
                                   $('#cna').val(cna);
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
     if ( $_SESSION['wrktipusu'] <= 2) {
          echo '<script>alert("Nível de usuário não permite acesso a essa opção");</script>';
          echo '<script>history.go(-1);</script>';
     }

     use NFePHP\Common\Certificate;
     use NFePHP\Common\Certificate\CertificationChain;     

     $_SESSION['wrknompro'] = __FILE__;
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(10,"Entrada na página de manutenção de emitente do sistema Pallas.35 - Gold Solutions");  
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
     $pes = (isset($_REQUEST['pes']) == false ? 1  : $_REQUEST['pes']);
     $cgc = (isset($_REQUEST['cgc']) == false ? "" : $_REQUEST['cgc']);
     $ins = (isset($_REQUEST['ins']) == false ? "" : $_REQUEST['ins']);
     $inm = (isset($_REQUEST['inm']) == false ? "" : $_REQUEST['inm']);
     $cna = (isset($_REQUEST['cna']) == false ? '' : $_REQUEST['cna']);
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
     $amb = (isset($_REQUEST['amb']) == false ? 2 : $_REQUEST['amb']);
     $reg = (isset($_REQUEST['reg']) == false ? 0 : $_REQUEST['reg']);
     $ser = (isset($_REQUEST['ser']) == false ? 0 : $_REQUEST['ser']);
     $nro = (isset($_REQUEST['nro']) == false ? 0 : $_REQUEST['nro']);
     $cps = (isset($_REQUEST['cps']) == false ? 0 : $_REQUEST['cps']);
     $cpn = (isset($_REQUEST['cpn']) == false ? 0 : $_REQUEST['cpn']);
     $par = (isset($_REQUEST['par']) == false ? 0 : $_REQUEST['par']);
     $ema = (isset($_REQUEST['ema']) == false ? '' : $_REQUEST['ema']);
     $sit = (isset($_REQUEST['sit']) == false ? '' : $_REQUEST['sit']);
     $cam = (isset($_REQUEST['cam']) == false ? '' : $_REQUEST['cam']);
     $log = (isset($_REQUEST['log']) == false ? '' : $_REQUEST['log']);
     $ace = (isset($_REQUEST['ace']) == false ? '' : $_REQUEST['ace']);
     $csc = (isset($_REQUEST['csc']) == false ? '' : $_REQUEST['csc']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : $_REQUEST['obs']);
     $raz = (isset($_REQUEST['raz']) == false ? '' : str_replace("'", "´", $_REQUEST['raz']));
     $fan = (isset($_REQUEST['fan']) == false ? '' : str_replace("'", "´", $_REQUEST['fan']));
     if ($_SESSION['wrkopereg'] == 1) { 
     $cod = ultimo_cod();
     $_SESSION['wrkmostel'] = 1;
}
if ($_SESSION['wrkopereg'] == 3) { 
     $bot = 'Deletar'; 
     $per = ' onclick="return confirm(\'Confirma exclusão de emitente informado em tela ?\')" ';
}  
if ($_SESSION['wrkopereg'] >= 2) {
     if (isset($_REQUEST['salvar']) == false) { 
          $cha = $_SESSION['wrkcodreg']; $_SESSION['wrkmostel'] = 1;
          $ret = ler_emitente($cha, $raz, $sta, $pes, $inm, $ema, $tel, $cel, $cep, $end, $num, $com, $bai, $cid, $est, $fan, $obs, $sit, $con, $ins, $cgc, $cna, $log, $cam, $ace, $reg, $amb, $ser, $nro, $par, $cps, $cpn, $csc); 
     }
 }
 if (isset($_REQUEST['salvar']) == true) {
     $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
     if ($_SESSION['wrkopereg'] == 1) {
         $ret = consiste_emi($dti, $dtf);
         if ($ret == 0) {
             $ret = incluir_emi($dti, $dtf);
             $ret = gravar_log(11,"Inclusão de novo emitente: " . $raz);
             $cod = ultimo_cod(); $_SESSION['wrkcodreg'] = $cod; 
             $pes = 1; $raz= ''; $ema = ''; $sta = 0; $amb = 0; $reg = 0; $fan = ''; $tel = ''; $cel = ''; $end = ''; $cep = ''; $bai = ''; $cid = ''; $est = ''; $com = ''; $con = ''; $sit = ''; $obs = ''; $cgc = ''; $ins = ''; $inm = ''; $cam = ''; $ace = ''; $cna = ''; $log = ''; $ser = 0; $nro = 0; $par = 0; $cps = 0; $cpn = 0; $csc = '';
         }
     }
     if ($_SESSION['wrkopereg'] == 2) {
         $ret = consiste_emi($dti, $dtf);
         if ($ret == 0) {
             $ret = alterar_emi($dti, $dtf);
             $ret = gravar_log(12,"Alteração de emitente existente: " . $raz);  
             $pes = 1; $raz= ''; $ema = ''; $sta = 0; $amb = 0; $reg = 0; $fan = ''; $tel = ''; $cel = ''; $end = ''; $cep = ''; $bai = ''; $cid = ''; $est = ''; $com = ''; $con = ''; $sit = ''; $obs = ''; $cgc = ''; $ins = ''; $inm = ''; $cam = ''; $ace = ''; $cna = ''; $log = '';  $ser = 0; $nro = 0; $par = 0; $cps = 0; $cpn = 0; $csc = '';
             echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
         }
     }
     if ($_SESSION['wrkopereg'] == 3) {
         $ret = excluir_emi();
         $ret = gravar_log(13,"Exclusão de emitente existente: " . $raz); 
         $pes = 1; $raz= ''; $ema = ''; $sta = 0; $amb = 0; $reg = 0; $fan = ''; $tel = ''; $cel = ''; $end = ''; $cep = ''; $bai = ''; $cid = ''; $est = ''; $com = ''; $con = ''; $sit = ''; $obs = ''; $cgc = ''; $ins = ''; $inm = ''; $cam = ''; $ace = ''; $cna = ''; $log = '';  $ser = 0; $nro = 0; $par = 0; $cps = 0; $cpn = 0; $csc = '';
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
                              <label>Manutenção de Emitentes</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-emitente.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar novo emitente no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>

                    <form class="tel-1" name="frmTelMan" action="" method="POST" enctype="multipart/form-data">
                         <div class="row">
                              <div class="col-md-2">
                                   <label>Código</label>
                                   <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                                        value="<?php echo $cod; ?>" disabled />
                              </div>
                              <div class="col-md-2"></div>
                              <div class="col-md-3">
                                   <label id="doc">Número do C.n.p.j.</label>
                                   <input type="text" class="form-control" maxlength="50" id="cgc" name="cgc"
                                        value="<?php echo $cgc; ?>" required />
                              </div>
                              <div class="col-md-2"></div>
                              <div class="col-md-3">
                                   <label>Inscrição Estadual</label>
                                   <input type="text" class="form-control" maxlength="15" id="ins" name="ins"
                                        value="<?php echo $ins; ?>" />
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
                              <div class="col-md-1"></div>
                              <div class="che-1 col-md-2 text-center">
                                   <span>Pessoa Jurídica</span> &nbsp;
                                   <input type="checkbox" id="pes" name="pes" value="1"
                                        <?php echo ($pes == 0 ? '': 'checked' ) ?> />
                              </div>
                              <div class="col-md-1"></div>
                              <div class="col-md-2">
                                   <label>Ambiente</label>
                                   <select name="amb" id="amb" class="form-control">
                                        <option value="2" <?php echo ($amb != 2 ? '' : 'selected="selected"'); ?>>Homologação</option>
                                        <option value="1" <?php echo ($amb != 1 ? '' : 'selected="selected"'); ?>>Produção</option>
                                        <option value="3" <?php echo ($amb != 3 ? '' : 'selected="selected"'); ?>>Contingência</option>
                                   </select>
                              </div>
                              <div class="col-md-2">
                                   <label>Regime</label>
                                   <select name="reg" id="reg" class="form-control">
                                        <option value="0" <?php echo ($reg != 0 ? '' : 'selected="selected"'); ?>>Simples</option>
                                        <option value="1" <?php echo ($reg != 1 ? '' : 'selected="selected"'); ?>>Simples-Excessão</option>
                                        <option value="2" <?php echo ($reg != 2 ? '' : 'selected="selected"'); ?>>Normal</option>
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
                              <div class="col-md-2">
                                   <label>C.n.a.e.</label>
                                   <input type="text" class="form-control" maxlength="8" id="cna" name="cna"
                                        value="<?php echo $cna; ?>" />
                              </div>
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
                              <div class="col-md-7">
                                   <label>Caminho do Certificado</label>
                                   <input type="text" class="form-control" maxlength="150" id="cam" name="cam"
                                        value="<?php echo $cam; ?>" />
                              </div>
                              <div class="col-md-1 text-left">
                                   <br />
                                   <button type="button" class="bot-3" id="bt_certifica" name="cer"
                                        title="Upload de arquivo com certificado digital para Danfe"><i
                                             class="fa fa-upload fa-3x" aria-hidden="true"></i>
                                   </button>
                              </div>
                              <div class="col-md-4">
                                   <label>Senha</label>
                                   <input type="password" class="form-control text-center" maxlength="15" id="ace"
                                        name="ace" value="<?php echo $ace; ?>" autocomplete="off" />
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-7">
                                   <label>Caminho do Logotipo</label>
                                   <input type="text" class="form-control" maxlength="150" id="log" name="log"
                                        value="<?php echo $log; ?>" />
                              </div>
                              <div class="col-md-1 text-left">
                                   <br />
                                   <button type="button" class="bot-3" id="bt_logotipo" name="ima"
                                        title="Upload de arquivo com logotipo da empresa para Danfe"><i
                                             class="fa fa-upload fa-3x" aria-hidden="true"></i>
                                   </button>
                              </div>
                              <div class="col-md-1">
                                   <label>Série</label>
                                   <input type="text" class="form-control text-center" maxlength="3" id="ser" name="ser"
                                        value="<?php echo $ser; ?>" />
                              </div>
                              <div class="col-md-3">
                                   <label>Último Nº de Danfe</label>
                                   <input type="text" class="form-control text-center" maxlength="11" id="nro"
                                        name="nro" value="<?php echo $nro; ?>" />
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-7">
                                   <label>Parâmetro Fiscal</label>
                                   <select id="par" name="par" class="form-control" required>
                                        <?php $ret = carrega_par($par); ?>
                                   </select>
                              </div>
                              <div class="col-md-1"></div>
                              <div class="col-md-1">
                                   <label>Série</label>
                                   <input type="text" class="form-control text-center" maxlength="3" id="cps" name="cps"
                                        value="<?php echo $cps; ?>" />
                              </div>
                              <div class="col-md-3">
                                   <label>Último Nº de Cupom</label>
                                   <input type="text" class="form-control text-center" maxlength="11" id="cpn"
                                        name="cpn" value="<?php echo $cpn; ?>" />
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-7">
                                   <label>Token CSC para Cupom</label>
                                   <input type="text" class="form-control" maxlength="50" id="css" name="csc"
                                        value="<?php echo $csc; ?>" />
                              </div>
                              <div class="col-md-5"></div>
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
                              <div class="col-md-3 text-center">
                                   <?php
                                        if ($log != "") {
                                             $ima = "Emp_" . str_pad($_SESSION['wrkcodreg'], 3, "0", STR_PAD_LEFT) . '/'. $log; 
                                             echo '<img id="log-1" class="img-fluid" src="' . $ima . '" width="150" />';
                                        }
                                   ?>
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
                         <input name="arq-cer" type="file" id="bt_janela" class="bot-4" accept=".pfx" />
                         <input name="arq-log" type="file" id="bt_window" class="bot-4" accept="image/*" />
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
     $sql = mysqli_query($conexao,"Select idemite, emirazao from tb_emitente order by idemite desc Limit 1");
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $cod = $lin['idemite'] + 1;
     }
     return $cod;
 }

 function consiste_emi(&$dti, &$dtf) {
     $sta = 0;
     $pes = (isset($_REQUEST['pes']) == false ? 0  : $_REQUEST['pes']);
     if (trim($_REQUEST['raz']) == "") {
         echo '<script>alert("Razão Social do emitente não pode estar em branco");</script>';
         return 1;
     }
     if (trim($_REQUEST['cgc']) == "" || trim($_REQUEST['cgc']) == "../-" || trim($_REQUEST['cgc']) == "..-") {
         echo '<script>alert("Número do C.n.p.j. do emitente pode estar em branco");</script>';
         return 7;
     }
     if (valida_est(strtoupper($_REQUEST['est'])) == 0) {
         echo '<script>alert("Estado da Federação do emitente informado não é válido");</script>';
         return 8;
     }
     if (strlen($_REQUEST['cam']) > 150) {
          echo '<script>alert("Caminho do certificado não pode ter mais de 150 caracteres");</script>';
          $sta = 1;
      }   
      if (strlen($_REQUEST['obs']) > 500) {
         echo '<script>alert("Observação do emitente não pode ter mais de 500 caracteres");</script>';
         $sta = 1;
     }   
     if ($_REQUEST['cgc'] != "") {
         $sta = valida_cgc($_REQUEST['cgc']);
         if ($sta != 0) {
             echo '<script>alert("Dígito de controle do C.n.p.j. não está correto");</script>';
             return 8;
         }
     }    
     if (cidade_exi($_REQUEST['est'], $_REQUEST['cid']) == "") {
          echo '<script>alert("Estado e/ou Município não cadastrados no sistema para emitente");</script>';
          return 8;
     }
     if (trim($_REQUEST['cgc']) != "") {
          $cod = cnpj_exi(0, $_REQUEST['cgc'], $nom);
          if ($cod != 0 && $cod != $_SESSION['wrkcodreg']) {
               echo '<script>alert("C.n.p.j. informado para emitente já existe cadastrado");</script>';
               return 6;
          }    
     }
      if ($_REQUEST['cam'] != "") {
       if ($_REQUEST['ace'] == "") {
            echo '<script>alert("Não pode haver certificado informado sem senha do mesmo informada");</script>';
            return 8;
       }
     }
     if ($_REQUEST['cam'] == "") {
          if ($_REQUEST['ace'] != "") {
               echo '<script>alert("Não pode haver certificado em branco com senha do mesmo informada");</script>';
               return 8;
          }
        }
   
     if ($_REQUEST['cam'] != "") {
       $tip = array('pfx');
       $fim = explode('.', $_REQUEST['cam']);
       $ext = strtolower(end($fim));
       if (array_search($ext, $tip) === false) {
            echo "<script>alert('Extensão de arquivo do certificado informado deve ser .pfx')</script>"; return 6; 
       }            
     }
     if ($_REQUEST['log'] != "") {
          $tip = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG');
          $fim = explode('.', $_REQUEST['log']);
          $ext = strtolower(end($fim));
          if (array_search($ext, $tip) === false) {
               echo "<script>alert('Extensão de logotipo do emitente informado deve ser uma imagem')</script>"; return 6; 
          }            
      }       
     if ($_REQUEST['log'] != "") {
          $cam = $_REQUEST['log'];
          $ret = upload_log($cam, $des, $tam, $ext);
      }        
      $dti = ''; $dtf = '';
      if ($_REQUEST['cam'] != "") {
       $cam = $_REQUEST['cam'];
       $ret = upload_cer($cam, $des, $tam, $ext);
       $ret = valida_cer($ret, $des, $dti, $dtf);
       if ($ret != 0) {
           echo "<script>alert('" . $des . "')</script>"; return 6; 
       }
   }        
     return $sta;
 }

 function carrega_par($par) {
     $sta = 0;
     include "lerinformacao.inc";    
     $com = "Select idparametro, parnome from tb_parametro where parstatus = 0 and parempresa = " . $_SESSION['wrkcodreg'] . " order by parnome";
     $sql = mysqli_query($conexao, $com);
     if ($par == 0) {
          echo '<option value="0" selected="selected">Selecione parâmetro fiscal para cupom ...</option>';
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

 function ler_emitente(&$cha, &$raz, &$sta, &$pes, &$inm, &$ema, &$tel, &$cel, &$cep, &$end, &$num, &$com, &$bai, &$cid, &$est, &$fan, &$obs, &$sit, &$con, &$ins, &$cgc, &$cna, &$log, &$cam, &$ace, &$reg, &$amb, &$ser, &$nro, &$par, &$cps, &$cpn, &$csc) {
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select * from tb_emitente where idemite = " . $cha);
     if (mysqli_num_rows($sql) == 0) {
         echo '<script>alert("Código do emitente informado não cadastrado");</script>';
         $nro = 1;
     }else{
         $lin = mysqli_fetch_array($sql);
         $cha = $lin['idemite'];
         $raz = $lin['emirazao'];
         $fan = $lin['emifantasia'];
         $sta = $lin['emistatus'];
         $cgc = $lin['emicnpj'];
         $ins = $lin['emiinscricao'];
         $inm = $lin['emiinsmunic'];
         $con = $lin['emicontato'];
         $sit = $lin['emisite'];
         $ema = $lin['emiemail'];
         $tel = $lin['emitelefone'];
         $cel = $lin['emicelular'];
         $cep = $lin['emicep'];
         $end = $lin['emiendereco'];
         $num = $lin['eminumeroend'];
         $com = $lin['emicomplemento'];
         $bai = $lin['emibairro'];
         $cid = $lin['emicidade'];
         $est = $lin['emiestado'];
         $cna = $lin['emicnae'];
         $pes = $lin['emipessoa'];
         $reg = $lin['emiregime'];
         $par = $lin['emiparametro'];
         $amb = $lin['emitipoamb'];
         $ser = $lin['emiserie'];
         $nro = $lin['eminumeronot'];
         $cps = $lin['emicupomser'];
         $cpn = $lin['emicupomnum'];
         $csc = $lin['eminumerocsc'];
         $log = $lin['emicamlogo'];
         $cam = $lin['emicamcertif'];
         $ace = $lin['emisencertif'];
         $obs = $lin['emiobservacao'];
         $_SESSION['wrkcodreg'] = $lin['idemite'];
     }
     return $cha;
 }

 function incluir_emi($dti, $dtf) {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "insert into tb_emitente (";
     $sql .= "emicnpj, ";
     $sql .= "emistatus, ";
     $sql .= "emiinscricao, ";
     $sql .= "emirazao, ";
     $sql .= "emifantasia, ";
     $sql .= "emicep, ";
     $sql .= "emiendereco, ";
     $sql .= "eminumeroend, ";
     $sql .= "emicomplemento, ";
     $sql .= "emibairro, ";
     $sql .= "emicidade, ";
     $sql .= "emiestado, ";
     $sql .= "emicelular, ";
     $sql .= "emitelefone, ";
     $sql .= "emiemail, ";
     $sql .= "emicontato, ";
     $sql .= "emisite, ";
     $sql .= "emiinsmunic, ";
     $sql .= "emicnae, ";
     $sql .= "emicamlogo, ";
     $sql .= "emicamcertif, ";
     $sql .= "emisencertif, ";
     $sql .= "emidatcertif, ";
     $sql .= "emiserie, ";
     $sql .= "eminumeronot, ";
     $sql .= "emicupomser, ";
     $sql .= "emicupomnum, ";
     $sql .= "eminumerocsc, ";
     $sql .= "emiregime, ";
     $sql .= "emitipoamb, ";
     $sql .= "emicodmunic, ";
     $sql .= "emiparametro, ";
     $sql .= "emiobservacao, ";
     $sql .= "emipessoa, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
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
     $sql .= "'" . $_REQUEST['cna'] . "',";
     $sql .= "'" . $_REQUEST['log'] . "',";
     $sql .= "'" . $_REQUEST['cam'] . "',";
     $sql .= "'" . $_REQUEST['ace'] . "',";
     $sql .= " " . ($dtf == "" || $dtf == "--" ? 'null' : "'" . $dtf . "'") . " ,";
     $sql .= "'" . limpa_nro($_REQUEST['ser']) . "',";
     $sql .= "'" . limpa_nro($_REQUEST['nro']) . "',";
     $sql .= "'" . limpa_nro($_REQUEST['cps']) . "',";
     $sql .= "'" . limpa_nro($_REQUEST['cpn']) . "',";
     $sql .= "'" . $_REQUEST['csc'] . "',";
     $sql .= "'" . $_REQUEST['reg'] . "',";
     $sql .= "'" . $_REQUEST['amb'] . "',";
     $sql .= "'" . cidade_exi($_REQUEST['est'], $_REQUEST['cid']) . "',";
     $sql .= "'" . $_REQUEST['par'] . "',";
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

 function alterar_emi($dti, $dtf) {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "update tb_emitente set ";
     $sql .= "emicnpj = '". limpa_nro($_REQUEST['cgc']) . "', ";
     $sql .= "emistatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "emiinscricao = '". $_REQUEST['ins'] . "', ";
     $sql .= "emiinsmunic = '". $_REQUEST['inm'] . "', ";
     $sql .= "emicnae = '". $_REQUEST['cna'] . "', ";
     $sql .= "emirazao = '". $_REQUEST['raz'] . "', ";
     $sql .= "emifantasia = '". $_REQUEST['fan'] . "', ";
     $sql .= "emicep = '". limpa_nro($_REQUEST['cep']) . "', ";
     $sql .= "emiendereco = '". $_REQUEST['end'] . "', ";
     $sql .= "eminumeroend = '". limpa_nro($_REQUEST['num']) . "', ";
     $sql .= "emicomplemento = '". $_REQUEST['com'] . "', ";
     $sql .= "emibairro = '". $_REQUEST['bai'] . "', ";
     $sql .= "emicidade = '". $_REQUEST['cid'] . "', ";
     $sql .= "emiestado = '". strtoupper($_REQUEST['est']) . "', ";
     $sql .= "emitelefone = '". $_REQUEST['tel'] . "', ";
     $sql .= "emicelular = '". $_REQUEST['cel'] . "', ";
     $sql .= "emicodmunic = '". cidade_exi($_REQUEST['est'], $_REQUEST['cid']) . "', ";
     $sql .= "emicnae = '". limpa_nro($_REQUEST['cna']) . "', ";
     $sql .= "emiserie = '". limpa_nro($_REQUEST['ser']) . "', ";
     $sql .= "eminumeronot = '". limpa_nro($_REQUEST['nro']) . "', ";
     $sql .= "emicupomser = '". limpa_nro($_REQUEST['cps']) . "', ";
     $sql .= "emicupomnum = '". limpa_nro($_REQUEST['cpn']) . "', ";
     $sql .= "eminumerocsc = '". $_REQUEST['csc'] . "', ";
     $sql .= "emicontato =  '". $_REQUEST['con'] . "', ";
     $sql .= "emiemail = '". $_REQUEST['ema'] . "', ";
     $sql .= "emisite = '". $_REQUEST['sit'] . "', ";
     $sql .= "emiparametro = '". $_REQUEST['par'] . "', ";
     $sql .= "emicamlogo = '". $_REQUEST['log'] . "', ";
     $sql .= "emicamcertif = '". $_REQUEST['cam'] . "', ";
     $sql .= "emisencertif = '". $_REQUEST['ace'] . "', ";
     $sql .= "emidatcertif =  ". ($dtf == "" || $dtf == "--" ? 'null' : "'" . $dtf . "'") . " , ";
     $sql .= "emiregime = '". $_REQUEST['reg'] . "', ";
     $sql .= "emitipoamb = '". $_REQUEST['amb'] . "', ";
     $sql .= "emipessoa = '". (isset($_REQUEST['pes']) == false ? 0 : 1 ) . "', ";
     $sql .= "emiobservacao = '". $_REQUEST['obs'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idemite = " . $_SESSION['wrkcodreg'];
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

 function excluir_emi() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "delete from tb_emitente where idemite = " . $_SESSION['wrkcodreg'] ;
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
         print_r($sql);
         echo '<script>alert("Erro na exclusão do emitente solicitado !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
 }

 function upload_cer(&$cam, &$des, &$tam, &$ext) {
     $sta = 0; 
     $cam = "Emp_" . str_pad($_SESSION['wrkcodreg'], 3, "0", STR_PAD_LEFT) . '/' . $_REQUEST['cam']; 
     if ($_REQUEST['cam'] == "") { return 0; }
     if (file_exists($cam) == true) { return 0; }
     $arq = isset($_FILES['arq-cer']) ? $_FILES['arq-cer'] : false;
     if ($arq == false) {
         $sta = 2; 
     }else if ($arq['name'] == "") {
         if ($_SESSION['wrkopereg'] == 1) {
             echo "<script>alert('Não foi informado arquivo para ser feito Upload no sistema')</script>";
             $sta = 3; 
         }else{
             return 0;
         }
     }            
     $erro[0] = 'Não houve erro encontrado no Upload do arquivo';
     $erro[1] = 'O arquivo informado no upload é maior do que o limite da plataforma';
     $erro[2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
     $erro[3] = 'O upload do arquivo foi feito parcialmente, tente novamente';
     $erro[4] = 'Não foi feito o upload do arquivo corretamente !';
     $erro[5] = 'Não foi feito o upload do arquivo corretamente !!';
     $erro[6] = 'Pasta temporária ausente para Upload do arquuivo informado';
     $erro[7] = 'Falha em escrever o arquivo para upload informado em disco';
     if ($arq['error'] != 0) {
         if ($_SESSION['wrkopereg'] == 1) {
             echo "<script>alert(" . $erro[$arq['error']] . "')</script>";
             $sta = 4; 
         }else{
             return 0;
         }
     }
     if ($sta == 0) {
         $tip = array('pfx');
         $des = limpa_cpo($arq['name']);
         $tam = $arq['size'];
         $fim = explode('.', $des);
         $ext = end($fim);
         if (array_search($ext, $tip) === false) {
              echo "<script>alert('Extensão de arquivo do certificado informado deve ser .pfx')</script>";
              $sta = 5; 
         }
     }
     if ($sta == 0) {
         $tip = explode('.', $des);
         $des = $tip[0] . "." . $ext;
         $pas = "Emp_" . str_pad($_SESSION['wrkcodreg'], 3, "0", STR_PAD_LEFT); 
         if (file_exists($pas) == false) {
             mkdir($pas);
         }
         $cam = $pas . "/" . $des;
         $ret = move_uploaded_file($arq['tmp_name'], $cam);
         if ($ret == false) {
              echo "<script>alert('Erro na cópia do arquivo informado para upload')</script>";
              $sta = 6; 
         } else {
             $sta = gravar_log(21,"UpLoad do certificado Nome: " . $cam . " Tamanho: " . $tam);
         }      
     }    
     return $sta;
 }

 function upload_log(&$cam, &$des, &$tam, &$ext) {
     $sta = 0; 
     $cam = "Emp_" . str_pad($_SESSION['wrkcodreg'], 3, "0", STR_PAD_LEFT) . '/' . $_REQUEST['log']; 
     if ($_REQUEST['log'] == "") { return 0; }
     if (file_exists($cam) == true) { return 0; }
     $arq = isset($_FILES['arq-log']) ? $_FILES['arq-log'] : false;
     if ($arq == false) {
          $sta = 2; 
     } else if ($arq['name'] == "") {
         return 0;
     }            
     $erro[0] = 'Não houve erro encontrado no Upload do arquivo';
     $erro[1] = 'O arquivo informado no upload é maior do que o limite da plataforma';
     $erro[2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
     $erro[3] = 'O upload do arquivo foi feito parcialmente, tente novamente';
     $erro[4] = 'Não foi feito o upload do arquivo corretamente !';
     $erro[5] = 'Não foi feito o upload do arquivo corretamente !!';
     $erro[6] = 'Pasta temporária ausente para Upload do arquuivo informado';
     $erro[7] = 'Falha em escrever o arquivo para upload informado em disco';
     if ($arq['error'] != 0) {
         if ($_SESSION['wrkopereg'] == 1) {
             echo "<script>alert(" . $erro[$arq['error']] . "')</script>";
             $sta = 4; 
         }else{
             return 0;
         }
     }
     if ($sta == 0) {
         $tip = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', );
         $des = limpa_cpo($arq['name']);
         $tam = $arq['size'];
         $fim = explode('.', $des);
         $ext = end($fim);
         if (array_search($ext, $tip) === false) {
              echo "<script>alert('Extensão de arquivo do certificado informado deve ser .pfx')</script>";
              $sta = 5; 
         }
     }
     if ($sta == 0) {
         $tip = explode('.', $des);
         $des = $tip[0] . "." . $ext;
         $pas = "Emp_" . str_pad($_SESSION['wrkcodreg'], 3, "0", STR_PAD_LEFT); 
         if (file_exists($pas) == false) {
             mkdir($pas);
         }
         $cam = $pas . "/" . $des;
         $ret = move_uploaded_file($arq['tmp_name'], $cam);
         if ($ret == false) {
              echo "<script>alert('Erro na cópia do arquivo informado para upload')</script>";
              $sta = 6; 
         } else {
             $sta = gravar_log(22,"UpLoad do logotipo Nome: " . $cam . " Tamanho: " . $tam);
         }      
     }    
     return $sta;
 }

 function valida_cer(&$ret, &$men, &$dti, &$dtf){
     $sta = 0; $ret = 0; $men = "";
     if ($_REQUEST['cam'] == "") { return 1; }
     $dir = "Emp_" . str_pad($_SESSION['wrkcodreg'], 3, "0", STR_PAD_LEFT) . '/' . $_REQUEST['cam']; 
     if (file_exists($dir) == false) { 
          echo "<script>alert('Caminho para o certificado digital não encontrado no sistema')</script>";  
          $ret = 1; $men = "Caminho para o certificado digital não encontrado no sistema"; return 2; 
     }
     error_reporting(E_ALL);
     ini_set('display_errors', 'On');
     include_once "sped-nfe-master/Common/Certificate/SignatureInterface.php";
     include_once "sped-nfe-master/Common/Certificate/VerificationInterface.php";
     include_once "sped-nfe-master/Common/Exception/ExceptionInterface.php";
     include_once "sped-nfe-master/Common/Exception/CertificateException.php";
     include_once "sped-nfe-master/Common/Exception/ValidatorException.php";
     include_once "sped-nfe-master/Common/Exception/RuntimeException.php";
     include_once "sped-nfe-master/Common/Certificate/PrivateKey.php";
     include_once "sped-nfe-master/Common/Certificate/PublicKey.php";
     include_once "sped-nfe-master/Common/Certificate/Asn1.php";
     include_once "sped-nfe-master/Common/Certificate.php";
     include_once "sped-nfe-master/Common/Certificate/CertificationChain.php";
     $pfx = file_get_contents($dir);

 try {     
     $cer = Certificate::readPfx($pfx, $_REQUEST['ace']);

     $nom = $cer->publicKey->commonName;
     $dti = $cer->getValidFrom()->format('Y-m-d H:i:s');
     $dtf = $cer->getValidTo()->format('Y-m-d H:i:s');
     if ($dti > date('Y-m-d')) {
          $ret = 2; $men = "Data inicial do certificado ainda não foi alcançada, lamento"; $sta = 1;           
     }
     if ($dtf < date('Y-m-d')) {
          $ret = 3; $men = "Certificado informado para emitente está vencido [" . date('d/m/Y', strtotime($dtf)) . "], lamento"; $sta = 1;
     }
} catch (\Exception $e) {
     $men = 'Não foi possível validar o certificado informado para o emitente';
     $txt = $e->getMessage();
     $sta = $sta + 1;
}
     return $sta;
}

?>

</html>
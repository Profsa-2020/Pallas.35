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
               $ret = gravar_log(10,"Entrada na página de manutenção de transportadora do sistema Pallas.35 - Gold Solutions");  
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
     $tip = (isset($_REQUEST['tip']) == false ? 4 : $_REQUEST['tip']);
     $ema = (isset($_REQUEST['ema']) == false ? '' : $_REQUEST['ema']);
     $sit = (isset($_REQUEST['sit']) == false ? '' : $_REQUEST['sit']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : $_REQUEST['obs']);
     $raz = (isset($_REQUEST['raz']) == false ? '' : str_replace("'", "´", $_REQUEST['raz']));
     if ($_SESSION['wrkopereg'] == 1) { 
     $cod = ultimo_cod();
     $_SESSION['wrkmostel'] = 1;
}
if ($_SESSION['wrkopereg'] == 3) { 
     $bot = 'Deletar'; 
     $per = ' onclick="return confirm(\'Confirma exclusão de transportadora informado em tela ?\')" ';
}  
if ($_SESSION['wrkopereg'] >= 2) {
     if (isset($_REQUEST['salvar']) == false) { 
          $cha = $_SESSION['wrkcodreg']; $_SESSION['wrkmostel'] = 1;
          $ret = ler_transporte($cha, $raz, $sta, $pes, $inm, $ema, $tel, $cel, $cep, $end, $num, $com, $bai, $cid, $est, $obs, $sit, $con, $ins, $cgc, $tip); 
     }
 }
 if (isset($_REQUEST['salvar']) == true) {
     $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
     if ($_SESSION['wrkopereg'] == 1) {
         $ret = consiste_tra();
         if ($ret == 0) {
             $ret = incluir_tra();
             $ret = gravar_log(11,"Inclusão de nova transportadora: " . $raz);
             $cod = ultimo_cod(); $_SESSION['wrkcodreg'] = $cod; 
             $pes = 1; $raz= ''; $ema = ''; $sta = 0; $tip = 0; $tel = ''; $cel = ''; $end = ''; $cep = ''; $bai = ''; $cid = ''; $est = ''; $com = ''; $con = ''; $sit = ''; $obs = ''; $cgc = ''; $ins = ''; $inm = '';
         }
     }
     if ($_SESSION['wrkopereg'] == 2) {
         $ret = consiste_tra();
         if ($ret == 0) {
             $ret = alterar_tra();
             $ret = gravar_log(12,"Alteração de transportadora existente: " . $raz);  
             $pes = 1; $raz= ''; $ema = ''; $sta = 0; $tip = 0; $tel = ''; $cel = ''; $end = ''; $cep = ''; $bai = ''; $cid = ''; $est = ''; $com = ''; $con = ''; $sit = ''; $obs = ''; $cgc = ''; $ins = ''; $inm = ''; 
             echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
         }
     }
     if ($_SESSION['wrkopereg'] == 3) {
         $ret = excluir_tra();
         $ret = gravar_log(13,"Exclusão de transportadora existente: " . $raz); 
         $pes = 1; $raz= ''; $ema = ''; $sta = 0; $tip = 0; $tel = ''; $cel = ''; $end = ''; $cep = ''; $bai = ''; $cid = ''; $est = ''; $com = ''; $con = ''; $sit = ''; $obs = ''; $cgc = ''; $ins = ''; $inm = ''; 
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
                              <label>Manutenção de Transportadoras</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-destino.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar novo transportadora no sistema"><i
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
                              <div class="col-md-12">
                                   <label>Razão Social</label>
                                   <input type="text" class="form-control" maxlength="75" id="raz" name="raz"
                                        value="<?php echo $raz; ?>" required />
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
                              <div class="col-md-2"></div>
                              <div class="col-md-2">
                                   <label>Tipo de Dado</label>
                                   <select name="tip" id="tip" class="form-control">
                                        <option value="0" <?php echo ($tip != 0 ? '' : 'selected="selected"'); ?>>Transportadora</option>
                                        <option value="1" <?php echo ($tip != 1 ? '' : 'selected="selected"'); ?>>Destinatário</option>
                                        <option value="2" <?php echo ($tip != 2 ? '' : 'selected="selected"'); ?>>Emitente</option>
                                   </select>
                              </div>
                              <div class="col-md-1"></div>
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
     $sql = mysqli_query($conexao,"Select idtransporte, trarazao from tb_transporte order by idtransporte desc Limit 1");
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $cod = $lin['idtransporte'] + 1;
     }
     return $cod;
 }

 function consiste_tra() {
     $sta = 0;
     $pes = (isset($_REQUEST['pes']) == false ? 0  : $_REQUEST['pes']);
     if (trim($_REQUEST['raz']) == "") {
         echo '<script>alert("Razão Social do transportadora não pode estar em branco");</script>';
         return 1;
     }
     if (trim($_REQUEST['cgc']) == "" || trim($_REQUEST['cgc']) == "../-" || trim($_REQUEST['cgc']) == "..-") {
         echo '<script>alert("Número do C.n.p.j. do transportadora pode estar em branco");</script>';
         return 7;
     }
     if (valida_est(strtoupper($_REQUEST['est'])) == 0) {
         echo '<script>alert("Estado da Federação do transportadora informado não é válido");</script>';
         return 8;
     }
     if (strlen($_REQUEST['obs']) > 500) {
         echo '<script>alert("Observação do transportadora não pode ter mais de 500 caracteres");</script>';
         $sta = 1;
     }   
     if ($_REQUEST['cgc'] != "") {
         $sta = valida_cgc($_REQUEST['cgc']);
         if ($sta != 0) {
             echo '<script>alert("Dígito de controle do C.n.p.j. não está correto");</script>';
             return 8;
         }
     }    
     if (trim($_REQUEST['cgc']) != "") {
          $cod = cnpj_exi(2, $_REQUEST['cgc'], $nom);
          if ($cod != 0 && $cod != $_SESSION['wrkcodreg']) {
               echo '<script>alert("C.n.p.j. informado para transportadora já existe cadastrado");</script>';
               return 6;
          }    
     }
     return $sta;
 }

 function ler_transporte(&$cha, &$raz, &$sta, &$pes, &$inm, &$ema, &$tel, &$cel, &$cep, &$end, &$num, &$com, &$bai, &$cid, &$est, &$obs, &$sit, &$con, &$ins, &$cgc, &$tip) {
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select * from tb_transporte where idtransporte = " . $cha);
     if (mysqli_num_rows($sql) == 0) {
         echo '<script>alert("Código do transportadora informado não cadastrado");</script>';
         $nro = 1;
     }else{
         $lin = mysqli_fetch_array($sql);
         $cha = $lin['idtransporte'];
         $raz = $lin['trarazao'];
         $sta = $lin['trastatus'];
         $cgc = $lin['tracnpj'];
         $ins = $lin['trainscricao'];
         $inm = $lin['trainsmunic'];
         $con = $lin['tracontato'];
         $sit = $lin['trawebsite'];
         $ema = $lin['traemail'];
         $tel = $lin['tratelefone'];
         $cel = $lin['tracelular'];
         $cep = $lin['tracep'];
         $end = $lin['traendereco'];
         $num = $lin['tranumeroend'];
         $com = $lin['tracomplemento'];
         $bai = $lin['trabairro'];
         $cid = $lin['tracidade'];
         $est = $lin['traestado'];
         $pes = $lin['trapesfisica'];
         $tip = $lin['tratipotransp'];
         $obs = $lin['traobservacao'];
         $_SESSION['wrkcodreg'] = $lin['idtransporte'];
     }
     return $cha;
 }

 function incluir_tra() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "insert into tb_transporte (";
     $sql .= "traempresa, ";
     $sql .= "tracnpj, ";
     $sql .= "trastatus, ";
     $sql .= "trainscricao, ";
     $sql .= "trarazao, ";
     $sql .= "tracep, ";
     $sql .= "traendereco, ";
     $sql .= "tranumeroend, ";
     $sql .= "tracomplemento, ";
     $sql .= "trabairro, ";
     $sql .= "tracidade, ";
     $sql .= "traestado, ";
     $sql .= "tracelular, ";
     $sql .= "tratelefone, ";
     $sql .= "traemail, ";
     $sql .= "tracontato, ";
     $sql .= "trawebsite, ";
     $sql .= "trainsmunic, ";
     $sql .= "tratipotransp, ";
     $sql .= "traobservacao, ";
     $sql .= "trapesfisica, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['cgc']) . "',";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . $_REQUEST['ins'] . "',";
     $sql .= "'" . $_REQUEST['raz'] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['cep']) . "',";
     $sql .= "'" . $_REQUEST['end'] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['num']) . "',";
     $sql .= "'" . $_REQUEST['com'] . "',";
     $sql .= "'" . $_REQUEST['bai'] . "',";
     $sql .= "'" . $_REQUEST['cid'] . "',";
     $sql .= "'" . $_REQUEST['est'] . "',";
     $sql .= "'" . $_REQUEST['cel'] . "',";
     $sql .= "'" . $_REQUEST['tel'] . "',";
     $sql .= "'" . $_REQUEST['ema'] . "',";
     $sql .= "'" . $_REQUEST['con'] . "',";
     $sql .= "'" . $_REQUEST['sit'] . "',";
     $sql .= "'" . $_REQUEST['inm'] . "',";
     $sql .= "'" . $_REQUEST['tip'] . "',";
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

 function alterar_tra() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "update tb_transporte set ";
     $sql .= "tracnpj = '". limpa_nro($_REQUEST['cgc']) . "', ";
     $sql .= "trastatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "trainscricao = '". $_REQUEST['ins'] . "', ";
     $sql .= "trainsmunic = '". $_REQUEST['inm'] . "', ";
     $sql .= "trarazao = '". $_REQUEST['raz'] . "', ";
     $sql .= "tracep = '". limpa_nro($_REQUEST['cep']) . "', ";
     $sql .= "traendereco = '". $_REQUEST['end'] . "', ";
     $sql .= "tranumeroend = '". limpa_nro($_REQUEST['num']) . "', ";
     $sql .= "tracomplemento = '". $_REQUEST['com'] . "', ";
     $sql .= "trabairro = '". $_REQUEST['bai'] . "', ";
     $sql .= "tracidade = '". $_REQUEST['cid'] . "', ";
     $sql .= "traestado = '". $_REQUEST['est'] . "', ";
     $sql .= "tratelefone = '". $_REQUEST['tel'] . "', ";
     $sql .= "tracelular = '". $_REQUEST['cel'] . "', ";
     $sql .= "tracontato =  '". $_REQUEST['con'] . "', ";
     $sql .= "traemail = '". $_REQUEST['ema'] . "', ";
     $sql .= "trawebsite = '". $_REQUEST['sit'] . "', ";
     $sql .= "tratipotransp = '". $_REQUEST['tip'] . "', ";
     $sql .= "trapesfisica = '". (isset($_REQUEST['pes']) == false ? 0 : 1 ) . "', ";
     $sql .= "traobservacao = '". $_REQUEST['obs'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idtransporte = " . $_SESSION['wrkcodreg'];
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

 function excluir_tra() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "delete from tb_transporte where idtransporte = " . $_SESSION['wrkcodreg'] ;
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
         print_r($sql);
         echo '<script>alert("Erro na exclusão do transportadora solicitado !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
 }

?>

</html>
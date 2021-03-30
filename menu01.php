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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>

    <script type="text/javascript" src="js/profsa.js"></script>

    <link href="css/pallas35.css" rel="stylesheet" type="text/css" media="screen" />
    <title>Emissão de NF-e e NFC-e - Gold Software Soluções Inteligentes - Profsa Informática Ltda - Login</title>
</head>

<script>
$(document).ready(function() {

    var dti = '';
    var dtf = '';
    $.ajax({
        url: 'carrega-bar.php',
        type: 'POST',
        dataType: 'json',
        data: {
            ini: dti,
            fim: dtf
        },
        success: function(data) {
            if (data != '*') {
                tit = data.tit;
                val = data.val;
                var ctx = document.getElementsByClassName("grafico-1");
                var chartGraph = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: tit,
                        datasets: [{
                            label: "Faturamento Mensal",
                            data: val,
                            borderWidth: 1,
                            borderColor: 'rgba(4,69,254,0.9)',
                            backgroundColor: '#2797cf',
                        }]
                    }
                });
            }
        }
    });

});
</script>

<?php
     $ret = 00;
     $dad = array();
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;

     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(9,"Entrada na página de menu principal do sistema Pallas.35 - Emissão NF-e e NFC-e");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrknomemp']) == false) { $_SESSION['wrknomemp'] = ''; } 
 
     $ret = carrega_das($dad);

?>

<body>
    <h1 class="cab-0">Login Inicial Sistema Emissão NF-e e NFC-e - Gold Solution- Profsa Informática</h1>
    <?php include_once "cabecalho-1.php"; ?>
    <div class="row">
        <div class="qua-4 col-md-2">
            <?php include_once "cabecalho-2.php"; ?>
        </div>
        <div class="col-md-10 text-left">
             <br />
            <div class="row">
                <div class="col-md-10">
                    <span class="lit-4">DashBoard</span> &nbsp; &nbsp; &nbsp; <i class="fa fa-tachometer fa-3x"
                        aria-hidden="true"></i>
                </div>
                <div class="col-md-1 text-left">
                    <form id="frmEmiCup" name="frmEmiCup" action="emi-cupom.php?ope=1&cod=0" method="POST">
                        <div class="text-right">
                            <button type="submit" class="bot-3" id="dan" name="danfe"
                                title="Abre página para emissão de Cupom Fiscal Eletrônica para consumidor final"><i
                                    class="fa fa-shopping-cart fa-3x" aria-hidden="true"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-1 text-left">
                    <form id="frmEmiDan" name="frmEmiDan" action="emi-danfe.php?ope=6" method="POST">
                        <div class="text-center">
                            <button type="submit" class="bot-3" id="dan" name="danfe"
                                title="Abre página para efetuar emissão de Nota Fiscal Eletrônica da pré-nota no sistema"><i
                                    class="fa fa-paper-plane fa-3x" aria-hidden="true"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <br /><br />
            <div class="row text-center">
                <div class="col-md-1"></div>
                <div class="qua-9 col-md-2">
                    <?php
                         echo '<span>' . 'Usuários' . '</span><br />';
                         echo '<span>' . number_format($dad['usu'], 0, ",", ".") . '</span>';
                    ?>
                </div>
                <div class="qua-9 col-md-2">
                    <?php
                         echo '<span>' . 'Emitentes' . '</span><br />';
                         echo '<span>' . number_format($dad['emi'], 0, ",", ".") . '</span>';
                    ?>
                </div>
                <div class="qua-9 col-md-2">
                    <?php
                         echo '<span>' . 'Destinatários' . '</span><br />';
                         echo '<span>' . number_format($dad['des'], 0, ",", ".") . '</span>';
                    ?>
                </div>
                <div class="qua-9 col-md-2">
                    <?php
                         echo '<span>' . 'Produtos' . '</span><br />';
                         echo '<span>' . number_format($dad['pro'], 0, ",", ".") . '</span>';
                    ?>
                </div>
                <div class="qua-9 col-md-2">
                    <?php
                         echo '<span>' . 'Notas Fiscais' . '</span><br />';
                         echo '<span>' . number_format($dad['not'], 0, ",", ".") . '</span>';
                    ?>
                </div>
                <div class="col-md-1"></div>
            </div>
            <br />
            <div class="row text-center">
                <div class="col-md-2"></div>
                <div class="qua-9 col-md-3">
                    <?php
                         echo '<span>' . 'Pré-Notas' . '</span><br />';
                         echo '<span>' . 'R$ ' . number_format($dad['val_p'], 2, ",", ".") . '</span>';
                    ?>
                </div>
                <div class="qua-9 col-md-2">
                    <?php
                         echo '<span>' . 'Notas Fiscais' . '</span><br />';
                         echo '<span>' . 'R$ ' . number_format($dad['val_n'], 2, ",", ".") . '</span>';
                    ?>
                </div>
                <div class="qua-9 col-md-3">
                    <?php
                         echo '<span>' . 'Notas Canceladas' . '</span><br />';
                         echo '<span>' . 'R$ ' . number_format($dad['val_c'], 2, ",", ".") . '</span>';
                    ?>
                </div>
                <div class="col-md-2"></div>

            </div>
            <br />
            <hr /><br />
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <canvas class="grafico-1"></canvas>
                </div>
                <div class="col-md-3"></div>
            </div>
            <br />
            <hr /><br />

        </div>
    </div>
    </div>

</body>
<?php
function carrega_das(&$dad) {
     $ret = 0;
     $dad['usu'] = 0;
     $dad['emi'] = 0;
     $dad['des'] = 0;
     $dad['not'] = 0;
     $dad['pro'] = 0;
     $dad['val_p'] = 0;
     $dad['val_n'] = 0;
     $dad['val_c'] = 0;
     include "lerinformacao.inc";

     if ($_SESSION['wrktipusu'] >= 4) {
          $com = "Select count(*) as qtde from tb_usuario";
     } else {
          $com = "Select count(*) as qtde from tb_usuario where usuempresa = " . $_SESSION['wrkcodemp'];
     }
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $dad['usu'] += $reg['qtde'];
     }

     if ($_SESSION['wrktipusu'] >= 4) {
          $com = "Select count(*) as qtde from tb_emitente";
     } else {
          $com = "Select count(*) as qtde from tb_emitente where emiempresa = " . $_SESSION['wrkcodemp'];
     }
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $dad['emi'] += $reg['qtde'];
     }

     if ($_SESSION['wrktipusu'] >= 4) {
          $com = "Select count(*) as qtde from tb_destino";
     } else {
          $com = "Select count(*) as qtde from tb_destino where desempresa = " . $_SESSION['wrkcodemp'];
     }
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $dad['des'] += $reg['qtde'];
     }

     $com = "Select count(*) as qtde from tb_produto" . ($_SESSION['wrktipusu'] >= 4 ? '' : ' where proempresa = ' . $_SESSION['wrkcodemp']) ;
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $dad['pro'] += $reg['qtde'];
     }

     $com = "Select count(*) as qtde from tb_nota_e" . ($_SESSION['wrktipusu'] >= 4 ? '' : ' where notempresa = ' . $_SESSION['wrkcodemp']) ;
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $dad['not'] += $reg['qtde'];
     }

     $com = "Select sum(pedvalorliq) as valor from tb_pedido" . ($_SESSION['wrktipusu'] >= 4 ? '' : ' where pedempresa = ' . $_SESSION['wrkcodemp']) ;
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $dad['val_p'] += $reg['valor'];
     }

     $com = "Select sum(notvalnota) as valor from tb_nota_e" . ($_SESSION['wrktipusu'] >= 4 ? '' : ' where notempresa = ' . $_SESSION['wrkcodemp']) ;
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $dad['val_n'] += $reg['valor'];
     }

     $com = "Select sum(notvalnota) as valor from tb_nota_e where notstatus = 3 " . ($_SESSION['wrktipusu'] >= 4 ? '' : ' and notempresa = ' . $_SESSION['wrkcodemp']) . " ";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $dad['val_c'] += $reg['valor'];
     }

     return $ret;
}

?>

</html>
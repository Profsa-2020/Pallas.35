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
    $("#cep").mask("99999-999");
    $("#cpf").mask("999.999.999-99");

    $("#cha").mask("999.999");
    $("#dat").mask("99/99/9999");
    $(".qua").mask("###.##0", { reverse: true });
    $("#qtd").mask("###.##0", { reverse: true });
    $("#inf").mask("###.##0,00", { reverse: true });
    $("#dsc").mask("###.##0,00", { reverse: true });
    $("#pre").mask("###.##0,00", { reverse: true });
});

$(function() {
    $('#des').autocomplete({
        minLength: 3,
        autoFocus: false,
        source: "carrega-des.php",
        select: function(event, ui) {
            var des = ui.item.value;
            var ini = des.indexOf("[");
            var fim = des.indexOf("]");
            if (ini > 0 && fim > 0) {
                var tam = fim - ini - 1;
                var cod = des.substring(ini + 1,
                    fim); // Pega uma parte da string, posição inicio e final igual MID()
                des = des.substring(0, ini - 1);
                $('#cha').val(cod);
                $('#des').val(des);
            }
        }
    });
});

$(document).ready(function() {
    var tip = 0;
    $('#ima-pro').hide();    
    $.getJSON("carrega-ini.php", {
            tip: tip
        })
        .done(function(data) {
            if (data.men != "") {
                alert(data.men);
            } else if (data.txt != "") {
                $('.ite-cup').empty().html(data.txt);
                var tot = data.tot.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
                });
                $('.val-tot').empty().html('Itens: ' + data.nro +
                    ' - Total: ' + tot);
            }
        }).fail(function(data) {
            console.log(JSON.stringify(data));
            alert(
                "Erro ocorrido no processamento da página inicial do cupom fiscal"
            );
        });

    $('#cha').blur(function() {
        var cod = $('#cha').val();
        var qtd = $('#qtd').val();
        if (cod != "") {
            $.getJSON("buscar-pro.php", {
                    cod: cod,
                    qtd: qtd
                })
                .done(function(data) {
                    if (data.men != "") {
                        alert(data.men);
                        $('#cha').val('');
                        $('#des').val('');
                        $('#med').val('');
                        $('#pre').val('');
                        $('#val').val('');
                        $('#ima').attr('src', '');
                    } else {
                        $('#cha').val(data.cod);
                        $('#des').val(data.des);
                        $('#med').val(data.uni);
                        $('#pre').val('R$ ' + data.pre);
                        $('#val').val('R$ ' + data.val);
                        if (data.ima == "") {
                            $('#ima').attr('src', '');
                        } else {
                            $('#ima').attr('src', data.ima);
                        }
                    }
                }).fail(function(data) {
                    console.log(JSON.stringify(data));
                    alert(
                        "Erro ocorrido no processamento do produto para item do cupom fiscal"
                    );
                });
        }
    });

    $('#des').blur(function() {
        var cod = $('#cha').val();
        var qtd = $('#qtd').val();
        if (cod != "") {
            $.getJSON("buscar-pro.php", {
                    cod: cod,
                    qtd: qtd
                })
                .done(function(data) {
                    if (data.men != "") {
                        alert(data.men);
                        $('#cha').val('');
                        $('#des').val('');
                        $('#med').val('');
                        $('#pre').val('');
                        $('#val').val('');
                    } else {
                        $('#cha').val(data.cod);
                        $('#des').val(data.des);
                        $('#med').val(data.uni);
                        $('#pre').val('R$ ' + data.pre);
                        $('#val').val('R$ ' + data.val);
                    }
                }).fail(function(data) {
                    console.log(JSON.stringify(data));
                    alert(
                        "Erro ocorrido no processamento do produto para item do cupom fiscal"
                    );
                });
        }
    });

    $('#qtd').change(function() {
        var qtd = $('#qtd').val();
        var cod = $('#cha').val();
        if (qtd == "") {
            $('#qtd').val(1);
        }

        if (cod != "") {
            $.getJSON("buscar-pro.php", {
                    cod: cod,
                    qtd: qtd
                })
                .done(function(data) {
                    if (data.men != "") {
                        alert(data.men);
                        $('#cha').val('');
                        $('#des').val('');
                        $('#med').val('');
                        $('#pre').val('');
                        $('#val').val('');
                    } else {
                        $('#cha').val(data.cod);
                        $('#des').val(data.des);
                        $('#med').val(data.uni);
                        $('#pre').val('R$ ' + data.pre);
                        $('#val').val('R$ ' + data.val);
                    }
                }).fail(function(data) {
                    console.log(JSON.stringify(data));
                    alert(
                        "Erro ocorrido no processamento do produto para item do cupom fiscal"
                    );
                });
        }

    });

    $('#qtd').blur(function() {
        var cod = $('#cha').val();
        var qtd = $('#qtd').val();
        if (cod != "") {
            $.getJSON("guardar-ite.php", {
                    cod: cod,
                    qtd: qtd
                })
                .done(function(data) {
                    if (data.men != "") {
                        alert(data.men);
                    } else {
                        $('.ite-cup').empty().html(data.txt);
                        var tot = data.tot.toLocaleString("pt-BR", {
                            style: "currency",
                            currency: "BRL"
                        });
                        $('.val-tot').empty().html('Itens: ' + data.nro +
                            ' - Total: ' + tot);
                        $('#tot').val(tot);
                        $('#cha').val('');
                        $('#des').val('');
                        $('#med').val('');
                        $('#qtd').val('');
                        $('#pre').val('');
                        $('#val').val('');
                    }
                }).fail(function(data) {
                    console.log(JSON.stringify(data));
                    alert(
                        "Erro ocorrido no processamento do item para o cupom fiscal"
                    );
                });
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
        $topo = $("#box00").offset().top;
        $('html, body').animate({
            scrollTop: $topo
        }, 1500);
    });

    $('#cpf').blur(function() {
        var cpf = $('#cpf').val();
        if (cpf != "" && cpf != "0") {
            $.getJSON("carrega-cpf.php", {
                    cpf: cpf
                })
                .done(function(data) {
                    if (data.men != "") {
                        $('#cpf').val('');
                        alert(data.men);
                    }
                    if (data.nom == "") {
                        $('#nom').val('');
                        $('#end').val('');
                        $('#num').val('');
                        $('#cep').val('');
                        $('#bai').val('');
                        $('#cid').val('');
                        $('#est').val('');
                        $('#ema').val('');
                        $('#cel').val('');
                    } else {
                        $('#nom').val(data.nom);
                        $('#end').val(data.end);
                        $('#num').val(data.num);
                        $('#cep').val(data.cep);
                        $('#bai').val(data.bai);
                        $('#cid').val(data.cid);
                        $('#est').val(data.est);
                        $('#ema').val(data.ema);
                        if (data.cel != "") {
                            $('#cel').val(data.cel);
                        } else {
                            $('#cel').val(data.tel);
                        }

                    }
                }).fail(function(data) {
                    console.log(JSON.stringify(data));
                    alert(
                        "Erro ocorrido no processamento do c.p.f. para o cliente informado"
                    );
                });
        }
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

    $('#cli_b').click(function() {
        $('#jan-cli').modal('show');
    });

    $('#pag_b').click(function() {
        $('#jan-pag').modal('show');
    });

    $('#fin_b').click(function() {
        var cpf = $('#cpf').val();
        var cep = $('#cep').val();
        var pag = $('#pag').val();
        var tot = $('#tot').val();
        var inf = $('#inf').val();
        var dsc = $('#dsc').val();
        var tro = $('#tro').val();
        $.getJSON("carrega-fim.php", {
                cpf: cpf,
                cep: cep,
                pag: pag,
                tot: tot,
                inf: inf,
                dsc: dsc,
                tro: tro
            })
            .done(function(data) {
                if (data.men != "") {
                    alert(data.men);
                }
                if (data.txt != "") {
                    $('#lis-fim').empty().html(data.txt);
                }
            }).fail(function(data) {
                console.log(JSON.stringify(data));
                alert(
                    "Erro ocorrido no processamento de finalização de compra"
                );
            });

        $('#jan-fim').modal('show');
    });

    $('#car_b').click(function() {
        var tip = 0;
        $.getJSON("carrega-car.php", {
                tip: tip
            })
            .done(function(data) {
                if (data.men != "") {
                    alert(data.men);
                }
                if (data.txt != "") {
                    $('#lis-pro').empty().html(data.txt);
                }
            }).fail(function(data) {
                console.log(JSON.stringify(data));
                alert(
                    "Erro ocorrido no processamento do carrinho de compras"
                );
            });

        $('#jan-car').modal('show');
    });

    $('#sal_c').click(function() {
        var dad = $('#frmJanCli').serialize();
        $.post("guardar-cli.php", dad, function(data) {
            if (data.men != "") {
                alert(data.men);
            }
            if (data.men == "") {
                return false;
            }
        }, "json"); // ou “text”
        $('#jan-cli').modal('hide');
    });

    $('#sal_p').click(function() {
        var dad = $('#frmJanCar').serialize();
        $.post("guardar-cup.php", dad, function(data) {
            if (data.men != "") {
                alert(data.men);
            }
            if (data.men == "") {
                $('.ite-cup').empty().html(data.txt);
                var tot = data.tot.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
                });
                $('.val-tot').empty().html('Itens: ' + data.nro + ' - Total: ' + tot);
                $('#tot').val(tot);
                return false;
            }
        }, "json"); // ou “text”
        $('#jan-car').modal('hide');
    });

    $('#sal_f').click(function() {

        $('#jan-pag').modal('hide');
        return false;
    });

    $('#inf').blur(function() {
        var inf = $('#inf').val();
        var pos = inf.indexOf(",");
        if (inf != '') {
            if (pos == -1) {
                $('#inf').val(inf + ',00');
            }
        }
        var dsc = $('#dsc').val();
        var tot = $('#tot').val();
        if (dsc == "") {
            dsc = '0,00';
        }
        inf = inf.replace('.', '');
        inf = inf.replace(',', '.');
        dsc = dsc.replace('.', '');
        dsc = dsc.replace(',', '.');
        tot = tot.replace('R$', '');
        tot = tot.replace('.', '');
        tot = tot.replace(',', '.');
        tot = parseFloat(tot, 10);
        inf = parseFloat(inf, 10);
        dsc = parseFloat(dsc, 10);
        if (inf != "") {
            if (inf >= (tot - dsc)) {
                var tro = (inf - tot + dsc).toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
                });
                $('#tro').val(tro);
            } else {
                $('#tro').val('');
            }
        }
    });

    $('#dsc').blur(function() {
        var inf = $('#inf').val();
        var dsc = $('#dsc').val();
        var tot = $('#tot').val();
        var pos = dsc.indexOf(",");
        if (dsc != '') {
            if (pos == -1) {
                $('#dsc').val(dsc + ',00');
            }
        }
        inf = inf.replace('.', '');
        inf = inf.replace(',', '.');
        dsc = dsc.replace('.', '');
        dsc = dsc.replace(',', '.');
        tot = tot.replace('R$', '');
        tot = tot.replace('.', '');
        tot = tot.replace(',', '.');
        tot = parseFloat(tot, 10);
        inf = parseFloat(inf, 10);
        dsc = parseFloat(dsc, 10);
        if (inf != "" && dsc != "") {
            if (inf >= (tot - dsc)) {
                var tro = (inf - tot + dsc).toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
                });
                $('#tro').val(tro);
            } else {
                $('#tro').val('');
            }
        }
    });

    $('#clo_f').click(function() {
        $('#frmTerCup').submit();
    });

    $('#gra_f').click(function() {
        $('#ima-pro').show();    
        var pag = $('#pag').val();
        var inf = $('#inf').val();
        var dsc = $('#dsc').val();
        var tro = $('#tro').val();
        var cpf = $('#cpf').val();
        var nom = $('#nom').val();
        var ema = $('#ema').val();
        $('#lis-err').empty().html('');
        $('#lis-sta').empty().html('');
        $.getJSON("emitir-cup.php", {
                pag: pag,
                inf: inf,
                dsc: dsc,
                tro: tro,
                cpf: cpf,
                nom: nom,
                ema: ema
            })
            .done(function(data) {
                if (data.men != "") {
                    $('#lis-err').empty().html(data.men);
                }
                if (data.xml != "") {
                    $('#cam-xml').attr('href', data.xml);
                }
                if (data.ret != "") {
                    $('#lis-sta').empty().html(data.ret);
                }
                if (data.pdf != "") {
                    $('#cup-pdf').attr('height', '600'); 
                    $('#cup-pdf').attr('src', data.pdf); 
                }
                $('#ima-pro').hide();    
            }).fail(function(data) {
                console.log(JSON.stringify(data));
                alert(
                    "Erro ocorrido na emissão do cupom fiscal eletrônico"
                );
            });
        return false;
    });

});
</script>

<?php
     $ret = 0;
     $err = 0;
     $txt = '';
     $avi = '';
     $dad = array();
     $dad['emi']['not'] = 0;
     $dad['not']['pdf'] = "";
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;
     $_SESSION['wrknomide'] = get_current_user();
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(18,"Entrada na página de emissão de cupom fiscal Pallas.35 - Emissão NF-e e NFC-e");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrkvaltot']) == false) { $_SESSION['wrkvaltot'] = 0; }
     if (isset($_SESSION['wrkqtdtot']) == false) { $_SESSION['wrkqtdtot'] = 0; }
     if (isset($_SESSION['wrkiteped']) == false) { $_SESSION['wrkiteped'] = array(); }

     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }

     if (isset($_SESSION['wrknomemp']) == false) { $_SESSION['wrknomemp'] = ''; } 
     if (isset($_SESSION['wrknumcha']) == false) { $_SESSION['wrknumcha'] = 0; }
     if (isset($_SESSION['wrkrecnot']) == false) { $_SESSION['wrkrecnot'] = ''; }
     if (isset($_SESSION['wrkchanot']) == false) { $_SESSION['wrkchanot'] = ''; }

    $cha = (isset($_REQUEST['cha']) == false ? '' : $_REQUEST['cha']);
    $des = (isset($_REQUEST['des']) == false ? '' : $_REQUEST['des']);
    $med = (isset($_REQUEST['med']) == false ? '' : $_REQUEST['med']);
    $qtd = (isset($_REQUEST['qtd']) == false ? 1 : $_REQUEST['qtd']);
    $pre = (isset($_REQUEST['pre']) == false ? '' : $_REQUEST['pre']);
    $val = (isset($_REQUEST['val']) == false ? '' : $_REQUEST['val']);

    $nom = (isset($_REQUEST['nom']) == false ? "" : $_REQUEST['nom']);
    $cpf = (isset($_REQUEST['cpf']) == false ? "" : $_REQUEST['cpf']);
    $cep = (isset($_REQUEST['cep']) == false ? "" : $_REQUEST['cep']);
    $end = (isset($_REQUEST['end']) == false ? "" : $_REQUEST['end']);
    $num = (isset($_REQUEST['num']) == false ? "" : $_REQUEST['num']);
    $com = (isset($_REQUEST['com']) == false ? "" : $_REQUEST['com']);
    $bai = (isset($_REQUEST['bai']) == false ? "" : $_REQUEST['bai']);
    $cid = (isset($_REQUEST['cid']) == false ? "" : $_REQUEST['cid']);
    $est = (isset($_REQUEST['est']) == false ? "" : $_REQUEST['est']);
    $cel = (isset($_REQUEST['cel']) == false ? '' : $_REQUEST['cel']);
    $ema = (isset($_REQUEST['ema']) == false ? '' : $_REQUEST['ema']);

    if (isset($dad['emi']['cod']) == false) {
        $ret = carrega_emp($dad); 
        $ret = carrega_emi($dad); 
        if ( $dad['emi']['csc'] == "" || $dad['emi']['csc'] == null) {
            echo '<script>alert("Não está informado Código de Segurança do Contribuinete - CSC");</script>';
        }
        if ( $dad['emi']['par'] == "0" || $dad['emi']['par'] == null) {
            echo '<script>alert("Não está informado Código de Parâmetro para emissão de NFC-e");</script>';
        }
        if ( $dad['par']['mod'] != '65') {
            echo '<script>alert("Môdelo para emissão do NFC-e informado difere de 65");</script>';
        }
    }

    if ($_SESSION['wrkopereg'] == 1 && $_SESSION['wrkcodreg'] == 0) {
        $_SESSION['wrkiteped'] = array(); $_SESSION['wrkqtdtot'] = 0; $_SESSION['wrkvaltot'] = 0; 
    }
?>

<body id="box00">
    <h1 class="cab-0">Emissão de Cupom Fiscal no Sistema Emissão NF-e e NFC-e - Gold Solution- Profsa Informática</h1>
    <div class="cupom">
        <?php include_once "cabecalho-3.php"; ?>
        <div class="containter-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="qua-a">
                        <form id="frmTerCup" name="frmTelCup" action="emi-cupom.php" method="POST">
                            <div class="row text-center">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <label>Produto</label><br />
                                    <input type="text" class="form-control text-center" maxlength="15" id="cha"
                                        autocomplete="off" name="cha" value="<?php echo $cha; ?>" />
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="row text-center">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <label>Descrição do Produto</label><br />
                                    <input type="text" class="form-control" maxlength="75" id="des" name="des"
                                        value="<?php echo $des; ?>" />
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row text-center">
                                <div class="col-md-5"></div>
                                <div class="col-md-2">
                                    <label>Unidade</label><br />
                                    <input type="text" class="form-control text-center" maxlength="5" id="med"
                                        name="med" value="<?php echo $med; ?>" disabled />
                                </div>
                                <div class="col-md-5"></div>
                            </div>
                            <div class="row text-center">
                                <div class="col-md-5"></div>
                                <div class="col-md-2">
                                    <label>Quantidade</label><br />
                                    <input type="text" class="form-control text-center" maxlength="7" id="qtd" autocomplete="off" name="qtd"
                                        value="<?php echo $qtd; ?>" />
                                </div>
                                <div class="col-md-5"></div>
                            </div>
                            <div class="row text-center">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <label>Preço</label><br />
                                    <input type="text" class="form-control text-center" maxlength="10" id="pre"
                                        name="pre" value="<?php echo $pre; ?>" disabled />
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="row text-center">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <label>Valor</label><br />
                                    <input type="text" class="lit-b form-control text-center" maxlength="10" id="val"
                                        name="val" value="<?php echo $val; ?>" disabled />
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </form>
                        <div class="row text-center">
                            <div class="lit-a col-md-12">
                                <p class="val-tot">
                                    <?php
                                                  if ($_SESSION['wrkqtdtot'] != 0) {
                                                       echo 'Itens: ' . $_SESSION['wrkqtdtot'] . ' - Total: R$ ' . number_format($_SESSION['wrkvaltot'], 2, ',', '.');
                                                  }
                                             ?>
                                </p>
                            </div>
                        </div>
                        <hr />
                        <div class="row text-center">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <img id="ima" src="" title="">
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <hr />
                    </div>
                </div>
                <div class="col-md-7 text-center">
                    <div class="qua-b">
                        <h3><strong>Lista de Itens - Cupom Nº
                                <?php echo number_format($dad['emi']['not'], 0, ',', '.'); ?></strong></h3>
                        <div class="row ite-cup">
                            <div class="tab-1 table-responsive">
                                <table id="tab-0" class="table table-sm table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Ordem</th>
                                            <th>Código</th>
                                            <th>Descrição do Produto</th>
                                            <th>Medida</th>
                                            <th>Quantidade</th>
                                            <th>Preço</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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

    <!-- Janela Modal com dados detalhados do título e pede campos para atualizar -->
    <div class="modal fade" id="jan-cli" tabindex="-1" role="dialog" aria-labelledby="tel-cli" aria-hidden="true"
        data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <!-- modal-sm lg xl -->
            <form id="frmJanCli" name="frmJanCli" action="" method="POST">
                <div class=" modal-content">
                    <div class="modal-header">
                        <strong>
                            <h4 class="modal-title text-danger" id="tel-cli">Dados do Cliente</h4>
                        </strong>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label id="doc_c">Número do C.p.f.</label>
                                <input type="text" class="form-control text-center" maxlength="14" id="cpf" name="cpf"
                                    value="<?php echo $cpf; ?>" />
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <label>C.e.p.</label>
                                <input type="text" class="form-control text-center" maxlength="9" id="cep" name="cep"
                                    value="<?php echo $cep; ?>" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Nome do Cliente</label>
                                <input type="text" class="form-control" maxlength="75" id="nom" name="nom"
                                    value="<?php echo $nom; ?>" />
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
                            <div class="col-md-5">
                                <label>Bairro</label>
                                <input type="text" class="form-control" maxlength="50" id="bai" name="bai"
                                    value="<?php echo $bai; ?>" />
                            </div>
                            <div class="col-md-5">
                                <label>Município</label>
                                <input type="text" class="form-control" maxlength="50" id="cid" name="cid"
                                    value="<?php echo $cid; ?>" />
                            </div>
                            <div class="col-md-2">
                                <label>Estado</label>
                                <input type="text" class="form-control text-center" maxlength="2" id="est" name="est"
                                    value="<?php echo $est; ?>" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label>E-Mail de Contato</label>
                                <input type="email" class="form-control" maxlength="75" id="ema" name="ema"
                                    value="<?php echo $ema; ?>" />
                            </div>
                            <div class="col-md-4">
                                <label>Número Telefone</label>
                                <input type="text" class="form-control" maxlength="15" id="cel" name="cel"
                                    value="<?php echo $cel; ?>" />
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" id="sal_c" name="salvar" value="cli"
                                class="btn btn-outline-success">Salvar</button>
                            <button type="button" id="fec_c" name="fechar" class="btn btn-outline-danger"
                                data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------------->

    <!-- Janela Modal com dados detalhados do título e pede campos para atualizar -->
    <div class="modal fade" id="jan-car" tabindex="-1" role="dialog" aria-labelledby="tel-car" aria-hidden="true"
        data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <!-- modal-sm lg xl -->
            <form id="frmJanCar" name="frmJanCar" action="" method="POST">
                <div class=" modal-content">
                    <div class="modal-header">
                        <strong>
                            <h4 class="modal-title text-danger" id="tel-car">Produtos Informados</h4>
                        </strong>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div id="lis-pro"></div>

                        <div class="modal-footer">
                            <button type="button" id="sal_p" name="salvar" value="car"
                                class="btn btn-outline-success">Salvar</button>
                            <button type="button" id="fec_p" name="fechar" class="btn btn-outline-danger"
                                data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------------->

    <!-- Janela Modal com dados detalhados do título e pede campos para atualizar -->
    <div class="modal fade" id="jan-pag" tabindex="-1" role="dialog" aria-labelledby="tel-pag" aria-hidden="true"
        data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <!-- modal-sm lg xl -->
            <form id="frmJanPag" name="frmJanPag" action="" method="POST">
                <div class=" modal-content">
                    <div class="modal-header">
                        <strong>
                            <h4 class="modal-title text-danger" id="tel-pag">Efetuar Pagamento</h4>
                        </strong>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                                   $sta = pagto_exi(0, $des, $dad);
                                   $nro = count($dad);
                              ?>
                        <div class="row">
                            <div id="lis-pag"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <label>Formas de Pagamento</label>
                                <select id="pag" name="pag" class="form-control" required>
                                    <?php 
                                                  for ($ind = 0; $ind < $nro; $ind++) {
                                                       echo  '<option value ="' . $dad['cha'][$ind] . "_" . $dad['din'][$ind] . '">' . $dad['des'][$ind] . '</option>'; 
                                                  }
                                             ?>
                                </select>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <label>Valor Total</label>
                                <input type="text" class="form-control text-center" maxlength="12" id="tot" name="tot"
                                    value="<?php echo 'R$ ' . number_format($_SESSION['wrkvaltot'], 2, ',', '.'); ?>"
                                    disabled />
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <label>Valor Informado</label>
                                <input type="text" class="form-control text-center" maxlength="12" id="inf" name="inf"
                                    value="" />
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <label>Valor de Desconto</label>
                                <input type="text" class="form-control text-center" maxlength="12" id="dsc" name="dsc"
                                    value="" />
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <label>Valor de Troco</label>
                                <input type="text" class="form-control text-center" maxlength="12" id="tro" name="tro"
                                    value="" disabled />
                            </div>
                            <div class="col-md-4"></div>
                        </div>

                        <br />
                        <div class="modal-footer">
                            <button type="button" id="sal_f" name="salvar" value="pag"
                                class="btn btn-outline-success">Salvar</button>
                            <button type="button" id="fec_f" name="fechar" class="btn btn-outline-danger"
                                data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------------->

    <!-- Janela Modal com dados detalhados do título e pede campos para atualizar -->
    <div class="modal fade" id="jan-fim" tabindex="-1" role="dialog" aria-labelledby="tel-fim" aria-hidden="true"
        data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <!-- modal-sm lg xl -->
            <form id="frmJanFim name=" frmJanFim" action="" method="POST">
                <div class=" modal-content">
                    <div class="modal-header">
                        <strong>
                            <h4 class="modal-title text-danger" id="tel-fim">Finaliza Venda - Emitir Cupom</h4>
                        </strong>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row text-center">
                            <div class="col-md-12">
                                <div id="lis-fim"></div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                            <img id="ima-pro" class="img-fluid" src="img/preloader2.gif" ></a>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="lit-8 col-md-12">
                                <div id="lis-err"></div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="lit-7 col-md-12">
                                <a id="cam-xml" href="#"
                                    title="Visualização do XML gerado para a emissão do cupom fiscal." target="_blank">
                                    <div id="lis-sta"></div>
                                </a>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <?php
                                $ret = carrega_emi($dad);   
                                $dad['not']['pdf'] = "Emp_" . str_pad($_SESSION['wrkcodemp'], 3, "0", STR_PAD_LEFT) . '/' . 'NFC_' . str_pad($_SESSION['wrkcodemp'], 3, "0",STR_PAD_LEFT) . '_' . str_pad($dad['emi']['ser'], 3, "0",STR_PAD_LEFT) . "_" . str_pad($dad['emi']['not'], 9, "0",STR_PAD_LEFT) . '-nfc.pdf';  
                                if (isset($dad['not']['pdf']) == true) {
                                    if (file_exists($dad['not']['pdf']) == false) { 
                                        echo '<embed id="cup-pdf" src="" width="100%" height="auto" type="application/pdf">';
                                    } else {
                                        echo '<embed id="cup-pdf" src="' . $dad['not']['pdf'] . '" width="100%" height="600" type="application/pdf">';
                                    }
                                }
                                ?>
                            </div>
                            <div class="col-md-1"></div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" id="gra_f" name="salvar" value="fim"
                                class="btn btn-outline-success">Emitir</button>
                            <button type="button" id="clo_f" name="fechar" class="btn btn-outline-danger"
                                data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------------->

</body>
<?php
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

function carrega_emp(&$dad) {
     $sta = 0;
     $dad['emp']['cod'] = 0;
     include "lerinformacao.inc";
     $com = "Select * from tb_empresa where idempresa = 1";
     $sql = mysqli_query($conexao,$com);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $dad['emp']['cod'] = $lin['idempresa'];
          $dad['emp']['raz'] = $lin['emprazao'];
          $dad['emp']['cgc'] = $lin['empcnpj'];
          $dad['emp']['ema'] = $lin['empemail'];
          $dad['emp']['con'] = $lin['empcontato'];
          $dad['emp']['tel'] = limpa_nro($lin['emptelefone']);
          $dad['emp']['cel'] = limpa_nro($lin['empcelular']);
     }
     return $sta;
}

function carrega_emi(&$dad) {
     $sta = 0;
     include "lerinformacao.inc";
     $dad['emi']['nro'] = $_SESSION['wrkcodemp'];
     $com = "Select * from tb_emitente where idemite = " . $_SESSION['wrkcodemp'];
     $sql = mysqli_query($conexao,$com);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $dad['emi']['cod'] = $lin['idemite'];
          $dad['emi']['raz'] = $lin['emirazao'];
          $dad['emi']['fan'] = $lin['emifantasia'];
          $dad['emi']['end'] = $lin['emiendereco'];
          $dad['emi']['num'] = $lin['eminumeroend'];
          $dad['emi']['com'] = $lin['emicomplemento'];
          $dad['emi']['bai'] = $lin['emibairro'];
          $dad['emi']['cep'] = $lin['emicep'];
          $dad['emi']['cid'] = $lin['emicidade'];
          $dad['emi']['est'] = $lin['emiestado'];
          $dad['emi']['mun'] = $lin['emicodmunic'];
          $dad['emi']['cgc'] = $lin['emicnpj'];
          $dad['emi']['ins'] = $lin['emiinscricao'];
          $dad['emi']['imu'] = $lin['emiinsmunic'];
          $dad['emi']['cna'] = $lin['emicnae'];
          $dad['emi']['reg'] = $lin['emiregime'];
          $dad['emi']['pes'] = $lin['emipessoa'];
          $dad['emi']['tel'] = $lin['emitelefone'];
          $dad['emi']['cel'] = $lin['emicelular'];
          $dad['emi']['con'] = $lin['emicontato'];
          $dad['emi']['ema'] = $lin['emiemail'];
          $dad['emi']['ver'] = $lin['emiverao'];
          $dad['emi']['ser'] = $lin['emicupomser'];
          $dad['emi']['not'] = $lin['emicupomnum'];
          $dad['emi']['amb'] = $lin['emitipoamb'];
          $dad['emi']['log'] = $lin['emicamlogo'];
          $dad['emi']['cer'] = $lin['emicamcertif'];
          $dad['emi']['sen'] = $lin['emisencertif'];
          $dad['emi']['val'] = $lin['emidatcertif'];
          $dad['emi']['csc'] = $lin['eminumerocsc'];
          $dad['emi']['par'] = $lin['emiparametro'];
          $dad['emi']['emi'] = date('Y-m-d H:i:s');
          $dad['not']['con'] = configura_not($dad);
          $dad['par']['mod'] = retorna_dad('parmodelo', 'tb_parametro', 'idparametro', $dad['emi']['par'] );    
     }
     return $sta;
}

?>

</html>
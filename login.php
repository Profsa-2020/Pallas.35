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

     <link rel="shortcut icon" href="http://sistema.goldinformatica.com.br/site/wp-content/uploads/2019/04/favicon.png" />

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

     <script type="text/javascript" src="js/profsa.js"></script>

     <link href="css/pallas35.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Emissão de NF-e e NFC-e - Gold Software Soluções Inteligentes - Profsa Informática Ltda - Login</title>
</head>

<?php
     $sta = 00;
     $ret = 00;
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     $lem = (isset($_REQUEST['lem']) == false ? '' : $_REQUEST['lem']);
     $ret = verifica_ace($sta); $_SESSION['wrkmostel'] = 0; $_SESSION['wrkopereg'] = 0;
     if (isset($_POST['entrar']))  {
          $ret = 00;
          if ($_POST['senha'] == "") {
              $ret = 9;
              echo '<script>alert("Senha do usuário não foi informado para o sistema");</script>';
          }elseif ($_POST['email'] == "") {
              $ret = 9;
              echo '<script>alert("E-Mail de Acesso não foi informado para o sistema");</script>';
          }
          if ($ret == 0) {
              $ret = conecta_bco();
              if ($ret == 0) {
                  $sen_usu = $_POST['senha'];
                  $ema_usu = $_POST['email'];
                  $ret = val_entrada($sen_usu,$ema_usu);
                  if ($ret == 1) {
                      echo '<script>alert("Uso de caracteres inválidos no login e/ou senha");</script>';
                  }
                  if ($ret == 2) {
                      echo '<script>alert("Há mais de um usuário com esse login e senha");</script>';
                  }                    
                  if ($ret == 3) {
                      echo '<script>alert("Senha e e-mail não encontrados no banco de dados");</script>';
                  }
                  if ($ret == 0) {
                      if ($_SESSION['wrkstausu'] == 1) {
                          echo '<script>alert("Usuário e senha informados não tem permissão de acesso");</script>';
                      }
                      if ($_SESSION['wrkdatval'] != null) {
                         $hoj = date('Y-m-d');
                         $dia = diferenca_dat(inverte_dat($hoj), inverte_dat($_SESSION['wrkdatval']));
                         if ($_SESSION['wrkdatval'] < $hoj) {
                              $ret = 7;
                              echo '<script>alert("Data de validade de acesso pelo usuário está vencida");</script>';     
                         } elseif (abs($dia) <= 15) {
                              echo '<script>alert("Atenção !   Usuário terá somente mais ' . abs($dia) . ' dias de acesso ao sistema !");</script>';     
                         }
                    }
                      if ($_SESSION['wrkstausu'] != 1) {
                          if ($_SESSION['wrktipusu'] < 0) {
                               echo '<script>alert("Usuário não tem permisão para acesso ao menu do sistema");</script>';
                          }else{
                              $_SESSION['wrknompro'] = __FILE__;
                              if ($lem == "S") {
                                  setcookie("k_ent", $sen_usu, time() + 3600 * 24 * 30);  // 60 * 60 * 24 * 30 = 30 dias
                                  setcookie("k_end", $ema_usu, time() + 3600 * 24 * 30);  
                              }
                                if ($_SESSION['wrktipusu'] == 1) {
                                  $ret = gravar_log(1,"Entrada para acesso ao sistema Pallas.35 - Menu.01 - Gold Software");  
                                  exit('<script>location.href = "emi-cupom.php"</script>');
                              }else if ($_SESSION['wrktipusu'] == 2) {
                                  $ret = gravar_log(2,"Entrada para acesso ao sistema Pallas.35 - Menu.02 - Gold Software");  
                                  exit('<script>location.href = "menu01.php"</script>');
                              }else if ($_SESSION['wrktipusu'] == 3) {
                                  $ret = gravar_log(3,"Entrada para acesso ao sistema Pallas.35 - Menu.04 - Gold Software");  
                                  exit('<script>location.href = "menu01.php"</script>');
                              }else if ($_SESSION['wrktipusu'] == 4) {
                                     $ret = gravar_log(4,"Entrada para acesso ao sistema Pallas.35 - Menu.05 - Gold Software");  
                                     exit('<script>location.href = "menu01.php"</script>');
                                 }else{
                                  $_SESSION['wrkhabcon'] = '';
                                  $ret = gravar_log(5,"Entrada para acesso ao sistema Pallas.35 - Menu.05 - Gold Software");  
                                  exit('<script>location.href = "menu01.php"</script>');
                              }
                          }
                      }
                  }
              }
              $ret = desconecta_bco();
          }
      }
 
?>

<body class="login">
     <h1 class="cab-0">Login Inicial Gold Software Soluções Inteligentes - Emissão NF-e e NFC-e - Profsa Informática</h1>
     <div class="entrada">
          <div class="qua-1 animated bounceInDown">
               <form name="frmLogin" action="" method="POST">
                    <br /><br />
                    <div class="row">
                         <a href="http://www.sistema.goldinformatica.com.br/">
                              <img src="img/logo02.png" class="img-fluid" alt="Logotipo da empresa Gold Software"
                                   title="Acesso ao site principal da empresa Gold Software" />
                         </a>
                    </div>
                    <br /><br />
                    <div class="row">
                         <div class="col s2"></div>
                         <div class="input-field col s8">
                              <i class="material-icons prefix">email</i>
                              <input type="email" class="text-center" id="email" name="email" maxlength="50" required>
                              <label for="nome">E-mail do usuário para acesso ...</label>
                         </div>
                         <div class="col s2"></div>
                    </div>

                    <div class="row">
                         <div class="col s2"></div>
                         <div class="input-field col s8">
                              <i class="material-icons prefix">lock</i>
                              <input type="password" class="text-center" id="senha" name="senha" maxlength="15"
                                   required>
                              <label for="senha">Senha de acesso ao sistema ...</label>
                         </div>
                         <div class="col s2"></div>
                    </div>

                    <div class="row">
                         <input class="bot-1" type="submit" name="entrar" value="Entrar" />
                         <br /><br />
                         <input type="checkbox" id="lem" name="lem" value="S" />
                         <label class="tit-1" for="lem">Lembrar Login</label>
                         <br /><br />
                         <span class="tit-2"><a href="recupera.php">Esqueci a senha</a></span>
                    </div>
                    <br />
               </form>
          </div>
     </div>
</body>

<?php
function verifica_ace($ret) {
     $sta = 0;
     if (isset($_COOKIE["k_ent"]) == false || isset($_COOKIE["k_end"]) == false) {
         return 9;
     }
     $sen_usu = $_COOKIE["k_ent"];
     $ema_usu = $_COOKIE["k_end"];
     $sta = val_entrada($sen_usu, $ema_usu);
     if ($sta == 0) {
         if ($_SESSION['wrkstausu'] == 2) {
             $sta = 2;
         }
         if ($sta == 0) {
             if ($_SESSION['wrktipusu'] == 1) {
                 $ret = gravar_log(1,"Entrada para acesso ao sistema Pallas.35 - Menu.01 - Gold Software");  
                 exit('<script>location.href = "emi-cupom.php"</script>');
             }else if ($_SESSION['wrktipusu'] == 2) {
                 $ret = gravar_log(2,"Entrada para acesso ao sistema Pallas.35 - Menu.02 - Gold Software");  
                 exit('<script>location.href = "menu01.php"</script>');
             }else if ($_SESSION['wrktipusu'] == 3) {
                 $ret = gravar_log(3,"Entrada para acesso ao sistema Pallas.35 - Menu.03 - Gold Software");  
                 exit('<script>location.href = "menu01.php"</script>');
             }else if ($_SESSION['wrktipusu'] == 4) {
                 $ret = gravar_log(4,"Entrada para acesso ao sistema Pallas.35 - Menu.04 - Gold Software");  
                 exit('<script>location.href = "menu01.php"</script>');
             }else{
                 $ret = gravar_log(5,"Entrada para acesso ao sistema Pallas.35 - Menu.05 - Gold Software");  
                 exit('<script>location.href = "menu01.php"</script>');
             }
         }
     }
     return $sta;
 }
?>

</html>

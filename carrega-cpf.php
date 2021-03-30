<?php
     $cpf = 0;
     $tab = array();
     session_start();
     $tab['cod'] = 0;
     $tab['nom'] = '';
     $tab['men'] = '';
     include_once "funcoes.php";
     include_once "lerinformacao.inc";
     if (isset($_REQUEST['cpf']) == true) { $cpf = limpa_nro($_REQUEST['cpf']); }     
     $sta = valida_cpf($cpf);
     if ($sta != 0) {
          $tab['men'] = 'Dígito de controle do C.p.f. informado não está correto';
     }
     if ($tab['men'] == "") {
          $com = "Select * from tb_destino where descnpj = '" . limpa_nro($cpf) . "'";
          $sql = mysqli_query($conexao,$com);
          if (mysqli_num_rows($sql) == 1) {
               $lin = mysqli_fetch_array($sql);
               $tab['cod'] = $lin['iddestino'];
               $tab['nom'] = $lin['desrazao'];
               $tab['cpf'] = $lin['descnpj'];
               $tab['end'] = $lin['desendereco'];
               $tab['num'] = $lin['desnumeroend'];
               $tab['com'] = $lin['descomplemento'];
               $tab['bai'] = $lin['desbairro'];
               $tab['cid'] = $lin['descidade'];
               $tab['est'] = $lin['desestado'];
               $tab['ema'] = $lin['desemail'];
               $tab['cel'] = $lin['descelular'];
               $tab['tel'] = $lin['destelefone'];
               $tab['mun'] = $lin['descodmunic'];
               $tab['cep'] = mascara_cpo($lin['descep'], '     -   ');
          }
     }
     echo json_encode($tab);     

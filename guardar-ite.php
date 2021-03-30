<?php
     $sta = 0;
     $nro = 0;
     $ope = 0;
     $cod = 0;
     $qtd = 0;
     $pre = 0;
     $val = 0;
     $txt = '';
     $des = '';
     $men = '';
     $med = '';
     session_start();
     $tab = array();
     $tab['tot'] = 0;     
     $tab['nro'] = 0;     
     $tab['men'] = '';
     include "lerinformacao.inc";
     include_once "funcoes.php";
     if (isset($_REQUEST['cod']) == true) { $cod = $_REQUEST['cod']; }
     if (isset($_REQUEST['qtd']) == true) { $qtd = $_REQUEST['qtd']; }
     if (isset($_REQUEST['pre']) == true) { $pre = $_REQUEST['pre']; }
     if (isset($_REQUEST['val']) == true) { $val = $_REQUEST['val']; }
     if (isset($_REQUEST['des']) == true) { $des = $_REQUEST['des']; }

     if ($cod == "") {$cod = 0; }
     if ($qtd == "") {$qtd = 1; }
     if ($pre == "") {$pre = 1; }
     if ($val == "") {$val = 1; }
     if ($cod != 0 && $des == '') {
          $ret = descricao_pro($cod, $des, $med, $pre); 
     }
     if ($qtd != "") { $qtd = str_replace(".", "", $qtd); }
     $txt = '
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
               <tbody>';
     if (isset($_SESSION['wrkiteped']['cod']) == true) {
          $nro = count($_SESSION['wrkiteped']['cod']);
     }
     if ($nro == 0) {
          $_SESSION['wrkiteped']['seq'][] = 0;
          $_SESSION['wrkiteped']['sta'][] = $ope;
          $_SESSION['wrkiteped']['cod'][] = $cod;
          $_SESSION['wrkiteped']['des'][] = $des;
          $_SESSION['wrkiteped']['med'][] = $med;
          $_SESSION['wrkiteped']['qtd'][] = $qtd;
          $_SESSION['wrkiteped']['liq'][] = $pre;
          $_SESSION['wrkiteped']['bru'][] = $pre;
          $_SESSION['wrkiteped']['val'][] = $qtd * $pre; 
          $_SESSION['wrkiteped']['usu'][] = $_SESSION['wrkideusu'];
          $_SESSION['wrkiteped']['dat'][] = date("Y/m/d H:i:s");
     } else {
          $fla = "";
          for ($ind = 0; $ind < $nro; $ind++) {
               if ($_SESSION['wrkiteped']['cod'][$ind] == $cod) {
                    $fla = "*"; break; 
               }                         
          }
          if ($fla == "") {
               $_SESSION['wrkiteped']['sta'][] = $ope;
               $_SESSION['wrkiteped']['seq'][] = $ind;
               $_SESSION['wrkiteped']['cod'][] = $cod;
               $_SESSION['wrkiteped']['des'][] = $des;
               $_SESSION['wrkiteped']['med'][] = $med;
               $_SESSION['wrkiteped']['qtd'][] = $qtd;
               $_SESSION['wrkiteped']['liq'][] = $pre;
               $_SESSION['wrkiteped']['bru'][] = $pre;
               $_SESSION['wrkiteped']['val'][] = $qtd * $pre;      
               $_SESSION['wrkiteped']['usu'][] = $_SESSION['wrkideusu'];
               $_SESSION['wrkiteped']['dat'][] = date("Y/m/d H:i:s");     
          } else {
               $_SESSION['wrkiteped']['sta'][$ind] = $ope;
               $_SESSION['wrkiteped']['seq'][$ind] = $ind;
               $_SESSION['wrkiteped']['cod'][$ind] = $cod;
               $_SESSION['wrkiteped']['des'][$ind] = $des;
               $_SESSION['wrkiteped']['med'][$ind] = $med;
               $_SESSION['wrkiteped']['qtd'][$ind] = $qtd;
               $_SESSION['wrkiteped']['liq'][$ind] = $pre;
               $_SESSION['wrkiteped']['bru'][$ind] = $pre;
               $_SESSION['wrkiteped']['val'][$ind] = $qtd * $pre;      
          }
     }
     
     if (isset($_SESSION['wrkiteped']['cod']) == true) {
          $nro = count($_SESSION['wrkiteped']['cod']);
     }
     if ($nro > 0) {
          for ($ind = 0; $ind < $nro; $ind++) {
               if ($_SESSION['wrkiteped']['cod'][$ind] != 0) {
                    if ($_SESSION['wrkiteped']['sta'][$ind] != 3) { 
                         $txt .= '<tr>';
                    } else {
                         $txt .= '<tr class="lit-r">';
                    }
                    $txt .= '<td>' . ($_SESSION['wrkiteped']['seq'][$ind] + 1) . '</td>';
                    $txt .= '<td>' . $_SESSION['wrkiteped']['cod'][$ind] . '</td>';
                    $txt .= '<td>' . $_SESSION['wrkiteped']['des'][$ind] . '</td>';
                    $txt .= '<td>' . $_SESSION['wrkiteped']['med'][$ind] . '</td>';
                    $txt .= '<td class="text-center">' . number_format($_SESSION['wrkiteped']['qtd'][$ind], 0, ',', '.') . '</td>';
                    $txt .= '<td class="text-center">' . number_format($_SESSION['wrkiteped']['bru'][$ind], 2, ',', '.') . '</td>';
                    $txt .= '<td class="text-center">' . number_format($_SESSION['wrkiteped']['val'][$ind], 2, ',', '.') . '</td>';
                    $txt .= '</tr>';
                    if ($_SESSION['wrkiteped']['sta'][$ind] != 3) { 
                         $tab['nro'] = $tab['nro'] + $_SESSION['wrkiteped']['qtd'][$ind];
                         $tab['tot'] = $tab['tot'] + $_SESSION['wrkiteped']['val'][$ind];
                    }
               }
          }
     }

     $txt .= '
     </tbody>
     </table>
     </div>';

     $tab['txt'] = $txt;
     $tab['men'] = $men;
     $_SESSION['wrkvaltot'] = $tab['tot'];
     $_SESSION['wrkqtdtot'] = $tab['nro'];
     $_SESSION['wrkiteped']['qtd_n'] = $tab['nro'];
     $_SESSION['wrkiteped']['val_b'] = $tab['tot'];

     echo json_encode($tab);     

function descricao_pro($cod, &$des, &$med, &$pre) {
     include "lerinformacao.inc";
     $sta = 0; $des = ''; $med = ''; $pre = 0; 
     $sql = mysqli_query($conexao,"Select idproduto, prodescricao, promedtributaria, propreco from tb_produto where idproduto = " . limpa_nro($cod));
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $pre = $lin['propreco']; 
          $des = $lin['prodescricao']; 
          $med = $lin['promedtributaria']; 
     }
     return $sta;
}     


?>
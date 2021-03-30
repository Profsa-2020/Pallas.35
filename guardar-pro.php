<?php
     $sta = 0;
     $ope = 0;
     $seq = 0;
     $cod = 0;
     $qtd = 0;
     $dev = 0;
     $pre = 0;
     $val = 0;
     $nro = 0;
     $ord = 0;
     $pcd = 0;
     $vld = 0;
     $des = '';
     $cfo = '';
     $ncm = '';
     $bar = '';
     $txt = '';
     $men = '';
     session_start();
     $tab = array();
     $tab['tot'] = 0;     
     $tab['nro'] = 0;     
     $tab['men'] = '';
     include "lerinformacao.inc";
     include_once "funcoes.php";
     if (isset($_REQUEST['pcd']) == true) { $pcd = $_REQUEST['pcd']; }
     if (isset($_REQUEST['vld']) == true) { $vld = $_REQUEST['vld']; }
     if (isset($_REQUEST['seqi']) == true) { $seq = $_REQUEST['seqi']; }
     if (isset($_REQUEST['codi']) == true) { $cod = $_REQUEST['codi']; }
     if (isset($_REQUEST['desi']) == true) { $des = $_REQUEST['desi']; }
     if (isset($_REQUEST['unii']) == true) { $uni = $_REQUEST['unii']; }
     if (isset($_REQUEST['qtdi']) == true) { $qtd = $_REQUEST['qtdi']; }
     if (isset($_REQUEST['prei']) == true) { $pre = $_REQUEST['prei']; }
     if (isset($_REQUEST['vali']) == true) { $val = $_REQUEST['vali']; }
     if (isset($_REQUEST['cfoi']) == true) { $cfo= $_REQUEST['cfoi']; }
     if (isset($_REQUEST['siti']) == true) { $sit = $_REQUEST['siti']; }
     if (isset($_REQUEST['ncmi']) == true) { $ncm = $_REQUEST['ncmi']; }
     if (isset($_REQUEST['bari']) == true) { $bar = $_REQUEST['bari']; }
     if (isset($_REQUEST['opei']) == true) { $ope = $_REQUEST['opei']; }
     if (isset($_REQUEST['ord']) == true) { $ord = $_REQUEST['codi']; }
     if ($cod == "") {$cod = 0; }
     if ($qtd == "") {$qtd = 1; }
     if ($pre == "") {$pre = 1; }
     if ($val == "") {$val = 1; }
     if ($sit == "") {$sit = 0; }
     if ($cfo == "") {$cfo = 0; }
     if ($pcd == "") {$pcd = 0; }
     if ($vld == "") {$vld = 0; }     
     $pre = str_replace('.','',$pre);  $pre = str_replace(',','.',$pre);
     $val = str_replace('.','',$val);  $val = str_replace(',','.',$val);
     $pcd = str_replace('.','',$pcd);  $pcd = str_replace(',','.',$pcd);
     $vld = str_replace('.','',$vld);  $vld = str_replace(',','.',$vld);
     if ($cod != 0 && $des == $cod) {
          $des = descricao_pro($cod, $med); 
     }
     if ($cod != 0 && $uni == "") {
          $des = descricao_pro($cod, $uni);
     }
     $txt = '
          <div class="tab-1 table-responsive">
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
               <tbody>';

     if (isset($_SESSION['wrkiteped']['cod']) == true) {
          $nro = count($_SESSION['wrkiteped']['cod']);
     }
     if ($nro == 0) {
          $_SESSION['wrkiteped']['seq'][] = 0;
          $_SESSION['wrkiteped']['sta'][] = $ope;
          $_SESSION['wrkiteped']['cod'][] = $cod;
          $_SESSION['wrkiteped']['des'][] = $des;
          $_SESSION['wrkiteped']['med'][] = $uni;
          $_SESSION['wrkiteped']['qtd'][] = $qtd;
          $_SESSION['wrkiteped']['dev'][] = $dev;
          $_SESSION['wrkiteped']['liq'][] = $pre;
          $_SESSION['wrkiteped']['bru'][] = $pre;
          $_SESSION['wrkiteped']['uni'][] = $pre;
          $_SESSION['wrkiteped']['sit'][] = $sit;
          $_SESSION['wrkiteped']['ncm'][] = $ncm;
          $_SESSION['wrkiteped']['bar'][] = $bar;
          $_SESSION['wrkiteped']['cfo'][] = $cfo;
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
               $_SESSION['wrkiteped']['med'][] = $uni;
               $_SESSION['wrkiteped']['qtd'][] = $qtd;
               $_SESSION['wrkiteped']['dev'][] = $dev;
               $_SESSION['wrkiteped']['liq'][] = $pre;
               $_SESSION['wrkiteped']['bru'][] = $pre;
               $_SESSION['wrkiteped']['uni'][] = $pre;
               $_SESSION['wrkiteped']['sit'][] = $sit;
               $_SESSION['wrkiteped']['ncm'][] = $ncm;
               $_SESSION['wrkiteped']['bar'][] = $bar;
               $_SESSION['wrkiteped']['cfo'][] = $cfo;     
               $_SESSION['wrkiteped']['val'][] = $qtd * $pre;      
               $_SESSION['wrkiteped']['usu'][] = $_SESSION['wrkideusu'];
               $_SESSION['wrkiteped']['dat'][] = date("Y/m/d H:i:s");     
          } else {
               $_SESSION['wrkiteped']['sta'][$ind] = $ope;
               $_SESSION['wrkiteped']['seq'][$ind] = $ind;
               $_SESSION['wrkiteped']['cod'][$ind] = $cod;
               $_SESSION['wrkiteped']['des'][$ind] = $des;
               $_SESSION['wrkiteped']['med'][$ind] = $uni;
               $_SESSION['wrkiteped']['qtd'][$ind] = $qtd;
               $_SESSION['wrkiteped']['dev'][$ind] = $dev;
               $_SESSION['wrkiteped']['liq'][$ind] = $pre;
               $_SESSION['wrkiteped']['bru'][$ind] = $pre;
               $_SESSION['wrkiteped']['uni'][$ind] = $pre;
               $_SESSION['wrkiteped']['sit'][$ind] = $sit;
               $_SESSION['wrkiteped']['ncm'][$ind] = $ncm;
               $_SESSION['wrkiteped']['bar'][$ind] = $bar;
               $_SESSION['wrkiteped']['cfo'][$ind] = $cfo;     
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
                    $tab['nro'] = $tab['nro'] + 1;
                    $tab['tot'] = $tab['tot'] + $_SESSION['wrkiteped']['val'][$ind];
               }
          }
     }

     $txt .= '
     </tbody>
     </table>
     </div>';
     $tab['txt'] = $txt;
     $tab['men'] = $men;
     $_SESSION['wrkiteped']['qtd_n'] = $tab['nro'];
     $_SESSION['wrkiteped']['val_b'] = $tab['tot'];
     $dsc = round($tab['tot'] * $pcd / 100, 4);
     $tab['val'] = number_format($tab['tot'] - $vld - $dsc, 2, ',', '.');
     $tab['tot'] = 'R$ ' . number_format($tab['tot'] - $vld - $dsc, 2, ',', '.');
     $_SESSION['wrkiteped']['val_l'] = $tab['val'];     
     
     echo json_encode($tab);     

     function descricao_pro($cod, &$med) {
          $des = '';
          include "lerinformacao.inc";
          $sql = mysqli_query($conexao,"Select idproduto,prodescricao, promedtributaria from tb_produto where idproduto = " . limpa_nro($cod));
          if (mysqli_num_rows($sql) == 1) {
               $lin = mysqli_fetch_array($sql);
               $des = $lin['prodescricao']; 
               $med = $lin['promedtributaria']; 
          }
          return $des;
     }     
?>
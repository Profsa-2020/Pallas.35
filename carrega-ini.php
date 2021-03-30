<?php
     $nro = 0;
     $txt = '';
     $men = '';
     session_start();
     $tab = array();
     $tab['txt'] = '';
     $tab['tot'] = 0;     
     $tab['nro'] = 0;     
     $tab['men'] = '';
     include "lerinformacao.inc";
     include_once "funcoes.php";

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

     if ($tab['tot'] != 0) { $tab['txt'] = $txt; }

     $_SESSION['wrkvaltot'] = $tab['tot'];
     $_SESSION['wrkqtdtot'] = $tab['nro'];
     $_SESSION['wrkiteped']['qtd_n'] = $tab['nro'];
     $_SESSION['wrkiteped']['val_b'] = $tab['tot'];

     echo json_encode($tab);     

?>
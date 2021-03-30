<?php
     $nro = 0;
     $tab = array();
     session_start();
     $tab['men'] = '';
     include "lerinformacao.inc";
     include_once "funcoes.php";
     $txt = '
          <div class="tab-1 table-responsive">
          <table class="tab-3 table table-sm table-striped">
               <thead>
                    <tr>
                    <th>Ordem</th>
                    <th>Código</th>
                    <th>Descrição do Produto</th>
                    <th>Medida</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Valor</th>
                    <th class="text-center">Excluir</th>
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
                    $txt .= '<td>' . '<input type="text" class="qua form-control text-center" maxlength="7" id="qtd_' . $ind . '" name="qtd_' . $ind . '" value="' . $_SESSION['wrkiteped']['qtd'][$ind] . '" />' . '</td>';
                    $txt .= '<td class="text-center">' . number_format($_SESSION['wrkiteped']['bru'][$ind], 2, ',', '.') . '</td>';
                    $txt .= '<td class="text-center">' . number_format($_SESSION['wrkiteped']['val'][$ind], 2, ',', '.') . '</td>';
                    $txt .= '<td class="text-center">' . ' <input type="checkbox" id="exc_' . $ind . '" name="exc_' . $ind . '" value="1" />  ' . '</td>';
                    $txt .= '</tr>';
               }
          }
     }
     $txt .= '
     </tbody>
     </table>
     </div>';

     $tab['txt'] = $txt;

     echo json_encode($tab);     

?>     
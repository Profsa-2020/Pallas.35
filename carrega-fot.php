<?php
     $qtd = 0;
     $cod = 0;
     $nro = 0;
     $txt = '';
     $ima = '';
     $tab = array();
     session_start();
     include "lerinformacao.inc";
     include_once "funcoes.php";
     if (isset($_REQUEST['cod']) == true) { $cod = $_REQUEST['cod']; }
     $sql = mysqli_query($conexao,"Select idproduto, prodescricao from tb_produto where idproduto = " . $cod);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $tab['cod'] = $lin['idproduto'];
          $tab['pro'] = $lin['prodescricao'];
     }
     $txt .= '<div class="row">
     <div class="col-md-12">
          <div class="tab-1 table-responsive">
               <table id="tab-0" class="table table-sm table-striped">
                    <thead>
                         <tr>
                              <th scope="col">Excluir</th>
                              <th scope="col">Ordem</th>
                              <th scope="col">Nome da Imagem</th>
                              <th scope="col">Extensão</th>
                              <th scope="col">Tamanho</th>
                              <th scope="col">Inclusão</th>
                              <th scope="col">Imagem</th>
                         </tr>
                    </thead>
                    <tbody>';

     $com = "Select *  from tb_produto_f where fotproduto = " . $cod . " order by fotsequencia";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $txt .=  '<tr>';
          $txt .= '<td class="lit-d bot-3 text-center"><a href="con-produto.php?ope=3&cod=' . $reg['idfoto'] . '" title="Efetua exclusão da imagem informado na linha"><i class="large material-icons">delete</i></a></td>';
          $txt .= '<td class="text-center">' . $reg['fotsequencia'] . '</td>';
          $txt .= '<td class="text-center">' . $reg['fotdescricao'] . '</td>';
          $txt .= '<td class="text-center">' . $reg['fotextensao'] . '</td>';
          $txt .= '<td class="text-center">' . $reg['fottamanho'] . '</td>';
          $txt .= '<td class="text-center">' . date('d/m/Y H:i:s', strtotime($reg['datinc'])) . '</td>';
          $cam = "fotos/" . "pro_" . str_pad($reg['fotproduto'], 8, "0", STR_PAD_LEFT) . "_" . str_pad($reg['fotsequencia'], 3, "0", STR_PAD_LEFT) . "." .  $reg['fotextensao'];
          $txt .= '<td class="text-center">' . '<img src="' . $cam . '" width="75"></td>';
          $txt .=  '</tr>';
     }
     $txt .= '
     </tbody>
     </table>';
     $tab['tab'] = $txt;
     echo json_encode($tab);     

?>

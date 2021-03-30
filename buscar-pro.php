<?php
     $cod = 0;
     $des = 0;
     $qtd = 0;
     $pre = 0;
     session_start();
     $tab = array();
     $tab['men'] = "";
     include "lerinformacao.inc";
     include_once "funcoes.php";
     if (isset($_REQUEST['cod']) == true) { $cod = $_REQUEST['cod']; }
     if (isset($_REQUEST['des']) == true) { $des = $_REQUEST['des']; }
     if (isset($_REQUEST['pre']) == true) { $pre = $_REQUEST['pre']; }
     if (isset($_REQUEST['qtd']) == true) { $qtd = $_REQUEST['qtd']; }
     if ($qtd == "") {$qtd = 1;}
     $com  = "Select * from tb_produto where idproduto = " . limpa_nro($cod);
     $sql = mysqli_query($conexao,$com);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          if ($lin['prostatus'] != 0) {
               $tab['men'] = "Código do produto informado não está ativo para venda";
          }
          $tab['pre'] = 0;
          $tab['val'] = 0;
          $tab['cod'] = $lin['idproduto'];
          $tab['des'] = $lin['prodescricao'];
          $tab['uni'] = $lin['promedtributaria'];
          if ($lin['propreco'] == 0) {
               $tab['men'] = "Preço unitário informado no produto não pode ser Zero";
          } else {
               $tab['pre'] = number_format($lin['propreco'], 2, ",", ".");
               if ($qtd != "") {
                    $tab['val'] = number_format($qtd * $lin['propreco'], 2, ",", ".");
               }
          }
          $tab['ima'] = imagem_pro($lin['idproduto']); 
     } else {
          $tab['men'] = "Código de produto informado no item não cadastrado no sistema";
     } 
     echo json_encode($tab);     

function imagem_pro($cod) {
     $ima = '';
     include "lerinformacao.inc";    
     $com = "Select idfoto, fotsequencia, fotproduto, fotextensao from tb_produto_f where fotproduto = " . $cod . " order by idfoto desc";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {       
          $cam = "fotos" . "/" . "pro_" . str_pad($reg['fotproduto'], 8, "0", STR_PAD_LEFT) . "_" . str_pad($reg['fotsequencia'], 3, "0", STR_PAD_LEFT) . "." . $reg['fotextensao'];
          if (file_exists($cam) == true) { 
               $ima = $cam; 
          }
     }
     return $ima;
}     

?>
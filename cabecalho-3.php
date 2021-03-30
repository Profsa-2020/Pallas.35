<?php
     if (isset($_SESSION['wrknomusu']) == false) {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "") {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "*") {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "#") {
          exit('<script>location.href = "login.php"</script>');   
     }   
     if (isset($_SESSION['wrknomemp']) == false) { $_SESSION['wrknomemp'] = '**********'; }
?>
     <div class="row qua-3">
          <div class="col-md-2 text-center">
               <a href="emi-cupom.php"> <img src="img/logo05.png"  title="Sistema Emissão NF-e e NFC-e - Gold Software Soluções Inteligentes"></a>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-1 text-center">
               <br /><a href="emi-cupom.php?ope=1&cod=0" title="Limpa dados para iniciar uma nova venda"><i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i> <br /> <span>Novo</span> </a>
          </div>
          <div class="col-md-1 text-center">
               <br /><button id="car_b" type="button" class="bot-3" title="Mostra itens informado para venda atual, produtos, quantidades e preços"><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i> <br /> <span>Carrinho</span> </button>
          </div>
          <div class="col-md-1 text-center">
               <br /><button id="cli_b" type="button" class="bot-3" title="Mostra itens informado para venda atual, produtos, quantidades e preços"><i class="fa fa-user fa-2x" aria-hidden="true"></i> <br /> <span>Cliente</span> </button>
          </div>
          <div class="col-md-1 text-center">
               <br /><button id="pag_b" type="button" class="bot-3" title="Abre janela para informar dados de pagamento e calculo de troco se pago em dinheiro para venda atual"><i class="fa fa-money fa-2x" aria-hidden="true"></i> <br /> <span>Pagamento</span> </button>
          </div>
          <div class="col-md-1 text-center">
               <br /><button id="fin_b" type="button" class="bot-3" title="Finaliza a compra, envia para a Receita Estadual, gera cupom fiscal para o cliente e registra a venda no caixa"><i class="fa fa-handshake-o fa-2x" aria-hidden="true"></i> <br /> <span>Finalizar</span> </button>
          </div>
          <div class="col-md-1 text-center">
               <br /><a href="adm-caixa.php" title="Mostra vendas efetuadas no dia e efetua movimento e administração de caixa"><i class="fa fa-bank fa-2x" aria-hidden="true"></i> <br /> <span>Caixa</span> </a>
          </div>
          <div class="col-md-1"></div>
          <div class="lit-1 col-md-2 text-center">
               <?php
                    echo '<strong>' . $_SESSION['wrknomusu'] . '</strong>' . '<br />' ;
                    echo '<div class="lit-2">' . $_SESSION['wrkemausu'] . '</div>' . '' ;
                    echo '<div class="lit-2">' . date('d/m/Y H:i:s')  . '</div>' . '';
                    if ($_SESSION['wrktipusu'] <= 2) {
                         echo '<a href="saida.php" title="Fecha sistema de Emissão de NFC-e e finaliza o sistema">';
                    } else {
                         echo '<a href="menu01.php" title="Fecha sistema de Emissão de NFC-e vai para menu principal">';
                    }
                    echo '<i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>';
                    echo '</a>';
               ?>
          </div>
     </div>

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
               <a href="menu01.php"> <img src="img/logo05.png"  title="Sistema Emissão NF-e e NFC-e - Gold Software Soluções Inteligentes"></a>
          </div>
          <div class="col-md-8 text-center">
               <?php
                    echo '<div class="lit-5">';
                    echo '<span>' . $_SESSION['wrknomemp'] . '</span>';
                    echo '</div>';
               ?>
          </div>
          <div class="lit-1 col-md-2 text-center">
               <?php
                    echo '<strong>' . $_SESSION['wrknomusu'] . '</strong>' . '<br />' ;
                    echo '<div class="lit-2">' . $_SESSION['wrkemausu'] . '</div>' . '' ;
                    echo '<div class="lit-2">' . date('d/m/Y H:i:s')  . '</div>' . '';
                    echo '<a href="saida.php" title="Fecha sistema de Emissão de NF-e e NFC-e">';
                    echo '<i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>';
                    echo '</a>';
               ?>
          </div>
     </div>

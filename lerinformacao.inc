<?php
    	$ser = "127.0.0.1:3306";
	$usu = "root";
        $pas = "";
	$bco = "bd_gold";
    
    	$conexao = mysqli_connect($ser,$usu,$pas,$bco) or die("Erro ao conectar o banco de dados do sistema -> " . $ser); 
    
	$banco = mysqli_select_db($conexao, $bco) or die("Erro ao selecionar o banco de dados do sistema -> " . $bco); 
    
    	$mysqli = new mysqli($ser,$usu,$pas,$bco) or die("Erro ao conectar o banco de dados do sistema MySqli -> " . $ser . " banco: " . $bco);
?>
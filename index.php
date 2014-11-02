<?php

/**
 *
 * Este projeto gera um simples placeholder para imagens. Ele
 * gera imagens para serem usadas em protótipos de tempaltes e
 * qualquer outro projeto que se precise de imagens rápidas
 * e não se pode perder tempo editando imagens para isso.
 *
 * Modo de uso:
 * ------------------------------------------------------------------------
 * Coloque os arquivos em um servidor e use o sendereço em
 * uma tag <img/> para exibir a imagem:
 *
 * Ex: <img src="http://linkparaoservidor.com/caminho/?size=400x300" />
 *
 * Parametros disponíveis:
 * ------------------------------------------------------------------------
 * size = Medidas da imagem (ex 400x300)
 * bg = Cor de fundo (ex fff)
 * tc = Cor do texto (ex fff)
 * text = Texto a ser exibido
 *
 * @author Eliel de Paula <elieldepaula@gmail.com>
 * @since 01/11/2014
 *
 */


header("Content-type: image/jpeg");

// Recebe as variáveis por query string.
$_size      = $_GET['size'];
$_bgcolor   = $_GET['bg'];
$_txtcolor  = $_GET['tc'];
$_text      = $_GET['text'];

// Defini o tamanho padrão caso não seja informado nenhum.
if($_size == ''){
	$_size = '400x300';
}

// Trata as medidas da imagem.
$_size = getSize($_size);

// Cria o stream da imagem.
$im = @imagecreate($_size[0], $_size[1]) or die("Não pude inicializar um stream de imagem com GD.");

// Define a cor do fundo.
if($_bgcolor == ''){
	$_bgcolor = hex2rgb('cccccc');
} else {
	$_bgcolor = hex2rgb($_bgcolor);
}

// Aplica a cor do fundo.
imagecolorallocate($im, $_bgcolor[0], $_bgcolor[1], $_bgcolor[2]);

// Define a cor do texto.
if($_txtcolor == ''){
	$_txtcolor = hex2rgb('333333');
} else {
	$_txtcolor = hex2rgb($_txtcolor);
}

// Aplica a cor no texto.
$_txtcolor = imagecolorallocate($im, $_txtcolor[0], $_txtcolor[1], $_txtcolor[2]);

// Define as medidas como texto caso nenhum texto seja enviado.
if($_text == ''){
	$_text = $_size[0] . ' x ' . $_size[1];
}

// Calcula uma média de tamanho para a fonte.
$_fontsize = ($_size[0] / 100) * 10;

// Pega os atributos do text box.
$tb = imagettfbbox($_fontsize, 0, './vera.ttf', $_text);

// Define os valores do posicionamento centralizado.
$x = ceil(($_size[0] - $tb[2]) / 2);
$y = ceil(($_size[1] - $tb[5]) / 2);

// Imprime o texto na imagem.
imagettftext($im, $_fontsize, 0, $x, $y, $_txtcolor, "./vera.ttf", $_text);

// Imprime a imagem.
imagejpeg($im);
imagedestroy($im);

// Faz a conversão dos valores hexadecimais das cores para valores RGB
function hex2rgb($hex) {
	
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   
   return $rgb; // Retorna um array com os valores RGB
}

// Retorna um array com as medidas da imagem.
function getSize($size){
	$sz = explode('x', $size);
	return $sz;
}
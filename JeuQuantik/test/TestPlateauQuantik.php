<?php

/**
 * Test de la calsse PlateauQuantik
 * @author tekfa fouad && mahdjane salim
 * @date 2022-01-15
 */
namespace test\quantik\src;

require_once("../src/PlateauQuantik.php");

use quantik\src\PlateauQuantik;
use quantik\src\PieceQuantik;
 echo"Test de la classe PlateauQuantik<br>";
echo("construire plateau vide puis l'afficher <br>");
$plateau = new PlateauQuantik();
echo("$plateau<br>");
$shpereNoir = PieceQuantik::initBlackSphere();
$plateau->setPiece(2, 3, $shpereNoir);
echo"Test la methode setPiece , en modifiant la position [2] [3] en remplacent vide par un shpere noir <br>";
echo("$plateau");

echo "<br>Test de la methode getPiece pour recupére la position [2][3]: <br>";
echo $plateau->getPiece(2,3);
echo "<br>Test de la methode getRow pour recupére la ligne 3<br>";
$ligne = $plateau->getRow(2);
for ($i = 0; $i < PlateauQuantik::NBROWS; $i++) {
    echo $ligne[$i] . " ";
}
echo "<br>Test de  la methode getCol pour recupere la colonne  <br>";
$colonne = $plateau->getcol(3);
for ($i = 0; $i < PlateauQuantik::NBCOLS; $i++) {
    echo $colonne[$i] . " "."<br>";

}

echo "<br> test de la methode getCorner pour  recupere le SUD_EST de notre plateau <br>";
$corner = $plateau->getCorner(PlateauQuantik::SE);
for ($i = 0; $i < PlateauQuantik::NBCOLS; $i++) {
    echo $corner[$i] . " ";
}
echo("<br>lever une exception à la position 5:3<br>");
try {
    echo($plateau->getPiece(5, 3)."<br>");
}catch(\Exception $e) {
    echo("$e<br><br>");

}


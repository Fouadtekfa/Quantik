<?php

/**
 * Test de la calsse ActionQuantik
 * @author tekfa fouad && mahdjane salim
 * @date 2022-01-15
 */
namespace test\quantik\src;

require_once("../src/ActionQuantik.php");
require_once("../src/PlateauQuantik.php");
require_once("../src/PieceQuantik.php");

use quantik\src\ActionQuantik;
use quantik\src\PlateauQuantik;
use quantik\src\PieceQuantik;

echo "Test de la classe ActionQuantik ";
echo "<br>Création d'un tableau <br>";
$plateau = new PlateauQuantik();
$action = new ActionQuantik($plateau);
echo"<br>Test de la méthode getplateau<br><br>";
echo($action->getPlateau());
$CUBEWHITE = PieceQuantik::initWhiteCube();
$CONEBLACK = PieceQuantik::initBlackCone();
$SPHERBLACK =pieceQuantik::initBlackSphere();
$CYLINDREBLACK=PieceQuantik::initBlackCylindre();
$plateau->setPiece(0, 0, $SPHERBLACK);
$plateau->setPiece(0, 1, $CONEBLACK);
$plateau->setPiece(2, 2, $SPHERBLACK);
$plateau->setPiece(0, 3, $CYLINDREBLACK);
$plateau->setPiece(1, 1,$SPHERBLACK );
$plateau->setPiece(2, 2,$CYLINDREBLACK );
$plateau->setPiece(2, 1, $CYLINDREBLACK);
$plateau->setPiece(3, 2, $CONEBLACK);
$plateau->setPiece(2, 3, $SPHERBLACK);

echo "<br>modifier le plateau vide <br><br>";
echo($action->getPlateau());
echo "<br> Test la methode isColWin<br>";
echo "<br>une colonne perdante return rien numcol=3  (faux)  :<br>";
echo $action->isColWin(3);

echo "<br> colonne (numcol=1) gagnante return vrai =1 :<br>";
echo $action->isColWin(1);


echo " <br><br>Test la methode isRowWin<br>";
echo "<br>ligne =0 (numrow=0) gagnante==> (vrai) ==> return 1 :<br>";
echo $action->isRowWin(0);
echo "<br>ligne =1 (numrow=1) perdante===>(faux ) ne retourne rien :<br>";
echo $action->isRowWin(1);
echo " <br>Test la methode isCornerWin<br>";
echo "<br>corner 3 gagnant (vrai)==> return 1 :<br>";
echo $action->isCornerWin(3);
echo "<br>corner 2 perdante ===>(faux) ne retourne rien :<br>";
echo $action->isCornerWin(2);



<?php


/**test de la classe pieceQuantik
 * @author tekfa fouad && mahdjane salim
 * @date 2022-01-15
 */
namespace tests\quantik\src;

require_once("../src/PieceQuantik.php");

use quantik\src\PieceQuantik;
echo "TESTS DE LA CLASSE PieceQuantik<br><br><br>";
$piece = PieceQuantik::initVoid();
echo ("Test initVoid : <br> ".$piece."<br><br>");
$piece=PieceQuantik::initWhiteCube();
echo ("Test initWhiteCube() : <br>".$piece."<br><br>");
$piece= PieceQuantik::initBlackCube();
echo "Test initBlackCube : <br><br>" .$piece."<br><br>";
$piece == PieceQuantik::initWhiteCone();
echo "Test initWhiteCone <br>" .$piece. "<br><br>";
$piece=PieceQuantik::initBlackCone();
echo "Test initBlackCone: <br>" .$piece. "<br><br>";
$piece=PieceQuantik::initWhiteCylindre();
echo "Test initWhiteCylindre : <br>" .$piece."<br><br>";
$piece=PieceQuantik::initBlackCylindre();
echo "initBlackCylindre <br>" .$piece."<br><br>";
$piece=PieceQuantik::initWhiteSphere();
echo "Test initWhiteSphere: <br>" .$piece."<br><br>";
$piece= PieceQuantik::initBlackSphere();
echo "Test initBlackSphere: <br>" .$piece."<br><br>";






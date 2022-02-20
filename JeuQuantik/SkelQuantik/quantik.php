<?php
/**
 * @author TEKFA FOUAD && MEHDJAN SALIM
 * @date janvier 2021
 */

require_once("../src/PieceQuantik.php");
require_once("../src/PlateauQuantik.php");
require_once("../src/ActionQuantik.php");
require_once("../SkelQuantik/QuantikException.php");
require_once("../SkelQuantik/QuantikUIGenerator.php");



use quantik\src\PieceQuantik;
use quantik\src\PlateauQuantik;
use quantik\src\ActionQuantik;
use quantik\src\ArrayPieceQuantik;
use quantik\QuantikException;


session_start();



if (isset($_GET['reset'])) { //pratique pour réinitialiser une partie à la main
    unset($_SESSION['etat']);
    unset($_SESSION['lesBlancs']);
    unset($_SESSION['lesNoirs']);
    unset($_SESSION['couleurActive']);
    unset($_SESSION['plateau']);
    unset($_SESSION['message']);
}

if (empty($_SESSION)) { // initialisation des variables de session
    $_SESSION['lesBlancs'] = ArrayPieceQuantik::initPiecesBlanches();
    $_SESSION['lesNoirs'] = ArrayPieceQuantik::initPiecesNoires();
    $_SESSION['plateau'] = new PlateauQuantik();
    $_SESSION['etat'] = 'choixPiece';
    $_SESSION['couleurActive'] = PieceQuantik::WHITE;
    $_SESSION['message'] = "";
}

$pageHTML = "";
$aq = new ActionQuantik($_SESSION['plateau']);

// on réalise les actions correspondant à l'action en cours :
try {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {

            case 'choisirPiece':
                $_SESSION['etat'] = "posePiece";
                break;

            case 'poserPiece':
                $_SESSION['etat'] = "choixPiece";

                $coordonnesX = -1;
                $coordonnesY = -1;
                if (isset($_GET['coord'])) {
                    $coordonnes = $_GET['coord'];
                    $coordonnesY = substr($coordonnes, -1);
                    $coordonnesX = $coordonnes[0];
                }

                if ($_SESSION['couleurActive'] == PieceQuantik::WHITE) {
                    $laPiece = $_SESSION['lesBlancs']->getPieceQuantik($_GET['position']);

                    if (isset($_GET['coord'])) {
                        $_SESSION['lesBlancs']->removePieceQuantik($_GET['position']);
                        $_SESSION['plateau']->setPiece($coordonnesX, $coordonnesY, $laPiece);
                    }
                    $_SESSION['couleurActive'] = PieceQuantik::BLACK;

                    //Si y a plus aucune piece à jouer
                    if(QuantikUIGenerator::verifierFinPartie($_SESSION['lesNoirs'], $aq)){
                        $_SESSION['etat'] = "victoire";
                    }
                } else {
                    $laPiece = $_SESSION['lesNoirs']->getPieceQuantik($_GET['position']);

                    if (isset($_GET['coord'])) {
                        $_SESSION['lesNoirs']->removePieceQuantik($_GET['position']);
                        $_SESSION['plateau']->setPiece($coordonnesX, $coordonnesY, $laPiece);
                    }
                    $_SESSION['couleurActive'] = PieceQuantik::WHITE;

                    //Si y a plus aucune piece à jouer
                    if(QuantikUIGenerator::verifierFinPartie($_SESSION['lesBlancs'], $aq)){
                        $_SESSION['etat'] = "victoire";
                    }
                }

                //Si une combinaison est gagnante
                for ($i = 0; $i < 4; $i++) {
                    if ($aq->isColWin($i) || $aq->isRowWin($i) || $aq->isCornerWin($i)) {
                        $_SESSION['etat'] = "victoire";
                    }
                }
                break;

            case 'annulerChoix':
                $_SESSION['etat'] = "choixPiece";
                break;

            default:
                throw new QuantikException("Action non valide");
        }
    }
} catch (QuantikException $exception) {
    $_SESSION['etat'] = 'bug';
    $_SESSION['message'] = $exception->__toString();
}

$tab[PieceQuantik::WHITE] = $_SESSION['lesBlancs'];
$tab[PieceQuantik::BLACK] = $_SESSION['lesNoirs'];

switch ($_SESSION['etat']) {
    case 'choixPiece':
        $pageHTML .= QuantikUIGenerator::getPageSelectionPiece($tab, $_SESSION['couleurActive'], $_SESSION['plateau']);
        break;

    case 'posePiece':
        $pageHTML .= QuantikUIGenerator::getPagePosePiece($tab, $_SESSION['couleurActive'], $_GET['position'], $_SESSION['plateau']);
        break;

    case 'victoire':
        $pageHTML .= QuantikUIGenerator::getPageVictoire($tab, $_SESSION['couleurActive'], $_SESSION['plateau']);
        break;

    default: // sans doute etape=bug
        echo QuantikUIGenerator::getPageErreur($_SESSION['message']);
        exit(1);
}

echo $pageHTML;

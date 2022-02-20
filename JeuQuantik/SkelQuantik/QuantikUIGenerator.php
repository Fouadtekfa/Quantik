<?php
require_once "../src/PlateauQuantik.php";
require_once "../src/ArrayPieceQuantik.php";
require_once "../src/ActionQuantik.php";

use quantik\src\PieceQuantik;
use quantik\src\PlateauQuantik;
use quantik\src\ActionQuantik;
use quantik\src\ArrayPieceQuantik;

/**
 * Class QuantikUIGenerator
 */
class QuantikUIGenerator
{

    /**
     * @param string $title
     * @return string
     */
    public static function getDebutHTML(string $title = "Quantik"): string
    {
        return "<!doctype html>
<html lang='fr'>
    <head>
        <meta charset='UTF-8' >
        <title>$title</title>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"quantik.css\" />
    </head>
    <body>
        <h1  class= \"titre\">$title</h1>
      
        <div id='quantik'>\n";
    }

    /**
     * @return string
     */
    public static function getFinHTML(): string
    {
        return "\n</div> <footer>
        <p> TEKFA FOUAD et MEHDJAN SALIM</p>
    </footer></body></html>";
    }

    /**
     * @param string $message
     * @return string
     */
    public static function getPageErreur(string $message): string
    {
        header("HTTP/1.1 400 Bad Request");
        $resultat = self::getDebutHTML("400 Bad Request");
        $resultat .= "<h2>$message</h2>";
        $resultat .= "<p><br /><br /><br /><a href='quantik.php?reset'>Retour à l'accueil...</a></p>";
        $resultat .= self::getFinHTML();
        return $resultat;
    }

    /**
     * @param PieceQuantik $pq
     * @return string
     */
    public static function getButtonClass(PieceQuantik $pq): string
    {
        if ($pq->getForme() == PieceQuantik::VOID)
            return "vide";
        $ch = $pq->__toString();
        return substr($ch, 1, 2) . substr($ch, 4, 1);
    }

    /**
     * production d'un bloc HTML pour présenter l'état du plateau de jeu,
     * l'attribution de classes en vue d'une utilisation avec les est un bon investissement...
     * @param PlateauQuantik $p
     * @return string
     */
    public static function getDivPlateauQuantik(PlateauQuantik $p): string
    {

        $resultat = "<table class='getPlateau'>";
        for ($i = 0; $i < 4; $i++) {
            $resultat .= "<tr>";
            for ($j = 0; $j < 4; $j++) {
                $piece = $p->getPiece($i, $j);
                $po = self::getButtonClass($piece);
                $resultat .= "<td><button type='submit' class='piecePlateau' name='active' disabled >$po</button></td>";
            }

            $resultat .= "</tr>";
        }
        $resultat .= "</table>";
        return $resultat;
    }

    /**
     * @param ArrayPieceQuantik $apq
     * @param int $pos permet d'identifier la pièce qui a été sélectionnée par l'utilisateur avant de la poser (si != -1)
     * @return string
     */
    public static function getDivPiecesDisponibles(ArrayPieceQuantik $apq, int $pos = -1): string
    {
        $string = "<div class='getPieces'>";
        for ($i = 0; $i < $apq->getTaille(); $i++) {
            $piece = $apq->getPieceQuantik($i);
            $po = self::getButtonClass($piece);
            if ($i == $pos) {
                $string .= "<button type='submit' class='pieceDispo' disabled >$po</button>";
            } else {
                $string .= "<button type='submit' class='piece' disabled >$po</button>";
            }
        }
        $string .= "</div>";
        $string .= "<br/>";
        return $string;
    }

    /**
     * @param ArrayPieceQuantik $apq
     * @return string
     */
    public static function getFormSelectionPiece(ArrayPieceQuantik $apq): string
    {

        $resultat = "<form action='' method='get'> <div class='getPieces'>";

        for ($i = 0; $i < $apq->getTaille(); $i++) {
            $s = $apq->getPieceQuantik($i);
            $po = self::getButtonClass($s);
            $resultat .= "<button type='submit' name='position' class='piece' value='$i'>$po</button>";
            $resultat .= "<input type='text' name='action' value='choisirPiece' hidden/>";
        }
        $resultat .= "</div></form>";
        $resultat .= "<br/>";
        return $resultat;
    }

    /**
     * @param PlateauQuantik $plateau
     * @param PieceQuantik $piece
     * @param int $position position de la pièce qui sera posée en vue de la transmettre via un champ caché du formulaire
     * @return string
     */
    public static function getFormPlateauQuantik(PlateauQuantik $plateau, PieceQuantik $piece, int $position): string
    {
        $action = new ActionQuantik($plateau);

        $resultat = "<form action='' method='get'> <table class='getPlateau''>";
        $resultat .= "<input type='text' name='position' class='button' value='$position' hidden/>";
        $resultat .= "<input type='text' name='action' class='button' value='poserPiece' hidden/>";

        for ($i = 0; $i < 4; $i++) {
            $resultat .= "<tr>";
            for ($j = 0; $j < 4; $j++) {
                $pi = $plateau->getPiece($i, $j);
                $po = self::getButtonClass($pi);
                if ($action->isValidPose($i, $j, $piece)) {
                    $resultat .= "<td><button type='submit' name='coord' class='piecePlateauDispo' value='$i-$j'>$po</button></td>";
                } else {
                    $resultat .= "<td><button type='submit' name='coord' class='piecePlateau' disabled>$po</button></td>";
                }
            }
            $resultat .= "</tr>";
        }
        $resultat .= "</table></form>";
        return $resultat;
    }


    /**
     * @return string
     */
    public static function getFormBoutonAnnuler(): string
    {
        $resultat = "<form action='' method = 'get'>";
        $resultat .= "<button type='submit' id='annul' name='action' value='annulerChoix'>Annuler choix</button>";
        $resultat .= "</form>";

        return $resultat;
    }

    /**
     * @param int $couleur
     * @return string
     */
    public static function getDivMessageVictoire(int $couleur): string
    {
        $resultat = "";
        if ($couleur == PieceQuantik::WHITE) {
            $resultat .= "<p id='noir'> The winner is : NOIR</p>";
        } else {
            $resultat .= "<p id='blanc'>The winner is: BLANC</p>";
        }
        $resultat .= self::getLienRecommencer();
        return $resultat;
    }

    /**
     * @return string
     */
    public static function getLienRecommencer(): string
    {
        $resultat = "<form action='' method='get'> ";
        $resultat .= "<button class='recommencer' type='submit' name='reset' value='reset' >Recommencer la partie</button>";
        $resultat .= "<p> </p></form>";
        return $resultat;
    }

    /**
     * @param array $lesPiecesDispos tableau contenant 2 ArrayPieceQuantik un pour les pièves blanches, un pour les pièces noires
     * @param int $couleurActive
     * @param PlateauQuantik $plateau
     * @return string
     */
    public static function getPageSelectionPiece(array $lesPiecesDispos, int $couleurActive, PlateauQuantik $plateau): string
    {
        $pageHTML = QuantikUIGenerator::getDebutHTML();
        if ($couleurActive == PieceQuantik::WHITE) {

            $pageHTML .= "<div class = 'conteneurPieces'>";
            $pageHTML .= QuantikUIGenerator::getFormSelectionPiece($lesPiecesDispos[PieceQuantik::WHITE]);
            $pageHTML .= QuantikUIGenerator::getDivPiecesDisponibles($lesPiecesDispos[PieceQuantik::BLACK]);
            $pageHTML .= "</div>";
            $pageHTML .= QuantikUIGenerator::getDivPlateauQuantik($plateau);


        } else {
            $pageHTML .= "<div class = 'conteneurPieces'>";
            $pageHTML .= QuantikUIGenerator::getDivPiecesDisponibles($lesPiecesDispos[PieceQuantik::WHITE]);
            $pageHTML .= QuantikUIGenerator::getFormSelectionPiece($lesPiecesDispos[PieceQuantik::BLACK]);
            $pageHTML .= "</div>";
            $pageHTML .= QuantikUIGenerator::getDivPlateauQuantik($plateau);
        }
        return $pageHTML . self::getFinHTML();
    }


    /**
     * @param array $lesPiecesDispos tableau contenant 2 ArrayPieceQuantik un pour les pièces blanches, un pour les pièces noires
     * @param int $couleurActive
     * @param int $posSelection position de la pièce sélectionnée dans la couleur active
     * @param PlateauQuantik $plateau
     * @return string
     */
    public static function getPagePosePiece(array $lesPiecesDispos, int $couleurActive, int $posSelection, PlateauQuantik $plateau): string
    {
        $pageHTML = QuantikUIGenerator::getDebutHTML();
        if ($couleurActive == PieceQuantik::WHITE) {
            $blancs = $lesPiecesDispos[PieceQuantik::WHITE];
            $laPiece = $blancs->getPieceQuantik($posSelection);
            $pageHTML .= "<div class = 'conteneurPieces'>";
            $pageHTML .= QuantikUIGenerator::getDivPiecesDisponibles($blancs, $posSelection);
            $pageHTML .= QuantikUIGenerator::getDivPiecesDisponibles($lesPiecesDispos[PieceQuantik::BLACK]);
            $pageHTML .= "</div>";
            $pageHTML .= "<div class = 'boutonAnnuler'>";
            $pageHTML .= QuantikUIGenerator::getFormPlateauQuantik($plateau, $laPiece, $posSelection);
            $pageHTML .= self::getFormBoutonAnnuler();
            $pageHTML .= "</div>";
        } else {
            $noires = $lesPiecesDispos[PieceQuantik::BLACK];
            $laPiece = $noires->getPieceQuantik($posSelection);
            $pageHTML .= "<div class = 'conteneurPieces'>";
            $pageHTML .= QuantikUIGenerator::getDivPiecesDisponibles($lesPiecesDispos[PieceQuantik::WHITE]);
            $pageHTML .= QuantikUIGenerator::getDivPiecesDisponibles($noires, $posSelection);
            $pageHTML .= "</div>";
            $pageHTML .= "<div class = 'boutonAnnuler'>";
            $pageHTML .= QuantikUIGenerator::getFormPlateauQuantik($plateau, $laPiece, $posSelection);
            $pageHTML .= self::getFormBoutonAnnuler();
            $pageHTML .= "</div>";
        }

        $pageHTML .= QuantikUIGenerator::getFinHTML();
        return $pageHTML;
    }


    /**
     * @param array $lesPiecesDispos tableau contenant 2 ArrayPieceQuantik un pour les pièves blanches, un pour les pièces noires
     * @param int $couleurActive
     * @param PlateauQuantik $plateau
     * @return string
     */
    public static function getPageVictoire(array $lesPiecesDispos, int $couleurActive, PlateauQuantik $plateau): string
    {
        $pageHTML = QuantikUIGenerator::getDebutHTML();
        $pageHTML .= "<div class = 'conteneurPieces'>";
        $pageHTML .= QuantikUIGenerator::getDivPiecesDisponibles($lesPiecesDispos[PieceQuantik::WHITE]);
        $pageHTML .= QuantikUIGenerator::getDivPiecesDisponibles($lesPiecesDispos[PieceQuantik::BLACK]);
        $pageHTML .= "</div>";
        $pageHTML .= "<div class = 'messageVictoire'>";
        $pageHTML .= QuantikUIGenerator::getDivPlateauQuantik($plateau);
        $pageHTML .= self::getDivMessageVictoire($couleurActive);
        $pageHTML .= "</div>";
        return $pageHTML . self::getFinHTML();
    }
    public static function verifierFinPartie(ArrayPieceQuantik $array, ActionQuantik $aq): bool
    {
        for ($p=0 ; $p<$array->getTaille() ; $p++){
            $piece = $array->getPieceQuantik($p);
            for ($i = 0; $i < 4; $i++) {
                for ($j = 0; $j < 4; $j++) {
                    if ($aq->isValidPose($i, $j, $piece)) {
                        return false;
                    }
                }
            }
        }
        return true;
    }
}
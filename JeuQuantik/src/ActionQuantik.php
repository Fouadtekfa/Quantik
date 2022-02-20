<?php
/**
 * Classe ActionQuantik
 * @author tekfa fouad && mahdjan salim
 * @date 2022-01-15
 */

namespace quantik\src;
require_once "../src/PlateauQuantik.php";
require_once("../src/PieceQuantik.php");


class ActionQuantik
{
    /**
     * $plateau : le plateau de jeu
     *
     */
    protected PlateauQuantik $plateau;


    /**
     * constructeur
     * @param PlateauQuantik $plateau
     *
     */
    public function __construct(PlateauQuantik $plateau)
    {
        $this->plateau = $plateau;
    }


    /**
     * @return PlateauQuantik
     */
    public function getPlateau(): PlateauQuantik
    {
        return $this->plateau;
    }


    /**
     * @param int $numRow :numéro de la ligne a verifier
     * @return bool : vrai si une ligne et gagnate
     * @throws Exception
     */
    public function isRowWin(int $numRow): bool
    {
        return self::isComboWin($this->plateau->getRow($numRow));
    }

    /**
     * @param int $numCol numéro de la colonne a verfier
     * @return bool :vrai si numéro de la colonne et gagnant sinon faux
     * @throws Exception
     */
    public function isColWin(int $numCol): bool
    {
        return self::isComboWin($this->plateau->getCol($numCol));
    }


    /**
     * @param int $dir numéro de la zone entre [0,3]
     * @return bool vrai si gagnante sinon faux
     * @throws Exception
     */
    public function isCornerWin(int $dir): bool
    {
        return $this->isComboWin($this->plateau->getCorner($dir));
    }


    /**
     * @param int $rowNum :numéro de la ligne
     * @param int $colNum : numéro de la colonne
     * @param PieceQuantik $piece ::piece a poser
     * @return bool : vrai si il existe pas une piece similaire à notre piece donner
     * @throws Exception
     */
    public function isValidPose(int $rowNum, int $colNum, PieceQuantik $piece): bool
    {
        if ( $piece->getForme() == PieceQuantik::VOID ) return false;
        $piecePlateau = $this->plateau->getPiece($rowNum, $colNum);
        if ( $piecePlateau->getForme() != PieceQuantik::VOID ) return false;

        $dir = $this->plateau->getCornerFromCoord($rowNum, $colNum);

        return self::isPieceValide($this->plateau->getRow($rowNum), $piece) &&
            self::isPieceValide($this->plateau->getCol($colNum), $piece) &&
            self::isPieceValide($this->plateau->getCorner($dir), $piece);

    }



    /**
     * @param int $rowNum :numéro de la ligne
     * @param int $colNum :numéro de la colonne
     * @param PieceQuantik $piece la nouvelle piec a poser
     * @return void
     * @throws Exception
     */
    public function posePiece(int $rowNum, int $colNum, PieceQuantik $piece): void
    {
        $this->plateau->verifier($rowNum);
        $this->plateau->verifier($colNum);
        if ($this->isValidPose($rowNum, $colNum, $piece))
            $this->plateau->setPiece($rowNum, $colNum, $piece);

    }


    /**
     * affichage
     * @return string
     */
    public function __toString()
    {
        return "$this->plateau";
    }

    /**
     * @param array $pieces un tableau de piece
     * @return bool :vrai si si l'emplacement est valid
     */
    private static function isComboWin(array $pieces): bool
    {
        for ($i = 0; $i < count($pieces) - 1; $i++) {
            for ($j = $i + 1; $j < count($pieces); $j++) {
                if ($pieces[$i] == $pieces[$j]) {
                    return false;
                }
            }
        }
        return true;
    }


    /**
     * @param array $pieces
     * @param PieceQuantik $p
     * @return bool
     */
    private function isPieceValide(array $pieces, PieceQuantik $p): bool
    {
        {
            for ($i = 0; $i < count($pieces); $i++) {
                if ($pieces[$i]->getForme() == $p->getForme())
                    return false;
            }
            return true;
        }

    }


}



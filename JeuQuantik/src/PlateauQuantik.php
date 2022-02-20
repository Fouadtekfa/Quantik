<?php
namespace quantik\src;

require_once("../src/PieceQuantik.php");

use quantik\src\PieceQuantik;
use Exception;

/**
 * Classe PlateauQuantik
 * @author tekfa fouad && mahdjane salim
 * @date 2022-01-15
*/
require_once "PieceQuantik.php";
class PlateauQuantik
{

    /**
     * nombre de lignes
     * @access public
     * @const int
     */
    public const NBROWS = 4;
    /**
     * nombre de colonnes
     * @access public
     * @const int
     */
    public const NBCOLS = 4;

    /**
     * valeur numérique représentant le NORD_WEST
     * @access public
     * @const int
     */
    public const NW = 0;
    /**
     * valeur numérique représentant le NORD_EST
     * @access public
     * @const int
     */
    public const NE = 1;
    /**
     * valeur numérique  représentant le SUD_WEST
     * @access public
     * @const int
     */
    public const SW = 2;
    /**
     * valeur numérique représentant le SUD_EST
     * @access public
     * @const int
     */
    public const SE = 3;


    /**
     * $cases : tableau de PieceQuantik à deux dimensions référant le plateau.
     * @access protected
     * @var PieceQuantik[][]
     */
    protected $cases;

    /**
     * Constructeur, d'un plateau vide avec des pièces de type VOID.
     * @access public
     */
    public function __construct()
    {

        $this->cases = array(array());
        for ($i = 0; $i < self::NBROWS; $i++)
            for ($j = 0; $j < self::NBCOLS; $j++)
                $this->cases[$i][$j] = PieceQuantik::initVoid();
    }


    /**
     *
     * @param $val
     * @return void
     *  Vérifie si le paramètre donné est un chiffre
     * qui fait partie de nos 4 valeur  (NW =0, NE=1, SW=2, SE=3)
     * @throws Exception
     */
    public function verifier($val): void
    {

        if (!is_numeric($val)) {
            throw new \Exception("ERREUR : Coordonnées hors du plateau");
        } else {
            if ($val < 0 || $val >= self::NBROWS) {
                throw new \Exception("ERREUR :  Coordonnées hors du plateau, saisir un nombre [0 ,3]");
            }
        }


    }


    /**
     * @param int $rowNum le numéro de la ligne
     * @param int $colNum le numéro de la colonne
     * @return PieceQuantik une piece [numéro de ligne][numéro de colonne];
     */
    public function getPiece(int $rowNum, int $colNum): PieceQuantik
    {
        $this->verifier($rowNum);
        $this->verifier($colNum);
        return $this->cases[$rowNum][$colNum];
    }

    /**
     * @param int $rowNum  le numéro de la ligne
     * @param int $colNum le numéro de la colonne
     * @param PieceQuantik $piece
     * @return void
     * @throws Exception
     */
    public function setPiece(int $rowNum, int $colNum, PieceQuantik $piece)
    {
        $this->verifier($rowNum);
        $this->verifier($colNum);
        $this->cases[$rowNum][$colNum] = $piece;
    }

    /**
     * @param int $rowNum :numéro de la ligne de plateau
     * @return array : tableau des pieces de la ligne
     * @throws Exception
     */
    public function getRow(int $rowNum): array
    {
        $this->verifier($rowNum);
        return $this->cases[$rowNum];
    }

    /**
     * @param int $colNum:colonne du plateau
     * @return array un tableau de la colonne colNum
     * @throws Exception
     */
    public function getCol(int $colNum): array
    {
        $this->verifier($colNum);
        $colonne = array();
        for ($i = 0; $i < self::NBCOLS; $i++)
            $colonne[$i] = $this->cases[$i][$colNum];
        return $colonne;
    }

    /**
     * @param int $dir :4 valeur représentant (NW =0, NE=1, SW=2, SE=3)
     * @return array tableau de coin $dir
     * @throws Exception
     */
    public function getCorner(int $dir): array
    {
        $this->verifier($dir);
        switch ($dir) {
            case (self::NW):
                return [
                    $this->cases[0][0],
                    $this->cases[0][1],
                    $this->cases[1][0],
                    $this->cases[1][1]
                ];

            case (self::NE):
                return [
                    $this->cases[0][2],
                    $this->cases[0][3],
                    $this->cases[1][2],
                    $this->cases[1][3]
                ];

            case (self::SW):
                return [
                    $this->cases[2][0],
                    $this->cases[2][1],
                    $this->cases[3][0],
                    $this->cases[3][1]
                ];

            default;
                return [
                    $this->cases[2][2],
                    $this->cases[2][3],
                    $this->cases[3][2],
                    $this->cases[3][3]
                ];
        }


    }

    /**
     * @return string affichage de notre plateau
     */
    public function __toString(): string
     {
         $msg = "";
         for ($i = 0; $i < self::NBROWS; $i++) {
             for ($j = 0; $j < self::NBCOLS; $j++) {
                 $msg .= "\t" . $this->cases[$i][$j];
             }
             $msg .= "<br><br>";
         }
         return $msg;
     }

    /**
     * @param int $rowNum :numéro de la ligne de plateau
     * @param int $colNum :numéro de la colonne de plateau
     * @return int : (0=NW, 1=NE, 2=SW, 3=SE)
     * @throws Exception
     */
    public static function getCornerFromCoord(int $rowNum, int $colNum): int
    {
        (new PlateauQuantik) -> verifier($rowNum);
        (new PlateauQuantik)-> verifier($colNum);

        if ($rowNum < self::NBROWS / 2) {
            if ($colNum < self::NBCOLS / 2)
                return PlateauQuantik::NW;
            else
                return PlateauQuantik::NE;
        } else {
            if ($colNum < self::NBCOLS / 2)
                return PlateauQuantik::SW;
            else
                return PlateauQuantik::SE;
        }
    }

}
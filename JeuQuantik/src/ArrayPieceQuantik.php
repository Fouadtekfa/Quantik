<?php
namespace quantik\src;

require_once("../src/PieceQuantik.php");

use quantik\src\PieceQuantik;

class ArrayPieceQuantik
{
    protected array $piecesQuantiks;
    protected int $taille;

    public function __construct()
    {
        $this->taille = 0;
        $this->piecesQuantiks = [];
    }


    public function __toString(): string
    {
        $msg = "";
        for ($i = 0; $i < count($this->piecesQuantiks); $i++) {
            $msg .= $this->piecesQuantiks[$i];
        }
        return $msg;
    }


    public function getPieceQuantik(int $pos): PieceQuantik
    {
        return $this->piecesQuantiks[$pos];
    }


    public function setPieceQuantik(int $pos, PieceQuantik $piece): void
    {
        $this->piecesQuantiks[$pos] = $piece;
    }


    public function addPieceQuantik(PieceQuantik $piece): void
    {
        array_push($this->piecesQuantiks, $piece);
        $this->taille++;
    }


    public function removePieceQuantik(int $pos): void
    {
        array_splice($this->piecesQuantiks, $pos, 1);
        $this->taille--;
    }

    public function getTaille(): int
    {
        return $this->taille;
    }


    public static function initPiecesNoires(): ArrayPieceQuantik
    {
        $apq = new ArrayPieceQuantik();
        $apq->addPieceQuantik(PieceQuantik::initBlackCone());
        $apq->addPieceQuantik(PieceQuantik::initBlackCone());
        $apq->addPieceQuantik(PieceQuantik::initBlackCube());
        $apq->addPieceQuantik(PieceQuantik::initBlackCube());
        $apq->addPieceQuantik(PieceQuantik::initBlackCylindre());
        $apq->addPieceQuantik(PieceQuantik::initBlackCylindre());
        $apq->addPieceQuantik(PieceQuantik::initBlackSphere());
        $apq->addPieceQuantik(PieceQuantik::initBlackSphere());
        return $apq;
    }


    public static function initPiecesBlanches(): ArrayPieceQuantik
    {
        $apq = new ArrayPieceQuantik();
        $apq->addPieceQuantik(PieceQuantik::initWhiteCone());
        $apq->addPieceQuantik(PieceQuantik::initWhiteCone());
        $apq->addPieceQuantik(PieceQuantik::initWhiteCube());
        $apq->addPieceQuantik(PieceQuantik::initWhiteCube());
        $apq->addPieceQuantik(PieceQuantik::initWhiteCylindre());
        $apq->addPieceQuantik(PieceQuantik::initWhiteCylindre());
        $apq->addPieceQuantik(PieceQuantik::initWhiteSphere());
        $apq->addPieceQuantik(PieceQuantik::initWhiteSphere());
        $apq->taille = 8;
        return $apq;
    }
}
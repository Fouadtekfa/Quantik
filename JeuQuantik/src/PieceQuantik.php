<?php
namespace quantik\src;


/**Classe PieceQuantik
 * @author tekfa fouad &&mahdjane salim
 * @date 2022-01-15
 */
class PieceQuantik
{
    /**
     * self::WHITE valeur numérique de la couleur blanche
     * @access public
     * @const int
     */
    public const WHITE = 0;
    /**
     * self::BLACK valeur numérique de la couleur noire
     * @access public
     * @const int
     */
    public const BLACK = 1;
    /**
     * self::VOID valeur numérique d'une pièce vide (case vide)
     * @access public
     * @const int
     */
    public const VOID = 0;
    /**
     * self::CUBE valeur numérique de la forme cube
     * @access public
     * @const int
     */
    public const CUBE = 1;
    /**
     * self::CONE valeur numérique de la forme cone
     * @access public
     * @const int
     */
    public const CONE = 2;
    /**
     * self::CYLINDRE valeur numérique de la forme cylindre
     * @access public
     * @const int
     */
    public const CYLINDRE = 3;
    /**
     * self::SPHERE valeur numérique de la forme sphère
     * @access public
     * @const int
     */
    public const SPHERE = 4;

    /**
     * $forme : entier appartenant à {0,1,2,3,4} indiquant l'etat de la piéce
     * @access protected
     * @var int
     */
    protected int $forme;
    /**
     * $forme : un entier appartenant à {0,1} indiquant la couleur  de la piéce
     * @access protected
     * @var int
     */
    protected int $couleur;

    private const TABLEAU =
        [
            self::VOID => "[()]",
            self::CUBE => [self::WHITE => "[CU:W]", self::BLACK => "[CU:B]"],
            self::CONE => [self::WHITE => "[CO:W]", self::BLACK => "[CO:B]"],
            self::CYLINDRE => [self::WHITE => "[CY:W]", self::BLACK => "[CY:B]"],
            self::SPHERE => [self::WHITE => "[SP:W]", self::BLACK => "[SP:B]"],
        ];


    /**
     * PieceQuantik constructeur.
     * @access private
     * @param int $forme : la forme de la piéce(Cube,Cone,Cylindre)
     * @param int $couleur : la couleur de la piéce(Noir,Blanc)
     */
    private function __construct(int $forme, int $couleur)
    {
        $this->forme = $forme;
        $this->couleur = $couleur;
    }

    /**
     * @access public
     * @return int $this->forme : retourne la forme d'une piéce
     */
    public function getForme(): int
    {
        return $this->forme;
    }

    /**
     * Modificateur getCouleur : retourne la couleur  d'une piéce
     * @access public
     * @return int $this->Couleur
     */
    public function getCouleur(): int
    {
        return $this->couleur;
    }

    /**
     * méthode __toString
     * @access public
     * @return string une chaine de caractères résumant $this
     * retourne la forme et la couleur d'une piece ex : (CU,B)
     */
    public function __toString(): string
    {
        $forme = $this->forme;
        if ( $forme == self::VOID ) return self::TABLEAU[$forme];
        return self::TABLEAU[$forme][$this->couleur];
    }

    /**
     * méthode initVoid
     * @access public
     * @return PieceQuantik:une piece vide
     */
    public static function initVoid(): PieceQuantik
    {
        return new PieceQuantik(self::VOID, self::BLACK);
    }

    /**
     * méthode initWhiteCube
     * @access public
     * @return PieceQuantik:un Cube blanc
     */
    public static function initWhiteCube(): PieceQuantik
    {
        return new PieceQuantik(self::CUBE, self::WHITE);
    }

    /**
     * méthode initBlackCube
     * @access public
     * @return PieceQuantik:un Cube noir
     */
    public static function initBlackCube(): PieceQuantik
    {
        return new PieceQuantik(self::CUBE, self::BLACK);
    }

    /**
     * méthode initWhiteCone
     * @access public
     * @return PieceQuantik:un Cone blanc
     */
    public static function initWhiteCone(): PieceQuantik
    {
        return new PieceQuantik(self::CONE, self::WHITE);
    }

    /**
     * méthode initBlackCone
     * @access public
     * @return PieceQuantik:un Cone noir
     */
    public static function initBlackCone(): PieceQuantik
    {
        return new PieceQuantik(self::CONE, self::BLACK);
    }

    /**
     * méthode initWhiteCylindre
     * @access public
     * @return PieceQuantik:un Cylindre blanc
     */
    public static function initWhiteCylindre(): PieceQuantik
    {
        return new PieceQuantik(self::CYLINDRE, self::WHITE);
    }

    /**
     * méthode initBlackCylindre
     * @access public
     * @return PieceQuantik:un Cylindre noir
     */
    public static function initBlackCylindre(): PieceQuantik
    {
        return new PieceQuantik(self::CYLINDRE, self::BLACK);
    }

    /**
     * méthode initWhiteSphere
     * @access public
     * @return PieceQuantik:un Shpere blanc
     */
    public static function initWhiteSphere(): PieceQuantik
    {
        return new PieceQuantik(self::SPHERE, self::WHITE);
    }

    /**
     * méthode initBlackSphere
     * @access public
     * @return PieceQuantik:un Sphere noir
     */
    public static function initBlackSphere(): PieceQuantik
    {
        return new PieceQuantik(self::SPHERE, self::BLACK);
    }
}
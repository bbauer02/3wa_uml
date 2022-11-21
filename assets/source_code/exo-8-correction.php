<?php

//tag::class_FurnitureCollection[]
class FurnitureCollection
{


    public function __construct(
        private string $name,
        private int $year,
        private array $furnitures = [] //<1>
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return FurnitureCollection
     */
    public function setName(string $name): FurnitureCollection
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     *
     * @return FurnitureCollection
     */
    public function setYear(int $year): FurnitureCollection
    {
        $this->year = $year;

        return $this;
    }

    //mutateurs et accesseur de la collection stockées dans l'attribut furnitures <2>

    /**
     * @param Furniture $furniture ajoute un item de type Furniture à la
     *                             collection
     */
    public function addFurniture(Furniture $furniture): bool
    {
        if (!in_array($furniture, $this->furnitures, true)) {
            $this->furnitures[] = $furniture;

            return true;
        }

        return false;
    }

    /**
     * @param Furniture $furniture retire l'item de la collection
     */
    public function removeFurniture(Furniture $furniture): bool
    {
        $key = array_search($furniture, $this->furnitures, true);

        if ($key !== false) {
            unset($this->furnitures[$key]);

            return true;
        }

        return false;
    }

    /**
     * @return Furniture[]
     */
    public function getFurnitures(): array
    {
        return $this->furnitures;
    }


}

//end::class_FurnitureCollection[]

//tag::class_Furniture[]
class Furniture
{
    /**
     * @var array contient les pièces de bois utiles
     */
    private array $woodPieces = []; //<1>
    /**
     * @var array contient les pièces de métal utiles
     */
    private array $metalPieces = []; //<1>
    /**
     * @var array contient les pièces de plastique utiles
     */
    private array $plasticPieces = []; //<1>

    /**
     * @param string $name
     * @param array  $woodPiecesData        tableau contenant les informations
     *                                      sur les pièces de bois à utiliser.
     *                                      Chaque essence de bois différente
     *                                      sera une entrée dans le tableau des
     *                                      informations :
     *                                      [['quantity'=> x,'specie'=>'xxx']
     *                                      ['quantity'=> y,'specie'=>'yyy']
     *                                      ['quantity'=> z,'specie'=>'zzz']]
     */
    public function __construct(
        private string $name,
        array $woodPiecesData = [], //<2>
        array $metalPiecesData = [], //<2>
        array $plasticPiecesData = [] //<2>
    ) {

        //création des composants en bois <3>
        //on parcourt le tableau qui contient les tableaux
        foreach ($woodPiecesData as $woodPieceData) {
            //pour chaque entrée du tableau, on crée le nombre de pièces de bois dans l'essence spécifiée
            for ($i = 0; $i < $woodPieceData['quantity']; $i++) {

                //en créant la pièce de bois, on passe une instance du meuble qu'il concerne ce qui met à jour l'objet inverse de type "Furniture" contenu dans "WoodPiece" <4>
                $woodPiece = new WoodPiece($woodPieceData['specie'], $this);

                $this->woodPieces[] = $woodPiece;
            }
        }

        //création des composants en métal <3>
        foreach ($metalPiecesData as $metalPieceData) {
            for ($i = 0; $i < $metalPieceData['quantity']; $i++) {
                $this->metalPieces[] = new WoodPiece(
                    $metalPieceData['type'],
                    $this
                );
            }
        }

        //création des composants en plastique <3>
        foreach ($plasticPiecesData as $plasticPieceData) {
            for ($i = 0; $i < $plasticPieceData['quantity']; $i++) {
                $this->plasticPieces[] = new PlasticPiece(
                    $plasticPieceData['nature']
                );
            }
        }


    }

    //accesseur pour chaque matière utilisée dans le meuble

    /**
     * @return array
     */
    public function getWoodPieces(): array
    {
        return $this->woodPieces;
    }

    /**
     * @return array
     */
    public function getMetalPieces(): array
    {
        return $this->metalPieces;
    }

    /**
     * @return array
     */
    public function getPlasticPieces(): array
    {
        return $this->plasticPieces;
    }

    //autres mutateurs et setters

    //tag::class_Furniture_setter_getter[]

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Furniture
     */
    public function setName(string $name): Furniture
    {
        $this->name = $name;

        return $this;
    }
    //end::class_Furniture_setter_getter[]


}

//end::class_Furniture[]

//tag::class_WoodPiece[]
class WoodPiece
{
    /**
     * @param string    $specie    essence de la pièce de bois
     * @param Furniture $furniture meuble associé à la pièce de bois consommée
     */
    public function __construct(
        private string $specie,
        //attribut d'objet permettant la navigation vers Furniture
        private Furniture $furniture
    ) {
    }

    /**
     * @return Furniture meuble dans lequel la pièce de bois courante est
     *                   utilisée
     */
    public function getFurniture(): Furniture
    {
        return $this->furniture;
    }

    /**
     * @return string
     */
    public function getSpecie(): string
    {
        return $this->specie;
    }

    /**
     * @param string $specie
     *
     * @return WoodPiece
     */
    public function setSpecie(string $specie): WoodPiece
    {
        $this->specie = $specie;

        return $this;
    }


}

//end::class_WoodPiece[]

//tag::class_MetalPiece[]
class MetalPiece
{

    public function __construct(
        private string $type
    ) {
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return MetalPiece
     */
    public function setType(string $type): MetalPiece
    {
        $this->type = $type;

        return $this;
    }

}

//end::class_MetalPiece[]

//tag::class_PlasticPiece[]
class PlasticPiece
{

    public function __construct(
        private string $nature
    ) {
    }

    /**
     * @return string
     */
    public function getNature(): string
    {
        return $this->nature;
    }

    /**
     * @param string $nature
     *
     * @return PlasticPiece
     */
    public function setNature(string $nature): PlasticPiece
    {
        $this->nature = $nature;

        return $this;
    }

}

//end::class_PlasticPiece[]

//tag::meo[]

//création du meuble BeautyLazy avec les éléments spécifiés
$woodPiecesInfo = [
    ['specie' => "chêne", 'quantity' => 2],
    ['specie' => "hêtre", 'quantity' => 1],
];

$metalPiecesInfo = [
    ['type' => "acier", 'quantity' => 1],
    ['type' => "chrome", 'quantity' => 2],
    ['type' => "fer", 'quantity' => 2],
];

$beautyLazyFurniture = new Furniture(
    "BeautyLazy",
    $woodPiecesInfo,
    $metalPiecesInfo,
    []
);

//création du meuble Nometal avec les éléments spécifiés
$woodPiecesInfo = [
    ['specie' => "noyer", 'quantity' => 1],
    ['specie' => "hêtre", 'quantity' => 1],
];

$metalPiecesInfo = [];

$plasticPiecesInfo = [
    ['nature' => "PET", 'quantity' => 1],
    ['nature' => "PEHD", 'quantity' => 3],
];

$nometalFurniture = new Furniture(
    "Nometal",
    $woodPiecesInfo,
    $metalPiecesInfo,
    $plasticPiecesInfo
);

//création de la collection
$furnitureCollection = new FurnitureCollection("Covidanne", 2022);

//affectation des meubles à la collection
$furnitureCollection->addFurniture($beautyLazyFurniture);
$furnitureCollection->addFurniture($nometalFurniture);

echo "`\nContenu de la collection {$furnitureCollection->getName()} :";

//liste des meubles (avec leur composition) à partir de la collection
foreach ($furnitureCollection->getFurnitures() as $furniture) {

    echo "\nMeuble \"{$furniture->getName()}\" composé des éléments cumulatifs suivants :";
    foreach ($furniture->getWoodPieces() as $woodPiece) {
        echo "\n- 1 pièce de {$woodPiece->getSpecie()}";
    }
    foreach ($furniture->getMetalPieces() as $metalPiece) {
        echo "\n- 1 pièce de {$metalPiece->getSpecie()}";
    }
    foreach ($furniture->getPlasticPieces() as $plasticPiece) {
        echo "\n- 1 pièce de {$plasticPiece->getNature()}";
    }


}



//end::meo[]

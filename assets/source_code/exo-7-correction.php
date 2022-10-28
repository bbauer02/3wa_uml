<?php

//tag::class_FurnitureCollection[]
class FurnitureCollection
{


    public function __construct(
        private string $name,
        private int $year,
        private array $furnitures = [] //<1>
    ) {
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
    public function __construct(
        private string $name
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
     * @return Furniture
     */
    public function setName(string $name): Furniture
    {
        $this->name = $name;

        return $this;
    }

}
//end::class_Furniture[]

//tag::meo[]

//a) Création de la collection

$furnitureCollection = new FurnitureCollection("Covidanne", 2022);

//b) Création des meubles
$repostartFurniture = new Furniture("Repostar");
$sietanneFurniture = new Furniture("Sietanne");
$letanneFurniture = new Furniture("Letanne");

//c) Affectation des meubles à la collection
$furnitureCollection->addFurniture($repostartFurniture);
$furnitureCollection->addFurniture($sietanneFurniture);
$furnitureCollection->addFurniture($letanneFurniture);

//d) Liste des meubles de la collection
echo "\n *** Liste des meubles de la collection {$furnitureCollection->getName()} ***";
foreach ($furnitureCollection->getFurnitures() as $furniture) {
    echo "\n-{$furniture->getName()}";
}

//e) nom de la collection à partir du meuble
// IMPOSSIBLE, l'association est unidirectionnelle !

//f) Il est utilisé une agrégation plutôt qu'une composition car le meuble peut exister sans la collection. Dans une composition, le composant n'existe pas sans le composite car ce dernier est responsable de son cycle de vie.

//end::meo[]
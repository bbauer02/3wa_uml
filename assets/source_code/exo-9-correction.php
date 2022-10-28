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
    public function __construct(
        private string $name,
        private ?WoodPiece $woodPiece,
        private ?MetalPiece $metalPiece,
        private ?PlasticPiece $plasticPiece,
    )
    {


    }

    /**
     * @return array
     */
    public function getMeaterialPieces(): array //<1>
    {
        return $this->MeaterialPieces;
    }

    /**
     * @param array $MeaterialPieces
     *
     * @return Furniture
     */
    public function setMeaterialPieces(array $MeaterialPieces): Furniture //<1>
    {
        $this->MeaterialPieces = $MeaterialPieces;

        return $this;
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

//tag::class_MaterielPiece[]
class MaterielPiece
{

    public function __construct(
        protected int $quantityByPiece
    ) {
    }

    /**
     * @return int
     */
    public function getQuantityByPiece(): int
    {
        return $this->quantityByPiece;
    }

    /**
     * @param int $quantityByPiece
     *
     * @return MaterielPiece
     */
    public function setQuantityByPiece(int $quantityByPiece): MaterielPiece
    {
        $this->quantityByPiece = $quantityByPiece;

        return $this;
    }
}

//end::class_MaterielPiece[]

//tag::class_WoodPiece[]
class WoodPiece  extends MaterielPiece
{
    /**
     * @param string    $specie    essence de la pièce de bois
     */
    public function __construct(
        private string $specie,
    ) {
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
class MetalPiece  extends MaterielPiece
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
class PlasticPiece extends MaterielPiece
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





//end::meo[]
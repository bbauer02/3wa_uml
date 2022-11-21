<?php

//tag::class_Technician[]
class Technician
{
    private string $name;

    public function __construct(string $name){
        $this->name = $name;
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
     * @return Technician
     */
    public function setName(string $name): Technician
    {
        $this->name = $name;

        return $this;
    }
}
//end::class_Technician[]
//tag::class_Vehicle[]
class Vehicle
{
    public function __construct(
        private Technician $technician //<1>
    ){
    }

    //mutateur et accesseur de l'attribut technician

    //tag::class_Vehicle_mutateur_accesseur[]
    /**
     * @return Technician|null
     */
    public function getTechnician(): ?Technician
    {
        return $this->technician;
    }

    /**
     * @param Technician|null $technician
     *
     * @return Vehicle
     */
    public function setTechnician(?Technician $technician): Vehicle
    {
        $this->technician = $technician;

        return $this;
    }
    //end::class_Vehicle_mutateur_accesseur[]

}
//end::class_Vehicle[]
//tag::meo[]
//création du technicien Paul
$technicienPaul = new Technician('Paul');

//création d'un véhicule avec un technicien
$vehicleA = new Vehicle($technicienPaul);

$technicianOfA = $vehicleA->getTechnician();

echo $technicianOfA->getName(); //affiche Paul
//end::meo[]



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
    //attribut d'objet qui peut être null ou référencer une instance de Technician
    private ?Technician $technician;
    
    public function __construct(
        ?Technician $technician = null
    ){
        $this->technician = $technician;
    }

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
//création d'un véhicule sans technicien
$vehicleA = new Vehicle();

//la voiture est au garage, le technicien Paul doit faire la maintenance.

//création du technicien Paul
$technicienPaul = new Technician('Paul');

//affectation du technicien à la voiture :
$vehicleA->setTechnician($technicienPaul);

//l'instance de Vehicle doit être navigable vers son technicien. Il doit être possible de récupérer le technicien du véhicule comme cela :

$technicianOfA = $vehicleA->getTechnician(); //<1>

echo $technicianOfA->getName(); //affiche Paul
//end::meo[]



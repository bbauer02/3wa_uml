<?php
//tag::class_Technician[]
class Technician
{
    private string $name;

    public function __construct(string $name)
    {
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
    private string $registerNumber;

    //tag::property_technician[]
    //attribut qui va permettre de stocker une instance de Technician
    private ?Technician $technician = null;
    //end::property_technician[]

    public function __construct(string $registerNumber, ?Technician $technician = null)
    {
        $this->registerNumber = $registerNumber;
        $this->technician = $technician;
    }

    /**
     * @return string
     */
    public function getRegisterNumber(): string
    {
        return $this->registerNumber;
    }

    /**
     * @param string $registerNumber
     *
     * @return Vehicle
     */
    public function setRegisterNumber(string $registerNumber): Vehicle
    {
        $this->registerNumber = $registerNumber;

        return $this;
    }

    //tag::mutator_accessor_of_technician[]

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
    //end::mutator_accessor_of_technician[]

    //tag::method_to_string[]
    //cette méthode est une méthode magique qui est automatiquement appelée lorsque l'objet est utilisé comme s'il s'agissait d'une chaîne au lieu d'un élément complexe
    public function __toString(): string
    {
        $string = "Je suis le véhicule immatriculé {$this->registerNumber}.";

        if ($this->technician === null) {
            $string .= " Je n'ai pas de technicien.";
        } else {
            $string .= " Mon technicien est {$this->technician->getName()}."; //<1>
        }

        return $string;
    }
    //end::method_to_string[]
}
//end::class_Vehicle[]
//tag::meo_1[]
$vehicleAAAA = new Vehicle('AAAA');
$paul = new Technician('Paul');
$vehicleAAAA->setTechnician($paul);
//on affiche l'objet comme si c'était une simple chaîne de caractères (ce n'est possible que parce que l'objet prévoit une méthode __toString()
echo $vehicleAAAA;

//end::meo_1[]
//tag::meo_2[]
$vehicleBBBB = new Vehicle('BBBB');
$sofien = new Technician('Sofien');

$vehicleBBBB->setTechnician($sofien);

//récupération du technicien depuis le véhicule
$technicianOfBBBB = $vehicleBBBB->getTechnician(); //<1>

echo "{$technicianOfBBBB->getName()} est le technicien du véhicule {$vehicleBBBB->getRegisterNumber()}.";
//end::meo_2[]
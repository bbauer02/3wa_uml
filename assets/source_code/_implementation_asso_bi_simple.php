<?php

//tag::class_Technician[]
class Technician
{
    //tag::method_technician_constructor[]
    public function __construct(
        private string $name,
        //tag::property_vehicle[]
        private ?Vehicle $vehicle = null,
        //end::property_vehicle[]
    )
    {
    }
    //end::method_technician_constructor[]

    //tag::mutator_accessor_of_vehicle[]
    /**
     * @return Vehicle|null
     */
    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    /**
     * @param Vehicle|null $vehicle
     *
     * @return Technician
     */
    public function setVehicle(?Vehicle $vehicle): Technician
    {
        $this->vehicle = $vehicle;

        return $this;
    }
    //end::mutator_accessor_of_vehicle[]

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

    //tag::method_technician_to_string[]
    public function __toString(): string
    {
        $string = "Je suis le technicien nommé {$this->name}.";

        if ($this->vehicle === null) {
            $string .= " Je n'ai pas de voiture en charge.";
        } else {
            $string .= " La voiture dont j'ai la charge a pour immatriculation {$this->vehicle->getRegisterNumber()}."; //<1>
        }

        return $string;
    }
    //end::method_technician_to_string[]

}

//end::class_Technician[]

//tag::class_Vehicle[]
class Vehicle
{
    //tag::method_vehicle_constructor[]
    public function __construct(
        private string $registerNumber,
        //tag::property_technician[]
        private ?Technician $technician = null,
        //end::property_technician[]
    )
    {
    }
    //end::method_vehicle_constructor[]

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

    //tag::method_set_technician[]

    /**
     * @param Technician|null $technician
     *
     * @return Vehicle
     */
    public function setTechnician(?Technician $technician): Vehicle
    {
        //tag::maj_inverse_technicien[]
        //mise à jour de l'objet lié (ici le technicien à qui l'on affecte la voiture courante $this)
        if (null !== $technician) {
            $technician->setVehicle($this);
        }
        //end::maj_inverse_technicien[]
        //tag::maj_inverse_ancien_technicien[]
        //l'ancien technicien affecté au véhicule courant ne doit plus l'être
        if (null !== $this->technician) {
            $this->technician->setVehicle(null); //<1>
        }
        //end::maj_inverse_ancien_technicien[]

        //on associe le nouveau technicien au véhicule
        $this->technician = $technician;

        return $this;
    }
    //end::method_set_technician[]
    //end::mutator_accessor_of_technician[]

    //tag::method_vehicle_to_string[]
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
    //end::method_vehicle_to_string[]
}

//end::class_Vehicle[]
//tag::meo_1[]
$vehicleAAAA = new Vehicle('AAAA');
$paul = new Technician('Paul');
//association d'un véhicule à son technicien
$vehicleAAAA->setTechnician($paul);
//end::meo_1[]
//tag::meo_2[]
//le véhicule AAAA connait son technicien :
echo $vehicleAAAA;
//end::meo_2[]
//tag::meo_3[]
var_dump($paul->getVehicle()); //<1>
//end::meo_3[]
//tag::meo_4[]
$vehicleBBBB = new Vehicle('BBBB');
$anna = new Technician('Anna');

//nous associons le technicien au véhicule (navigabilité de Vehicle vers Technician)
$vehicleBBBB->setTechnician($anna);

//nous associons également le véhicule au technicien (navigabilité de Technician vers Vehicle)
$anna->setVehicle($vehicleBBBB);

//Nous pouvons naviguer de Vehicle vers Technician :
echo $vehicleBBBB;

//Nous pouvons naviguer de Technician vers Vehicle :
echo $anna;
//end::meo_4[]
//tag::meo_5[]
$vehicleEEEE = new Vehicle('EEEE');
$cedric = new Technician('Cédric');

//une seule affectation depuis la voiture
$vehicleEEEE->setTechnician($cedric);

//la navigabilité est possible dans les deux sens
var_dump($vehicleEEEE->getTechnician()); //Cédric
var_dump($cedric->getVehicle()); // EEEE

//le véhicule est associé à un nouveau technicien
$karl = new Technician('Karl');
$vehicleEEEE->setTechnician($karl);

//le nouveau technicien est bien lié au véhicule (bidirectionnelle ok)
var_dump($karl->getVehicle()); // EEEE

//l'ancien technicien n'est plus lié au véhicule EEEE
var_dump($cedric->getVehicle()); // null
//end::meo_5[]
//tag::meo_6[]
$vehicleHHHH = new Vehicle('HHHH');
$julien = new Technician('Julien');

//cette fois, on associe un véhicule au technicien
$julien->setVehicle($vehicleHHHH);

//la navigabilité doit être possible dans les deux sens
var_dump($vehicleHHHH->getTechnician()); //NULL <1>
var_dump($julien->getVehicle()); // HHHH
//end::meo_6[]
//tag::meo_7[]
$vehicleIIII = new Vehicle('IIII');
$malo = new Technician('Malo');

//On associe un véhicule au technicien
$vehicleIIII->setTechnician($malo);

//la navigabilité est maintenant possible depuis l'objet lié
var_dump($malo->getVehicle()); // IIII
//end::meo_7[]
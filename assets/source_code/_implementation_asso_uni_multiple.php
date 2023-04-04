<?php

//tag::class_Technician[]
class Technician
{
    public function __construct(
        private string $name, //<1>
    )
    {
        //il n'y a plus besoin d'écrire $this->name = $name
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

    //tag::method_constructor[]
    public function __construct(
        private string $registerNumber,
        //tag::property_technicians[]
        private array $technicians = [],  //<1>
        //end::property_technicians[]
    )
    {
        //tag::check_array_technicians_from_constructor[]
        $this->setTechnicians($technicians); //<1>
        //end::check_array_technicians_from_constructor[]
    }
    //end::method_constructor[]
    //tag::method_add_technician[]
    /**
     * @param Technician $technician ajoute un item de type Technician à la
     *                               collection
     */
    public function addTechnician(Technician $technician): bool
    {
        if (!in_array($technician, $this->technicians, true)) { //<1>
            $this->technicians[] = $technician; //<2>

            return true;
        }

        return false;
    }
    //end::method_add_technician[]
    //tag::method_remove_technician[]
    /**
     * @param Technician $technician retire l'item de la collection
     */
    public function removeTechnician(Technician $technician): bool
    {
        $key = array_search($technician, $this->technicians, true); //<1>

        if ($key !== false) {
            unset($this->technicians[$key]); //<2>

            return true;
        }

        return false;
    }
    //end::method_remove_technician[]

    //tag::method_get_technicians[]
    /**
     * @return Technician[]
     */
    public function getTechnicians(): array
    {
        return $this->technicians;
    }
    //end::method_get_technicians[]
    //tag::method_set_technicians[]
    /**
     * Initialise la collection avec la collection passée en argument
     *
     * @param array $technicians collection d'objets de type Technician
     *
     * @return $this
     */
    public function setTechnicians(array $technicians): self
    {
        //tag::init_technicians_from_array[]
        //on vide la collection avant de l'initialiser
        $this->technicians = [];
        //end::init_technicians_from_array[]

        //tag::init_technicians_with_check_array[]
        foreach($technicians as $technician){ //<1>
            $this->addTechnician($technician); //<2>
        }
        //end::init_technicians_with_check_array[]

        return $this;
    }
    //end::method_set_technicians[]

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

    //tag::method_to_string[]
    public function __toString(): string
    {
        $string = "Je suis le véhicule immatriculé {$this->registerNumber}.";

        if (count($this->technicians) === 0) {
            $string .= "\nJe ne suis associé à aucun technicien.\n";
        } else {
            $string .= "\nJe suis associé à un ou plusieurs techniciens :";
            foreach ($this->technicians as $technician) {
                $string .= "\n- {$technician->getName()}";
            }
        }

        return $string;
    }
    //end::method_to_string[]
}

//end::class_Vehicle[]
//tag::meo_1[]
$vehicleAAAA = new Vehicle('AAAA');
$paul = new Technician('Paul');
$sofien = new Technician('Sofien');
$anna = new Technician('Anna');

//affectation de plusieurs techniciens
$vehicleAAAA->addTechnician($paul);
$vehicleAAAA->addTechnician($sofien);
$vehicleAAAA->addTechnician($anna);

echo $vehicleAAAA;
//end::meo_1[]
//tag::meo_2[]
$vehicleAAAA->removeTechnician($paul);
echo $vehicleAAAA;
//end::meo_2[]
//tag::meo_3[]
echo "\nVoici la liste des techniciens du véhicule {$vehicleAAAA->getRegisterNumber()} :";

foreach ($vehicleAAAA->getTechnicians() as $technician) { //<1>
    echo "\n* Technicien {$technician->getName()}";
}
//end::meo_3[]
//tag::meo_4[]
$cedric = new Technician('Cédric');
$baptiste = new Technician('Baptiste');

$techniciansCollection = [$cedric, $baptiste];

$vehicleCCCC = new Vehicle('CCCC');

$vehicleCCCC->setTechnicians($techniciansCollection);

echo $vehicleCCCC;
//end::meo_4[]
//tag::meo_5[]
$cedric = new Technician('Cédric');
$baptiste = new Technician('Baptiste');

$techniciansCollection = [$cedric, $baptiste];

$vehicleCCCC = new Vehicle('CCCC', $techniciansCollection);
//end::meo_5[]
//tag::meo_6[]
$arrayInt = [14,84,170];

$vehicleCCCC = new Vehicle('CCCC', $arrayInt); //<1>
//tag::echo_vehicle_error[]

echo $vehicleCCCC; //<1>
//end::echo_vehicle_error[]
//end::meo_6[]
//tag::meo_7[]
$arrayInt = [14,84,170];

$vehicleDDDD = new Vehicle('DDDD');

$vehicleDDDD->setTechnicians($arrayInt); //<1>
//end::meo_7[]


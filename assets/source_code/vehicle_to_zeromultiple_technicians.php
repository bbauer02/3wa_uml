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
    /**
     * @param string $registerNumber immatriculation
     */
    public function __construct(
        private string $registerNumber,
//tag::property_technicians[]
        private array $technicians = [],
//end::property_technicians[]
    )
    {
        //tag::check_collection_in_constructor[]
        //en affectant nous même la collection de techniciens, on s'assure qu'il n'y a que des objets du type attendu
        $this->setTechnicians($this->technicians);
        //end::check_collection_in_constructor[]
    }
//tag::mutator_accessor_of_technician[]

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

    /**
     * @param Technician $technician retire l'item de la collection
     */
    public function removeTechnician(Technician $technician): bool
    {
        $key = array_search($technician, $this->technicians, true); //<3>

        if ($key !== false) {
            unset($this->technicians[$key]); //<4>

            return true;
        }

        return false;
    }
//end::mutator_accessor_of_technician[]
    //tag::method_getTechnician[]
    /**
     * @return Technician[]
     */
    public function getTechnicians(): array
    {
        return $this->technicians;
    }
    //end::method_getTechnician[]

    //tag::method_setTechnicians[]
    /**
     * Assigne en une fois une collection de techniciens
     *
     * @param array $technicians tableau d'instances de type Technician
     *
     * @return Vehicle
     */
    public function setTechnicians(array $technicians): self
    {
        //initialisation de la collection à "vide"
        $this->technicians = []; //<1>

        //chaque élément du tableau est ajouté à la collection grâce à la méthode prévue pour cela
        foreach ($technicians as $technician) { //<2>
            $this->addTechnician($technician); //<3>
        }

        return $this;

    }
    //end::method_setTechnicians[]

//tag::mutator_accessor_of_registerNumber[]

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
//end::mutator_accessor_of_registerNumber[]
}

//end::class_Vehicle[]
//tag::meo[]

//a) création du technicien Paul
$technicianPaul = new Technician('Paul');

//b) création d'un véhicule avec un technicien
$vehicleA = new Vehicle('AAAA');

//c)Affectation de Paul à AAAA
$vehicleA->addTechnician($technicianPaul);

//d) Liste des techniciens du véhicule A
echo "\nListe des techniciens affectés au véhicule {$vehicleA->getRegisterNumber()} :";
foreach ($vehicleA->getTechnicians() as $technician) {
    echo "\n- {$technician->getName()}";
}

//e) création des techniciens Anna et Sofien et affectation au véhicule AAAA
$technicianAnna = new Technician('Anna');
$technicianSofien = new Technician('Sofien');
$vehicleA->addTechnician($technicianAnna);
$vehicleA->addTechnician($technicianSofien);

//f) Liste des techniciens du véhicule A
echo "\nListe des techniciens affectés au véhicule {$vehicleA->getRegisterNumber()} après ajout de Anna et Sofien :";
foreach ($vehicleA->getTechnicians() as $technician) {
    echo "\n- {$technician->getName()}";
}

//g) Sofien ne fera plus l'entretien du véhicule AAAA
$vehicleA->removeTechnician($technicianSofien);

//h) Liste des techniciens du véhicule A
echo "\nListe des techniciens affectés au véhicule {$vehicleA->getRegisterNumber()} après suppression de Sofien :";
foreach ($vehicleA->getTechnicians() as $technician) {
    echo "\n- {$technician->getName()}";
}

//i) Création d'une collection de deux techniciens
$technicianJeff = new Technician('Jeff');
$technicianSophie = new Technician('Sophie');
$collectionOfTechnicians = [
    $technicianJeff,
    $technicianSophie,
];
echo "\n";
//j) Affectation de la collection de techniciens Jeff et Sophie au véhicule AAAA
$vehicleA->setTechnicians($collectionOfTechnicians);

//k) Liste des techniciens du véhicule A
echo "\nListe des techniciens affectés au véhicule {$vehicleA->getRegisterNumber()} après affectation de la collection contenant Jeff et Sophie :";
foreach ($vehicleA->getTechnicians() as $technician) {
    echo "\n- {$technician->getName()}";
}

//l) Ajout d'une instance qui n'est pas du type Technician dans la collection
$collectionOfTechnicians = [...$collectionOfTechnicians, 'toto'];

//m) Affectation de la collection de techniciens qui contient un objet de type stdClass au véhicule AAAA
$vehicleA->setTechnicians($collectionOfTechnicians);

//end::meo[]



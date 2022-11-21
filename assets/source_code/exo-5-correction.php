<?php

//la classe véhicule est obligatoirement la classe responsable de la mise à jour de la classe inverse puisqu'elle doit être associée à un Driver dès son instanciation
//tag::class_vehicle_difference_ex_5[]
// <1>
class Vehicle implements Stringable
{

//end::class_vehicle_difference_ex_5[]

    //Déclaration des variables d'objet
    /**
     * @var string numéro d'immatriculation du véhicule
     */
    private string $registrationNumber;
    /**
     * @var int nombre de roues
     */
    private int $nbWheels;
    /**
     * @var string couleur du véhicule
     */
    private string $color;
    /**
     * @var string type de moteur (essence, diesel, électrique, hydrogène, ...)
     */
    private string $typeEngine;
    /**
     * @var int Position du véhicule
     */
    private int $position = 0;

    //tag::class_vehicle_difference_ex_5[]

    //ici déclaration des autres attributs d'objets
    /**
     * @param Driver $driver conducteur associé au véhicule
     */
    public function __construct(
        private Driver $driver //<2>
    )
    {
        // ATTENTION ATTENTION ATTENTION ATTENTION
        // ATTENTION ATTENTION ATTENTION ATTENTION

        //Même si vous utilisez la promotion des arguments, il faut passer par la méthode setDriver de façon à mettre à jour l'objet inverse (ici le conducteur)
        $this->setDriver($driver); //<5>
    }


    /**
     * @return Driver
     */
    public function getDriver(): Driver
    {
        return $this->driver;
    }

    /**
     * @param Driver $driver
     *
     * @return Vehicle
     */
    public function setDriver(Driver $driver): Vehicle
    {
        $this->driver = $driver;
        //mise à jour de l'objet inverse (le conducteur)
        $driver->addVehicle($this); //<3>

        return $this;
    }

    // ici les autres opérations (mutateurs, setters, ...)

    //end::class_vehicle_difference_ex_5[]


    //region ****** Mutateurs et accesseurs ******


    /**
     * @return string
     */
    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

    /**
     * @return int
     */
    public function getNbWheels(): int
    {
        return $this->nbWheels;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getTypeEngine(): string
    {
        return $this->typeEngine;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param string $registrationNumber
     *
     * @return Vehicle
     */
    public function setRegistrationNumber(string $registrationNumber): Vehicle
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    /**
     * @param int $nbWheels
     *
     * @return Vehicule
     */
    public function setNbWheels(int $nbWheels): self
    {
        $this->nbWheels = $nbWheels;

        return $this;
    }

    /**
     * @param string $color
     *
     * @return Vehicule
     */
    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @param string $typeEngine
     *
     * @return Vehicule
     */
    public function setTypeEngine(string $typeEngine): self
    {
        $this->typeEngine = $typeEngine;

        return $this;
    }

    //endregion ****** Mutateurs et accesseurs ******


    //region ****** Autres opérations ******

    public function __toString(): string
    {
        return "Immatriculation : {$this->registrationNumber} ; Nombre de roues : {$this->nbWheels} ; couleur : {$this->color} ; type de moteur {$this->typeEngine} ; position : {$this->position}";
    }


    public function moveForward(int $nbKms): self
    {
        $this->position += $nbKms;

        return $this;
    }

    public function moveBack(int $nbKms): self
    {
        $this->position -= $nbKms;

        return $this;
    }

    //endregion ****** Autres opérations ******

//tag::class_vehicle_difference_ex_5[]
}

//end::class_vehicle_difference_ex_5[]

//tag::class_vehicle_difference_ex_5[]
class Driver
{
    /**
     * @param string            $name      nom du conducteur
     * @param DateTimeImmutable $birthDate date de naissance du conducteur
     * @param array|Vehicle[]   $vehicles  collection d'objets de type Vehicle
     */
    public function __construct(
        private string $name,
        private DateTimeImmutable $birthDate,
        private array $vehicles = []
    ) {
    }

    //autres mutateurs, accesseurs et méthodes

    //end::class_vehicle_difference_ex_5[]

    //region ****** mutateurs et accesseurs ******

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
     * @return Driver
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getBirthDate(): DateTimeImmutable
    {
        return $this->birthDate;
    }

    /**
     * @param DateTimeImmutable $birthDate
     *
     * @return Driver
     */
    public function setBirthDate(DateTimeImmutable $birthDate): self
    {
        $this->birthDate = $birthDate;

        //si jamais la personne change sa date de naissance pour une date qui la conduit à être mineure, alors il faut désassocier les véhicules
        if (!$this->isLegal()) {
            $this->messageIsNotLegal();
            $this->vehicle = [];
        }

        return $this;
    }

    //tag::class_vehicle_difference_ex_5[]

    /**
     * @param Vehicle $vehicle ajoute un item de type Vehicle à la collection
     */
    public function addVehicle(Vehicle $vehicle): bool
    {
        //tester si le conducteur est mineur
        if (!$this->isLegal()) {
            $this->messageIsNotLegal();

            return false;
        }
        if (!in_array($vehicle, $this->vehicles, true)) {
            $this->vehicles[] = $vehicle;
            //<4>
            //pas de mise à jour de l'objet lié car c'est l'objet Vehicle qui est responsable de la navigabilité bidirectionnelle
            return true;
        }

        return false;
    }

    /**
     * @param Vehicle $vehicle retire l'item de la collection
     */
    public function removeVehicle(Vehicle $vehicle): bool
    {

        $key = array_search($vehicle, $this->vehicles, true);

        if ($key !== false) {
            unset($this->vehicles[$key]);

            return true;
        }

        return false;
    }

    /**
     * @return Vehicle[]
     */
    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    //end::class_vehicle_difference_ex_5[]

    private function messageIsNotLegal(): void
    {
        echo "\n La personne est mineure, il n'est pas possible de lui associer un véhicule.\n";

    }

    //endregion ****** mutateurs et accesseurs ******

    //region ****** Autres opérations ******

    public function isLegal(): bool
    {
        //date courante
        $now = new DateTimeImmutable(
        ); //j'aurais pu prendre une date de type DateTime
        //calcul de la différente entre la date du jour et la date de naissance
        //documentation : https://www.php.net/manual/fr/datetime.diff.php
        $interval = $this->birthDate->diff($now);
        //cet interval est un objet, il faut retourner l'écart en nombre d'années
        $years = (int)$interval->format('%r%y');

        return $years > 18;

    }

    //endregion ****** Autres opérations ******
//tag::class_vehicle_difference_ex_5[]
}

//end::class_vehicle_difference_ex_5[]

//tag::class_vehicle_difference_ex_5[]

echo "\n\n==== DEBUT DU TEST EXERCICE 5 ==== \n";

//création de Paul (majeur)
$driverPaul = new Driver('Paul', new DateTimeImmutable('2000-04-12'));

//création de Juliette (mineure)
$driverJuliette = new Driver('Juliette', new DateTimeImmutable('2019-02-24'));

//Tentative d'affectation d'un véhicule A à Juliette
$vA = (new Vehicle($driverJuliette))->setRegistrationNumber('AAAA');

//Tentative d'affectation d'un véhicule B à Paul
$vB = (new Vehicle($driverPaul))->setRegistrationNumber('BBBB');

//liste des véhicules conduits par Paul
echo "\n *** Liste des véhicules de {$driverPaul->getName()} ***";
foreach ($driverPaul->getVehicles() as $vehicle) {
    echo "\n-{$vehicle->getRegistrationNumber()}";
}

//liste des véhicules conduits par Juliette
echo "\n *** Liste des véhicules de {$driverJuliette->getName()} ***";
foreach ($driverJuliette->getVehicles() as $vehicle) {
    echo "\n-{$vehicle->getRegistrationNumber()}";
}

echo "\n==== FIN DU TEST EXERCICE 5 ====";
//end::class_vehicle_difference_ex_5[]


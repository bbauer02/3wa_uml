<?php


//tag::classes[]

class Vehicle implements Stringable
{
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

    /**
     * @var array collection d'objets de type Driver
     */
    private array $drivers = []; //<1>

    //tag::class_vehicle_difference_ex_6[]

    //ici déclaration des autres attributs d'objets
    /**
     * @param Driver $driver conducteur associé au véhicule
     */
    public function __construct(
    )
    {
    }

    //mutateurs et accesseur pour la collection $drivers

    /**
     * @param Driver $driver ajoute un item de type Driver à la collection
     */
    public function addDriver(Driver $driver): bool //<2>
    {
        if (!in_array($driver, $this->drivers, true)) {
            $this->drivers[] = $driver;
            //mise à jour de l'objet inverse (lié)
            $driver->addVehicle($this); //<5>
            return true;
        }

        return false;
    }

    /**
     * @param Driver $driver retire l'item de la collection
     */
    public function removeDriver(Driver $driver): bool //<3>
    {
        $key = array_search($driver, $this->drivers, true);

        if ($key !== false) {
            unset($this->drivers[$key]);
            //mise à jour de l'objet inverse (lié)
            $driver->removeVehicle($this); //<5>
            return true;
        }

        return false;
    }

    /**
     * @return Driver[]
     */
    public function getDrivers(): array //<4>
    {
        return $this->drivers;
    }
    

    // ici les autres opérations (mutateurs, setters, ...)



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

}


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

    //end::class_vehicle_difference_ex_6[]

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

    //end::class_vehicle_difference_ex_6[]

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
}

//end::classes[]

//tag::mise_en_oeuvre[]
echo "\n\n==== DEBUT DU TEST EXERCICE 6 ==== \n";

//création de Anna (majeure)
$driverAnna = new Driver('Anna', new DateTimeImmutable('2000-04-12'));

//création de Juliette (majeure)
$driverJalila = new Driver('Jalila', new DateTimeImmutable('1998-02-24'));

//création des 4 véhicules
$vA = (new Vehicle())->setRegistrationNumber('AAAA'); //<1>
$vB = (new Vehicle())->setRegistrationNumber('BBBB');
$vC = (new Vehicle())->setRegistrationNumber('CCCC');
$vD = (new Vehicle())->setRegistrationNumber('DDDD');

//Affectation des véhicules A et B à Anna
$vA->addDriver($driverAnna); //<1>
$vB->addDriver($driverAnna);

//Affectation des véhicule B, C et D à Jalila
$vB->addDriver($driverJalila);
$vC->addDriver($driverJalila);
$vD->addDriver($driverJalila);

//liste des véhicules conduits par Anna
echo "\n *** Liste des véhicules de {$driverAnna->getName()} ***";
foreach ($driverAnna->getVehicles() as $vehicle) {
    echo "\n-{$vehicle->getRegistrationNumber()}";
}

//liste des conducteur du véhicule B
echo "\n *** Liste des conducteur du véhicule immatriculé {$vB->getRegistrationNumber()} ***";
foreach ($vB->getDrivers() as $driver) {
    echo "\n-{$driver->getName()}";
}

echo "\n==== FIN DU TEST EXERCICE 6 ====";

//end::mise_en_oeuvre[]


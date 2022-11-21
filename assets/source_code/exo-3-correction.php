<?php

//inclusion de la classe Vehicle
include_once 'exo-1-correction.php';

/**
 * Navigabilité unidirectionnelle de Driver vers Vehicle
 */
class Driver
{
    /**
     * @param string            $name      nom du conducteur
     * @param DateTimeImmutable $birthDate date de naissance du conducteur
     * @param arrray|Vehicle[]      $vehicles   collection d'objets de type Vehicle
     */
    public function __construct(
        private string $name,
        private DateTimeImmutable $birthDate,
        private array $vehicles = [] //<1>
    ) {

    }

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
        if(!$this->isLegal()){
            $this->messageIsNotLegal();
            return false;
        }
        if (!in_array($vehicle, $this->vehicles, true)) {
            $this->vehicles[] = $vehicle;

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
        $interval = $this->birthDate->diff($now); //<2>
        //cet intervalle est un objet, il faut retourner l'écart en nombre d'années
        $years = (int)$interval->format('%r%y'); //<3>

        return $years > 18;

    }

    //endregion ****** Autres opérations ****** 
}

echo "\n\n==== DEBUT DU TEST EXERCICE 3 ==== \n";

//création des conducteurs
$driverPaul = new Driver('Paul', new DateTimeImmutable('2000-04-12'));
$driverJuliette = new Driver('Juliette', new DateTimeImmutable('2019-02-24'));

//création des véhicules
$vA = (new Vehicle())->setRegistrationNumber('AAAA');
$vB = (new Vehicle())->setRegistrationNumber('BBBB');
$vC = (new Vehicle())->setRegistrationNumber('CCCC');
$vD = (new Vehicle())->setRegistrationNumber('DDDD');
$vE = (new Vehicle())->setRegistrationNumber('EEEE');

//affectation des véhicules à Paul
$driverPaul->addVehicle($vA);
$driverPaul->addVehicle($vB);
$driverPaul->addVehicle($vC);
$driverPaul->addVehicle($vD);

//affectation des véhicules à Juliette
$driverJuliette->addVehicle($vA);
$driverJuliette->addVehicle($vB);

//déplacement des véhicules
$vA->moveForward(120);
$vC->moveForward(84);
$vC->moveBack(25);

//liste des véhicules conduits par Paul
echo "\n *** Liste des véhicules de {$driverPaul->getName()} ***";
foreach ($driverPaul->getVehicles() as $vehicle ){
    echo "\n-{$vehicle->getRegistrationNumber()}";
}

//liste des véhicules conduits par Juliette
echo "\n *** Liste des véhicules de {$driverJuliette->getName()} ***";
foreach ($driverJuliette->getVehicles() as $vehicle ){
    echo "\n-{$vehicle->getRegistrationNumber()}";
}

//suppression des véhicules A et E pour Paul
$driverPaul->removeVehicle($vA);
$driverPaul->removeVehicle($vE);

//liste des véhicules restant à Paul
echo "\n *** Liste des véhicules restant à {$driverPaul->getName()} ***";
foreach ($driverPaul->getVehicles() as $vehicle ){
    echo "\n-{$vehicle->getRegistrationNumber()}";
}

echo "\n==== FIN DU TEST EXERCICE 3 ====";


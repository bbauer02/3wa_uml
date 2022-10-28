<?php

//inclusion de la classe Vehicle
include_once 'exo-1-correction.php';

/**
 * Navigabilité unidirectionnelle de Driver vers Vehicle
 */
class Driver
{
    /**
     * @var array|Vehicle[] $vehicles collection d'objets de type Vehicle
     */
    private array $vehicles = []; //ne pas oublier d'initialiser la collection !

    /**
     * @param string            $name      nom du conducteur
     * @param DateTimeImmutable $birthDate date de naissance du conducteur
     * @param Vehicle      $vehicle   un objet de type Vehicle (ce n'est pas une variable d'objet !)
     */
    public function __construct(
        private string $name,
        private DateTimeImmutable $birthDate,
        Vehicle $vehicle //<1>
    ) {
        //conformément au diagramme, on associe un véhicule dès la création du conducteur
        $this->addVehicle($vehicle); //<2>
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
        //s'il ne reste plus qu'un véhicule, il ne faut pas le retirer conformément au diagramme
        if(count($this->vehicles) === 1){ //<3>
            return false;
        }

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
        $interval = $this->birthDate->diff($now);
        //cet interval est un objet, il faut retourner l'écart en nombre d'années
        $years = (int)$interval->format('%r%y');

        return $years > 18;

    }

    //endregion ****** Autres opérations ****** 
}

echo "\n\n==== DEBUT DU TEST EXERCICE 4 ==== \n";

//Création du véhicule A
$vA = (new Vehicle())->setRegistrationNumber('AAAA');

//création de Paul
$driverPaul = new Driver('Paul', new DateTimeImmutable('2000-04-12'),$vA);

//Création du véhicule B
$vB = (new Vehicle())->setRegistrationNumber('BBBB');
//affectation du véhicule B à Paul
$driverPaul->addVehicle($vB);
//Création du véhicule C
$vC = (new Vehicle())->setRegistrationNumber('CCCC');
//circulation des véhicules A et C
$vA->moveForward(123);
$vC->moveForward(257);
$vA->moveBack(70);

//liste des véhicules conduits par Paul
echo "\n *** Liste des véhicules de {$driverPaul->getName()} ***";
foreach ($driverPaul->getVehicles() as $vehicle ){
    echo "\n-{$vehicle->getRegistrationNumber()}";
}

//suppression des véhicules A et C pour Paul
$driverPaul->removeVehicle($vA);
$driverPaul->removeVehicle($vC);

//liste des véhicules conduits par Paul
echo "\n *** Liste des véhicules restant à {$driverPaul->getName()} ***";
foreach ($driverPaul->getVehicles() as $vehicle ){
    echo "\n-{$vehicle->getRegistrationNumber()}";
}

echo "\n==== FIN DU TEST EXERCICE 4 ====";


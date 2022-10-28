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
     * @param Vehicle|null      $vehicle   instance du véhicule associé au
     *                                     conducteur
     */
    public function __construct(
        private string $name,
        private DateTimeImmutable $birthDate,
        private ?Vehicle $vehicle = null
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

        //si jamais la personne change sa date de naissance pour une date qui la conduit à être mineure, alors il faut désassocier le véhicule
        if (!$this->isLegal()) {
            $this->messageIsNotLegal();
            $this->vehicle = null;
        }

        return $this;
    }

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
     * @return Driver
     */
    public function setVehicle(?Vehicle $vehicle): self
    {
        //si le conducteur est majeur, on peut lui affecter un véhicule, sinon on ne lui affecte pas
        if ($this->isLegal()) {
            $this->vehicle = $vehicle;
        } else {
            $this->messageIsNotLegal();
            $this->vehicle = null;
        }

        return $this;
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

echo "\n\n==== DEBUT DU TEST EXERCICE 2 ==== \n";

$driverPaul = new Driver('Paul', new DateTimeImmutable('2017-04-12'));
$driverPaul->setVehicle($v1);
$driverJuliette = new Driver('Juliette', new DateTimeImmutable('2000-02-24'));
$driverJuliette->setVehicle($v1);
$driverJuliette->getVehicle()->moveForward(100)->moveBack(40);
//on donne la position du véhicule depuis l'objet "Juliette"
echo "\n La position du véhicule de {$driverJuliette->getName()} est {$driverJuliette->getVehicle()->getPosition()}";
echo "\n==== FIN DU TEST EXERCICE 2 ====";


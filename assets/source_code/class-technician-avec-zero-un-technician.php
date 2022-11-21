<?php

class Vehicle
{
    //l'attribut stockant la référence d'un  objet de type Technician peut être null
    public function __construct(private ?Technician $technician = null)
    {
    }

    //on peut affecter un autre technicien
    public function setTechnician(Tecnician $t): void
    {
        $this->technician = $t;
    }

    //navigabilité : on peut accéder au technicien depuis le véhicule courant
    public function tetTechnician(Tecnician $t): Technician
    {
        return $this->t;
    }
}

class Technician
{
}

$vehicle = new Vehicle(); //ok
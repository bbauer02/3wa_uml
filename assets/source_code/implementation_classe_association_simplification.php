<?php


//tag::class_Vehicle[]
class Vehicle
{
    /**
     * @param array $intervention |Intervention[] tableau d'objets de type
     *                            Intervention
     */
    public function __construct(
        private array $interventions = []

    ) {
    }

    /**
     * @param Intervention $intervention ajoute un item de type Intervention à
     *                                   la collection
     */
    public function addIntervention(Intervention $intervention): bool
    {
        if (!in_array($intervention, $this->interventions, true)) {
            $this->interventions[] = $intervention;

            return true;
        }

        return false;
    }

    /**
     * @param Intervention $intervention retire l'item de la collection
     */
    public function removeIntervention(Intervention $intervention): bool
    {
        $key = array_search($intervention, $this->interventions, true);

        if ($key !== false) {
            unset($this->interventions[$key]);

            return true;
        }

        return false;
    }

    /**
     * @return Intervention[]
     */
    public function getInterventions(): array
    {
        return $this->interventions;
    }

    //tag::class_Vechicule_getTechnician[]
    //méthode à ajouter dans la classe Vehicle
    public function getTechnicians()
    {
        $technicians = [];
        /** @var Intervention $intervention */
        foreach ($this->interventions as $intervention) {
            $technicians[] = $intervention->getTechnician();
        }

        return $technicians;

    }
    //end::class_Vechicule_getTechnician[]
}

//end::class_Vehicle[]

//tag::class_Technician[]
class Technician
{
    /**
     * @param array $intervention |Intervention[] tableau d'objets de type
     *                            Intervention
     */
    public function __construct(
        private array $interventions = []
    ) {

    }

    /**
     * @param Intervention $intervention ajoute un item de type Intervention à
     *                                   la collection
     */
    public function addIntervention(Intervention $intervention): bool
    {
        if (!in_array($intervention, $this->interventions, true)) {
            $this->interventions[] = $intervention;

            return true;
        }

        return false;
    }

    /**
     * @param Intervention $intervention retire l'item de la collection
     */
    public function removeIntervention(Intervention $intervention): bool
    {
        $key = array_search($intervention, $this->interventions, true);

        if ($key !== false) {
            unset($this->interventions[$key]);

            return true;
        }

        return false;
    }

    /**
     * @return Intervention[]
     */
    public function getInterventions(): array
    {
        return $this->interventions;
    }

    //tag::class_Technician_getVehicles[]
    //méthode à ajouter dans la classe Technician
    public function getVehicles()
    {
        $vehicles = [];
        /** @var Intervention $intervention */
        foreach ($this->interventions as $intervention) {
            $vehicles[] = $intervention->getVehicle();
        }

        return $vehicles;

    }
    //end::class_Technician_getVehicles[]
}

//end::class_Technician[]


//tag::class_Intervention[]
class Intervention
{
    /**
     * @param string     $descriptionIntervention
     * @param bool       $isResolved
     * @param Vehicle    $vehicle
     * @param Technician $technician
     */
    public function __construct(
        private string $descriptionIntervention,
        private bool $isResolved,
        private Vehicle $vehicle,
        private Technician $technician
    ) {
    }


    //accesseur pour le véhicule

    /**
     * @return Vehicle
     */
    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    //mutateur pour le véhicule (on pourrait ne pas avoir de mutateur car le véhicule est affecté à l'intervention au moment de l'instanciation de cette dernière). Laisse le mutateur permet de modifier le véhicule associé (suite à une erreur de saisi par exemple)

    /**
     * @param Vehicle $vehicle
     */
    public function setVehicle(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;

        //mise à jour de l'objet lié pour la navigabilité bidirectionnelle
        $vehicle->addIntervention($this);
    }

    /**
     * @return Technician
     */
    public function getTechnician(): Technician
    {
        return $this->technician;
    }

    /**
     * @param Technician $technician
     */
    public function setTechnician(Technician $technician): void
    {
        $this->technician = $technician;

        //mise à jour de l'objet lié pour la navigabilité bidirectionnelle
        $technician->addIntervention($this);
    }

    //mutateurs et accesseurs des autres attributs
    //...

}
//end::class_Intervention[]
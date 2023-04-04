<?php

class  Vehicle {

    public function __construct(
        private string $registerNumber,
        private array $technicians = []
    ) {
        $this->setTechnicians($this->technicians);

    }

    /**
     * @param Technician $technician ajoute un item de type Technician à la
     *                               collection
     */
    public function addTechnician(Technician $technician): bool
    {
        if (!in_array($technician, $this->technicians, true)) {
            $this->technicians[] = $technician;

            return true;
        }

        return false;
    }

    /**
     * @param Technician $technician retire l'item de la collection
     */
    public function removeTechnician(Technician $technician): bool
    {
        $key = array_search($technician, $this->technicians, true);

        if ($key !== false) {
            unset($this->technicians[$key]);

            return true;
        }

        return false;
    }

    /**
     * Initialise la collection avec la collection passée en argument
     *
     * @param array $technicians collection d'objets de type Technician
     *
     * @return $this
     */
    public function setTechnicians(array $technicians): self
    {
        $this->technicians = [];

        foreach ($technicians as $technician) {
            $this->addTechnician($technician);
        }

        return $this;
    }

    /**
     * @return Technician[]
     */
    public function getTechnicians(): array
    {
        return $this->technicians;
    }
    

}

class Technician{
    public function __construct(
        private string $name,
        private Vehicle $vehicle = null
    ) {}

    /**
     * @return Vehicle|null
     */
    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    /**
     * @param Vehicle|null $vehicle
     */
    public function setVehicle(?Vehicle $vehicle): void
    {
        //maj de l'objet inverse
        if($vehicle !== null) {
            $vehicle->addTechnician($this);
        }

        //check du précédent véhicule associé au technicien courant
        if( $this->vehicle !== null){
            $this->vehicle->removeTechnician($this);
        }

        //maj du nouveau véhicule associé au technicien

        $this->vehicle = $vehicle;
    }


}
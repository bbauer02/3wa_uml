<?php

//tag::class_Technician[]
class Technician
{
    public function __construct(
        private array $surbordinates = [],
        //tag::property_superior[]
        private ?Technician $superior = null,
        //end::property_superior[]
    ) {
    }

    //tag::mutator_accessor_of_superior[]
    /**
     * Retourne le supérieur du technicien courant
     * @return Technician|null
     */
    public function getSuperior(): ?Technician
    {
        return $this->superior;
    }

    /**
     * Affecte un supérieur au technicien courant
     * @param Technician|null $superior
     *
     * @return Technician
     */
    public function setSuperior(?Technician $superior): Technician
    {
        //tag::check_superior_is_not_himself[]
        //contrôle que le supérieur du technicien courant n'est pas lui-même
        if ($superior === $this) {
            throw new Exception(
                "Un technicien ne peut pas être son propre supérieur"
            );
        }
        //end::check_superior_is_not_himself[]
        
        
        //tag::maj_inverse_superior[]
        //mise à jour de l'ancien supérieur <1>
        if (null !== $this->superior) {
            $this->superior->removeSubordinate($this);
        }

        //mise à jour du nouveau supérieur <2>
        if (null !== $superior) {
            $superior->addSubordinate($this);
        }
        //end::maj_inverse_superior[]

        $this->superior = $superior;

        return $this;
    }
    //end::mutator_accessor_of_superior[]
    //tag::mutator_accessor_of_subordinates[]
    /**
     * Ajoute un subordonné au technicien courant
     * @param Technician $subordinate  ajoute un item de type Technician à la
     *                                 collection
     */
    public function addSubordinate(Technician $subordinate): bool
    {
        //tag::check_subordinate_is_not_himself[]
        //contrôle que le subordonné du technicien courant n'est pas lui-même
        if ($subordinate === $this) {
            throw new Exception(
                "Un technicien ne peut pas être son propre subordonné"
            );
        }
        //end::check_subordinate_is_not_himself[]

        if (!in_array($subordinate, $this->subordinates, true)) {
            $this->subordinates[] = $subordinate;

            return true;
        }

        return false;
    }

    /**
     * Retire un subordonné au technicien courant
     * @param Technician $subordinate retire l'item de la collection
     */
    public function removeSubordinate(Technician $subordinate): bool
    {
        $key = array_search($subordinate, $this->subordinates, true);

        if ($key !== false) {
            unset($this->subordinates[$key]);

            return true;
        }

        return false;
    }

    /**
     * Initialise la collection de subordonnés du technicien courant
     *
     * @param array $subordinates collection d'objets de type Technician
     *
     * @return $this
     */
    public function setSubordinates(array $subordinates): self
    {

        foreach ($subordinates as $subordinate) {
            $this->addSubordinate($subordinate);
        }

        return $this;
    }

    /**
     * Retourne la collection de subordonnés du technicien courant
     * @return Technician[]
     */
    public function getSubordinates(): array
    {
        return $this->subordinates;
    }
    //end::mutator_accessor_of_subordinates[]


}
//end::class_Technician[]
//tag::meo_1[]
//Mise en oeuvre du contrôle qu'un technicien ne peut être ni son propre supérieur, ni son propre subordonné
$t = new Technician();
$t->setSuperior($t); //lève une exception : Un technicien ne peut pas être son propre supérieur !
$t->addSubordinate($t); //lève une exception : Un technicien ne peut pas être son propre subordonné !
//end::meo_1[]
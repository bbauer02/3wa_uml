<?php

class Technician
{

    /**
     * Il faut choisir quel technicien sera l'objet possédant. Ici, ce sera le
     * technicien subordonné à qui on affecte un supérieur
     *
     * @param Technician[]    $subordinates collection de techniciens
     *                                      subordonnés
     * @param Technician|null $superior     supérieur hiérarachique
     */
    public function __construct(
        private array $subordinates = [],
        private ?Technician $superior = null
    ) {
    }

    //***************************************************************
    //region *H1* gestion des subordonnés
    //***************************************************************

    //tag::methodeAddSubordinate[]
    /**
     * @param Technician $subordinate ajoute un item de type Technician à la
     *                                collection
     */
    public function addSubordinate(Technician $subordinate): bool
    {
        //tag::checkSubordonateHimself[]
        //on contrôle que le technicien proposé comme subordonné n'est pas lui-même
        if($subordinate === $this){
            echo 'Un technicien ne peut pas être son propre subordonné !';
            return false;
        }
        //end::checkSubordonateHimself[]

        if (!in_array($subordinate, $this->subordinates, true)) {
            $this->subordinates[] = $subordinate;

            return true;
        }

        return false;
    }
    //end::methodeAddSubordinate[]

    /**
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
     * @return Technician[]
     */
    public function getSubordinates(): array
    {
        return $this->subordinates;
    }

    //***************************************************************
    //endregion *H1* gestion des subordonnés
    //***************************************************************

    //***************************************************************
    //region *H1* gestion du supérieur
    //***************************************************************

    //tag::methodeAddSubordinate[]
    /**
     * @param Technician|null $superior
     */
    public function setSuperior(?Technician $superior): void
    {
        //tag::checkSubordonateHimself[]
        //on contrôle que le technicien proposé comme supérieur n'est pas lui-même
        if($superior === $this){
            echo 'Un technicien ne peut pas être son propre supérieur !';
            return ;
        }
        //end::checkSubordonateHimself[]
        //...
        //end::methodeAddSubordinate[]

        //si le nouveau supérieur est null et que le technicien courant avait un supérieur, c'est qu'il faut retirer ce subordonné de son supérieur actuel (enfin, s'il en a un)
        if ($superior === null && $this->getSuperior() !== null) {
            //mise à jour de l'objet inverse
            $this->getSuperior()->removeSubordinate($this); // <1>
        }

        $this->superior = $superior; // <2>

        //si le nouveau supérieur n'est pas null, alors on lui ajoute le subordonné courant
        if ($superior !== null) {
            $superior->addSubordinate($this); //<3>
        }
        //tag::methodeAddSubordinate[]
    }
    //end::methodeAddSubordinate[]

    /**
     * @return Technician|null
     */
    public function getSuperior(): ?Technician
    {
        return $this->superior;
    }

    //***************************************************************
    //endregion *H1* gestion du supérieur
    //***************************************************************
}
//tag::checkSuperiorAndSubordinate[]
//Mise en oeuvre du contrôle qu'un technicien ne peut être ni son propre supérieur, ni son propre subordonné
$t = new Technician();
$t->setSuperior($t); //affiche Un technicien ne peut pas être son propre supérieur !
$t->addSubordinate($t); //Un technicien ne peut pas être son propre subordonné !
//end::checkSuperiorAndSubordinate[]
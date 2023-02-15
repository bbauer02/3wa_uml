<?php

//tag::class_Table[]
class Table
{
//on définit un nombre de serveurs minimum à affecter à une table
    const MIN_WAITERS_BY_TABLE = 1;

    public function __construct(
        //il faut forcer le passage d'un  tableau à l'instanciation afin de contrôler s'il contient au moins une instance de Waiter
        private array $waiters = [] // <1>
    )
    {
        $this->setWaiters($waiters);
    }

    /**
     * @param Waiter $waiter ajoute un item de type Waiter à la collection
     */
    public function addWaiter(Waiter $waiter): bool
    {
        if (!in_array($waiter, $this->waiters, true)) {
            $this->waiters[] = $waiter;

            return true;
        }

        return false;
    }

    /**
     * @param Waiter $waiter retire l'item de la collection
     */
    public function removeWaiter(Waiter $waiter): bool
    {
        $key = array_search($waiter, $this->waiters, true);

        if ($key !== false) {

            //on ne tente pas de supprimer le serveur s'il n'y en a qu'un seul dans la collection
            if(count($this->waiters) === self::MIN_WAITERS_BY_TABLE){ //<2>
                throw new Exception("Une table doit être associée à au moins {self::MIN_WAITERS_BY_TABLE} serveur(s)");
            }

            unset($this->waiters[$key]);

            return true;
        }

        return false;
    }

    /**
     * Initialise la collection avec la collection passée en argument
     *
     * @param array $waiters collection d'objets de type Waiter
     *
     * @return $this
     */
    public function setWaiters(array $waiters): self
    {

        foreach ($waiters as $waiter) {
            $this->addWaiter($waiter);
        }

        //on contrôle qu'il y a au moins un serveur dans la collection
        if(count($this->waiters) < self::MIN_WAITERS_BY_TABLE){ //<3>
            throw new Exception("Une table doit être associée à au moins {self::MIN_WAITERS_BY_TABLE} serveur(s)");
        }

        return $this;
    }

    /**
     * @return Waiter[]
     */
    public function getWaiters(): array
    {
        return $this->waiters;
    }

}
//end::class_Table[]

//tag::class_Waiter[]
class Waiter
{
}
//end::class_Waiter[]
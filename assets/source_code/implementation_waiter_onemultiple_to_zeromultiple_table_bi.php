<?php

//tag::class_Waiter[]
class Waiter
{

    //nombre maximum de tables pouvant être affectées à un serveur
    const MAX_TABLES = 4;

    public function __construct(
        private array $tables = []
    )
    {
    }

    /**
     * @param Table $table ajoute un item de type Table à la collection
     */
    public function addTable(Table $table): bool
    {
        //on vérifie que le nombre maximum de tables n'est pas déjà atteint
        if (count($this->tables) === self::MAX_TABLES) {
            return false;
        }

        if (!in_array($table, $this->tables, true)) {
            $this->tables[] = $table;

            return true;
        }

        return false;
    }

    /**
     * @param Table $table retire l'item de la collection
     */
    public function removeTable(Table $table): bool
    {
        $key = array_search($table, $this->tables, true);

        if ($key !== false) {
            unset($this->tables[$key]);

            return true;
        }

        return false;
    }

    /**
     * Initialise la collection avec la collection passée en argument
     *
     * @param array $tables collection d'objets de type Table
     *
     * @return $this
     */
    public function setTables(array $tables): self
    {

        foreach ($tables as $table) {
            $this->addTable($table);
        }

        return $this;
    }

    /**
     * @return Table[]
     */
    public function getTables(): array
    {
        return $this->tables;
    }

}
//end::class_Waiter[]
//tag::class_Table[]
class Table
{
//on définit un nombre de serveurs minimum à affecter à une table
    const MIN_WAITERS_BY_TABLE = 1;

    public function __construct(
        //il faut forcer le passage d'un  tableau à l'instanciation afin de contrôler s'il contient au moins une instance de Waiter
        private array $waiters
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

            //maj de l'objet inverse
            $waiter->addTable($this); //<1>

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
            if(count($this->waiters) === self::MIN_WAITERS_BY_TABLE){
                throw new Exception("Une table doit être associée à au moins {self::MIN_WAITERS_BY_TABLE} serveur(s)");
            }

            unset($this->waiters[$key]);

            //maj de l'objet inverse
            $waiter->removeTable($this); //<1>


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
        //maj des objets inverses de la collection AVANT son actualisation
        foreach($this->waiters as $waiter){
            $waiter->removeTable($this); //<1>
        }

        foreach ($waiters as $waiter) {
            $this->addWaiter($waiter);
        }

        //on contrôle qu'il y a au moins un serveur dans la collection
        if(count($this->waiters) < self::MIN_WAITERS_BY_TABLE){
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

<?php

//tag::class_Table[]
class Table
{

}
//end::class_Table[]

//tag::class_Waiter[]
class Waiter
{

    //tag::property_max_tables[]
    //nombre maximum de tables pouvant être affectées à un serveur
    const MAX_TABLES = 4;
    //end::property_max_tables[]

    public function __construct(
        private array $tables = []
    )
    {
    }

    //tag::method_add_table[]
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
    //end::method_add_table[]

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
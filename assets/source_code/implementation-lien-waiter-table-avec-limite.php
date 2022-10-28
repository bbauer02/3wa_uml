<?php

//je n'utilise pas la promotion des paramètres de méthodes de PHP8 pour bien rendre visible l'attribut qui représente l'association à la classe Table.
    //tag::cardinaliteMax[]
class Waiter
{
    //la limite du nombre de tables est la même pour tous les serveurs, c'est donc un attribut de classe et non d'objet que j'utilise pour stocker cette limite
    private const MAX_TABLES = 4;

    //end::cardinaliteMax[]
    /**
     * Collection d'objets de type Table
     * (ce sont les tables associées au serveur courant. (l'instance de Waiter manipulée)
     */
    private array $tables = [];

    //tag::cardinaliteMin1[]
    /**
     * Un serveur ne peut être instancié sans un objet Table.
     * Cela nous assure qu'il y aura au moins une table affectée au serveur courant
     */
    public function __construct(Table $table)
    {
        $this->addTable($table);
    }
    //end::cardinaliteMin1[]

    /**
     * Ajoute la table si elle ne fait pas déjà partie des tables servies par le serveur courant
     */
    //tag::addTableMethod[]
    public function addTable(Table $table): bool
    {
        //on contrôle si le maximum exprimé par la cardinalité est déjà atteint
        if(count($this->tables) === self::MAX_TABLES ){
            //faire ce que l'on veut ici
            echo "Il ne peut pas être affecté plus de ".self::MAX_TABLES." tables à un même serveur";
            return false;
        }

        //l'instance n'est ajoutée à la collection que si elle n'y est pas déjà
        if (!in_array($table, $this->tables, true)) {
            $this->tables[] = $table;

            return true;
        }

        return false;
    }
    //end::addTableMethod[]


    /**
     * Supprime la table si elle fait partie des tables servies par le serveur courant
     */
    public function removeTable(Table $table): bool
    {
        //indice où se trouve l'instance à supprimer
        $key = array_search($table, $this->tables, true);

        if ($key !== false) {
            unset($this->tables[$key]);

            return true;
        }

        return false;
    }

    /**
     * Retourne la collection de tables associées au serveur courant
     */
    public function getTables(): array {
        return $this->tables;
    }

    /**
     * Ce mutateur remplace la collection existante par une autre.
     * Cette méthode est à prévoir seulement si ce besoin est nécessaire.
     */
    public function setTables(array $tables): self {
        //il faudrait ici s'assurer que tous les objets sont de types Table

        $this->tables = $tables;

        return $this;
    }
}

//il n'est pas demandé d'implémenter cette classe.
class Table{}

//tag::testLimit[]
$waiter = new Waiter();

$waiter->addTable(new Table()); //ok
$waiter->addTable(new Table()); //ok
$waiter->addTable(new Table()); //ok
$waiter->addTable(new Table()); //ok
$waiter->addTable(new Table()); //affiche "Il ne peut pas être affecté plus de 4 tables à un même serveur"
//end::testLimit[]


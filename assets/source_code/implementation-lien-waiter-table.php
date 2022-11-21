<?php
//tag::classes[]
//je n'utilise pas la promotion des paramètres de méthodes de PHP8 pour bien rendre visible l'attribut qui représente l'association à la classe Table.
class Waiter
{

    /**
     * Collection d'objets de type Table
     * (ce sont les tables associées au serveur courant. (l'instance de Waiter manipulée)
     * Il ne faut pas oublier d'initialiser la collection !
     */
    private array $tables = []; //<1>

    /**
     * Ajoute la table si elle ne fait pas déjà partie des tables servies par le serveur courant
     */
    public function addTable(Table $table): bool
    {
        //l'instance n'est ajoutée à la collection que si elle n'y est pas déjà
        if (!in_array($table, $this->tables, true)) {
            $this->tables[] = $table;

            return true;
        }

        return false;
    }

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

class Table{}
//end::classes[]


$paul = new Waiter();
$cindy = new Waiter();

$t1 = new Table();
$t2 = new Table();
$t3 = new Table();
$t4 = new Table();
$t5 = new Table();

//paul doit s'occuper des tables 1, 4 et 5
$paul->addTable($t1);
$paul->addTable($t4);
$paul->addTable($t5);

//paul doit s'occuper des tables 1, 2 et 3
$cindy->addTable($t1);
$cindy->addTable($t2);
$cindy->addTable($t3);


var_dump('---- PAUL ----');
var_dump($paul);
var_dump('---- CINDY ----');
var_dump($cindy);


$paul->removeTable($t1);
$paul->removeTable($t4);
$cindy->removeTable($t2);
var_dump('---- PAUL après ----');
var_dump($paul);
var_dump('---- CINDY après ----');
var_dump($cindy);

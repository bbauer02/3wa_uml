<?php

//tag::customer[]
class Customer
{
    private ?string $name;
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }


}

//end::customer[]

//tag::customer_manager[]
class CustomerManager
{

    //l'objet PDO utilisé dans les méthodes read et update est le même. Le lien est "fort" et durable dans le temps. C'est pouquoi il est stocké dans un attribut. (c'est donc une association)
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            'mysql:host:localhost;dbname=cinema',
            'gandahlf',
            'l3precieuX#'
        );
    }


    //récupération d'un client (ou rien s'il n'existe pas en bdd)
    public function read(int $id): ?Customer
    {
        $pdoStatement = $this->pdo->prepare(
            'SELECT * FROM customer WHERE id = :id'
        ); //<1>

        //liaison du paramètre nommé
        $pdoStatement->bindValue('id', $id, PDO::PARAM_INT);

        //exécution de la requête (il faudrait tester le retour dans la réalité pour voir si tout est ok)
        $pdoStatement->execute(); //<2>

        //on récupère le client recherché (il faudrait tester le retour pour voir si tout est ok
        return $pdoStatement->fetchObject('Customer');
    }

    //mise à jour d'une client
    public function update(Customer $customer): bool
    {

        $pdoStatement = $this->pdo->prepare('UPDATE contact set name = :name WHERE id = :id'); //<1>

        $pdoStatement->bindValue('name', $customer->getName(), PDO::PARAM_STR); //<3>
        $pdoStatement->bindValue('id', $customer->getId(), PDO::PARAM_INT); //<3>

        return $pdoStatement->execute();

    }

}

//end::customer_manager[]





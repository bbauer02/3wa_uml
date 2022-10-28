<?php
//tag::interface_file[]
interface File //<1>
{
    /**
     * @return int retourne la taille du fichier en Mo
     */
    public function getSize():int; //<2>

    /**
     * @return int retourne l'âge du fichier en mois
     */
    public function getAge():int; //<2>

}
//end::interface_file[]

//tag::filetext_implement_file[]

class FileText implements File{ //<1>

    //ici les membres spécifiques de FileText
    
    //tag::constraint_implementation[]

    public function getAge(): int
    {
        // ici du code qui retourne un nombre de mois
    }

    public function getSize(): int
    {
        // ici du code qui retourne un nombre de Mo
    }
    //end::constraint_implementation[]
}

//end::filetext_implement_file[]
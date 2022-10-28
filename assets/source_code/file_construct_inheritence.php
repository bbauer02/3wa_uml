<?php

//tag::classes[]
class File
{
    public function __construct()
    {
        echo "Je suis du texte dans le constructeur de la classe File.\n";
    }
}

class FileText extends File
{

    //tag::filetext_with_construct[]
    public function __construct()
    {
        echo "Appel du constructeur de la classe FileText.\n";
        //tag::call_parent_construct[]
        //appel du constructeur parent
        parent::__construct(); //<1>
        //end::call_parent_construct[]
    }
    //end::filetext_with_construct[]
}

//end::classes[]

//tag::classes_use[]

$file = new File();
$fileText = new FileText();

//end::classes_use[]


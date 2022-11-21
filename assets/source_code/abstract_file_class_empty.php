<?php

abstract class File { //<1>
    //ici les membres (attributs et méthodes)
}

class FileText extends File { //<2>
    //membres spécifiques au sous-type (attributs et méthodes)
}
class FileVideo extends File { //<2>
    //membres spécifiques au sous-type (attributs et méthodes)
}
class FileImage extends File { //<2>
    //membres spécifiques au sous-type (attributs et méthodes)
}
class FileOther extends File { //<2>
    //membres spécifiques au sous-type (attributs et méthodes)
}
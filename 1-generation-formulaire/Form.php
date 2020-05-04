<?php
class Form{
    private $fields = [];
    private $method='POST';
    private $action='data_form.php';
    private $button;

    // INIT du formulaire HTML
    public function __construct(string $action, string $method)
    {
        $this->action = $action;
        $this->method = $method;

    }

    public function addTextField(String $fieldName, String $fieldValue) // Création d'une balise input text
    {
        $this->fields[] = "<input type='text' name='$fieldName' value='$fieldValue'>";
        return $this;
    }
    

    public function addTextAreaField(String $fieldName, string $fieldValue) // création d'une balise textarea
    {
        $this->fields[] = "<textarea row=30 cols=30 name='$fieldName'>
        $fieldValue
        </textarea>";
        return $this;
    }

    public function addNumberField(String $fieldName, int $fieldValue)  // Création d'une balise input de type number
    {
        $this->fields[] = "<input type='number' name='$fieldName' value='$fieldValue'>";
        return $this;
    }
   
    public function addSelectField(String $fieldName) //Création d'une balise select 
    {
        $animalbreeds = ["Dog","Cat","Goldfish"];
        $selector="<select name=$fieldName>";
        foreach($animalbreeds as $nb => $animalbreed)
        {
            $selector.="<option value=$nb>$animalbreed</option>";
        }
        $selector.="</select>";

        $this->field[] = $selector;
        return $this;
    }

    public function addCheckboxField(String $fieldName, bool $fieldValue) // Création d'une balise pour la Chekedbox
    {
        $checked = ($fieldValue)?'checked':''; // Vérification si checked (dans l'exemple par defaut c'est true)
        $this->fields[] = "<input type='checkbox' name='$fieldName' $checked>";
        return $this;

    }

    public function addSubmitButton($text) //Bouton submit à completer si vérif
    {
        $this->button = "<input type='submit' name='$text'>";
    }


    public function build() // Création de la page du formulaire
    {
        $html = "<form action='$this->action' method='$this->method'>";
        foreach($this->fields as $field){
            $html .= $field;
        }
        $html .= $this->button;
        $html .= '</form>';
        return $html;
    }

    // Fin INIT

 // NE PAS TENIR COMPTE SERVIRA POUR LA SUITE
    // Fonction des gestion des données rentrées ds le form à refaire

    /*public function addName(){
        return $this->$_POST['name'];        
    }

    public function addLastName(){
        return $this->$_POST['lastname'];        
    }

    public function addEmail(){
        return $this->$_POST['email'];        
    }

    public function addAnimalBreed(){
        return $this->$_POST['animalbreed'];        
    }

    public function addAnimalName(){
        return $this->$_POST['animalname'];        
    }*/

}

?>
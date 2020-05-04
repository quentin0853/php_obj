<?php
spl_autoload_register(function ($className) { // Bonne pratique de gerer l'autoload(à integrer obligatoirement dans le form impossible de le joindre à côté)
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    include $className.'.php';
});


class Form{
    private $fields;
    private $method;
    private $action;
    private $button;

    // INIT du formulaire HTML
    public function __construct(string $action, string $method)
    {
        $this->action = $action;
        $this->method = $method;
        $this->fields = [];

    }

    private function addField(HtmlField $field) {
        $this->fields[] = $field;
        return $this;
    }

    public function addTextField(String $fieldName, String $fieldValue) // Création d'une balise input text
    {
        return $this->addField(new TextField($fieldName, $fieldValue));
    }
    

    public function addNumberField(String $fieldName, int $fieldValue)  // Création d'une balise input de type number
    {
        return $this->addField(new NumberField($fieldName, $fieldValue));
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
        return $this->addField(new CheckboxField($fieldName, $fieldValue));

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
}
<?php
include 'Form.php';

// Des variables par défaut pour vos tests.
$action = '#';
$method = 'POST';
$firstname = 'Jean-Luc';
$lastname ='Dupond';
$animalname = 'Pikachu';
$email='azerty@gmail.fr';
$des_injure='Blessé à la queue avec une atk queue de fer';
$is_checked=(bool)true;




// YOUR CODE HERE

$form = new Form($action, $method);  // créer le début du formulaire
$form->addTextField('firstname',$firstname); // créer un input de type texte avec comme valeur par défaut $name
$form->addTextField('lastname',$lastname); // créer un input de type texte avec comme valeur par défaut $lastname
$form->addTextField('animalname',$animalname);
$form->addSelectField('Quel animal de compagnie?');
$form->addTextField('email',$email);
$form->addTextAreaField('desc_injure', $des_injure);
$form->addCheckboxField('Accepter patati patata', $is_checked);
$form->addSubmitButton('valider'); //Créer un bouton pour soumettre le formulaire se nommant Valider

echo $form->build(); // générer le formulaire


?>



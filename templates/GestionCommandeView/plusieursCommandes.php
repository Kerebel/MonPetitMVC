<?php
//include_once PATH_VIEW . "header.html";
echo "<p>Nombre de commandes trouvés : ".count($commandes) ."</p>";

foreach ($commandes as $commande){
    $facture = (empty($commande->getNoFacture())) ? 'Non facturé' : $commande->getNoFacture()  ;
    echo $commande->getId() . "-" . $commande->getDateCde() . "-" . $facture . "-" . $commande->getIdClient() . "<br>";
}
//include_once PATH_VIEW . "footer.html";

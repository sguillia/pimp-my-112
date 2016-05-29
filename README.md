# pimp-my-112
A project about locating someone who calls emergency services

[FR]

Ce projet a été réalisé en moins de 24h le week-end du 15 janvier 2016 lors du hackathon Nec mergitur, à l'école 42, dans le but de promouvoir la sécurité à Paris.

* L'opérateur 112 écrit ou copie le numéro de l'appelant dans l'interface (`index.php`)
* Un SMS est envoyé à l'appelant via une API quelconque (`encode_number.php`)
* L'appelant -possesseur d'un smartphone- clique sur le lien reçu et le mène vers une page web (`client.php`) qui va :
 * Demander l'autorisation d'accéder au GPS du téléphone
 * Localiser la personne
 * Transmettre les coordonnées GPS à l'opérateur 112 via un serveur web et base SQL (`receive_coord.php`)
* L'opérateur voit apparaître la position de la personne sur une carte google maps (`show_coord.php`)

Le tout peut prendre une vingtaine de secondes. Une évolution possible est la transmission d'une photo après avoir transmis les coordonnées.

En raison du manque de temps, le code est peu commenté.

<?php
// Paramètres de connexion à la base de données
$serveur = "localhost";
$utilisateur = "username";
$motDePasse = "password";
$baseDeDonnees = "sae23";

try {
    // Connexion à la base de données avec PDO
    $connexion = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Vérification si les données du formulaire existent
    if (isset($_GET['nom']) && isset($_GET['prenom'])) {
        // Récupération des données du formulaire
        $nom = $_GET['nom'];
        $prenom = $_GET['prenom'];

        // Requête pour récupérer les adresses et les villes avec leur code postal
        $requete = $connexion->prepare("SELECT e.adresse_principal, e.adresse_secondaire, l.ville, l.code_postal, l.alti_min, l.alti_max
                                        FROM etudiants e 
                                        INNER JOIN lieux l ON e.adresse_principal = l.ville 
                                                           OR e.adresse_secondaire = l.ville 
                                        WHERE e.nom = ? AND e.prenom = ?");
        $requete->execute([$nom, $prenom]);
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);

        // Si des résultats sont trouvés
        if ($resultat) {
            // Récupération des données
            $ville = $resultat['ville'];
            $adressePrincipale = $resultat['adresse_principal'];
            $adresseSecondaire = $resultat['adresse_secondaire'];
            $codePostal = $resultat['code_postal'];
            $altiMin = $resultat['alti_min'];
            $altiMax = $resultat['alti_max'];
            
            // Affichage des résultats
            echo "<h2>Résultat de la recherche :</h2>";
            echo "<p>Adresse principale : $adressePrincipale, $codePostal </p>";
            if ($adresseSecondaire && $adresseSecondaire != $ville) {
                echo "<p>Adresse secondaire : $adresseSecondaire, $codePostal </p>";
            }
            echo "<p>Altitude minimale : $altiMin m</p>";
            echo "<p>Altitude maximale : $altiMax m</p>";

            // Vérification si les altitudes sont vides
            if ($altiMin === null && $altiMax === null) {
                // Appel du script maj_altitudes.php
                exec("php /var/www/html/maj_altitudes.php $ville");
            } else {
                // Affichage du message indiquant que les altitudes sont déjà dans la base de données
                echo "<p>Altitudes trouvées dans la base de données</p>";
            }
        } else {
            echo "<h2>Aucun résultat trouvé pour ce nom et ce prénom.</h2>";
        }
    } else {
        echo "<h2>Aucune donnée reçue.</h2>";
    }
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>

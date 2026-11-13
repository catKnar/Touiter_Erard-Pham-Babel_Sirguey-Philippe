<?php

namespace Touiteur\repository;

use PDO;
use PDOException;
use Exception;
use Touiteur\classes\touite;
use Touiteur\classes\Image;
use Touiteur\classes\Tag;
use Touiteur\classes\Utilisateur;

class TouiterRepository
{
    private static ?TouiterRepository $instance = null;
    private static array $config = [];

    private PDO $db;

    private function __construct()
    {
        if (empty(self::$config)) {
            throw new Exception("Configuration non définie. Utilisez TouiterRepository::setConfig().");
        }

        $driver = self::$config['driver'] ?? 'mysql';
        $host = self::$config['host'] ?? 'localhost';
        $dbname = self::$config['database'] ?? '';
        $charset = self::$config['charset'] ?? 'utf8mb4';
        $user = self::$config['username'] ?? '';
        $pass = self::$config['password'] ?? '';

        $dsn = "$driver:host=$host;dbname=$dbname;charset=$charset";

        try {
            $this->db = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    /**
     * Charge la configuration depuis un fichier INI
     */
    public static function setConfig(string $file): void
    {
        if (!file_exists($file)) {
            throw new Exception("Fichier de configuration introuvable : $file");
        }

        $config = parse_ini_file($file);
        if ($config === false) {
            throw new Exception("Erreur lors de la lecture du fichier INI : $file");
        }

        self::$config = $config;
    }

    /**
     * Retourne l’instance unique du Repository (singleton)
     */
    public static function getInstance(): TouiterRepository
    {
        if (self::$instance === null) {
            self::$instance = new TouiterRepository();
        }

        return self::$instance;
    }

    /**
     * Retourne la connexion PDO
     */
    public function getPDO(): PDO
    {
        return $this->db;
    }

    /**
     * Fonctionnalité 1
     */
    public function Affiche_liste_touites(): array
    {
        $query = "SELECT t.*, u.nom, u.prenom, u.email, u.nb_touite
              FROM touite t
              JOIN utilisateur u ON u.id_user = t.id_user
              ORDER BY t.date DESC";
        $stmt = $this->getPDO()->prepare($query);
        $stmt->execute();

        $touites = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $touites[] = [
                'touite' => new Touite((int)$row['id_touite'], $row['texte'], $row['date'], (int)$row['id_user'], (int)$row['id_img'], (int)$row['pouceUp'], (int)$row['pouceDown']),
                'auteur' => new Utilisateur((int)$row['id_user'], $row['nom'], $row['prenom'], $row['email'], (int)$row['nb_touite'])
            ];
        }
        return $touites;
    }

    /**
     * Fonctionnalité 2
     */
    public function Affiche_touite_detail(int $id): ?array
    {
        $stmt = $this->getPDO()->prepare(
            "SELECT t.*, u.nom, u.prenom, u.email, u.nb_touite
         FROM touite t
         JOIN utilisateur u ON u.id_user = t.id_user
         WHERE t.id_touite = ?"
        );
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            return null;
        }

        return [
            'touite' => new Touite((int)$row['id_touite'], $row['texte'], $row['date'], (int)$row['id_user'], (int)$row['id_img'], (int)$row['pouceUp'], (int)$row['pouceDown']),
            'auteur' => new Utilisateur((int)$row['id_user'], $row['nom'], $row['prenom'], $row['email'], (int)$row['nb_touite'])
        ];
    }

    /**
     * Fonctionnalité 4
     */
    public function Afficher_Touite_Personne_donnee(int $idUser): array
    {
        $query = "SELECT t.*, u.nom, u.prenom, u.email, u.nb_touite
              FROM touite t
              JOIN utilisateur u ON u.id_user = t.id_user
              WHERE t.id_user = ?
              ORDER BY t.date DESC";
        $stmt = $this->getPDO()->prepare($query);
        $stmt->bindParam(1, $idUser, PDO::PARAM_INT);
        $stmt->execute();

        $touites = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $touites[] = [
                'touite' => new Touite((int)$row['id_touite'], $row['texte'], $row['date'], (int)$row['id_user'], (int)$row['id_img'], (int)$row['pouceUp'], (int)$row['pouceDown']),
                'auteur' => new Utilisateur((int)$row['id_user'], $row['nom'], $row['prenom'], $row['email'], (int)$row['nb_touite'])
            ];
        }
        return $touites;
    }

    /**
     * Fonctionnalité 5
     */
    public function Affiche_touite_ParTag(int $idTag): array
    {
        $query = "SELECT t.*, u.nom, u.prenom, u.email, u.nb_touite
              FROM touite t
              JOIN utilisateur u ON u.id_user = t.id_user
              JOIN hashtag tt ON tt.id_touite = t.id_touite
              WHERE tt.id_tag = ?
              ORDER BY t.date DESC";
        $stmt = $this->getPDO()->prepare($query);
        $stmt->bindParam(1, $idTag, PDO::PARAM_INT);
        $stmt->execute();

        $touites = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $touites[] = [
                'touite' => new Touite((int)$row['id_touite'], $row['texte'], $row['date'], (int)$row['id_user'], (int)$row['id_img'], (int)$row['pouceUp'], (int)$row['pouceDown']),
                'auteur' => new Utilisateur((int)$row['id_user'], $row['nom'], $row['prenom'], $row['email'], (int)$row['nb_touite'])
            ];
        }
        return $touites;
    }
    // Fonctionnalité 6
    public function Ajout_Touite(int $id_user, string $texte, ?int $id_img = null): int
    {
        $pdo = $this->getPDO();
        $pdo->beginTransaction();

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO touite (texte, date, id_user, id_img, pouceUp, pouceDown)
             VALUES (?, NOW(), ?, ?, 0, 0)"
            );
            $stmt->bindParam(1, $texte, PDO::PARAM_STR);
            $stmt->bindParam(2, $id_user, PDO::PARAM_INT);
            $stmt->bindParam(3, $id_img, $id_img === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
            $stmt->execute();
            $idTouite = (int)$pdo->lastInsertId();

            $stmt = $pdo->prepare(
                "UPDATE utilisateur SET nb_touite = nb_touite + 1 WHERE id_user = ?"
            );
            $stmt->bindParam(1, $id_user, PDO::PARAM_INT);
            $stmt->execute();

            $this->extract_Tag($idTouite, $texte);

            $pdo->commit();
            return $idTouite;
        } catch (\Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    //fonctionnalité 7

    public function incrementPouceUp(int $idTouite): void
    {
        $stmt = $this->getPDO()->prepare("UPDATE touite SET pouceUp = pouceUp + 1 WHERE id_touite = ?");
        $stmt->bindParam(1, $idTouite, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function incrementPouceDown(int $idTouite): void
    {
        $stmt = $this->getPDO()->prepare("UPDATE touite SET pouceDown = pouceDown + 1 WHERE id_touite = ?");
        $stmt->bindParam(1, $idTouite, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Fonctionnalité 8
    public function extract_Tag(int $idTouite, string $texte): void
    {
        preg_match_all('/#(\w+)/u', $texte, $matches);
        $libelles = array_unique(array_map('mb_strtolower', $matches[1]));

        $pdo = $this->getPDO();

        foreach ($libelles as $libelle) {
            // le tag existe-t-il déjà ?
            $stmt = $pdo->prepare("SELECT id_tag FROM tag WHERE libelle = ?");
            $stmt->bindParam(1, $libelle, PDO::PARAM_STR);
            $stmt->execute();
            $idTag = $stmt->fetchColumn();

            if ($idTag === false) {
                $stmt = $pdo->prepare("INSERT INTO tag (libelle, description_tag) VALUES (?, '')");
                $stmt->bindParam(1, $libelle, PDO::PARAM_STR);
                $stmt->execute();
                $idTag = (int)$pdo->lastInsertId();
            }

            // lien touite <-> tag
            $stmt = $pdo->prepare("INSERT INTO hashtag (id_touite, id_tag) VALUES (?, ?)");
            $stmt->bindParam(1, $idTouite, PDO::PARAM_INT);
            $stmt->bindParam(2, $idTag, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    // Fonctionnalité 9
    public function Affiche_mur(int $idMoi): array
    {
        $query = "SELECT t.*, u.nom, u.prenom, u.email, u.nb_touite
              FROM touite t
              JOIN utilisateur u ON u.id_user = t.id_user
              WHERE t.id_user IN (SELECT id_user_following FROM follower WHERE id_user = ?)
                 OR t.id_touite IN (SELECT h.id_touite
                                    FROM hashtag h
                                    JOIN tag_abonnement ta ON ta.id_tag = h.id_tag
                                    WHERE ta.id_user = ?)
              ORDER BY t.date DESC";
        $stmt = $this->getPDO()->prepare($query);
        $stmt->bindParam(1, $idMoi, PDO::PARAM_INT);
        $stmt->bindParam(2, $idMoi, PDO::PARAM_INT);
        $stmt->execute();

        $touites = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $touites[] = [
                'touite' => new Touite((int)$row['id_touite'], $row['texte'], $row['date'], (int)$row['id_user'], (int)$row['id_img'], (int)$row['pouceUp'], (int)$row['pouceDown']),
                'auteur' => new Utilisateur((int)$row['id_user'], $row['nom'], $row['prenom'], $row['email'], (int)$row['nb_touite'])
            ];
        }
        return $touites;
    }

    //Fonctionnalité 10
    public function suivreUtiliseurs(int $idMe, int $idFollow)
    { {
            $stmt = $this->getPDO()->prepare("Insert ignore into follower values ($idMe,$idFollow)");
            $stmt->execute();
        }
    }

    public function desabonnerUtiliseurs(int $idMe, int $idFollow)
    { {
            $stmt = $this->getPDO()->prepare("Delete ignore from follower where id_user = $idMe and id_user_following = $idFollow");
            $stmt->execute();
        }
    }

    //Fonctionnalité 11
    public function tagAbonnement(int $id_user, int $id_tag): void
    {

        $stmt = $this->getPDO()->prepare("INSERT IGNORE INTO tag_abonnement (id_user, id_tag) VALUES (?, ?)");
        $stmt->execute([$id_user, $id_tag]);
    }

    public function estAbonneAuTag(int $id_user, int $id_tag): bool
    {

        $stmt = $this->getPDO()->prepare("SELECT 1 FROM tag_abonnement WHERE id_user = ? AND id_tag = ? LIMIT 1");
        $stmt->execute([$id_user, $id_tag]);

        return $stmt->fetchColumn() !== false;
    }

    public function retirerAbonnementTag(int $id_user, int $id_tag): void
    {

        $stmt = $this->getPDO()->prepare("DELETE FROM tag_abonnement WHERE id_user = ? AND id_tag = ?");
        $stmt->execute([$id_user, $id_tag]);
    }

    //affichage d'une image par id 
    public function Affiche_image_par_id(int $id): ?Image
    {
        $stmt = $this->getPDO()->prepare("SELECT * FROM image WHERE id_img = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            return null;
        }

        return new Image(
            (int)$row['id_img'],
            $row['description_image'] ?? '',
            $row['chemin_fichier'] ?? '',
        );
    }

    public function Affiche_tag_par_id(int $id): array
    {
        $query = "SELECT * 
                  FROM tag
                  JOIN hashtag on tag.id_tag = hashtag.id_tag
                  WHERE id_touite = ?";

        $stmt = $this->getPDO()->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $tag = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tag[] = new Tag((int)$row['id_tag'], $row['libelle'], $row['description_tag']);
        }

        return $tag;
    }

    public function estSuivi(int $idMe, int $idFollow): bool
    {
        $query = "SELECT *
                  FROM follower
                  WHERE id_user = ? AND id_user_following = ?";
        $stmt = $this->getPDO()->prepare($query);
        $stmt->execute([$idMe, $idFollow]);

        return $stmt->fetch() !== false;
    }
}

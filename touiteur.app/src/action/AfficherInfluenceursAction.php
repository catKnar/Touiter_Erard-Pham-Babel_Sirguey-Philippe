<?php

namespace Touiteur\action;

use Touiteur\repository\TouiterRepository;

class AfficherInfluenceursAction extends Action
{
    public function execute(): string
    {
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
            return "<div style='padding: 20px; border: 2px solid #d9084e; margin: 20px; text-align: center;'>
                        <h2 style='color: #ff4444;'>Accès refusé</h2>
                        <p>Cette page est réservée aux administrateurs de Touiteur.</p>
                        <p><a href='?action=switch-admin' style='color: #00ff88;'>[Activer le mode Admin pour tester]</a></p>
                        </div>";
        }

        $repo = TouiterRepository::getInstance();

        try {
            $influenceurs = $repo->getMostFollowedUsers(20);
        } catch (\Exception $e) {
            return "<h2>Erreur lors du chargement des influenceurs : " . htmlspecialchars($e->getMessage()) . "</h2>";
        }

        $html = "<h2>Les Influenceurs</h2>";
        $html .= "<p>Liste des utilisateurs classés par ordre croissant du nombre de suiveurs :</p>";

        if (empty($influencers)) {
            $html .= "<p>Aucun utilisateur enregistré pour le moment.</p>";
            return $html;
        }

        $html .= "<table style='width: 90%; margin: 20px auto; border-collapse: collapse; color: white; font-family: monospace;'>";
        $html .= "<tr style='background-color: #d9084e; text-align: left;'>";
        $html .= "<th style='padding: 12px; border: 1px solid white;'>ID</th>";
        $html .= "<th style='padding: 12px; border: 1px solid white;'>Nom & Prénom</th>";
        $html .= "<th style='padding: 12px; border: 1px solid white;'>Email</th>";
        $html .= "<th style='padding: 12px; border: 1px solid white; text-align: center;'>Touites</th>";
        $html .= "<th style='padding: 12px; border: 1px solid white; text-align: center;'>Nombre de suiveurs</th>";
        $html .= "</tr>";

        foreach ($influencers as $item) {
            $user = $item['utilisateur'];
            $nbSuiveurs = $item['nb_suiveurs'];
            
            $id = $user->get('id_user');
            $nom = htmlspecialchars($user->get('nom'));
            $prenom = htmlspecialchars($user->get('prenom'));
            $email = htmlspecialchars($user->get('email'));
            $nbTouite = (int)$user->get('nb_touite');

            $html .= "<tr>";
            $html .= "<td style='padding: 10px; border: 1px solid white;'>{$id}</td>";
            $html .= "<td style='padding: 10px; border: 1px solid white;'><a href='?action=profil&id_user={$id}' style='color: #00bfff;'>{$prenom} {$nom}</a></td>";
            $html .= "<td style='padding: 10px; border: 1px solid white;'>{$email}</td>";
            $html .= "<td style='padding: 10px; border: 1px solid white; text-align: center;'>{$nbTouite}</td>";
            $html .= "<td style='padding: 10px; border: 1px solid white; text-align: center;'><strong>{$nbSuiveurs}</strong></td>";
            $html .= "</tr>";
        }

        $html .= "</table>";
        return $html;
    }
}
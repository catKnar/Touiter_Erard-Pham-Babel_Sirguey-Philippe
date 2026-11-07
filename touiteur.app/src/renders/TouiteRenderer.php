<?php

namespace Touiteur\renders;

use Touiteur\classes\Touite;
use Touiteur\classes\Utilisateur;
use Touiteur\interfaces\Renderer;
use Touiteur\repository\TouiterRepository;

class TouiteRenderer implements Renderer
{
    private Touite $touite;

    public function __construct(Touite $touite)
    {
        $this->touite = $touite;
    }

    public function render(int $selector = self::COMPACT): string
    {
        switch ($selector) {
            case self::LONG:
                return $this->renderLong();
            case self::COMPACT:
            default:
                return $this-> renderCompact();
        }
    }

    /**
     * Affichage court pour les listes de touites
     */
    private function renderCompact(): string
    {
        $id = $this->touite->get('id_touite');
        $idUser = $this->touite->get('id_user');
        $date = htmlspecialchars((string)$this->touite->get('date'));
        $texte = htmlspecialchars($this->touite->get('texte'));

        // Tronquage si texte trop long
        $apercu = mb_strlen($texte) > 100 ? mb_substr($texte, 0, 100) . "..." : $texte;
        
        return <<<HTML
        <div class="touite-compact" style="border: 1px solid #ff5500; margin: 10px; padding: 10px; border-radius: 5px;">
            <p>
                <strong><a href="?action=user-touites&id_user={$idUser}" style="color: #ff5500;">@Utilisateur #{$idUser}</a></strong>
                <small style="color: #ccc;"> - {$date}</small>
            </p>
            <p>{$apercu}</p>
            <p><a href="?action=display-touite&id={$id}" style="color: #00bfff;">Voir le touite en détail →</a></p>
        </div>
        HTML;
    }

    /**
     * 
     */
    private function renderLong(): string
    {
        $id = $this->touite->get('id_touite');
        $idUser = $this->touite->get('id_user');
        $date = htmlspecialchars((string)$this->touite->get('date'));
        $texte = $this->touite->get('texte');

        $repo = TouiterRepository::getInstance();
        $tags = $repo->Affiche_tag_par_id($id);
        $auteur = $repo->Affiche_touite_detail($id);

        $texteFormatte = '';
        foreach($tags as $t){
            $tag = $t->get('libelle');
            
            // Tags en liens cliquables
            $texteFormatte = preg_replace('/#([a-zA-Z0-9_À-ÿ]+)/u','<a href="?action=tag-touites&tag=$1" style="color: #00bfff;">#$1</a>', $tag);
        }

        $l = $auteur['auteur'];
        $nom = $l->get('nom');
        $prenom = $l->get('prenom');

        // Gestion image
        $htmlImage = '';
        try {
            $idImg = $this->touite->get('id_img');
            if (!empty($idImg)) {
                $image = $repo->Affiche_image_par_id($idImg);
                $htmlImage = (new ImageRenderer($image))->render(Renderer::LONG);
            }
        } catch (\Exception $e) {}

        $htmlScore = '';
        try {
            $score = $this->touite->get('pouceUp');
            $htmlScore = "<p><strong>Score :</strong> {$score}</p>";
        } catch (\Exception $e) {}

        return <<<HTML
        <div class="touite-long" style="border: 2px solid #ff5500; margin: 15px; padding: 15px; border-radius: 8px;">
            <h3>
                Auteur : <a href="?action=user-touites&id_user={$idUser}" style="color: #ff5500;">$nom $prenom #{$idUser}</a>
                <a href="?action=follow-user&id_user={$idUser}" style="margin-left: 15px; font-size: 0.8em; color: #00ff88;">[+ Suivre cet auteur]</a>
            </h3>
            <p><small>Publié le : {$date}</small></p>
            <p style="font-size: 1.2em;">$texte {$texteFormatte}</p>
            {$htmlImage}
            {$htmlScore}
            <div class="touite-actions" style="margin-top: 10px;">
                <a href="?action=evaluate-touite&id={$id}&note=1" style="color: #00ff88; margin-right: 15px;">👍 Like (+1)</a>
                <a href="?action=evaluate-touite&id={$id}&note=-1" style="color: #ff4444;">👎 Dislike (-1)</a>
            </div>
        </div>
        HTML;
    }

}
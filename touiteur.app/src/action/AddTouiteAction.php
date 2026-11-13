<?php

namespace Touiteur\action;

use Touiteur\repository\TouiterRepository;

class AddTouiteAction extends Action
{
    public function execute(): string
    {
       
        $userId = filter_var(
            $_SESSION['id_user'] ?? null,
            FILTER_VALIDATE_INT
        );

       
        if ($this->http_method === 'POST') {

            $content = trim($_POST['content'] ?? '');

            
            if ($content === '') {
                return $this->renderForm(
                    "Le contenu du touite ne peut pas être vide."
                );
            }

            if (mb_strlen($content) > 280) {
                return $this->renderForm(
                    "Le touite ne doit pas dépasser 280 caractères.",
                    $content
                );
            }

           
            $repo = TouiterRepository::getInstance();

            $repo->Ajout_Touite($userId, $content);

           
            header('Location: ?action=default');
            exit;
        }

      
        return $this->renderForm();
    }

    private function renderForm(
        string $error = '',
        string $content = ''
    ): string {

        $safeContent = htmlspecialchars(
            $content,
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        );

        $safeError = htmlspecialchars(
            $error,
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        );

        return <<<HTML
        <section>
            <h2>Publier un touite</h2>

            {$this->errorHtml($safeError)}

            <form method="POST" action="?action=publier">

                <textarea
                    name="content"
                    maxlength="280"
                    required
                    placeholder="Touite un max"
                >{$safeContent}</textarea>

                <p>280 caractères maximum.</p>

                <button type="submit">
                    Publier
                </button>

            </form>
        </section>
        HTML;
    }

    private function errorHtml(string $error): string
    {
        return $error === ''
            ? ''
            : '<p style="color:red;">' . $error . '</p>';
    }
}

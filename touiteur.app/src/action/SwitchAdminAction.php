<?php

namespace Touiteur\action;

class SwitchAdminAction extends Action 
{
    public function execute(): string
    {
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
            $_SESSION['is_admin'] = false;
            $message = "Mode Administrateur désactivé";
        } else {
            $_SESSION['is_admin'] = true;
            $message = "Mode Administrateur activé";
        }

        header("Refresh: 1; url=?action=default");
        return "<div style='padding: 20px; text-align: center;>'
                <h2>{$message}</h2>
                <p>Redirection en cours... <a href='?action=default' style='color: #00bfff;'>Cliquez ici si rien ne se passe</a></p>
                </div>";
    }
}
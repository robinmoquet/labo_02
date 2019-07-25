<?php

namespace App\Service\Mailer;

use NotFloran\MjmlBundle\Renderer\BinaryRenderer;
use \Symfony\Component\Mime\Email as EmailMailer;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Part\AbstractPart;
use Twig\Environment;
use Twig\Error\Error;


class Email extends EmailMailer
{

    /**
     * @var BinaryRenderer
     */
    private $mjmlRender;

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(BinaryRenderer $mjmlRender, Environment $twig, Headers $headers = null, AbstractPart $body = null)
    {
        parent::__construct($headers, $body);

        $this->mjmlRender = $mjmlRender;
        $this->twig = $twig;
    }

    /**
     * Permet de generer la vue de l'email en HTML, genere la vue twig avec la compilation
     * du MJML, puis genere le html avec la compilation du twig
     *
     * @param string $viewName Le nom de la vue | email
     * @param array $context Les parametres passes a la vue
     * @return Email
     */
    public function renderView(string $viewName, array $context): self
    {
        try {
            $this->html($this->mjmlRender->render(
                $this->twig->render($viewName, $context)
            ));
        } catch (Error $e) { /* Logging de l'erreur */ }

        return $this;
    }

}
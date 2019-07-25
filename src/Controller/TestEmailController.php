<?php


namespace App\Controller;


use App\Entity\User;
use App\Service\Mailer\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestEmailController extends AbstractController
{

    /**
     * Vue qui permet de visualiser l'email
     *
     * @Route("test-email")
     * @param Mailer $mailer
     * @return Response
     */
    public function testEmail(Mailer $mailer)
    {
        $user = (new User())
            ->setLastname("Demo")
            ->setFirstname("Nemo");

        $email = $mailer->createEmail();
        $email->renderView("emails/welcome.mjml.twig", ["user" => $user]);
        $content = $email->getHtmlBody();

        return new Response($content, 200);
    }

}
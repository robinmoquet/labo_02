<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\RepositoryInterface\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render("index.html.twig");
    }

    /**
     * Route qui gere l'inscription d'un utilisateur
     * L'action principale est de sauvegarder l'utilisateur, on passe par le UserRepository
     * Les actions secondaires sont geres a l'issue de l'event UserSavedEvent, qui est dispatcher
     * par le decorateur DecoratorUserRepository
     *
     * @Route("/registration", name="registration")
     * @param Request $request
     * @param UserRepository $repository Repository qui est Decorate par App\Decorator\Repository\DecoratorUserRepository
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function registration(Request $request, UserRepository $repository, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User($encoder);
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $repository->add($user);
            return $this->redirectToRoute("login");
        }

        return $this->render("registration.html.twig", [
            "form" => $form->createView()
        ]);
    }


}

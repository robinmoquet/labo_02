<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\RepositoryInterface\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
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
     * @Route("/registration", name="registration")
     * @param Request $request
     * @param UserRepository $repository Repository qui est Decorate par App\Decorator\Repository\DecoratorUserRepository
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function registration(Request $request, UserRepository $repository, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $repository->add($user);
            return $this->redirectToRoute("login");
        }

        return $this->render("registration.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile()
    {
        return $this->render("profile.html.twig");
    }

}
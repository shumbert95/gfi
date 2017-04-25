<?php

namespace AppBundle\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Offer;

class UserController extends Controller
{
    /**
     *
     * @param Request $request
     * @Rest\Get("/users/{username}")
     */
    public function getUserAction(Request $request)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User')
            ->findByReference($request->get('username'));

        if (count($user)) {
            $user = $user[0];
            $formatted = array(
                'id' => $user->getId(),
                'reference' => $user->getReference(),
                'title' => $user->getTitle(),
                'description' => $user->getDescription(),
                'poste' => $offer->getPoste(),
            );
        } else {
            $formatted = array('errors' => array('Message' => 'Undefined reference'));
        }
        $viewHandler = $this->get('fos_rest.view_handler');

        $view = View::create($formatted);
        $view->setFormat('json');

        return $viewHandler->handle($view);

    }

    /**
     * @param Request $request
     * @Post("/users/register")
     */
    public function registerUserAction(Request $request) {

        $content = json_decode($request->getContent());

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('email' => $content->email));
        if ($user) {
            $response = array('Success' => 'false', 'Message' => 'This email is already used.');
        } else {
            $user = $userManager->createUser();
            $user->setEnabled(true);
            $user->setFirstName($content->first_name);
            $user->setLastName($content->last_name);
            $user->setPassword($content->password);
            $user->setUsername($content->email);
            $user->setEmail($content->email);
            $user->setPhone($content->phone);
            $tokenGenerator = $this->container->get('fos_user.util.token_generator');
            $token = $tokenGenerator->generateToken();
            $user->setConfirmationToken($token);
            $userManager->updateUser($user);
            $response = array('Success' => 'true', 'Message' => 'User created', 'user_id' => $user->getId());
        }

        return new JsonResponse($response);
    }

    /**
     * @param Request $request
     * @Post("/users/login")
     */
    public function loginUserAction(Request $request) {

        $content = json_decode($request->getContent());

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('email' => $content->email, 'password' => $content->password));
        if ($user) {
            $response = array('Success' => 'true', 'Message' => 'Connected', 'user_id' => $user->getId());
        } else {
            $response = array('Success' => 'false', 'Message' => 'No account found for this combination email/password');
        }

        return new JsonResponse($response);
    }
}

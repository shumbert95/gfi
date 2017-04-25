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
     * @Rest\Get("/user")
     */
    public function getUserAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('email' => $request->get('username')));

        if ($user) {
            $response = array('success' => 'true', 'user' => array(
                                                            'id' => $user->getId(),
                                                            'first_name' => $user->getFirstName(),
                                                            'last_name' => $user->getLastName(),
                                                            'email' => $user->getEmail(),
                                                            'phone' => $user->getPhone(),
                                                            'tags' => array('html', 'css', 'javascript', 'php')
                                                            )
            );
        } else {
            $response = array('success' => 'false', 'message' => 'No user found');
        }

        return new JsonResponse($response);

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
            $response = array('success' => 'false', 'message' => 'This email is already used.');
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
            $response = array('success' => 'true', 'message' => 'User created', 'user_id' => $user->getId());
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
            $response = array('success' => 'true', 'message' => 'Connected', 'user_id' => $user->getId());
        } else {
            $response = array('success' => 'false', 'message' => 'No account found for this combination email/password');
        }

        return new JsonResponse($response);
    }
}

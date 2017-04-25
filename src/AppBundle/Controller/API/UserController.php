<?php

namespace AppBundle\Controller\API;

use AppBundle\Entity\Tags;
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
            $tags = array();
            if (count($user->getSkills())) {
                foreach ($user->getSkills() as $skill) {
                    $tags[] = $skill->name;
                }
            }
            $response = array('success' => 'true', 'user' => array(
                                                            'id' => $user->getId(),
                                                            'first_name' => $user->getFirstName(),
                                                            'last_name' => $user->getLastName(),
                                                            'email' => $user->getEmail(),
                                                            'phone' => $user->getPhone(),
                                                            'tags' => $tags
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
            $user->setPlainPassword($content->password);
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
        $factory = $this->get('security.encoder_factory');
        $user = $userManager->findUserBy(array('email' => $content->email));
        if (!$user) {
            $response = array('success' => 'false', 'message' => 'No account found for this email.');
        } else {
            $encoder = $factory->getEncoder($user);
            $bool = ($encoder->isPasswordValid($user->getPassword(), $content->password, $user->getSalt())) ? true : false;

            if ($bool) {
                $response = array('success' => 'true', 'message' => 'Connected', 'user_id' => $user->getId());
            } else {
                $response = array('success' => 'false', 'message' => 'Wrong password');
            }
        }

        return new JsonResponse($response);
    }

    /**
     * @param Request $request
     * @Post("/users/update_skills")
     */
    public function updateSkillsAction(Request $request) {

        $content = json_decode($request->getContent());

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('email' => $content->email));
        if ($user) {
            $tags = new ArrayCollection();

            $doctrine = $this->container->get('doctrine');
            $em = $doctrine->getManager();

            foreach ($content->tags as $tag) {
                $_tag = $this->get('doctrine.orm.entity_manager')
                    ->getRepository('AppBundle:Tags')
                    ->findOneByName($tag);
                if ($_tag) {
                    $tags->add($_tag);
                } else {
                    $_tag = new Tags();
                    $_tag->setName($tag);
                    $_tag->setCustom(true);
                    $em->persist($_tag);
                    $em->flush();
                    $tags->add($_tag);
                }
            }
            $user->setSkills($tags);
            $userManager->updateUser($user);
            $response = array('success' => 'true', 'message' => 'User updated', 'user_id' => $user->getId());
        } else {
            $response = array('success' => 'false', 'message' => 'No account found for this combination email/password');
        }

        return new JsonResponse($response);
    }
}

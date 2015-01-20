<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction() {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/testtask", name="testtask")
     */
    public function testTaskAction() {
        return $this->render('default/testtask.html.twig');
    }

    /**
     * @Route("/example", name="example")
     */
    public function exampleAction() {
        return $this->render('default/example.html.twig');
    }

    /**
     * @Route("/ajaxgetdata", name="ajaxdata")
     */
    public function returnUserAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            if ($reqObj = json_decode($request->getContent())) {
                $user = $em->getRepository('AppBundle:User')->find($reqObj->id);
                if (isset($reqObj->name)) {
                    $user->setName($reqObj->name);
                }
                if (isset($reqObj->education)) {
                    $user->getEducation()->setTitle($reqObj->education);
                }
                $em->flush();
                return new Response("OK");
            } else {
                $users = $em->getRepository('AppBundle:User')->findAll();
                foreach ($users as $key => $user) {
                    $result[$key]['id'] = $user->getId();
                    $result[$key]['name'] = $user->getName();
                    $result[$key]['education'] = $user->getEducation()->getTitle();
                }
                $result = json_encode($result);
                $response = new Response($result, 200);
                return $response;
            }
        }
    }

}

<?php
/**
 * Created by Evis Bregu <evis.bregu@gmail.com>.
 * Date: 7/6/18
 * Time: 12:53 PM
 */

namespace AppBundle\Controller\Web;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReactTestController extends Controller
{
    /**
     * @Route("/test_react", name="test_react")
     */
    public function testReactAction()
    {
        return $this->render('test_react.html.twig');
    }
}
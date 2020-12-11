<?php


namespace App\Controller\Admin;





use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class HompageController extends AbstractController
{
    /**
     * @Route("/", name="admin.homepage.index")
    */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}
<?php


namespace App\Controller;

use App\Repository\RegionRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    //Création des routes


    private RequestStack $requestStack;
    private RegionRepository $regionRepository;

    public function __construct(RequestStack $requestStack, RegionRepository $regionRepository)
    {
        $this->requestStack = $requestStack;
        $this->regionRepository = $regionRepository;
    }

    /**
     * @Route("/", name="homepage.index")
     */
    public function index():Response
    {
        //dd($this->requestStack->getCurrentRequest()->headers->get('accept-language'));
        //return new Response('Coucou');
        $regions = $this->regionRepository->findAll();
        //dd($regions);
        return $this->render('homepage/index.html.twig', [
            'regions' => $regions,
        ]);
    }

}
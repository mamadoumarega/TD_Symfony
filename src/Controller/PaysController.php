<?php


namespace App\Controller;


use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaysController extends AbstractController
{
    private CountryRepository $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * @Route("/countries", name="country.index")
    */
    public function index():Response
    {
        $countries = $this->countryRepository->findAll();
        return $this->render('country/index.html.twig',[
            'countries' => $countries
        ]);
    }

    /**
     * @Route("/country/{slug}", name="country.getCountry")
     * @param string $slug
     * @return Response
     */
    public function getCountry(string $slug):Response
    {
        $country = $this->countryRepository->findOneBy([
            'slug' => $slug
        ]);

        return $this->render('country/country.html.twig',[
            'country' => $country
        ]);
    }

}
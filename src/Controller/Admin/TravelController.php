<?php


namespace App\Controller\Admin;


use App\Entity\Travel;
use App\Form\TravelType;
use App\Repository\TravelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * @Route("/admin")
 */
class TravelController extends AbstractController
{
    private TravelRepository $travelRepository;
    private RequestStack $requestStack;
    private Request $request;
    private SluggerInterface $slugger;
    private EntityManagerInterface $entityManager;

    public function __construct(TravelRepository $travelRepository, RequestStack $requestStack, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $this->travelRepository = $travelRepository;
        $this->requestStack = $requestStack;
        $this->request = $this->requestStack->getCurrentRequest();
        $this->slugger = $slugger;
        $this->entityManager = $entityManager;

    }

    /**
     * @Route("/travel", name="admin.travel.index")
    */
    public function index(): Response
    {
        $travels = $this->travelRepository->findAll();
        return $this->render('admin/travel/index.html.twig',[
            'travels' => $travels
        ]);
    }

    /**
     * @Route("/travel/form", name="admin.travel.form.add")
     */
    public function form(): Response
    {
        $type = TravelType::class;
        $entity = new Travel();
        $form = $this->createForm($type, $entity);
        $form->handleRequest( $this->request );

        if ($form->isSubmitted() && $form->isValid())
        {
            $entity->setSlug($this->slugger->slug( $entity->getName() ) );

            $uploadedFile = $entity->getPoster();
            $originalName = $uploadedFile->getClientOriginalName();
            $uploadedFile->move('img/', $originalName);
            $entity->setPoster($originalName);


            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            $message = "Le voyage a été créé";
            $this->addFlash("notice",$message);

            return $this->redirectToRoute('admin.travel.index');



           // dd($entity);
        }

         return $this->render('admin/travel/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
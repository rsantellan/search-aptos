<?php
/**
 * @copyright Copyright © 2019 Geocom. All rights reserved.
 * @author    Rodrigo Santellan <rsantellan@geocom.com.uy>
 */
namespace App\Controller;

use App\Repository\ApartamentoRepository;
use App\Repository\FocusPointRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Apartamento;

class ApartamentosController extends AbstractController
{

    /**
     * @Route("/", name="index", methods={"GET"})
     * @param ApartamentoRepository $apartamentoRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index(ApartamentoRepository $apartamentoRepository)
    {
        $quantityActivePossibleInMap = $apartamentoRepository->doCount(true, true, true);
        $quantityActivePossibleNotInMap = $apartamentoRepository->doCount(true, true, false);
        $quantityActiveNotPossibleInMap = $apartamentoRepository->doCount(true, false, true);
        $quantityActiveNotPossibleNotInMap = $apartamentoRepository->doCount(true, false, false);
        $quantityNotActive =  $apartamentoRepository->doCount(false, null, null);
        $data = [
            'active' =>
                [
                    'inmap' => [
                        'posible' => $quantityActivePossibleInMap[1],
                        'notposible' => $quantityActiveNotPossibleInMap[1],
                ],
                    'notmap' => [
                        'posible' => $quantityActivePossibleNotInMap[1],
                        'notposible' => $quantityActiveNotPossibleNotInMap[1],
                    ]
                ],
            'notactive' => $quantityNotActive[1]
        ];
        return $this->render('apartamentos/index.html.twig', ['data' => $data]);
    }

    /**
     * @Route("/actives.html", name="activos", methods={"GET"})
     */
    public function active(ApartamentoRepository $apartamentoRepository)
    {
        $data = $apartamentoRepository->getAllActive();
        return $this->render('apartamentos/activelist.html.twig', ['list' => $data]);
    }

    /**
     * @Route("/inactives.html", name="inactivos", methods={"GET"})
     */
    public function inactive(ApartamentoRepository $apartamentoRepository)
    {
        $data = $apartamentoRepository->getAllActive();
        return $this->render('apartamentos/activelist.html.twig', ['list' => $data]);
    }

    /**
     * @Route("/mapa.html", name="mapa", methods={"GET"})
     * @param ApartamentoRepository $apartamentoRepository
     * @param FocusPointRepository $focusPointRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function map(ApartamentoRepository $apartamentoRepository, FocusPointRepository $focusPointRepository)
    {
        $focusPoints = $focusPointRepository->findAll();
        $focusPointData = [];
        foreach ($focusPoints as $focusPoint) {
            $focusPointData[] = [
                'name' => $focusPoint->getName(),
                'latitud' => $focusPoint->getLatitud(),
                'longitud' => $focusPoint->getLongitud(),
            ];
        }
        $data = $apartamentoRepository->getAllActiveMarkers();
        $sendData = [];
        foreach($data as $apto){
            $aux = new \stdClass();
            $aux->name = $apto['name'];
            $aux->longitud = $apto['longitud'];
            $aux->latitud = $apto['latitud'];
            $aux->url = $this->generateUrl('viewpublication', ['hash' => $apto['hash']]);
            $sendData[] = $aux;
        }
        return $this->render('apartamentos/map.html.twig', ['data' => $sendData, 'focusPoints' => $focusPointData]);
    }
    /**
     * @Route("/apto/{hash}", name="viewpublication", methods={"GET"})
     */
    public function apto(ApartamentoRepository $apartamentoRepository, string $hash)
    {
        $apto = $apartamentoRepository->findOneBy(['hash' => $hash]);
        return $this->render('apartamentos/apto.html.twig', ['apto' => $apto]);
    }
    /**
     * @Route("/nomap.html", name="sinmapa", methods={"GET"})
     */
    public function sinmapa()
    {

    }
}
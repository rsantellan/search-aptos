<?php
/**
 * @copyright Copyright © 2019 Geocom. All rights reserved.
 * @author    Rodrigo Santellan <rsantellan@geocom.com.uy>
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Apartamento;

class ApartamentosController extends AbstractController
{

    public function index()
    {
        $quantityActivePossibleInMap = $this
                        ->getDoctrine()
                        ->getRepository(Apartamento::class)
                        ->doCount(true, true, true);
        $quantityActivePossibleNotInMap = $this
            ->getDoctrine()
            ->getRepository(Apartamento::class)
            ->doCount(true, true, false);
        $quantityActiveNotPossibleInMap = $this
            ->getDoctrine()
            ->getRepository(Apartamento::class)
            ->doCount(true, false, true);
        $quantityActiveNotPossibleNotInMap = $this
            ->getDoctrine()
            ->getRepository(Apartamento::class)
            ->doCount(true, false, false);
        $quantityNotActive =  $this
            ->getDoctrine()
            ->getRepository(Apartamento::class)
            ->doCount(false, null, null);
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

    public function active()
    {
        $data = $this
            ->getDoctrine()
            ->getRepository(Apartamento::class)
            ->getAllActive();
        return $this->render('apartamentos/activelist.html.twig', ['list' => $data]);
    }

    public function map()
    {
        $data = $this->getDoctrine()->getRepository(Apartamento::class)->getAllActiveMarkers();
        return $this->render('apartamentos/map.html.twig', ['data' => $data]);
    }
}
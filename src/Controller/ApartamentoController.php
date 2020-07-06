<?php

namespace App\Controller;

use App\Entity\Apartamento;
use App\Form\ApartamentoType;
use App\Repository\ApartamentoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/apartamento")
 */
class ApartamentoController extends AbstractController
{
    /**
     * @Route("/", name="apartamento_index", methods={"GET"})
     */
    public function index(ApartamentoRepository $apartamentoRepository): Response
    {
        return $this->render('apartamento/index.html.twig', [
            'apartamentos' => $apartamentoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="apartamento_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $apartamento = new Apartamento();
        $form = $this->createForm(ApartamentoType::class, $apartamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $apartamento->setCreatedAt(new \DateTime());
            $entityManager->persist($apartamento);
            $entityManager->flush();

            return $this->redirectToRoute('apartamento_index');
        }

        return $this->render('apartamento/new.html.twig', [
            'apartamento' => $apartamento,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="apartamento_show", methods={"GET"})
     */
    public function show(Apartamento $apartamento): Response
    {
        return $this->render('apartamento/show.html.twig', [
            'apartamento' => $apartamento,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="apartamento_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Apartamento $apartamento): Response
    {
        $form = $this->createForm(ApartamentoType::class, $apartamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('apartamento_index');
        }

        return $this->render('apartamento/edit.html.twig', [
            'apartamento' => $apartamento,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{url}", name="apartamento_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Apartamento $apartamento): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apartamento->getUrl(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($apartamento);
            $entityManager->flush();
        }

        return $this->redirectToRoute('apartamento_index');
    }
}

<?php

namespace App\Controller;

use App\Entity\Credit;
use App\Form\CreditType;
use App\Repository\CreditRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/credit')]
class CreditController extends AbstractController
{
    #[Route('/', name: 'app_credit_index', methods: ['GET'])]
    public function index(CreditRepository $creditRepository): Response
    {
        return $this->render('credit/index.html.twig', [
            'credits' => $creditRepository->findAll(),
        ]);
    }

    #[Route('/back', name: 'app_credit_indexback', methods: ['GET'])]
    public function indexback(CreditRepository $creditRepository): Response
    {
        return $this->render('credit/indexback.html.twig', [
            'credits' => $creditRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_credit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $credit = new Credit();
        $form = $this->createForm(CreditType::class, $credit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $credit->setDateDemande(new \DateTime('now'));
            $credit->setMontant(0);
            $credit->setDateEcheance(new \DateTime('now'));
            $credit->setTauxInteret(0);
            $credit->setStatus(0);
            $entityManager->persist($credit);
            $entityManager->flush();

            return $this->redirectToRoute('app_credit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('credit/new.html.twig', [
            'credit' => $credit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_credit_show', methods: ['GET'])]
    public function show(Credit $credit): Response
    {
        return $this->render('credit/show.html.twig', [
            'credit' => $credit,
        ]);
    }

    #[Route('/back/{id}', name: 'app_credit_showback', methods: ['GET'])]
    public function showback(Credit $credit): Response
    {
        return $this->render('credit/showback.html.twig', [
            'credit' => $credit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_credit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Credit $credit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CreditType::class, $credit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_credit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('credit/edit.html.twig', [
            'credit' => $credit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_credit_delete', methods: ['POST'])]
    public function delete(Request $request, Credit $credit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$credit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($credit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_credit_index', [], Response::HTTP_SEE_OTHER);
    }
}

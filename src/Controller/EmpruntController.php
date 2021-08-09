<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Form\EmpruntType;
use App\Repository\EmpruntRepository;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmpruntController extends AbstractController
{
    #[Route('/emprunt', name: 'emprunt')]
    public function index(EmpruntRepository $empruntRepo, LivresRepository $livreRepo): Response
    {
        return $this->render('livres/index.html.twig', [
            'livres' => $livreRepo->findAll(),
            'emprunts' => $empruntRepo->findAll(),
        ]);
    }

    /**
     * Mettre à jour un livre existant.
     *
     *
     * @param EntityManagerInterface $em
     * @param Request $post
     * @param Emprunt|null $emprunt
     * @return RedirectResponse|Response
     */
    #[Route('/emprunt/edit/{emprunt}', name: "edit_emp")]
    public function update(EntityManagerInterface $em, Request $post, Emprunt $emprunt)
    {
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($post);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash("success", "Date prolongé avec succès");

            return $this->redirectToRoute("livres");
        }

        return $this->render("emprunt/empEdit.html.twig", [
            "form" => $form->createView(),
            "emprunt" => $emprunt
        ]);
    }

    /**
     * Enregistrer un livre existant.
     *
     * @param EntityManagerInterface $em
     * @param Request $post
     * @return RedirectResponse|Response
     */
    #[Route('/emprunt/add', name: "add_emp")]
    public function edit(EntityManagerInterface $em, Request $post)
    {
        $emprunt = new Emprunt();
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($post);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($emprunt);
            $em->flush();
            $this->addFlash("success", "Emprunt effectué avec succès");
            return $this->redirectToRoute("livres");
        }

        return $this->render("emprunt/empAdd.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * Supprimer un livre
     *
     * @param EntityManagerInterface $em
     * @param Request $delete
     * @param Emprunt $emprunt
     * @return RedirectResponse
     */
    #[Route('emprunt/delete/{emprunt}', name: "emp_del")]
    public function delete(EntityManagerInterface $em, Request $delete, Emprunt $emprunt)
    {
        $csrfToken = $delete->request->get("_token");
        if ($this->isCsrfTokenValid("delete" . $emprunt->getId(), $csrfToken)) {
            $em->remove($emprunt);
            $em->flush();
            $this->addFlash("success", "Livre rendu");
        } else {
            $this->addFlash("warning", "Quelque chose s'est mal passé, veuillez reprendre");
        }

        return $this->redirectToRoute("livres");
    }
}

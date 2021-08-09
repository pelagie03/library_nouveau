<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Form\LivresType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\{EmpruntRepository, LivresRepository};
use Symfony\Component\HttpFoundation\{RedirectResponse, Request, Response};
use Symfony\Component\Routing\Annotation\Route;

class LivresController extends AbstractController
{
    #[Route('/livres', name: 'livres')]
    public function index(LivresRepository $livreRepo, EmpruntRepository $empruntRepo): Response
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
     * @param Livres|null $livre
     * @return RedirectResponse|Response
     */
    #[Route('/livres/edit/{livre}', name: "livEdit")]
    public function update(EntityManagerInterface $em, Request $post, Livres $livre)
    {
        $form = $this->createForm(LivresType::class, $livre) ;
        $form->handleRequest($post) ;

        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush() ;
            $this->addFlash("success", "Livre modifié avec succès") ;

            return $this->redirectToRoute("livres") ;
        }

        return $this->render("livres/livEdit.html.twig", [
            "form" => $form->createView(),
            "livres" => $livre
        ]) ;
    }

    /**
     * Enregistrer un livre.
     *
     * @param EntityManagerInterface $em
     * @param Request $post
     * @return RedirectResponse|Response
     */
    #[Route('/livres/add', name: "livAdd")]
    public function edit(EntityManagerInterface $em, Request $post)
    {
        $livres = new Livres() ;
        $form = $this->createForm(LivresType::class, $livres) ;
        $form->handleRequest($post) ;

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($livres) ;
            $em->flush() ;
            $this->addFlash("success", "Livre ajouté avec succès") ;
            return $this->redirectToRoute("livres") ;

        }

        return $this->render("livres/livAdd.html.twig", [
            "form" => $form->createView()
        ]) ;
    }

    /**
     * Supprimer un livre
     *
     * @param EntityManagerInterface $em
     * @param Request $delete
     * @param Livres $livre
     * @return RedirectResponse
     */
    #[Route('livres/delete/{livre}', name: "livDel")]
    public function delete(EntityManagerInterface $em, Request $delete, Livres $livre)
    {
        $csrfToken = $delete->request->get("_token") ;
        if($this->isCsrfTokenValid("delete" . $livre->getId(), $csrfToken))
        {
            $em->remove($livre) ;
            $em->flush() ;
            $this->addFlash("success", "Livre supprimé") ;
        }
        else
        {
            $this->addFlash("warning", "Quelque chose s'est mal passé, veuillez reprendre") ;
        }

        return $this->redirectToRoute("livres") ;
    }
}

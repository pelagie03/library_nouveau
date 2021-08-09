<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Form\LivresType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivresController extends AbstractController
{
    #[Route('/livres', name: 'livres')]
    public function index(): Response
    {
        return $this->render('livres/index.html.twig', [
            'controller_name' => 'LivresController',
        ]);
    }

    /**
     * Mettre à jour un livre existant.
     *
     *
     * @param EntityManagerInterface $em
     * @param Request $post
     * @param Livres|null $livres
     * @return RedirectResponse|Response
     */
    #[Route('/livres/edit/{livres}', name: "edit_livres")]
    public function update(EntityManagerInterface $em, Request $post, Livres $livres)
    {
        $form = $this->createForm(LivresType::class, $livres) ;
        $form->handleRequest($post) ;

        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush() ;
            $this->addFlash("success", "Livre modifié avec succès") ;

            return $this->redirectToRoute("livres") ;
        }

        return $this->render("livres/livEdit.html.twig", [
            "form" => $form->createView(),
            "livres" => $livres
        ]) ;
    }

    /**
     * Enregistrer un livre existant.
     *
     * @param EntityManagerInterface $em
     * @param Request $post
     * @return RedirectResponse|Response
     */
    #[Route('/livres/add', name: "add_livres")]
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
     * @param Livres $livres
     * @return RedirectResponse
     */
    #[Route('livres/delete/{livres}', name: "liv_del")]
    public function delete(EntityManagerInterface $em, Request $delete, Livres $livres)
    {
        $csrfToken = $delete->request->get("_token") ;
        if($this->isCsrfTokenValid("delete" . $livres->getId(), $csrfToken))
        {
            $em->remove($livres) ;
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

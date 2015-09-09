<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contribution;
use AppBundle\Form\AddContributionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function editAction(Request $request, $id)
    {
        if (null !== $id) {
            $repo = $this->container->get('pimterest.repository.contribution');
            $contribution = $repo->findOneBy(['id' => $id]);

            if (!$contribution) {
                throw new \Exception('No contribution found with this id');
            }
        } else {
            $contribution = new Contribution([]);
            $contribution->setActive(true);
            $contribution->setSource('community');
        }

        $form = $this->createForm(new AddContributionType(), $contribution);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contribution);
            $em->flush();

            $this->addFlash('success', 'Success');

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('@App/admin/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function deleteAction(Request $request, $id)
    {
        $repo = $this->container->get('pimterest.repository.contribution');
        $contribution = $repo->findOneBy(['id' => $id]);

        if (!$contribution) {
            throw new \Exception('No contribution found with this id');
        }

        $this->container->get('doctrine.orm.entity_manager')->remove($contribution);
        $this->container->get('doctrine.orm.entity_manager')->flush($contribution);

        return new RedirectResponse($this->generateUrl('admin_index'));
    }

    public function indexAction(Request $request)
    {
        $repo = $this->container->get('pimterest.repository.contribution');
        $page = $request->query->getInt('page', 1);
        $contributions = $repo->findBy([], ['id' => 'DESC']);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $contributions,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('@App/admin/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}

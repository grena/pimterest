<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contribution;
use AppBundle\Form\AddContributionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function indexAction(Request $request)
    {
        $contribution = new Contribution([]);
        $contribution->setActive(true);
        $contribution->setSource('community');

        $form = $this->createForm(new AddContributionType(), $contribution);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contribution);
            $em->flush();

            $this->addFlash('success', 'Added');

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('@App/admin/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

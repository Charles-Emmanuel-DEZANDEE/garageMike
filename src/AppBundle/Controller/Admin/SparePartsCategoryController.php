<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\SparePartCategory;
use AppBundle\Form\SparePartCategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class SparePartsCategoryController extends Controller
{


    /**
     * @Route("/spare-parts-category", name="app.admin.spare.parts.category.index")
     */
    public function indexAction(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $rc = $doctrine->getRepository(SparePartCategory::class);
        $results = $rc->findAll();

        return $this->render('admin/sparePartsCategory/index.html.twig',[
            'results' => $results
        ]);

    }



    /**
     * @Route("/spare-parts-category/form", name="app.admin.spare.parts.category.form", defaults={"id" : null })
     * @Route("/spare-parts-category/form/update/{id}", name="app.admin.spare.parts.category.form.update")
     */
    public function formAction(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(SparePartCategory::class);


        $entity = $id ? $rc->find($id):new SparePartCategory();
        $entityType = SparePartCategoryType::class;

/*        exit(dump($entityType, $entity));*/
        $form = $this->createForm($entityType, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ){
/*            exit(dump($entity));*/
            //insertion
            $em->persist($entity);
            $em->flush();

            //message flash
            $message = $id ? 'Le contact a été mis à jour' : 'Le contact a été inséré';
            $this->addFlash('notice', $message);

            // redirection
            $this->redirectToRoute('app.admin.spare.parts.category.index');

        }

        return $this->render('/admin/sparePartsCategory/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/spare-parts-category/delete/{id}", name="app.admin.spare.parts.category.delete")
     */
    public function deleteAction(Request $request, $id)
    {
        //selection
        $doctrine = $this->getDoctrine();
        $rc = $doctrine->getRepository(SparePartCategory::class);
        $result = $rc->find($id);

        // delete

        $em = $doctrine->getManager();
        $em->remove($result);
        $em->flush();

        return $this->redirectToRoute('app.admin.spare.parts.category.index');

    }

}

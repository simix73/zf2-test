<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Entity\Recipe;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RecipesController extends AbstractActionController
{
    public function newAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $sections = $objectManager
            ->getRepository('Application\Entity\Section');

        $view = new ViewModel(array(
            'sections' => $sections->findAll(),
        ));

        return $view;
    }


    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $sections = $objectManager
            ->getRepository('Application\Entity\Section');

        $recipe = $objectManager
            ->find('Application\Entity\Recipe', $id);

        $view = new ViewModel(array(
            'id' => $id,
            'recipe' => $recipe,
            'sections' => $sections->findAll(),
        ));

        return $view;
    }

    public function updateAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        $description = $this->params()->fromPost('descr', '');
        $sectionId = $this->params()->fromPost('section', 1);

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $recipe = $objectManager
            ->find('Application\Entity\Recipe', $id);

        $section = $objectManager
            ->find('Application\Entity\Section', $sectionId);


        $recipe->setDescription($description);
        $recipe->setSection($section);
        $objectManager->persist($recipe);
        $objectManager->flush();

        return $this->redirect()->toRoute('admin');
    }

    public function createAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        $description = $this->params()->fromPost('descr', '');
        $sectionId = $this->params()->fromPost('section', 1);

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $section = $objectManager
            ->find('Application\Entity\Section', $sectionId);


        $recipe = new Recipe();
        $recipe->setDescription($description);
        $recipe->setSection($section);

        $objectManager->persist($recipe);
        $objectManager->flush();

        return $this->redirect()->toRoute('admin');
    }

    public function removeAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $recipe = $objectManager
            ->find('Application\Entity\Recipe', $id);

        $objectManager->remove($recipe);
        $objectManager->flush();

        return $this->redirect()->toRoute('admin');
    }

}
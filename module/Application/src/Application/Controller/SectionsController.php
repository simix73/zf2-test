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
use Application\Entity\Section;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SectionsController extends AbstractActionController
{
    public function newAction()
    {
        return new ViewModel();
    }


    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $section = $objectManager
            ->find('Application\Entity\Section', $id);

        $view = new ViewModel(array(
            'id' => $id,
            'section' => $section,
        ));

        return $view;
    }

    public function updateAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        $name = $this->params()->fromPost('name', 'Не задано');

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $section = $objectManager
            ->find('Application\Entity\Section', $id);

        /* @var $section \Application\Entity\Section */
        $section->setName($name);

        $objectManager->persist($section);
        $objectManager->flush();

        return $this->redirect()->toRoute('admin');
    }

    public function createAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        $name = $this->params()->fromPost('name', 'Не задано');

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $section = new Section();
        $section->setName($name);

        $objectManager->persist($section);
        $objectManager->flush();

        return $this->redirect()->toRoute('admin');
    }

    public function removeAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $section = $objectManager
            ->find('Application\Entity\Section', $id);

        $recipes = $objectManager
            ->getRepository('Application\Entity\Recipe')
            ->findBy(['section' => $section]);

        foreach ($recipes as $recipe) {
            $objectManager->remove($recipe);
        }

        $objectManager->remove($section);
        $objectManager->flush();

        return $this->redirect()->toRoute('admin');
    }

}
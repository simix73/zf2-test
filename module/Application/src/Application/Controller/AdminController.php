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

class AdminController extends AbstractActionController
{
    public function indexAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $recipes = $objectManager
            ->getRepository('Application\Entity\Recipe')->findAll();

        $sections = $objectManager
            ->getRepository('Application\Entity\Section')->findAll();


        $view = new ViewModel(array(
            'recipes' => $recipes,
            'sections' => $sections,
            'recipesCount' => count($recipes),
            'sectionsCount' => count($sections),
        ));

        return $view;
    }

}
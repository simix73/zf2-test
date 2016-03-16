<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $sectionId = $this->params()->fromQuery('section', 1);
        $searchstr = $this->params()->fromQuery('searchstr');

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $recipes = $objectManager
            ->getRepository('Application\Entity\Recipe');

        $sections = $objectManager
            ->getRepository('Application\Entity\Section')->findAll();

        if ($searchstr) {
            $qb = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager')->createQueryBuilder();
            $recipes = $qb->select('recipes')
                ->from('Application\Entity\Recipe', 'recipes')
                ->where('(recipes.id = :id or lower(recipes.description) like \'%' . $searchstr . '%\') and (recipes.section_id = '.$sectionId.')')
                ->setParameter('id', intval($searchstr))
                ->getQuery()
                ->getResult();
        } else {
            $recipes = $recipes->findAll();
        }


        $view = new ViewModel(array(
            'recipes' => $recipes,
            'sections' => $sections,
            'currentSection' => $sectionId,
            'count' => count($recipes),
            'searchstr' => $searchstr,
        ));

        return $view;
    }
}

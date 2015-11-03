<?php

namespace AppBundle\Controller;

use AppBundle\Service\Search;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 *
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @return Search
     */
    protected function getSearchService()
    {
        return $this->container->get(Search::SERVICE);
    }

    /**
     * @Route("/", name="homepage")
     * @return array
     */
    public function indexAction()
    {
        $searchService = $this->getSearchService();

        return $this->render(
            "@App/Default/index.html.twig",
            [
                'rand' => $searchService->getRandomStudent(),
                'maxStudentCourses' => $searchService->getMaxStudentCourses(),
                'list' => $searchService->getStudentList(),
            ]
        );
    }
}

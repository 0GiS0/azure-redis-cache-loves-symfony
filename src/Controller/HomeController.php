<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $cache;
    public function __construct(AdapterInterface $cacheClient)
    {
        $this->cache = $cacheClient;
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {

        $itemCache = $this->cache->getItem('cached');
        $cached = 'no';

        if (!$itemCache->isHit()) {
            $itemCache->set('yes');
            $this->cache->save($itemCache);
        } else {           
            $cached = $itemCache->get();
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'cached' => $cached,
        ]);
    }
}

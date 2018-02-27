<?php

namespace App\Controller;

use App\Entity\Host;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HostController extends Controller
{
    /**
     * @Route("/host/add/{name}/{ttl}")
     */
    public function add($name, $ttl)
    {
        $em = $this->getDoctrine()->getManager();

        $host = Host::create($name, $ttl);
        $em->persist($host);
        $em->flush();

        return new Response(
            '<html><body>ID: ' . $host->getId() . '; Hash: ' . $host->getHash() .'</body></html>'
        );
    }
}

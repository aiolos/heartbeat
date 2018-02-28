<?php

namespace App\Controller;

use App\Entity\Heartbeat;
use App\Exceptions\HostNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PingController extends Controller
{
    /**
     * @Route("/ping/{hash}")
     */
    public function ping($hash)
    {
        $em = $this->getDoctrine()->getManager();

        $host = $em->getRepository('App\Entity\Host')->findOneBy(array('hash' => $hash));
        if (!is_object($host)) {
            throw new HostNotFoundException('Unknown Host');
        }
        $heartbeat = Heartbeat::create($host);
        $em->persist($heartbeat);
        $em->flush();

        return new JsonResponse([
            'result' => 'ok',
            'id' => $heartbeat->getId(),
        ]);
    }
}

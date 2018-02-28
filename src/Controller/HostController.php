<?php

namespace App\Controller;

use App\Entity\Host;
use App\Exceptions\HostNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        return new JsonResponse([
            'id' => $host->getId(),
            'hash' => $host->getHash(),
        ]);
    }

    /**
     * @Route("/host/details/{hash}")
     * @throws HostNotFoundException
     */
    public function details($hash)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Host $host */
        $host = $em->getRepository('App\Entity\Host')->findOneBy(array('hash' => $hash));
        if (!is_object($host)) {
            throw new HostNotFoundException('Unknown Host');
        }

        return new JsonResponse([
            'id' => $host->getId(),
            'name' => $host->getName(),
            'last' => $host->getLastHeartbeat()->toArray()
        ]);
    }
}

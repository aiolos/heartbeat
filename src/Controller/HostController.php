<?php

namespace App\Controller;

use App\Entity\Heartbeat;
use App\Entity\Host;
use App\Exceptions\HostNotFoundException;
use App\Exceptions\InvalidAdminException;
use App\Helpers\Authenticate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HostController extends Controller
{
    /**
     * @Route("/admin/{adminUuid}/host/add/{name}/{ttl}")
     * @return JsonResponse
     * @throws InvalidAdminException
     * @throws \App\Exceptions\InvalidIntervalException
     */
    public function add($adminUuid, $name, $ttl)
    {
        Authenticate::check($adminUuid);

        $em = $this->getDoctrine()->getManager();

        $host = Host::create($name, $ttl);
        $em->persist($host);
        $em->flush();

        return new JsonResponse([
            'id' => $host->getId(),
            'uuid' => $host->getHash(),
        ]);
    }

    /**
     * @Route("/admin/{adminUuid}/host/details/{hash}")
     * @throws HostNotFoundException
     * @throws InvalidAdminException
     */
    public function details($adminUuid, $hash)
    {
        Authenticate::check($adminUuid);

        $em = $this->getDoctrine()->getManager();

        /** @var Host $host */
        $host = $em->getRepository('App\Entity\Host')->findOneBy(array('hash' => $hash));
        if (!is_object($host)) {
            throw new HostNotFoundException('Unknown Host');
        }

        $response = $host->toArray();
        $response['heartbeats'] = array_map(function (Heartbeat $heartbeat) {
            return $heartbeat->toArray();
        }, $host->getHeartbeats()->slice(0, 10));

        return new JsonResponse($response);
    }

    /**
     * @Route("/admin/{uuid}/host/list")
     * @throws InvalidAdminException
     */
    public function list($uuid)
    {
        Authenticate::check($uuid);

        $em = $this->getDoctrine()->getManager();

        /** @var Host $host */
        $hosts = $em->getRepository('App\Entity\Host')->findAll();
        $hostsArray = array_map(function (Host $host) {
            return $host->toArray();
        }, $hosts);

        return new JsonResponse(['hosts' => $hostsArray]);
    }
}

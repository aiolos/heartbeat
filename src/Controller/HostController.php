<?php

namespace App\Controller;

use App\Entity\Host;
use App\Exceptions\HostNotFoundException;
use App\Exceptions\InvalidAdminException;
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
        $this->checkAdminUuid($adminUuid);

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
     * @Route("/admin/{adminUuid}/host/details/{hash}")
     * @throws HostNotFoundException
     * @throws InvalidAdminException
     */
    public function details($adminUuid, $hash)
    {
        $this->checkAdminUuid($adminUuid);

        $em = $this->getDoctrine()->getManager();

        /** @var Host $host */
        $host = $em->getRepository('App\Entity\Host')->findOneBy(array('hash' => $hash));
        if (!is_object($host)) {
            throw new HostNotFoundException('Unknown Host');
        }

        return new JsonResponse([
            'id' => $host->getId(),
            'name' => $host->getName(),
            'ttl' => $host->getTtl(),
            'last' => $host->getLastHeartbeat() ? $host->getLastHeartbeat()->toArray() : null,
        ]);
    }

    /**
     * @Route("/admin/{uuid}/host/list")
     * @throws InvalidAdminException
     */
    public function list($uuid)
    {
        $this->checkAdminUuid($uuid);

        $em = $this->getDoctrine()->getManager();

        /** @var Host $host */
        $hosts = $em->getRepository('App\Entity\Host')->findAll();
        $hostsArray = array_map(function ($host) {
            return [
                'id' => $host->getId(),
                'name' => $host->getName(),
                'uuid' => $host->getHash(),
                'ttl' => $host->getTtl(),
                'last' => $host->getLastHeartbeat() ? $host->getLastHeartbeat()->toArray(): null,
            ];
        }, $hosts);

        return new JsonResponse($hostsArray);
    }

    private function checkAdminUuid($uuid)
    {
        if ($uuid !== getenv('ADMIN_UUID')) {
            throw new InvalidAdminException('No valid uuid given');
        }
    }
}

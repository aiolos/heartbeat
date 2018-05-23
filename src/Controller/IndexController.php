<?php

namespace App\Controller;

use App\Entity\Heartbeat;
use App\Entity\Host;
use App\Exceptions\HostNotFoundException;
use App\Helpers\Authenticate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller
{
    /**
     * @Route("/{adminUuid}")
     */
    public function index($adminUuid)
    {
        return $this->render('views/index.html.twig', ['adminUuid' => $adminUuid]);
    }

    /**
     * @Route("/{adminUuid}/view/{hostUuid}")
     */
    public function view($adminUuid, $hostUuid)
    {
        Authenticate::check($adminUuid);

        $em = $this->getDoctrine()->getManager();

        /** @var Host $host */
        $host = $em->getRepository('App\Entity\Host')->findOneBy(array('hash' => $hostUuid));
        if (!is_object($host)) {
            throw new HostNotFoundException('Unknown Host');
        }

        $response = $host->toArray();
        $response['heartbeats'] = array_map(function (Heartbeat $heartbeat) {
            return $heartbeat->toArray();
        }, $host->getHeartbeats()->toArray());

        return $this->render('views/view.html.twig', ['adminUuid' => $adminUuid, 'host' => $response]);
    }
}

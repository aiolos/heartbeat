<?php

namespace App\Controller;

use App\Entity\Heartbeat;
use App\Exceptions\HostNotFoundException;
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
}

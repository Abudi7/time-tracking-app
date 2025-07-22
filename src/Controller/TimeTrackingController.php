<?php

namespace App\Controller;

use App\Entity\TimeTracking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class TimeTrackingController extends AbstractController
{
    #[Route('/time/tracking', name: 'app_time_tracking')]
    public function index(): Response
    {
        return $this->render('time_tracking/index.html.twig', [
            'controller_name' => 'TimeTrackingController',
        ]);
    }
    #[Route('/api/time/start', name: 'time_start', methods: ['POST'])]
    public function startTracking(EntityManagerInterface $em, UserInterface $user): JsonResponse
    {
        $tracking = new TimeTracking();
        $tracking->setUser($user);
        $tracking->setStartAt(new \DateTimeImmutable());

        $em->persist($tracking);
        $em->flush();

        return $this->json([
            'message' => '✅ Work started successfully.',
            'start_time' => $tracking->getStartAt()->format('Y-m-d H:i:s')
        ]);
    }

    #[Route('/api/time/stop', name: 'time_stop', methods: ['POST'])]
    public function stopTracking(EntityManagerInterface $em, UserInterface $user): JsonResponse
    {
        $tracking = $em->getRepository(TimeTracking::class)->findOneBy([
            'user' => $user,
            'endAt' => null
        ], ['startAt' => 'DESC']);

        if (!$tracking) {
            return $this->json(['error' => '❌ Failed to start time tracking.'], 400);
        }

        $end = new \DateTimeImmutable();
        $tracking->setEndAt($end);

        $duration = $end->getTimestamp() - $tracking->getStartAt()->getTimestamp();
        $minutes = floor($duration / 60);
        $tracking->setDurationInMinutes($minutes);

        $em->flush();

        return $this->json([
            'message' => '🕒 Work ended successfully.',
            'start_time' => $tracking->getStartAt()->format('Y-m-d H:i:s'),
            'end_time' => $tracking->getEndAt()->format('Y-m-d H:i:s'),
            'duration_minutes' => $tracking->getDurationInMinutes()
        ]);
    }
    // In TimeTrackingController
    #[Route('/api/time/all', name: 'time_all', methods: ['GET'])]
    public function getAllUserTimes(EntityManagerInterface $em, UserInterface $user): JsonResponse
    {
        $records = $em->getRepository(TimeTracking::class)->findBy(['user' => $user], ['startAt' => 'DESC']);

        $data = [];
        foreach ($records as $r) {
            $data[] = [
                'startAt' => $r->getStartAt()?->format('Y-m-d H:i:s'),
                'endAt' => $r->getEndAt()?->format('Y-m-d H:i:s'),
                'durationInMinutes' => $r->getDurationInMinutes(),
                'email' => $user->getEmail() // Add email to each record
            ];
        }

        return $this->json($data);
    }

}

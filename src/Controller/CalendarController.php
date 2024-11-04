<?php
// src/Controller/CalendarController.php
namespace App\Controller;

use App\Service\BoxService;
use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(BoxService $boxService, SettingsRepository $settingsRepository): Response
    {
        $settings = $settingsRepository->findOneBy(['main_settings' => true]);

        $allowPreviousDays = $settings ? $settings->isAllowPreviousDays() : false;

        $boxes = $boxService->getBoxesWithStatus($allowPreviousDays);

        $user = $this->getUser();
        $activatedBoxIds = $user ? $user->getBoxes() : [];

        if ($settings && $settings->isShuffle()) {
            shuffle($boxes);
        }

        return $this->render('index.html.twig', [
            'boxes' => $boxes,
            'activatedBoxIds' => $activatedBoxIds,
            'settings' => $settings
        ]);
    }
}

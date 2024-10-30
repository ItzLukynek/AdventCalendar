<?php
namespace App\Controller;

use App\Entity\Box;
use App\Repository\BoxRepository;
use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(BoxRepository $boxRepository, SettingsRepository $settingsRepository): Response
    {
        $boxes = $boxRepository->findAll();

        $user = $this->getUser();
        $activatedBoxIds = $user ? $user->getBoxes() : [];

        $settings = $settingsRepository->findOneBy(['main_settings' => true]);

        //shuffle day if set to true
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

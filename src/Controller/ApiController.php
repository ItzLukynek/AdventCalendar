<?php
// src/Controller/ApiController.php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Box;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Attribute\AsController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Repository\SettingsRepository;

#[AsController]
#[Route('/api', name: 'api_')]
class ApiController
{
    private EntityManagerInterface $entityManager;
    private TokenStorageInterface $tokenStorage;
    private EventDispatcherInterface $eventDispatcher;

    private SettingsRepository $settingsRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        EventDispatcherInterface $eventDispatcher,
        SettingsRepository $settingsRepository
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->eventDispatcher = $eventDispatcher;
        $this->SettingsRepository = $settingsRepository;
    }
    //api login for frontend auth
    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user || !$this->passwordHasher->isPasswordValid($user, $password)) {
            return new JsonResponse(['error' => 'Invalid credentials'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);

        $loginEvent = new InteractiveLoginEvent($request, $token);
        $this->eventDispatcher->dispatch($loginEvent);

        return new JsonResponse(['message' => 'Login successful', 'user' => [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
        ]]);
    }
    //api for actiavting box for a user
    #[Route('/activate-box/{boxId}', name: 'activate_box', methods: ['POST'])]
    public function activateBox(Request $request, int $boxId, SettingsRepository $settingsRepository): JsonResponse
    {

        $token = $this->tokenStorage->getToken();

        $settings = $settingsRepository->findOneBy(['main_settings' => true]);

        // auth for user
        if (!$token || !$token->getUser() instanceof User) {
            return new JsonResponse(['error' => 'User is not authenticated'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $user = $token->getUser();


        $box = $this->entityManager->getRepository(Box::class)->find($boxId);
        if (!$box) {
            return new JsonResponse(['error' => 'Box not found'], JsonResponse::HTTP_NOT_FOUND);
        }


        $user->addBox($boxId);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Box activated successfully', 'activatedBoxIds' => $user->getBoxes()]);
    }
}



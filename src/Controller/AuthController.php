<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticatorManagerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\JsonLoginAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
final class AuthController extends AbstractController
{
    #[Route('/auth', name: 'app_auth')]
    public function index(): Response
    {
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (! $data['email'] || ! $data['password']) {
            return $this->json(['error' => 'Email and password are required'], 400);
        }

        $user = new User();
        $user->setEmail($data['email']);

        // ✅ تشفير كلمة المرور هنا!
        $hashedPassword = $hasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // تعيين الدور تلقائيًا
        $user->setRoles(['ROLE_USER']);

        $em->persist($user);
        $em->flush();

        return $this->json(['message' => 'User registered successfully']);
    }

    #[Route('/api/login', name: 'custom_login', methods: ['POST'])]
    public function login(
        Request $request,
        UserProviderInterface $userProvider,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $em,
    ): JsonResponse {
        $data     = json_decode($request->getContent(), true);
        $email    = $data['email'] ?? null;
        $password = $data['password'] ?? null;
    
        if (! $email || ! $password) {
            return new JsonResponse(['error' => 'Email and password required'], 400);
        }
    
        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        if (! $user) {
            return new JsonResponse(['error' => 'User not found'], 401);
        }
    
        if (! $hasher->isPasswordValid($user, $password)) {
            return new JsonResponse(['error' => 'Invalid credentials'], 401);
        }
    
        // You can generate token here if needed later
        return $this->json([
            'message' => 'Login successful!',
            'redirect' => $this->generateUrl('app_time_tracking') // send URL to client
        ]);
    }
    
}

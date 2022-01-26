<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(Request $request): Response
    {
        return $this->render('pages/home.html.twig');
    }

    #[Route('/generate-password', name: 'app_generate_password')]
    public function geneartePassword(Request $request): Response
    {
        $length = $request->query->getInt('length');
        $digits = $request->query->getBoolean('digits');
        $uppercase_letters = $request->query->getBoolean('uppercase_letters');
        $characters_specials = $request->query->getBoolean('characters_specials');

        $characters = range('a', 'z');

        if ($uppercase_letters) {
            $characters = array_merge($characters, range('A', 'Z'));
        }

        if ($digits) {
            $characters = array_merge($characters, range('0', '9'));
        }

        if ($characters_specials) {
            $characters = array_merge($characters, [
                '!', '#', '$', '%', '&', '(', ')', '*', '+', ',', '-', '.', '/', ':',
                 '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '{', '|', '}', '~',
            ]);
        }

        $password = '';

        for ($i = 0; $i < $length; ++$i) {
            $password = $password . $characters[mt_rand(0, count($characters) - 1)];
        }

        return $this->render('pages/generate-password.html.twig', [
            'password' => $password,
        ]);
    }
}

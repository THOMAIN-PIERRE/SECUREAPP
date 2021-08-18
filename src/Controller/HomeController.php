<?php

namespace App\Controller;
use App\Service\EncryptService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     * @IsGranted("ROLE_USER")
     */
    public function index(EncryptService $encryptService)
    {
        // creation of a new key (this code must be commented once the key has been generated)
        // $encryptkey = $encryptService->generateNewEncryptKey();
        // dd($encryptkey);

        // Test of encryption / decryption of a text (to be commented on once we have verified that the service is working)
        // $ciphertext =  $encryptService->encrypt('Ceci est un texte strictement confidentiel.');
        // $decrypted =  $encryptService->decrypt($ciphertext);    
        // Display for control
        // dd( ["Message chiffré" => $ciphertext, "Message déchiffré" => $decrypted]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}

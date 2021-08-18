<?php
namespace App\Service;

use ParagonIE\Halite\KeyFactory;
use ParagonIE\HiddenString\HiddenString;
use ParagonIE\Halite\Symmetric\Crypto as Symmetric;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class EncryptService
{
    //Pour accès aux paramètres de service
    private $params;
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    //Chiffrement d'un texte de données
    public function encrypt(string $texte): string
    {
        $app_encryptkey =  $this->params->get('app.encryptkey');
        $encryptkey = KeyFactory::importEncryptionKey(new HiddenString( $app_encryptkey ));
        $ciphertext = Symmetric::encrypt( new HiddenString($texte), $encryptkey);
        return $ciphertext;
    }

    // Déchiffrement d'un texte chiffré
    public function decrypt(string $ciphertext): string
    {
        $app_encryptkey =  $this->params->get('app.encryptkey');
        $encryptkey = KeyFactory::importEncryptionKey(new HiddenString( $app_encryptkey ));
        $decrypted = Symmetric::decrypt($ciphertext, $encryptkey);
        return $decrypted;
    }

    // Génération d'une nouvelle clé secrète
    // Et encodage suous forme de chaine (pour paramètres)
    public function generateNewEncryptKey(): string
    {
        $encryptkey = KeyFactory::generateEncryptionKey(); 
        $encryptkey = KeyFactory::export($encryptkey)->getString();
        return $encryptkey;
    }
}
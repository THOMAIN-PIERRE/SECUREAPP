<?php
namespace App\EventListener;

use App\Entity\Client;
use Doctrine\Persistence\Event\LifecycleEventArgs;

use App\Service\EncryptService;

class DoctrineListener
{
    //accès au service
    private $encryptService;
    public function __construct(EncryptService $encryptService)
    {
        $this->encryptService = $encryptService;
    }

    // Méthodes écoutées : 
    // - prePersist et preUpdate avant l'enregistrement des entités
    // - postLoad après le chargement des entités
    // Dans chacune, on récupère l'entité des arguments passées
    // Et on teste s'il s'agit d'une entité protégée (ici Client)

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject(); 
        if ($entity instanceof Client) {
            $this->encryptFields($entity);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof Client) {
            $this->encryptFields($entity);
        }
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof Client) {
            $this->decryptFields($entity);
        }
    }  

    // Méthode de chiffrement des propriétés du Client
    private function encryptFields(Client $client)
    {
        $nomcrypt = $this->encryptService->encrypt( $client->getNom());
        $prenomcrypt = $this->encryptService->encrypt( $client->getPrenom());
        $emailcrypt = $this->encryptService->encrypt( $client->getEmail());
        $client->setNom($nomcrypt);
        $client->setPrenom($prenomcrypt);
        $client->setEmail($emailcrypt);
        return $client;
    }

    // Méthode de déchiffrement des propriétés du Client
    private function decryptFields(Client $client)
    {
        $nomclair = $this->encryptService->decrypt( $client->getNom()); 
        $prenomclair = $this->encryptService->decrypt( $client->getPrenom()); 
        $emailclair = $this->encryptService->decrypt( $client->getEmail());  
        $client->setNom($nomclair);
        $client->setPrenom($prenomclair);
        $client->setEmail($emailclair);
        return $client;
    }
}
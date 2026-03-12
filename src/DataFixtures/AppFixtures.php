<?php

namespace App\DataFixtures;

use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $usuario = new Usuario();
        $usuario->setUsername('admin');
        $usuario->setNombre('Admin');
        $usuario->setApellido1('Sistema');
        $usuario->setApellido2('EduKey');
        $usuario->setEmail('admin@edukey.com');
        $usuario->setRoles(['ROLE_ADMIN']);

        // Hasheamos la contraseña "admin123"
        $password = $this->hasher->hashPassword($usuario, 'admin123');
        $usuario->setPassword($password);

        $manager->persist($usuario);

        $usuario = new Usuario();
        $usuario->setUsername('user');
        $usuario->setNombre('User');
        $usuario->setApellido1('Sistema');
        $usuario->setApellido2('EduKey');
        $usuario->setEmail('user@edukey.com');
        $usuario->setRoles(['ROLE_USER']);

        // Hasheamos la contraseña "admin123"
        $password = $this->hasher->hashPassword($usuario, 'admin123');
        $usuario->setPassword($password);

        $manager->persist($usuario);
        $manager->flush();
    }
}

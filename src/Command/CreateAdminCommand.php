<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Create a new administrator',
)]
class CreateAdminCommand{

    public function __construct(private EntityManagerInterface $entityManager,
                                private UserPasswordHasherInterface $userPasswordHasher) { }

    public function __invoke(
        SymfonyStyle $io,
        #[Argument('username')] string $name,
        #[Argument('Password')] string $password,
    ): int {

        $admin = new User();
        $admin->setUsername($name);
        $admin->setPassword(
            $this->userPasswordHasher->hashPassword(
                $admin,
                $password
            )
        );
        $admin->setRoles(['ROLE_ADMIN']);

        try {
            $this->entityManager->persist($admin);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            $io->error('Error creating admin: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $io->success('Admin created successfully');
        return Command::SUCCESS;
    }
}

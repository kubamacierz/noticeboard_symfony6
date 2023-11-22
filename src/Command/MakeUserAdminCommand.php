<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:promote',
    description: 'A command to give ROLE_ADMIN role to a specified user'
)]
class MakeUserAdminCommand extends Command
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, string $name = null)
    {
        parent::__construct($name);

        $this->em = $em;
    }

    protected function configure()
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'Type user username');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $username = $input->getArgument('username');

        /** @var User $user */
        $user = $this->em->getRepository(User::class)->findOneBy(['username' => $username]);

        $user->addRole('ROLE_ADMIN');
        $this->em->flush();

        return Command::SUCCESS;
    }

}

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
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'app:promote',
    description: 'A command to give specified user a ROLE_ADMIN role'
)]
class MakeUserAdminCommand extends Command
{
    private $em;
    private $serial;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $em, string $name = null)
    {
        parent::__construct($name);

        $this->em = $em;
        $this->serial = $serializer;
    }

    protected function configure()
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'Type user username');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $username = $input->getArgument('username');


        $user = $this->em->getRepository(User::class)->findBy(['username' => $username]);
        var_dump($user);
//        return Command::SUCCESS;
    }

}

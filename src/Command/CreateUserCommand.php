<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * @var OutputInterface
     */
    private OutputInterface $output;

    /**
     * CreateUserCommand constructor.
     *
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        EntityManagerInterface $manager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        parent::__construct(null);

        $this->manager = $manager;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function configure()
    {
        $this
            ->setName('app:create-user')
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user.')
            ->addOption(
                'username',
                'u',
                InputOption::VALUE_REQUIRED,
                'Username of user',
            )
            ->addOption(
                'nickname',
                null,
                InputOption::VALUE_OPTIONAL,
                'Nickname of user',
            )
            ->addOption(
                'password',
                'p',
                InputOption::VALUE_REQUIRED,
                'Password of user',
            )
        ;
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->output = $output;

        $username = $input->getOption('username');
        $nickname = $input->getOption('nickname');
        $password = $input->getOption('password');

        if (empty($username)) {
            $this->displayError('You must input "username"!');

            return 1;
        }
        if (!preg_match('/^[a-z0-9]{3,}/', $username)) {
            $this->displayError('Username can only contain lowercase letters and numbers, min length: 3');

            return 1;
        }
        if (empty($password)) {
            $this->displayError('You must input "password"!');

            return 1;
        }
        if (6 > strlen($password)) {
            $this->displayError('Password must contain at least 6 characters.');

            return 1;
        }

        $userRepo = $this->manager->getRepository(User::class);
        $existUser = $userRepo->findOneBy(['username' => $username]);

        if ($existUser instanceof User) {
            $this->displayError('Username already exist.');

            return 1;
        }

        $user = new User();
        $user
            ->setUsername(strtolower($username))
            ->setNickname(empty($nickname) ? $username : $nickname)
            ->setPlainPassword($password);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
        $this->manager->persist($user);
        $this->manager->flush();

        $this->displayInfo('User has been successfully created!');

        return 0;
    }

    /**
     * @param string $message
     */
    private function displayError(string $message)
    {
        $message = '  Error: ' . $message . '  ';
        $length = strlen($message);

        $this->output->writeln(
            [
                '',
                '<error>' . str_repeat(' ', $length) . '</error>',
                '<error>' . $message . '</error>',
                '<error>' . str_repeat(' ', $length) . '</error>',
                '',
            ]
        );
    }

    /**
     * @param string $message
     */
    private function displayInfo(string $message)
    {
        $message = '  ' . $message . '  ';
        $length = strlen($message);

        $this->output->writeln(
            [
                '',
                '<bg=green;fg=black>' . str_repeat(' ', $length) . '</>',
                '<bg=green;fg=black>' . $message . '</>',
                '<bg=green;fg=black>' . str_repeat(' ', $length) . '</>',
                '',
            ]
        );
    }
}

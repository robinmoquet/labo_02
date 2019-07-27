<?php


namespace App\Security;


use App\Entity\User;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\LockedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    /**
     * {@inheritDoc}
     */
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        $statsUser = $user->getStatsUser();
        $isBlocked = $statsUser->getBlocked();
        if ($isBlocked) {
            try {
                // maintenant moins le temps durant lequel le compte a etais bloqué
                $now = (new \DateTime("now"))->sub(new \DateInterval("PT" . $statsUser::TIME_BLOCKED . "M"));
            } catch (\Exception $e) {
                return;
            }

            if ($statsUser->getBlockedAt() > $now) {
                throw new LockedException('Votre compte est temporairement bloqué !');
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function checkPostAuth(UserInterface $user)
    {
        return;
    }
}
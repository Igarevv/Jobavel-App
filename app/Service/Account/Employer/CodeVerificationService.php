<?php

declare(strict_types=1);

namespace App\Service\Account\Employer;

use App\Events\ContactEmailUpdatedEvent;
use App\Exceptions\AppException\InvalidVerificationCodeException;
use App\Exceptions\AppException\UnknownUserTryToVerifyCodeException;
use App\Exceptions\AppException\VerificationCodeTimeExpiredException;
use App\Persistence\Contracts\VerificationCodeRepositoryInterface;

class CodeVerificationService
{
    public function __construct(
        protected VerificationCodeRepositoryInterface $verificationRepository
    ) {
    }

    public function verifyCodeFromRequest(int $code, string $user_id): void
    {
        $verificationData = $this->verificationRepository->getCodeByUserId($user_id);

        if (! $verificationData) {
            throw new UnknownUserTryToVerifyCodeException();
        }

        if (now() > $verificationData->expires_at) {
            $this->regenerateExpiredCode($user_id, $verificationData->new_contact_email);
        }

        $this->ensureCodesAreSame($code, $verificationData->code);

        $this->verificationRepository->setNewEmployerContactEmail($user_id, $verificationData->new_contact_email);
    }

    public function sendEmail(string $userId, string $email): bool
    {
        $code = $this->verificationRepository
            ->saveVerificationCode($userId, $email, $this->generateCode());

        event(new ContactEmailUpdatedEvent($code, $email));

        return true;
    }

    public function resendEmail(string $userId): void
    {
        $newCode = $this->generateCode();

        $this->verificationRepository->updateCodeForResendingAction($newCode, $userId);

        $verificationData = $this->verificationRepository->getCodeByUserId($userId);

        if (! $verificationData || $verificationData->code !== $newCode) {
            throw new UnknownUserTryToVerifyCodeException();
        }

        event(new ContactEmailUpdatedEvent($newCode, $verificationData->new_contact_email));
    }

    public function discardEmailChanges(string $userId): void
    {
        $this->verificationRepository->deleteCode($userId);
    }

    protected function regenerateExpiredCode(string $userId, string $email): void
    {
        $this->sendEmail($userId, $email);

        throw new VerificationCodeTimeExpiredException('Verification code time expired. New code was sent by email');
    }

    protected function ensureCodesAreSame(int $code, int $codeFromDb): void
    {
        if ($code !== $codeFromDb) {
            throw new InvalidVerificationCodeException('Invalid code. Please, try again');
        }
    }

    protected function generateCode(): int
    {
        return random_int(100_000, 999_999);
    }

}
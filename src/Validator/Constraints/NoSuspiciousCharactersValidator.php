// src/Validator/Constraints/NoSuspiciousCharactersValidator.php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoSuspiciousCharactersValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!is_string($value)) {
            return;
        }

        // Define your logic to check for suspicious characters here
        // For example, you might use a regular expression
        if (preg_match('/[<>{}()]/', $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}

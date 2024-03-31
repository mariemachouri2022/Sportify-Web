// src/Validator/Constraints/NoSuspiciousCharacters.php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoSuspiciousCharacters extends Constraint
{
    public $message = 'The value contains suspicious characters: "{{ value }}"';
}

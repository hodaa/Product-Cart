<?php

namespace App\Validations;

interface ValidatorInterface
{
    public function validate($params): bool;
}

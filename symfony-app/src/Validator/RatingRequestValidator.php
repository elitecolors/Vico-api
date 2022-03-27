<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;

final class RatingRequestValidator
{
    /**
     * @Assert\NotNull
     * @Assert\NotBlank()
     */
    public int $project_id;

    /**
     * @Assert\NotNull
     * @Assert\Valid
     */
    public RatingDataDTO $ratingData;
}

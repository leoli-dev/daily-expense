<?php

namespace App\Entity\Traits;

use App\Model\FlowType;
use Doctrine\ORM\Mapping as ORM;

trait FlowTypeTrait
{
    /**
     * @ORM\Column(type="smallint")
     *
     * @var int
     */
    protected int $flowType;

    /**
     * @return int
     */
    public function getFlowType(): int
    {
        return $this->flowType;
    }

    /**
     * @param int $flowType
     *
     * @return self
     */
    public function setFlowType(int $flowType): self
    {
        if (!in_array($flowType, FlowType::OPTIONS)) {
            throw new \LogicException(
                sprintf('Invalid Flow Type: %d', $flowType)
            );
        }

        $this->flowType = $flowType;

        return $this;
    }
}

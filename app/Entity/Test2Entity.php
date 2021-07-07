<?php

namespace App\Entity;

use Codememory\Components\Database\ORM\Construction as ORM;

/**
 * Class Test2Entity
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repository: '')]
#[ORM\Table(name: 'test2')]
class Test2Entity
{

    private ?int $t2id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'col1', type: 'text', length: 255, nullable: false)]
    private ?string $col1 = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'col2', type: 'text', length: 255, nullable: false)]
    private ?string $col2 = null;

    /**
     * @return string|null
     */
    public function getCol1(): ?string
    {

        return $this->col1;
    }

    /**
     * @param string|null $col1
     */
    public function setCol1(?string $col1): void
    {

        $this->col1 = $col1;
    }

    /**
     * @return string|null
     */
    public function getCol2(): ?string
    {

        return $this->col2;
    }

    /**
     * @param string|null $col2
     */
    public function setCol2(?string $col2): void
    {

        $this->col2 = $col2;
    }

}
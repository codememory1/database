<?php

namespace App\Entity;

use App\Respository\TestRepository;
use Codememory\Components\Database\ORM\Construction as ORM;

/**
 * Class TestEntity
 *
 * @package App\Entity
 *
 * @author  Codemmeory
 */
#[ORM\Entity(repository: TestRepository::class)]
#[ORM\Table(name: 'test')]
class TestEntity
{

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'id', type: 'varchar', length: 20, nullable: false, charset: 'utf8_general_ci')]
    #[ORM\AI]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'name', type: 'text', length: 255, nullable: true)]
    #[ORM\DefaultValue(defaultValue: 'Danil')]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'text', type: 'text', nullable: false)]
    private ?string $text = null;

    /**
     * @var Test2Entity|null
     */
    #[ORM\Join(entity: Test2Entity::class, columns: ['col1', 'col2', 't2id'])]
    private ?Test2Entity $test2 = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {

        return $this->name;

    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {

        $this->name = $name;

    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {

        return $this->text;

    }

    /**
     * @param string|null $text
     */
    public function setText(?string $text): void
    {

        $this->text = $text;

    }

}
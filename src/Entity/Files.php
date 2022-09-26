<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Mapping\EntityBase;

/**
 * Files
 *
 * @ORM\Table(name="files")
 * @ORM\Entity()
 */
class Files extends EntityBase
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $tempFile;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $alt;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Articles", inversedBy="medias", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $article;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTempFile(): ?string
    {
        return $this->tempFile;
    }

    public function setTempFile(string $tempFile): self
    {
        $this->tempFile = $tempFile;
        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;
        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getArticle(): ?Articles
    {
        return $this->article;
    }

    public function setArticle(?Articles $article): self
    {
        $this->article = $article;

        return $this;
    }

}

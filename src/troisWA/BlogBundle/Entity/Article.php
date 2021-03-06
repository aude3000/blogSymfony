<?php

namespace troisWA\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="troisWA\BlogBundle\Entity\ArticleRepository")
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="articleId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    private $articleId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="articleDate", type="datetime")
     */
    private $articleDate;

    /**
     * @var string
     *
     * @ORM\Column(name="articleTitle", type="string", length=255)
     */
    private $articleTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="articleContent", type="text")
     */
    private $articleContent;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="troisWA\BlogBundle\Entity\Category")
     * @ORM\JoinColumn(name="categoryId", referencedColumnName="categoryId")
     */
    private $Category;

    /**
     * on insère le __construct() avant les getter et les setter
     * Quand on sera dans le controller, celui-ci pourra générer un formulaire automatiquement qu'il mettra à la vue et que celui-ci puisse utiliser Doctrine pour définir une entité*/
    public function __construct()
    {
        $this->articleDate = new \DateTime();
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set erticleId
     *
     * @param integer $erticleId
     * @return Article
     */
    /* on désactive cette fonction car il y a une strategy AUTO d'auto-incrémentation
    public function setErticleId($erticleId)
    {
        $this->erticleId = $erticleId;

        return $this;
    }

    /**
     * Get erticleId
     *
     * @return integer 
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * Set articleDate
     *
     * @param \DateTime $articleDate
     * @return Article
     */
    public function setArticleDate($articleDate)
    {
        $this->articleDate = $articleDate;

        return $this;
    }

    /**
     * Get articleDate
     *
     * @return \DateTime 
     */
    public function getArticleDate()
    {
        return $this->articleDate;
    }

    /**
     * Set articleTitle
     *
     * @param string $articleTitle
     * @return Article
     */
    public function setArticleTitle($articleTitle)
    {
        $this->articleTitle = $articleTitle;
        //Pour transformer le string tout en majuscule
        //On peut le mettre là ou dans le "if($form->handleRequest($request)->isValid() === true)" du ArticleContrôller
        $this->articleTitle = strtoupper($articleTitle);

        return $this;
    }

    /**
     * Get articleTitle
     *
     * @return string 
     */
    public function getArticleTitle()
    {
        return $this->articleTitle;
    }

    /**
     * Set articleContent
     *
     * @param string $articleContent
     * @return Article
     */
    public function setArticleContent($articleContent)
    {
        $this->articleContent = $articleContent;

        return $this;
    }

    /**
     * Get articleContent
     *
     * @return string 
     */
    public function getArticleContent()
    {
        return $this->articleContent;
    }



    /**
     * Set Category
     *
     * @param \TroisWA\BlogBundle\Entity\Category $category
     * @return Article
     */
    public function setCategory(\TroisWA\BlogBundle\Entity\Category $category = null)
    {
        $this->Category = $category;

        return $this;
    }

    /**
     * Get Category
     *
     * @return \TroisWA\BlogBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->Category;
    }
}

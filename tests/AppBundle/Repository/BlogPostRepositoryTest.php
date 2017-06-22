<?php
/**
 * Created by PhpStorm.
 * User: evis
 * Date: 6/22/17
 * Time: 10:46 AM
 */

namespace Tests\AppBundle\Repository;

use AppBundle\Entity\BlogPost;
use AppBundle\Test\DoctrineDependableTestCase;

class BlogPostRepositoryTest extends DoctrineDependableTestCase
{
    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->createUser("filan.fisteku2@gmail.com", "I<3Pizza");
    }

    public function testBlogPostRepository()
    {
        $this->createBlogPosts();
        $queryBuilder = $this->em->getRepository("AppBundle:BlogPost")->findAllQueryBuilder();
        $blogPosts = $queryBuilder->getQuery()->execute();

        $this->assertInternalType("array", $blogPosts);
        $this->assertInstanceOf("AppBundle\Entity\BlogPost", $blogPosts[0]);
        $this->assertEquals(9, count($blogPosts));

        $queryBuilder = $this->em->getRepository("AppBundle:BlogPost")->findAllQueryBuilder("Published Blog Article_1");
        $blogPosts = $queryBuilder->getQuery()->execute();

        $this->assertInternalType("array", $blogPosts);
        $this->assertInstanceOf("AppBundle\Entity\BlogPost", $blogPosts[0]);
        $this->assertEquals(1, count($blogPosts));

        $blogPosts = $this->em->getRepository("AppBundle:BlogPost")->findAllPublishedOrderedByPublishedDate();
        $this->assertInternalType("array", $blogPosts);
        $this->assertInstanceOf("AppBundle\Entity\BlogPost", $blogPosts[0]);
        $this->assertEquals(3, count($blogPosts));

        $category = $this->em->getRepository("AppBundle:Category")->findOneBy(["name" => "Category2"]);
        $this->assertNotNull($category);
        $this->assertInstanceOf("AppBundle\Entity\Category", $category);
        $queryBuilder = $this->em->getRepository("AppBundle:BlogPost")->findAllByCategoryQueryBuilder($category);
        $blogPosts = $queryBuilder->getQuery()->execute();
        $this->assertInternalType("array", $blogPosts);
        $this->assertInstanceOf("AppBundle\Entity\BlogPost", $blogPosts[0]);
        $this->assertEquals(3, count($blogPosts));
        $this->assertInstanceOf("AppBundle\Entity\Category", $blogPosts[0]->getCategory());
    }

    public function createBlogPosts()
    {
        $category = $this->createCategory("Category1");
        for ($i = 1; $i < 4; $i++) {
            $article = new BlogPost();
            $article->setTitle("Published Blog Article_".$i);
            $article->setCategory($category);
            $article->setSummary("TEST SUMMARY");
            $article->setContent("TEST CONTENT");
            $article->setPublishedAt(new \DateTime());
            $article->setIsPublished(true);
            $article->setUser($this->createdUser);
            $this->em->persist($article);
        }

        for ($i = 4; $i < 7; $i++) {
            $article = new BlogPost();
            $article->setTitle("Published Blog Article_".$i);
            $article->setCategory($category);
            $article->setSummary("TEST SUMMARY");
            $article->setContent("TEST CONTENT");
            $article->setPublishedAt(new \DateTime());
            $article->setIsPublished(false);
            $article->setUser($this->createdUser);
            $this->em->persist($article);
        }

        $category = $this->createCategory("Category2");
        for ($i = 7; $i < 10; $i++) {
            $article = new BlogPost();
            $article->setTitle("Published Blog Article_".$i);
            $article->setCategory($category);
            $article->setSummary("TEST SUMMARY");
            $article->setContent("TEST CONTENT");
            $article->setPublishedAt(new \DateTime());
            $article->setIsPublished(false);
            $article->setUser($this->createdUser);
            $this->em->persist($article);
        }

        $this->em->flush();
    }
}

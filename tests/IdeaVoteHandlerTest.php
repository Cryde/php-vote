<?php

namespace App\Tests;

use App\Entity\Idea;
use App\Entity\User;
use App\Entity\Vote;
use App\Repository\VoteRepository;
use App\Services\VotableClassNameResolver;
use App\Services\VoteFactory;
use App\Services\VoteFinder;
use App\Services\VoteHandler;
use App\Services\VoteManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class IdeaVoteHandlerTest extends TestCase
{
    public function testHandleNewIdeaVote()
    {
        $votableClassNameResolver = $this->votableClassNameResolverMock(2);

        $voteHandler = new VoteHandler(
            new VoteFinder($votableClassNameResolver, $this->voteRepositoryMockNull()),
            new VoteManager($this->entityManagerMockVote()),
            new VoteFactory($votableClassNameResolver)
        );

        $idea = (new Idea())
            ->setTotalVoteUp(10)
            ->setTotalVoteDown(5);

        $user = new User();

        $this->assertSame(10, $idea->getTotalVoteUp());
        $this->assertSame(5, $idea->getTotalVoteDown());

        $voteHandler->handleVote($idea, $user, 1);

        $this->assertSame(11, $idea->getTotalVoteUp());
        $this->assertSame(5, $idea->getTotalVoteDown());
    }

    public function testHandleExistingIdeaVoteWithSameVote()
    {
        $votableClassNameResolver = $this->votableClassNameResolverMock(1);

        $idea = (new Idea())
            ->setTotalVoteUp(10)
            ->setTotalVoteDown(5);

        $user = new User();

        $vote = (new Vote())->setUser($user)->setIdea($idea)->setValue(1);

        $voteHandler = new VoteHandler(
            new VoteFinder($votableClassNameResolver, $this->voteRepositoryMock($vote)),
            new VoteManager($this->entityManagerMockVote(0, 1)),
            new VoteFactory($votableClassNameResolver)
        );

        $this->assertSame(10, $idea->getTotalVoteUp());
        $this->assertSame(5, $idea->getTotalVoteDown());

        // user vote again +1 so we should remove his vote
        $voteHandler->handleVote($idea, $user, 1);

        $this->assertSame(9, $idea->getTotalVoteUp());
        $this->assertSame(5, $idea->getTotalVoteDown());
    }

    public function testHandleExistingIdeaVoteWithOppositeVote()
    {
        $votableClassNameResolver = $this->votableClassNameResolverMock(1);

        $idea = (new Idea())
            ->setTotalVoteUp(10)
            ->setTotalVoteDown(5);

        $user = new User();

        $vote = (new Vote())->setUser($user)->setIdea($idea)->setValue(1);

        $voteHandler = new VoteHandler(
            new VoteFinder($votableClassNameResolver, $this->voteRepositoryMock($vote)),
            new VoteManager($this->entityManagerMockVote(0, 1)),
            new VoteFactory($votableClassNameResolver)
        );

        $this->assertSame(10, $idea->getTotalVoteUp());
        $this->assertSame(5, $idea->getTotalVoteDown());

        // user vote -1 so we should remove his vote from up and add to down
        $voteHandler->handleVote($idea, $user, -1);

        $this->assertSame(9, $idea->getTotalVoteUp());
        $this->assertSame(6, $idea->getTotalVoteDown());
    }

    private function voteRepositoryMock($vote)
    {
        $mock = $this->getMockBuilder(VoteRepository::class)->disableOriginalConstructor()->getMock();

        $mock->expects($this->once())
             ->method('findOneBy')
             ->willReturn($vote);

        /** @var VoteRepository $mock */
        return $mock;
    }

    private function voteRepositoryMockNull()
    {
        $mock = $this->getMockBuilder(VoteRepository::class)->disableOriginalConstructor()->getMock();

        $mock->expects($this->once())
             ->method('findOneBy')
             ->willReturn(null);

        /** @var VoteRepository $mock */
        return $mock;
    }

    private function entityManagerMockVote($persistCall = 1, $flushCall = 1)
    {
        $mock = $this->getMockBuilder(EntityManagerInterface::class)->disableOriginalConstructor()->getMock();

        $mock->expects($this->exactly($persistCall))
             ->method('persist');

        $mock->expects($this->exactly($flushCall))
             ->method('flush');

        /** @var EntityManagerInterface $mock */
        return $mock;
    }

    private function votableClassNameResolverMock($numberOfCall)
    {
        $mock = $this->getMockBuilder(VotableClassNameResolver::class)->disableOriginalConstructor()->getMock();

        $mock->expects($this->exactly($numberOfCall))
             ->method('getName')
             ->willReturn(Idea::class);

        /** @var VotableClassNameResolver $mock */
        return $mock;
    }
}

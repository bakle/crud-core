<?php declare(strict_types=1);

namespace Tests\Integration;


use Bakle\CrudCore\Exceptions\ModelTypeException;
use Tests\BaseTestCase;
use Tests\Utils\Entities\UserEntity;
use Tests\Utils\Factories\CommentFactory;
use Tests\Utils\Factories\PostFactory;
use Tests\Utils\Factories\UserFactory;
use Tests\Utils\Presenters\UserPostCommentUrlPresenter;
use Tests\Utils\Presenters\UserUrlPresenter;

class UrlPresenterIntegrationTest extends BaseTestCase
{
    public function testItReturnsResolvedUrlsForOneParam(): void
    {
        $user = UserFactory::new()->make();

        $urlPresenter = new UserUrlPresenter($user);

        $this->assertEquals($urlPresenter->index(), route('users.index'));
        $this->assertEquals($urlPresenter->show(), route('users.show', $user->id));
        $this->assertEquals($urlPresenter->edit(), route('users.edit', $user->id));
        $this->assertEquals($urlPresenter->update(), route('users.update', $user->id));
        $this->assertEquals($urlPresenter->create(), route('users.create'));
        $this->assertEquals($urlPresenter->store(), route('users.store'));
        $this->assertEquals($urlPresenter->destroy(), route('users.destroy', $user->id));
    }

    public function testItReturnsResolvedUrlsForMoreThanOneParam(): void
    {
        $user = UserFactory::new()->create();
        $post = PostFactory::new()->create();
        $comment = CommentFactory::new()->make();

        $urlPresenter = new UserPostCommentUrlPresenter($user, $post, $comment);

        $this->assertEquals($urlPresenter->index(), route('users.posts.comments.index', [$user, $post]));
        $this->assertEquals($urlPresenter->show(), route('users.posts.comments.show', [$user, $post, $comment]));
        $this->assertEquals($urlPresenter->edit(), route('users.posts.comments.edit', [$user, $post, $comment]));
        $this->assertEquals($urlPresenter->update(), route('users.posts.comments.update', [$user, $post, $comment]));
        $this->assertEquals($urlPresenter->create(), route('users.posts.comments.create', [$user, $post]));
        $this->assertEquals($urlPresenter->store(), route('users.posts.comments.store', [$user, $post]));
        $this->assertEquals($urlPresenter->destroy(), route('users.posts.comments.destroy', [$user, $post, $comment]));
    }

    public function testItUsesRouteKeyValue(): void
    {
        $user = UserFactory::new()->create();
        $post = PostFactory::new()->create();
        $comment = CommentFactory::new()->make();

        $urlPresenter = new UserPostCommentUrlPresenter($user, $post, $comment);

        $this->assertStringContainsString("users/$user->id/posts/$post->slug", $urlPresenter->index());
    }

    public function testItShoudThrowAndExceptionIfOneOfPassedEntitiesAreTheWrongType(): void
    {
        $user = UserFactory::new()->make();
        $comment = CommentFactory::new()->make();

        $this->expectException(ModelTypeException::class);
        new UserPostCommentUrlPresenter($user, [], $comment);
    }

}

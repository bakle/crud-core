<?php declare(strict_types=1);

namespace Tests\Integration;


use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Tests\BaseTestCase;
use Tests\Utils\Entities\UserEntity;
use Tests\Utils\Factories\UserFactory;
use Tests\Utils\Models\User;
use Tests\Utils\ViewModels\UserIndexViewModel;

class UserIndexViewModelIntegrationTest extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->defineViews();
    }

    public function testItShouldGetTheCorrectIndexData(): void
    {
        $user = UserFactory::new()->count(3)->create();
        $userQuery = User::query();

        $userIndexViewModel = new UserIndexViewModel($userQuery, new Request());
        $data = $userIndexViewModel->build();

        $this->assertCount(3, $data['entities']);
        $this->assertInstanceOf(Htmlable::class, $data['pagination']);
        $this->assertEquals(trans('Users'), $data['title']);

        $data['entities']->each(function ($item) use ($user) {
            $this->assertInstanceOf(UserEntity::class, $item);
            $this->assertContains($item->getId(), $user->pluck('id'));
        });
    }

    public function testItShouldBuildFormViewModelWithView(): void
    {
        $user = UserFactory::new()->count(3)->create();
        $userQuery = User::query();
        $userIndexViewModel = new UserIndexViewModel($userQuery, new Request());
        $response = $userIndexViewModel->buildWithView('test');
        $data = $response->getData();

        $this->assertInstanceOf(View::class, $response);
        $this->assertCount(3, $data['entities']);
        $this->assertInstanceOf(Htmlable::class, $data['pagination']);
        $this->assertEquals(trans('Users'), $data['title']);
    }

}

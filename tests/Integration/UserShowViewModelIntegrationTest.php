<?php declare(strict_types=1);

namespace Tests\Integration;


use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Tests\BaseTestCase;
use Tests\Utils\Entities\UserEntity;
use Tests\Utils\Factories\UserFactory;
use Tests\Utils\Models\User;
use Tests\Utils\ViewModels\UserIndexViewModel;
use Tests\Utils\ViewModels\UserShowViewModel;

class UserShowViewModelIntegrationTest extends BaseTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->defineViews();
    }

    public function testItShouldGetTheCorrectShowData(): void
    {
        $user = UserFactory::new()->create();

        $userShowViewModel = new UserShowViewModel($user);
        $data = $userShowViewModel->build();

        $this->assertInstanceOf(UserEntity::class, $data['entity']);
        $this->assertEquals(trans('User'), $data['title']);
    }

    public function testItShouldBuildFormViewModelWithView(): void
    {
        $user = UserFactory::new()->create();

        $userShowViewModel = new UserShowViewModel($user);
        $response = $userShowViewModel->buildWithView('test');
        $data = $response->getData();

        $this->assertInstanceOf(View::class, $response);
        $this->assertInstanceOf(UserEntity::class, $data['entity']);
        $this->assertEquals(trans('User'), $data['title']);
    }

}

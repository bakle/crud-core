<?php declare(strict_types=1);

namespace Tests\Integration;


use Bakle\CrudCore\Core\Enums\FormMethods;
use Bakle\CrudCore\Core\Enums\FormTypes;
use Bakle\CrudCore\Core\Forms\Form;
use Illuminate\View\View;
use Tests\BaseTestCase;
use Tests\Utils\Entities\UserEntity;
use Tests\Utils\Factories\UserFactory;
use Tests\Utils\Models\Post;
use Tests\Utils\Models\User;
use Tests\Utils\ViewModels\UserFormViewModel;

class UserFormViewModelIntegrationTest extends BaseTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->defineViews();
    }

    public function testItShouldGetTheCorrectFormData(): void
    {
        $user = UserFactory::new()->make();
        $formViewModel = new UserFormViewModel(FormTypes::CREATE, new User());
        $userEntity = new UserEntity($user);

        $form = $formViewModel->getForm();

        $this->assertTrue($form->isCreateType());
        $this->assertEquals($userEntity->url()->store(), $form->getUrl());
        $this->assertEquals(FormMethods::POST->value, $form->getMethod());

    }

    public function testItShouldBuildFormViewModel(): void
    {
        $formViewModel = new UserFormViewModel(FormTypes::CREATE, new User());

        $data = $formViewModel->build();

        $this->assertInstanceOf(UserEntity::class, $data['entity']);
        $this->assertInstanceOf(Form::class, $data['form']);
        $this->assertEquals('Create User', $data['title']);
        $this->assertInstanceOf(Post::class, $data['post']);
    }

    public function testItShouldBuildFormViewModelWithView(): void
    {
        $formViewModel = new UserFormViewModel(FormTypes::CREATE, new User());
        $response = $formViewModel->buildWithView('test');
        $data = $response->getData();

        $this->assertInstanceOf(View::class, $response);
        $this->assertInstanceOf(UserEntity::class, $data['entity']);
        $this->assertInstanceOf(Form::class, $data['form']);
        $this->assertEquals('Create User', $data['title']);
        $this->assertInstanceOf(Post::class, $data['post']);
    }
}

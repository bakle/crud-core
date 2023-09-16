<?php declare(strict_types=1);

namespace Tests\Integration;


use Bakle\LskCore\Core\Enums\FormMethods;
use Bakle\LskCore\Core\Enums\FormTypes;
use Bakle\LskCore\Core\Forms\Form;
use Tests\BaseTestCase;
use Tests\Utils\Entities\UserEntity;
use Tests\Utils\Factories\UserFactory;
use Tests\Utils\Models\Post;
use Tests\Utils\Models\User;
use Tests\Utils\Presenters\UserUrlPresenter;
use Tests\Utils\ViewModels\UserFormViewModel;

class UserFormViewModelIntegrationTest extends BaseTestCase
{
    public function testItShouldGetTheCorrectFormData(): void
    {
        $user = UserFactory::new()->make();
        $formViewModel = new UserFormViewModel(FormTypes::CREATE, new User());
        $userEntity = new UserEntity($user);

        $form = $formViewModel->getForm();

        $this->assertTrue($form->isCreateType());
        $this->assertEquals($userEntity->url()->store(),  $form->getUrl());
        $this->assertEquals(FormMethods::POST->value,  $form->getMethod());

    }

    public function testItShouldBuildFormViewModel(): void
    {
        $user = UserFactory::new()->make();
        $formViewModel = new UserFormViewModel(FormTypes::CREATE, new User());

        $data = $formViewModel->build();

        $this->assertInstanceOf(UserEntity::class, $data['entity']);
        $this->assertInstanceOf(Form::class, $data['form']);
        $this->assertEquals('Create User', $data['title']);
        $this->assertInstanceOf(Post::class, $data['post']);
    }
}

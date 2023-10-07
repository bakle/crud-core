<?php declare(strict_types=1);

namespace Tests\Integration;


use Bakle\LskCore\Core\Enums\FormMethods;
use Bakle\LskCore\Core\Enums\FormTypes;
use Bakle\LskCore\Core\Forms\Form;
use Tests\BaseTestCase;
use Tests\Utils\Entities\UserEntity;
use Tests\Utils\Factories\UserFactory;
use Tests\Utils\Models\User;
use Tests\Utils\Presenters\UserUrlPresenter;

class FormIntegrationTest extends BaseTestCase
{
    public function testItShouldGetUrl(): void
    {
        $user = UserFactory::new()->make();
        $userEntity = new UserEntity($user);

        $form = new Form($userEntity->url()->create(), FormTypes::CREATE);

        $this->assertEquals($userEntity->url()->create(), $form->getUrl());
    }

    public function testItShouldGetTypeValue(): void
    {
        $user = UserFactory::new()->make();
        $userEntity = new UserEntity($user);

        $form = new Form($userEntity->url()->create(), FormTypes::CREATE);

        $this->assertEquals(FormTypes::CREATE->value, $form->getType());
    }

    public function testItShouldValidateIsCreateType(): void
    {
        $user = UserFactory::new()->make();
        $userEntity = new UserEntity($user);

        $form = new Form($userEntity->url()->create(), FormTypes::CREATE);

        $this->assertTrue($form->isCreateType());
        $this->assertFalse($form->isEditType());
    }

    public function testItShouldValidateIsEditType(): void
    {
        $user = UserFactory::new()->make();
        $userEntity = new UserEntity($user);

        $form = new Form($userEntity->url()->create(), FormTypes::EDIT);

        $this->assertTrue($form->isEditType());
        $this->assertFalse($form->isCreateType());
    }

    public function testItShouldGetPutMethodIfTypeIsEdit(): void
    {
        $user = UserFactory::new()->make();
        $userEntity = new UserEntity($user);

        $form = new Form($userEntity->url()->create(), FormTypes::EDIT);

        $this->assertEquals(FormMethods::PUT->value, $form->getMethod());
    }

    public function testItShouldGetPostMethodIfTypeIsCreate(): void
    {
        $user = UserFactory::new()->make();
        $userEntity = new UserEntity($user);

        $form = new Form($userEntity->url()->create(), FormTypes::CREATE);

        $this->assertEquals(FormMethods::POST->value, $form->getMethod());
    }
}

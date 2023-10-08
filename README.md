# Laravel CRUD Core

This package contains base files that contains all boilerplate logic for creating a crud.

## Installation

```shell
composer require bakle/crud-core
```

## What's inside this package?

## UrlPresenter
The url presenter encapsulate the routes that are generated in `Route::resource('users, UserController::class)`

### For one model
```php
class UserUrlPresenter extends BaseUrlPresenter
{

    function getRouteName(): string
    {
        return 'users';
    }
}

// --- Examples ---

// Url presenter for routes that doesn't depend on a specific model (index, create)
$userUrlPresenter = new UserUrlPresenter();
$userUrlPresenter->index(); // --> /users
$userUrlPresenter->create(); // --> /users/create
$userUrlPresenter->store(); // --> /users (for post method)

// Url presenter for routes that depend on a specific model (show, edit, update, delete )
$user = User::first();
$userUrlPresenter = new UserUrlPresenter($user);
$userUrlPresenter->index(); // --> /users
$userUrlPresenter->show(); // --> /users/1
$userUrlPresenter->create(); // --> /users/create
$userUrlPresenter->store(); // --> /users (for post method)
$userUrlPresenter->edit(); // --> /users/1/edit
$userUrlPresenter->update(); // --> /users/1
$userUrlPresenter->destroy(); // --> /users/1



```

### For related models
```php
class UserPostCommentUrlPresenter extends BaseUrlPresenter
{

    function getRouteName(): string
    {
        return 'users.posts.comments';
    }
}

class Post extends \Illuminate\Database\Eloquent\Model
{

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

// Example

$user = User::first();
$post = Post::first();
$comment = Comment::first();

$urlPresenter = new UserPostCommentUrlPresenter($user, $post, $comment);
$userUrlPresenter->index(); // --> /users/1/posts/the-post-slug/comments
$userUrlPresenter->show(); // --> /users/1/posts/the-post-slug/comments/1
$userUrlPresenter->create(); // --> /users/1/posts/the-post-slug/comments/create
$userUrlPresenter->store(); // --> /users/1/posts/the-post-slug/comments (for post method)
$userUrlPresenter->edit(); // --> /users/1/posts/the-post-slug/comments/1/edit
$userUrlPresenter->update(); // --> /users/1/posts/the-post-slug/comments/1
$userUrlPresenter->destroy(); // --> /users/1/posts/the-post-slug/comments/1
```

## Entities
An entity is an extra layer that wraps your model to add extra logic. The `BaseEntity` only require a `url()` method to be implemented

```php
class UserEntity extends BaseEntity
{

    public function url(): ?BaseUrlPresenter
    {
        return new UserUrlPresenter($this->model);
    }
    ... // more methods
}

// Example single model
$user = User::first();
$userEntity = new UserEntity($user);

$user->entity->getCreatedAtDayDateFormat(); // Sat, Oct 7, 2023

// Example multiple model
$users = User::all();
$userEntities = UserEntity::collection($users);

$userEntities->first()->url()->show() // /users/1

```

## View Models
View models encapsulates all the logic and data that you need to send to your views.

### IndexViewModel
This view model send to the view the following data:

* **entities:** A collection of the entities of the model defined in the `IndexViewModel` (i.e: UserEntity)
* **pagination:** Because now you receive a collection of entities and not models, this is the same as doing `$users->links`. now you can do:
    ```injectablephp
  <div class="flex w-full mt-4 justify-end">
      {!! $pagination !!}
  </div>
  ```
* **title:**: This is just the string you return  in the `getTitle()` method. It's useful in your index to add it in your blade like this:
```injectablephp
    <h1 class="text-2xl">{{ $title }}</h1>
```

#### Example
```php
class UserIndexViewModel extends BaseIndexViewModel
{
    public function getTitle(): string
    {
        return trans('Users');
    }

    public function getEntityClass(): string
    {
        return UserEntity::class;
    }
}


// In the UserController
class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()->with('roles');
    
        return view('users.index',
            (new UserIndexViewModel($users, $request))->build()
        );
    }
}

```

### ShowViewModel
This view model send to the view the following data:
* **entity:** A single entity of the model defined in the `ShowViewModel` (i.e: UserEntity)

#### Example

```php
class UserShowViewModel extends BaseShowViewModel
{
    public function getTitle(): string
    {
        return trans('User');
    }

    public function getEntityClass(): string
    {
        return UserEntity::class;
    }

    protected function getExtraData(): array
    {
        return [
            'title' => $this->getTitle()
        ];
    }
}

// In your UserController
class UserController extends Controller
{
    public function show(User $user)
    {
        $user->load('roles');
            
        return view('users.show', (new UserShowViewModel($user))->build());
    }
}
```

### FormViewModel
This view model send to the view the following data:
* **entity:** A single entity of the model defined in the `ShowViewModel` (i.e: UserEntity)
* **form:** This contains the url for submitting the form, the method type (POST or PUT) and some other helper methods. It's useful to use it in your forms like this:
```injectablephp
    <form method="POST" action="{{ $form->getUrl() }}">
        @csrf
        @method($form->getMethod())
    
    //...your fields

    <button class="btn btn-primary">
        @if($form->isEditType())
            {{ trans('Update') }}
        @else
            {{ trans('Create') }}
        @endif
    </button>
</form>
```
* **title:**: This will resolve automatically the title based on the method type. For example if you use `->setFormType(FormTypes::CREATE)`, the title will be ***Create user***, if it's `->setFormType(FormTypes::EDIT)`, the title will be ***Edit User***. You can use it like this:
```injectablephp
    <h1 class="text-2xl">{{ $title }}</h1>
```

#### Example

```php
class UserFormViewModel extends BaseFormViewModel
{

    protected function getEntityClass(): string
    {
        return UserEntity::class;
    }

    protected function getExtraData(): array
    {
        return [
            'roles' => Role::query()->get();
        ];
    }
}

// In your UserController

class UserController extends Controller
{

    public function create(): View
    {
        return view('users.form',
            (new UserFormViewModel(new User()))->setFormType(FormTypes::CREATE)->build()
        );
    }
    
    public function edit(User $user): View
    {
        return view('users.form',
            (new UserFormViewModel($user))->setFormType(FormTypes::EDIT)->build()
        );
    }
}
```

All `ViewModel` includes a method `getExtraData()` where you can return an array of extra data you need to send to the view. 

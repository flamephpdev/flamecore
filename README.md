# Welcome to Flame Core!

## What is FlameCore?

FlameCore is a PHP Framework that operates independently, free from any other code dependencies. It can be installed and run seamlessly.

## How to run?

To get started, you can clone the project using Git, or simply download the ZIP file and extract it using the following commands:

```bash
git clone https://github.com/flamephpdev/flamecore.git
```

Navigate to the project directory:
```bash
cd flamecore-main
```

Launch the development server:
```bash
php ignite serve
```

## How it works?

FlameCore has its own predefined folder structure, which currently cannot be altered. So, how can you use it?
Okay but how to use it?

Primarily, these are the folders commonly used during development:

```text
📦 FlameCore Project
    📂 app
        📂 Controllers
        📂 Models
        📂 config
        📂 ...
    📂 public
    📂 routes
    📂 views (optional)
    📜 env.php
    📜 ignite
```

That's great, but how do you get started?
First and foremost, you need to design how your application will function, including all the endpoints. Typically, developers start with creating a new route, like this:

```php
use Routing\Route;
use Cache\Views\Flame\FlameRender;

Route::get('/counter/{int:i}')->name('counter')->control(function ($i) {
    return FlameRender::textParser('
        <h1>Count {{ $i }}</h1>
        <a href="{{ $addOneLink }}">Add +1</button>
    ', ['addOneLink' => route('counter', $i)]);
});
```

This is the simplest demonstration of this framework. For more details, you can refer to the official documentation [here](https://flamephpdev.mrtn.vip).
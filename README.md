## Selector
This library allow to retrieve data from an array or a json string using selectors:

```php
<?php
use Selector\Selector;
use Selector\Parser\ArrayParser;

$data = [
    'users' => [
        'name' => 'Steve',
        'age' => 49,
    ],
    [
        'name' => 'Edward',
        'age' => 34,
    ],
];

$selector = new Selector($data, new ArrayParser);

$selector->get('users.name'); // return ['Steve', 'Edward']
$selector->get('users[1].name'); // return 'Edward'
```

## License

This library is open-sourced software licensed under the MIT license
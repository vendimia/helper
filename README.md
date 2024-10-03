# Vendimia helper classes

## `Vendimia\Helper\TextFromDocComment`

Process a DocComment, (perhaps obtained with `Reflection*::getDocComment()` method), obtaining only the text with preceding or trailing spaces or empty lines removed. Also remove an initial `*` on each line.

### `public string $text`

Processed text, also obtainable by using the class in a string context.

### `public function __construct(string $doc_comment, bool $merge_lines = true)`

* `string $doc_comment`: Original doc comment.

* `bool $merge_lines`: `true` merges continuous non-empty lines as one, joined by a single empty space. `false` returns the lines as is.

### Example

```php
use Vendimia\Helper\TextFromDocComment;

require __DIR__ . '/vendor/autoload.php';

/**
 * This is a dummy function.
 *
 * Its purpose is to hold a multiline doc comment to test the
 * Vendimia\Helper\TextFromDocComment class.
 */
function dummy()
{

}

echo (string)new TextFromDocComment(
    new ReflectionFunction(dummy(...))->getDocComment()
);
```

This outputs:

```
This is a dummy function.
Its purpose is to hold a multiline doc comment to test the Vendimia\Helper\TextFromDocComment class. 
```

On PHP prior to 8.4, you must enclose  `new ReflectionFunction(dummy(...))` on parenthesis.

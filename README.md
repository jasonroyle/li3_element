# Element Helper for Lithium

## Installation

Assuming your project is a clone of `https://github.com/UnionOfRAD/framework.git`, register li3_element as a submodule into the projects' libraries.

```
cd path/to/project
git submodule add https://github.com/jasonroyle/li3_element.git libraries/li3_element
```

Finally make the application aware of the library by adding the following to `app/config/bootstrap/libraries.php`.

```php
Libraries::add('li3_element');
```

## Usage

### Columns

Iterates through items and renders an element per item. The elements are wrapped in row and column divs and returned as a rendered HTML string.

#### Params

* `$element` (string)
* `$data` (array)
* `$options` (array, optional)

#### Return

Rendered HTML (string)

#### Examples

By default the first value of the data array will be used as the items of which to iterate through.

The following example iterates through posts, replaces the post value of the data array with the individual post and passes the data on to the element to render.

```php
echo $this->element->columns('post', ['post' => $posts]);
```

To pass more data to each of the elements simply append the data array.

```php
echo $this->element->columns('post', [
	'post' => $posts,
	'foo' => $foo,
	'bar' => $bar
]);
```

Set `per_row`, `offset` and `max` options to control how the items are displayed.

The following example renders 3 posts per row, ignores the first 2 posts and limits the amount of displayed posts to 9.

```php
echo $this->element->columns('post', ['post' => $posts], [
	'per_row' => 3,
	'offset' => 2,
	'max' => 9
]);
```

Appling attributes to rows and columns.

The following example applies the `class="row"` attribute to each row and the `class="column"` attribute to each column.

```php
echo $this->element->columns('post', ['post' => $posts], [
	'per_row' => 5,
	'row' => ['class' => 'row'],
	'column' => ['class' => 'column']
]);
```

The following example renders the same as the last except the attribute `class="column first"` is applied to every first column of each row and the attribute `class="column last"` is applied to every last column of each row.

```php
echo $this->element->columns('post', ['post' => $posts], [
	'per_row' => 5,
	'row' => ['class' => 'row'],
	'column' => ['class' => 'column'],
	'first_column' => ['class' => 'column first'],
	'last_column' => ['class' => 'column last']
]);
```

The following example renders the same as the last except the last row contains only one column. The attribute `class="column first last"` is applied to this column.

```php
echo $this->element->columns('post', ['post' => $posts], [
	'per_row' => 5,
	'max' => 11,
	'row' => ['class' => 'row'],
	'column' => ['class' => 'column'],
	'first_column' => ['class' => 'column first'],
	'last_column' => ['class' => 'column last'],
	'first_and_last_column' => ['class' => 'column first last']
]);
```

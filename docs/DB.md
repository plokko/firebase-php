# Real time database
This package includes a Firebase Realtime database REST API implementation.

First create a new `Database` instance using you ServiceAccount credentials
```php
$sa = new ServiceAccount($serviceCredentials);
$db = new Database($sa);
```

You can use the methods
 - get(string $path) - to get the value of a path
 - set(string $path,mixed $value) - to put a value in a path
 - update(string $path,mixed $value) - to update a path value
 - delete(string $path) - to delete a path from the database

```php
$example1 = $db->get('examples/1');//Get value
$db->set('examples/2',['name'=>'2','value'=>'2']);//Set value
$db->update('examples/2',['name'=>'Example 2']); //Update value
$db->delete('examples/3');//Delete path
```
You can also get a reference of a path to easly manage paths and subpaths (recommended):
all the base methods will be applied to the path relative to the reference
```php
$examples = $db->getReference('examples');//Get reference for /examples

$example1 = $examples->get('1');//Get value
$examples->set('2',['name'=>'2','value'=>'2']);//Set value
$examples->update('2',['name'=>'Example 2']); //Update value
$examples->delete('3');//Delete path
```
You can also get child references using the getReference on a reference:
```
$examples = $db->getReference('examples');//Get reference for /examples
$example1 = $examples->getReference('1'); // get reference for /examples/1
$example1name = $example1->getReference('name'); // get reference for /examples/1/name

$data1 = $example1->getData(); //get /examples/1 data (array)
```

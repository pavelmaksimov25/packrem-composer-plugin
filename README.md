### Example of composer Package

Name: `"spryker-feature/tax"`

`$package->getRequirements()`:
```php
array(4) {
["php"]=>
object(Composer\Package\Link)#21914 (5) {
["source":protected]=>
string(19) "spryker-feature/tax"
["target":protected]=>
string(3) "php"
["constraint":protected]=>
object(Composer\Semver\Constraint\Constraint)#1119 (5) {
["operator":protected]=>
int(4)
["version":protected]=>
string(11) "8.0.0.0-dev"
["prettyString":protected]=>
string(5) ">=8.0"
["lowerBound":protected]=>
NULL
["upperBound":protected]=>
NULL
}
["description":protected]=>
string(8) "requires"
["prettyConstraint":protected]=>
string(5) ">=8.0"
}
["spryker/tax"]=>
object(Composer\Package\Link)#21915 (5) {
["source":protected]=>
string(19) "spryker-feature/tax"
["target":protected]=>
string(11) "spryker/tax"
["constraint":protected]=>
object(Composer\Semver\Constraint\MultiConstraint)#6346 (6) {
["constraints":protected]=>
array(2) {
[0]=>
object(Composer\Semver\Constraint\Constraint)#6344 (5) {
["operator":protected]=>
int(4)
["version":protected]=>
string(12) "5.14.0.0-dev"
["prettyString":protected]=>
NULL
["lowerBound":protected]=>
NULL
["upperBound":protected]=>
NULL
}
[1]=>
object(Composer\Semver\Constraint\Constraint)#6345 (5) {
["operator":protected]=>
int(1)
["version":protected]=>
string(11) "6.0.0.0-dev"
["prettyString":protected]=>
NULL
["lowerBound":protected]=>
NULL
["upperBound":protected]=>
NULL
}
}
["prettyString":protected]=>
string(7) "^5.14.0"
["string":protected]=>
NULL
["conjunctive":protected]=>
bool(true)
["lowerBound":protected]=>
NULL
["upperBound":protected]=>
NULL
}
["description":protected]=>
string(8) "requires"
["prettyConstraint":protected]=>
string(7) "^5.14.0"
}
["spryker/tax-product-storage"]=>
object(Composer\Package\Link)#21916 (5) {
["source":protected]=>
string(19) "spryker-feature/tax"
["target":protected]=>
string(27) "spryker/tax-product-storage"
["constraint":protected]=>
object(Composer\Semver\Constraint\MultiConstraint)#1203 (6) {
["constraints":protected]=>
array(2) {
[0]=>
object(Composer\Semver\Constraint\Constraint)#1201 (5) {
["operator":protected]=>
int(4)
["version":protected]=>
string(11) "1.3.0.0-dev"
["prettyString":protected]=>
NULL
["lowerBound":protected]=>
NULL
["upperBound":protected]=>
NULL
}
[1]=>
object(Composer\Semver\Constraint\Constraint)#1202 (5) {
["operator":protected]=>
int(1)
["version":protected]=>
string(11) "2.0.0.0-dev"
["prettyString":protected]=>
NULL
["lowerBound":protected]=>
NULL
["upperBound":protected]=>
NULL
}
}
["prettyString":protected]=>
string(6) "^1.3.0"
["string":protected]=>
string(30) "[>= 1.3.0.0-dev < 2.0.0.0-dev]"
["conjunctive":protected]=>
bool(true)
["lowerBound":protected]=>
NULL
["upperBound":protected]=>
NULL
}
["description":protected]=>
string(8) "requires"
["prettyConstraint":protected]=>
string(6) "^1.3.0"
}
["spryker/tax-storage"]=>
object(Composer\Package\Link)#21917 (5) {
["source":protected]=>
string(19) "spryker-feature/tax"
["target":protected]=>
string(19) "spryker/tax-storage"
["constraint":protected]=>
object(Composer\Semver\Constraint\MultiConstraint)#1279 (6) {
["constraints":protected]=>
array(2) {
[0]=>
object(Composer\Semver\Constraint\Constraint)#1277 (5) {
["operator":protected]=>
int(4)
["version":protected]=>
string(11) "1.4.0.0-dev"
["prettyString":protected]=>
NULL
["lowerBound":protected]=>
NULL
["upperBound":protected]=>
NULL
}
[1]=>
object(Composer\Semver\Constraint\Constraint)#1278 (5) {
["operator":protected]=>
int(1)
["version":protected]=>
string(11) "2.0.0.0-dev"
["prettyString":protected]=>
NULL
["lowerBound":protected]=>
NULL
["upperBound":protected]=>
NULL
}
}
["prettyString":protected]=>
string(6) "^1.4.0"
["string":protected]=>
string(30) "[>= 1.4.0.0-dev < 2.0.0.0-dev]"
["conjunctive":protected]=>
bool(true)
["lowerBound":protected]=>
NULL
["upperBound":protected]=>
NULL
}
["description":protected]=>
string(8) "requires"
["prettyConstraint":protected]=>
string(6) "^1.4.0"
}
}
```

list of spryker dependencies:
```php
array(3) {
[1]=>
string(11) "spryker/tax"
[2]=>
string(27) "spryker/tax-product-storage"
[3]=>
string(19) "spryker/tax-storage"
}
```

list of modules
```php
array(3) {
[0]=>
string(3) "Tax"
[1]=>
string(17) "TaxProductStorage"
[2]=>
string(10) "TaxStorage"
}
```

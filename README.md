# Vehicle Identification Number (VIN)

Validation function written in PHP. Validates against the ISO 3779 standard.

See: http://en.wikipedia.org/wiki/Vehicle_identification_number

Example:

```
if (is_vin('1M8GDM9AXKP042788')) {
     echo 'valid';
} else {
     echo 'not valid';
}
```

This function will work for any US/Canadian automobile made after January 1st, 1980.

Tested with PHP 5.2.x however it should work with older versions.

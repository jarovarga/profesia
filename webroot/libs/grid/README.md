# CSS grid system

An extremely lightweight (only 2 kB) and highly customizable grid system.

**Breakpoints:**

```less
// max-width 640px, class xs-[0-11]
@media only screen and (max-width: 40em) { }
// min-width 641px, class sm-[0-11]
@media only screen and (min-width: 40.0625em) { }
// min-width 1025px, class md-[0-11]
@media only screen and (min-width: 64.0625em) { }
// min-width 1441px, class lg-[0-11]
@media only screen and (min-width: 90.0625em) { }
// min-width 1921px, class xl-[0-11]
@media only screen and (min-width: 120.0625em) { }
```

**Example:**

```html
<!DOCTYPE html>
<html lang="">
    <head>
        <title>CSS grid system</title>
        <meta name="viewport" content="initial-scale=1, width=device-width">
        <link href="./reset.min.css" rel="stylesheet">
        <link href="./grid.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="offset">
            <div class="grid">
                <div class="sm-8 md-6 invert"></div>
                <div class="sm-4 md-6"></div>
            </div>
            <div class="grid">
                <div class="sm-6 offset"></div>
            </div>
        </div>
    </body>
</html>
```
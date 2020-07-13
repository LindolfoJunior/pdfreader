# PdfReader

## Requirements
* [Ghostscript](https://www.ghostscript.com/) >= 9.16.
* Tesseract OCR for PHP

### Tesseract Installation

#### ![Windows](https://thiagoalessio.github.io/tesseract-ocr-for-php/images/windows-18.svg) Note for Windows users
There are many ways to install Tesseract OCR on your system, but if you just want something quick to get up and running, I recommend installing the Capture2Text package with Chocolatey.

choco install capture2text --version 3.9
> Recent versions of Capture2Text stopped shipping the tesseract binary.

#### ![macOS](https://thiagoalessio.github.io/tesseract-ocr-for-php/images/apple-18.svg) Note for macOS users
With MacPorts you can install support for individual languages, like so:

$ sudo port install tesseract-<langcode>
But that is not possible with Homebrew. It comes only with English support by default, so if you intend to use it for other language, the quickest solution is to install them all:

$ brew install tesseract --with-all-languages

### Ghostscript and Tesseract Configuration (Windows)

* Add the ghostscript's bin folder to the path environment variable:
  * <code>setx PATH "%PATH%;C:\Program Files\gs\gs9.27\bin" /M</code>
* In the ghostscript's bin folder, rename the **gswin64.exe** to **gs**

* Download the [por.traineddata](https://github.com/tesseract-ocr/tessdata/raw/4.00/por.traineddata)
* Copy the traineddata file to tessdata folder. Located at:
<code>C:\ProgramData\chocolatey\lib\capture2text\tools\Capture2Text\Utils\tesseract\tessdata</code>

## Usage

### Include autoload and import PdfReader class

```php
<?php
require 'vendor/autoload.php';
use Handle\File\PdfReader;
```

```php

// Returns an object with all details
$pdf = new PdfReader('file/path');

print_r($pdf);

echo $pdf->total_of_pages;

echo $pdf->created_at;

// Retrieve all the pages
print_r($pdf->pages);

// or one at time

echo $pdf->pages[0]; // returns the first page

echo $pdf->pages[1]; // returns the second page...
```

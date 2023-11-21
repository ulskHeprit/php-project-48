<?php

use PHPUnit\Framework\TestCase;
use function Hexlet\Code\gendiff\gendiff;
use function Hexlet\Code\Parsers\parser\parseFile;

class GendiffJSONTest extends TestCase
{
    /**
     * @covers \Hexlet\Code\gendiff\gendiff
     * @covers \Hexlet\Code\Parsers\parser\parseFile
     * @covers \Hexlet\Code\Parsers\Types\json\parseJson
     */
    public function testGendiff(): void
    {
        $arr1 = parseFile('tests/fixtures/file1.json');
        $arr2 = parseFile('tests/fixtures/file2.json');

        $expected = <<<EXP
{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}
EXP;


        $this->assertSame($expected, gendiff($arr1, $arr2));
    }
}
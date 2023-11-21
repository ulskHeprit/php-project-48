<?php

use PHPUnit\Framework\TestCase;
use function Hexlet\Code\gendiff\gendiff;

class GendiffTest extends TestCase
{
    /**
     * @covers \Hexlet\Code\gendiff\gendiff
     */
    public function testGendiff(): void
    {
        $arr1 = json_decode(file_get_contents(__DIR__ . '/fixtures/file1.json'), true);
        $arr2 = json_decode(file_get_contents(__DIR__ . '/fixtures/file2.json'), true);

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
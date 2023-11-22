<?php

use PHPUnit\Framework\TestCase;
use function Hexlet\Code\gendiff\gendiff;
use function Hexlet\Code\Parsers\parser\parseFile;

class GendiffYAMLTest extends TestCase
{
    /**
     * @covers \Hexlet\Code\gendiff\gendiff
     * @covers \Hexlet\Code\gendiff\getdiff
     * @covers \Hexlet\Code\Formatters\stylish\formatStylish
     * @covers \Hexlet\Code\Parsers\parser\parseFile
     * @covers \Hexlet\Code\Parsers\Types\yaml\parseYaml
     */
    public function testGendiff(): void
    {
        $arr1 = parseFile('tests/fixtures/file1.yaml');
        $arr2 = parseFile('tests/fixtures/file2.yaml');

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


        $this->assertSame($expected, gendiff($arr1, $arr2, 'stylish'));
    }

    /**
     * @covers \Hexlet\Code\gendiff\gendiff
     * @covers \Hexlet\Code\gendiff\getdiff
     * @covers \Hexlet\Code\Formatters\stylish\formatStylish
     * @covers \Hexlet\Code\Parsers\parser\parseFile
     * @covers \Hexlet\Code\Parsers\Types\yaml\parseYaml
     */
    public function testGendiffNested(): void
    {
        $arr1 = parseFile('tests/fixtures/file3.yaml');
        $arr2 = parseFile('tests/fixtures/file4.yaml');

        $expected = <<<EXP
{
    common: {
      + follow: false
        setting1: Value 1
      - setting2: 200
      - setting3: true
      + setting3: null
      + setting4: blah blah
      + setting5: {
            key5: value5
        }
        setting6: {
            doge: {
              - wow: 
              + wow: so much
            }
            key: value
          + ops: vops
        }
    }
    group1: {
      - baz: bas
      + baz: bars
        foo: bar
      - nest: {
            key: value
        }
      + nest: str
    }
  - group2: {
        abc: 12345
        deep: {
            id: 45
        }
    }
  + group3: {
        deep: {
            id: {
                number: 45
            }
        }
        fee: 100500
    }
}
EXP;


        $this->assertSame($expected, gendiff($arr1, $arr2, 'stylish'));
    }
}

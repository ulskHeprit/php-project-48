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
     * @covers \Hexlet\Code\Formatters\stylish\toString
     * @covers \Hexlet\Code\Parsers\parser\parseFile
     * @covers \Hexlet\Code\Parsers\Types\yaml\parseYaml
     */
    public function testGendiffStylish(): void
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
     * @covers \Hexlet\Code\Formatters\plain\formatPlain
     * @covers \Hexlet\Code\Formatters\plain\toString
     * @covers \Hexlet\Code\Parsers\parser\parseFile
     * @covers \Hexlet\Code\Parsers\Types\yaml\parseYaml
     */
    public function testGendiffPlain(): void
    {
        $arr1 = parseFile('tests/fixtures/file1.yaml');
        $arr2 = parseFile('tests/fixtures/file2.yaml');

        $expected = <<<EXP
Property 'follow' was removed
Property 'proxy' was removed
Property 'timeout' was updated. From 50 to 20
Property 'verbose' was added with value: true
EXP;

        $this->assertSame($expected, gendiff($arr1, $arr2, 'plain'));
    }

    /**
     * @covers \Hexlet\Code\gendiff\gendiff
     * @covers \Hexlet\Code\gendiff\getdiff
     * @covers \Hexlet\Code\Formatters\stylish\formatStylish
     * @covers \Hexlet\Code\Formatters\stylish\toString
     * @covers \Hexlet\Code\Parsers\parser\parseFile
     * @covers \Hexlet\Code\Parsers\Types\yaml\parseYaml
     */
    public function testGendiffNestedStylish(): void
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

    /**
     * @covers \Hexlet\Code\gendiff\gendiff
     * @covers \Hexlet\Code\gendiff\getdiff
     * @covers \Hexlet\Code\Formatters\plain\formatPlain
     * @covers \Hexlet\Code\Formatters\plain\toString
     * @covers \Hexlet\Code\Parsers\parser\parseFile
     * @covers \Hexlet\Code\Parsers\Types\yaml\parseYaml
     */
    public function testGendiffNestedPlain(): void
    {
        $arr1 = parseFile('tests/fixtures/file3.yaml');
        $arr2 = parseFile('tests/fixtures/file4.yaml');

        $expected = <<<EXP
Property 'common.follow' was added with value: false
Property 'common.setting2' was removed
Property 'common.setting3' was updated. From true to null
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: [complex value]
Property 'common.setting6.doge.wow' was updated. From '' to 'so much'
Property 'common.setting6.ops' was added with value: 'vops'
Property 'group1.baz' was updated. From 'bas' to 'bars'
Property 'group1.nest' was updated. From [complex value] to 'str'
Property 'group2' was removed
Property 'group3' was added with value: [complex value]
EXP;

        $this->assertSame($expected, gendiff($arr1, $arr2, 'plain'));
    }
}

<?php

use PHPUnit\Framework\TestCase;
use function Hexlet\Code\gendiff\gendiff;
use function Hexlet\Code\Parsers\parser\parseFile;

class GendiffJSONTest extends TestCase
{
    /**
     * @covers \Hexlet\Code\gendiff\gendiff
     * @covers \Hexlet\Code\gendiff\getdiff
     * @covers \Hexlet\Code\Formatters\stylish\formatStylish
     * @covers \Hexlet\Code\Formatters\stylish\toString
     * @covers \Hexlet\Code\Parsers\parser\parseFile
     * @covers \Hexlet\Code\Parsers\Types\json\parseJson
     */
    public function testGendiffStylish(): void
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

        $this->assertSame($expected, gendiff($arr1, $arr2, 'stylish'));
    }

    /**
     * @covers \Hexlet\Code\gendiff\gendiff
     * @covers \Hexlet\Code\gendiff\getdiff
     * @covers \Hexlet\Code\Formatters\plain\formatPlain
     * @covers \Hexlet\Code\Formatters\plain\toString
     * @covers \Hexlet\Code\Parsers\parser\parseFile
     * @covers \Hexlet\Code\Parsers\Types\json\parseJson
     */
    public function testGendiffPlain(): void
    {
        $arr1 = parseFile('tests/fixtures/file1.json');
        $arr2 = parseFile('tests/fixtures/file2.json');

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
     * @covers \Hexlet\Code\Parsers\parser\parseFile
     * @covers \Hexlet\Code\Parsers\Types\json\parseJson
     */
    public function testGendiffJson(): void
    {
        $arr1 = parseFile('tests/fixtures/file1.json');
        $arr2 = parseFile('tests/fixtures/file2.json');

        $expected = <<<EXP
{
    "follow": {
        "type": "deleted",
        "oldValue": false
    },
    "host": {
        "type": "not changed",
        "oldValue": "hexlet.io"
    },
    "proxy": {
        "type": "deleted",
        "oldValue": "123.234.53.22"
    },
    "timeout": {
        "type": "changed",
        "oldValue": 50,
        "newValue": 20
    },
    "verbose": {
        "type": "added",
        "newValue": true
    }
}
EXP;

        $this->assertSame($expected, gendiff($arr1, $arr2, 'json'));
    }

    /**
     * @covers \Hexlet\Code\gendiff\gendiff
     * @covers \Hexlet\Code\gendiff\getdiff
     * @covers \Hexlet\Code\Formatters\stylish\formatStylish
     * @covers \Hexlet\Code\Formatters\stylish\toString
     * @covers \Hexlet\Code\Parsers\parser\parseFile
     * @covers \Hexlet\Code\Parsers\Types\json\parseJson
     */
    public function testGendiffNestedStylish(): void
    {
        $arr1 = parseFile('tests/fixtures/file3.json');
        $arr2 = parseFile('tests/fixtures/file4.json');

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
     * @covers \Hexlet\Code\Parsers\Types\json\parseJson
     */
    public function testGendiffNestedPlain(): void
    {
        $arr1 = parseFile('tests/fixtures/file3.json');
        $arr2 = parseFile('tests/fixtures/file4.json');

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

    /**
     * @covers \Hexlet\Code\gendiff\gendiff
     * @covers \Hexlet\Code\gendiff\getdiff
     * @covers \Hexlet\Code\Parsers\parser\parseFile
     * @covers \Hexlet\Code\Parsers\Types\json\parseJson
     */
    public function testGendiffNestedJson(): void
    {
        $arr1 = parseFile('tests/fixtures/file3.json');
        $arr2 = parseFile('tests/fixtures/file4.json');

        $expected = <<<EXP
{
    "common": {
        "type": "changed",
        "value": {
            "follow": {
                "type": "added",
                "newValue": false
            },
            "setting1": {
                "type": "not changed",
                "oldValue": "Value 1"
            },
            "setting2": {
                "type": "deleted",
                "oldValue": 200
            },
            "setting3": {
                "type": "changed",
                "oldValue": true,
                "newValue": null
            },
            "setting4": {
                "type": "added",
                "newValue": "blah blah"
            },
            "setting5": {
                "type": "added",
                "newValue": {
                    "key5": "value5"
                }
            },
            "setting6": {
                "type": "changed",
                "value": {
                    "doge": {
                        "type": "changed",
                        "value": {
                            "wow": {
                                "type": "changed",
                                "oldValue": "",
                                "newValue": "so much"
                            }
                        }
                    },
                    "key": {
                        "type": "not changed",
                        "oldValue": "value"
                    },
                    "ops": {
                        "type": "added",
                        "newValue": "vops"
                    }
                }
            }
        }
    },
    "group1": {
        "type": "changed",
        "value": {
            "baz": {
                "type": "changed",
                "oldValue": "bas",
                "newValue": "bars"
            },
            "foo": {
                "type": "not changed",
                "oldValue": "bar"
            },
            "nest": {
                "type": "changed",
                "oldValue": {
                    "key": "value"
                },
                "newValue": "str"
            }
        }
    },
    "group2": {
        "type": "deleted",
        "oldValue": {
            "abc": 12345,
            "deep": {
                "id": 45
            }
        }
    },
    "group3": {
        "type": "added",
        "newValue": {
            "deep": {
                "id": {
                    "number": 45
                }
            },
            "fee": 100500
        }
    }
}
EXP;

        $this->assertSame($expected, gendiff($arr1, $arr2, 'json'));
    }
}

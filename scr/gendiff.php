<?PHP
require('../vendor/docopt/docopt/src/docopt.php');
$doc = <<<'DOCOPT' Generate diff

Usage: gendiff (-h|--help) gendiff (-v|--version)

Options: -h --help Show this screen -v --version Show version DOCOPT;

$result = Docopt::handle($doc, array( 'argv'=>array_slice($_SERVER['argv'], 1), 'help'=>true, 'version'=>null, 'optionsFirst'=>false, )); foreach ($result as $k=>$v) echo $k.': '.json_encode($v).PHP_EOL;
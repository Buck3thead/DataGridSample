<?php

require_once __DIR__ . '/vendor/autoload.php';

use Bieronski\DataGrid\Config\DefaultConfig;
use Bieronski\DataGrid\DataGrid\HtmlDataGrid;
use Bieronski\DataGrid\State\HttpState;
use Bieronski\DataGrid\Template\DefaultTemplate;

// Read array to render
$rows = json_decode(file_get_contents('DataSet.json'), true);

// To separate business logic used additional rendering Template class
$defaultTemplates = json_decode(file_get_contents(__DIR__ .'/vendor/bieronski/data-grid/templates/defaults.json'), true);
$defaultMainTemplate = new DefaultTemplate(__DIR__ . $defaultTemplates['main']);

// Detect current GET variable keys significant for current library
$state = HttpState::create();

// Prepare config to be consumed by DataGrid class
$config = (new DefaultConfig($defaultTemplates))
    ->addIntColumn('id')
    ->addTextColumn('name')
    ->addIntColumn('age')
    ->addTextColumn('company')
    ->addCurrencyColumn('balance', 'USD')
    ->addTextColumn('phone')
    ->addLinkColumn('email');

// Render to string
$renderedTable = (new HtmlDataGrid($defaultMainTemplate))
    ->withConfig($config)
    ->render($rows, $state);

/* ------------------------------------------------------------------------------------------------ */
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <title>DataGrid sample</title>
</head>
<body>
    <!-- Rendered table -->
    <div style="width: 70%; margin: 0 auto; padding-top: 50px">
        <?php echo $renderedTable ?>
    </div>
</body>
</html>
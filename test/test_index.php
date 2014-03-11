<?php

$examples = array(
    'Arithmetics' => 'output/arithmetics.php',
    'Json'        => 'output/json.php',
    'Css'         => 'output/css.php',
    'Javascript'  => 'output/javascript.php'
);

$output = null;
$classname = null;
$parsing_time = null;
$error = null;

if (isset($_POST['code'], $_POST['parser']) && isset($examples[$_POST['parser']]))
{
    $classname = $_POST['parser'];
    $parser_file = $examples[$classname];
    if (file_exists($parser_file))
    {
        include $parser_file;
        $start = microtime(true);
        try
        {
            $full_classname = "Parser\\" . $classname;
            $parser = new $full_classname();
            $output = $parser->parse($_POST['code']);
        }
        catch (Parser\SyntaxError $ex)
        {
            $exc_expected = array();
            foreach ($ex->expected as $expect) $exc_expected[] = $expect['description'];
            $error = "Syntax error: found '". $ex->found . "' but expected one of: " . join(", ", $exc_expected) . '. ' .
                     'At line ' . $ex->grammarLine . ' column ' . $ex->grammarColumn . ' offset ' . $ex->grammarOffset;
        }
        $parsing_time = microtime(true) - $start;
    }
    else $error = "Parser " . $parser_file . ' is not exist';
}


?><!doctype html>
<html xmlns ="http://www.w3.org/1999/xhtml">
    <head>
        <style>
             body {
                margin: 0px;
                padding: 0px;
                font:  12px "Segoe UI", "Helvetica Neue", Frutiger, "Frutiger Linotype", "Dejavu Sans", Arial, sans-serif;
             }
            .cols2_holder:after{
                content:"";
                display: block;
                clear: left;
            }
            .col2{
                float:left;
                width:50%;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                padding: 10px 30px;
            }
            h1{
                text-align: center;
            }
            select,
            textarea{
                width:100%;
            }
            .output{
                border:1px solid #999;
                padding: 10px;
                white-space: pre;
            }
            .error{
                color:#F00;
                margin-top: 20px;
            }


        </style>
    </head>
    <body>
        <h1>Grammar testing</h1>
        <div class="cols2_holder">
            <div class="col2">
                <form action="" method="POST">
                    <h2>Parser:</h2>
                    <div>
                        <select name="parser"><?php
                            foreach ($examples as $cl => $file)
                            {
                                echo "<option ";
                                if ($classname == $cl) echo "selected ";
                                echo "value='" . htmlspecialchars($cl) . "'";
                                echo ">" . htmlspecialchars($cl) . ' (' .htmlspecialchars($file) . ')';
                                echo '</option>';
                            }
                        ?></select>
                    </div>
                    <h2>Input string:</h2>
                    <div>
                        <textarea name="code" style="height: 250px"><?php
                            if (isset($_POST['code'])) echo htmlspecialchars($_POST['code']);
                        ?></textarea>
                    </div>
                    <div><input type="submit" value="Test"></div>
                </form>
            </div>
            <div class="col2">
                <h2>Output</h2>
                <div class="output"><?php
                    echo htmlspecialchars(var_export($output, true));
                ?></div>
                <?php
                    if ($error) echo "<div class='error'>" . htmlspecialchars($error) . "</div>";
                    if ($parsing_time !== null)
                    {
                        echo "<h2>Parsing time</h2>";
                        echo "<div>" . htmlspecialchars($parsing_time) . " s.</div>";
                    }
                ?>
            </div>
        </div>
    </body>
</html>
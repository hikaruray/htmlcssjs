<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Div for Database </title>
    <style>
        body {
            background-image: url(計算機/images/A.jpeg);
            /*background-color:#778899;*/
        }

        header {
            background: linear-gradient(to top, #696969, #a9a9a9);
            width: 100%;
            height: 3em;
            padding: 1em 0;
            color: white;
            /*#a0d8ef*/
        }

        header ul {
            list-style-type: none;
            display: flex;
            justify-content: space-evenly;

        }

        .calclist {
            /*履歴*/
            width: 250px;
            height: 200px;
            overflow-y: auto;
            /* border:solid 1px red; */
            /* background-color: #696969; */
            background: linear-gradient(to top, #696969, #a9a9a9);
            margin-top: 10px;
            border-radius: 50px;
            padding: 50px;
            color: white;



        }

        .otherlist {
            /*そのほか*/
            width: 250px;
            height: 200px;
            /* border:solid 1px blue; */
            overflow-y: auto;
            /* background-color: #696969; */
            background: linear-gradient(to top, #696969, #a9a9a9);
            margin-top: 50px;
            border-radius: 50px;
            padding: 50px;
            display: nowrap;
            color: white;


        }


        @import url('https://fonts.googleapis.com/css2?family=Orbitron&display=swap');

        .calculator {
            padding: 20px;
            border-radius: 1em;
            height: 400px;
            width: 250px;
            background-color: white;
            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
        }

        .display-box {
            font-family: 'メイリオ', sans-serif;
            background-color: white;
            border: solid black 0.5px;
            color: black;
            border-radius: 5px;
            width: 100%;
            height: 65%;
        }

        .button {
            font-family: 'Orbitron', sans-serif;
            background-color: #555555;
            color: white;
            border: solid black 0.5px;
            width: 100%;
            border-radius: 5px;
            height: 70%;
            outline: none;
        }

        .button:active {
            background: #88FFFF;
            -webkit-box-shadow: inset 0px 0px 5px #c1c1c1;
            -moz-box-shadow: inset 0px 0px 5px #c1c1c1;
            box-shadow: inset 0px 0px 5px #c1c1c1;
        }


        .contena {
            display: flex;
            width: 90%;
            margin: auto;
            flex-wrap: wrap;

        }

        .box-a {
            padding-top: 200px;
            padding-right: 20px;
        }

        .box-b {
            padding-top: 100px;
            padding-left: 180px;
            width: 50%;
            height: 50%;
        }
    </style>
    <?php
    $currentValue = 0;

    $input = [];


    function getInputAsString($values)
    {
        $o = "";
        foreach ($values as $value) {
            $o .= $value;
        }
        return $o;
    }

    function calculateInput($userInput)
    {
        // format user input
        $arr = [];
        $char = "";
        foreach ($userInput as $num) {
            if (is_numeric($num) || $num == ".") {
                $char .= $num;
            } else if (!is_numeric($num)) {
                if (!empty($char)) {
                    $arr[] = $char;
                    $char = "";
                }
                $arr[] = $num;
            }
        }
        if (!empty($char)) {
            $arr[] = $char;
        }
        // calculate user input

        $current = 0;
        $action = null;
        for ($i = 0; $i <= count($arr) - 1; $i++) {
            if (is_numeric($arr[$i])) {
                if ($action) {
                    if ($action == "+") {
                        $current = $current + $arr[$i];
                    }
                    if ($action == "-") {
                        $current = $current - $arr[$i];
                    }
                    if ($action == "x") {
                        $current = $current * $arr[$i];
                    }
                    if ($action == "/") {
                        $current = $current / $arr[$i];
                    }
                    $action = null;
                } else {
                    if ($current == 0) {
                        $current = $arr[$i];
                    }
                }
            } else {
                $action = $arr[$i];
            }
        }
        return $current;
    }
    $b = []; //数字のまとめ
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['input'])) {
            $input = json_decode($_POST['input']);
        }

        if (isset($_POST)) {
            foreach ($_POST as $key => $value) {
                if ($key == 'equal') {
                    $currentValue = calculateInput($input);
                    $a = getInputAsString($input); //数字ひとつ
                    array_push($b, $a);
                    // $input = [];
                    // $input[] = $currentValue;
                } elseif ($key == "C") {
                    $input = [];
                    $currentValue = 0;
                } elseif ($key != 'input') {
                    $input[] = $value;
                }
            }
        }
    }



    print getInputAsString($input);
    print "<br>";
    print getInputAsString($b);
    print "<br>";
    print $currentValue;

    ?>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>HMTL</li>
                <li>CSS</li>
                <li>JavaScript</li>
                <li>PHP/SQL</li>
            </ul>
        </nav>
    </header>
    <script>
        function clearScreen() {
            document.getElementById("result").value = "";
        }

        function display(value) {
            document.getElementById("result").value += value;
        }

        function calculate() {
            var p = document.getElementById("result").value;
            var q = eval(p);
            document.getElementById("result").value = q;
        }
    </script>
    <div class="contena">
        <div class="box-a">
            <form action="divs.php" method="post">
                <input type="hidden" name="input" value='<?php echo json_encode($input); ?>' />
                <table class="calculator">
                    <tr>
                        <td colspan="3"> <input class="display-box" type="text" value='<?php echo getInputAsString($input); ?>' id="result" disabled /> </td>
                        <!-- clearScreen() function clear all the values -->
                        <td> <button type="submit" class="button" value="" name="C" style="background-color: #fb0066;" />C</td>
                    </tr>
                    <tr>
                        <!-- () function  the value of clicked button -->
                        <td> <button type="submit" class="button" value="7" name="button" />7</td>
                        <td> <button type="submit" class="button" value="8" name="button" />8</td>
                        <td> <button type="submit" class="button" value="9" name="button" />9</td>
                        <td> <button type="submit" class="button" value="/" name="divide" />/</td>
                    </tr>
                    <tr>
                        <td> <button type="submit" class="button" value="4" name="button" />4</td>
                        <td> <button type="submit" class="button" value="5" name="button" />5</td>
                        <td> <button type="submit" class="button" value="6" name="button" />6</td>
                        <td> <button type="submit" class="button" value="-" name="minus" />-</td>
                    </tr>
                    <tr>
                        <td> <button type="submit" class="button" value="1" name="button" />1</td>
                        <td> <button type="submit" class="button" value="2" name="button" />2</td>
                        <td> <button type="submit" class="button" value="3" name="button" />3</td>
                        <td> <button type="submit" class="button" value="+" name="add" />+</td>
                    </tr>
                    <tr>
                        <td> <button type="submit" class="button" value="." name="button" />.</td>
                        <td> <button type="submit" class="button" value="0" name="button" />0</td>
                        <!-- calculate() function evaluate the mathematical expression -->
                        <td> <button type="submit" class="button" value="=" name="equal" style="background-color: #fb0066;" />=</td>
                        <td> <button type="submit" class="button" value="*" name="multiply" />×</td>
                    </tr>
                </table>
            </form>
            <script type="text/javascript" src="script.js"></script>
        </div>
        <div class="box-b">
            <div class="calclist">
                <h3>これまでの計算式</h3>
                <ol class="listview">
                    <li>1+1=2</li>
                    <li>2+2=4</li>
                    <li>$num1-$num2</li>
                    <li>Select * from db</li>
                    <li> while($s->fetch())</li>
                </ol>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis vero sequi necessitatibus quis, esse accusamus omnis eum, doloremque cum corporis molestias eos recusandae obcaecati placeat. Mollitia dignissimos est odit veniam reprehenderit doloremque illum veritatis saepe nisi natus expedita facilis ut, nihil aliquid iure qui minus ratione labore perspiciatis autem nulla.</p>
            </div>

            <div class="otherlist">
                <ul class="listview2">
                    <li><a href="#">catetory1</a></li>
                    <li><a href="#">catetory2</a></li>
                    <li><a href="#">catetory3</a></li>
                    <li><a href="#">catetory4</a></li>
                    <li><a href="#">catetory5</a></li>
                    <li><a href="#">catetory6</a></li>
                    <li><a href="#">catetory7</a></li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>
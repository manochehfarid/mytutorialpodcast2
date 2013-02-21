<!DOCTYPE html>
<html>
    <head>
        <title>PHP Proof</title>
        <link href="styles/styles.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <header>
            <h1>Here's my PHP Proof</h1>
        </header>
        <nav>
            <a href="http://phpproof.mytutorialpodcast.com">my php proof</a>
            <a href="http://community.mytutorialpodcast.com">the my tutorial podcast community</a>
            <a href="http://learning-journal.mytutorialpodcast.com">my 336 learning journal</a>
            <a href="http://project.mytutorialpodcast.com">my yellowstone project</a>
            <a href="http://mytutorialpodcast.com">Home</a>
        </nav>
            <div id="content">
                <div class="scalar_variable">
                    <h2>Scalar Variable</h2>
                    <p>The code I'm about to do echo's quotes in the form of strings.  <code>echo "Get a move on you maggots!";</code> <?php include 'proofs/scalar_variable.php'?></p>
                </div> <!-- end scaler variable -->
                <div class="if_structure">
                    <h2>If Structure</h2>
                    <p>The code in this proof will check and see if a file exists and include it <code>if(file_exsists()){
                        include 'scalar_variable.php'
                        }</code>. <?php include'proofs/if_structure.php'?></p>    
                </div><!--End of if structure-->
                <div class="for_loop">
                    <h2>For Loop</h2>
                    <p>In this proof I'll cycle through 100 numbers and print them out <code>for($i = 1; $i <= 100; $i++){
                        echo $i;
                        }</code>. <?php include 'proofs/for_loop.php'; ?></p>       
                </div> <!--End of for loop-->
                <div class="POST_array">
                    <h2>$_POST array</h2>
                    <p>In this proof I'm capturing my choice of Root Beer and printing it <code>if ($_POST){
    echo '<pre>';
    echo htmlspecialchars(print_r($_POST, true));
    echo '</pre>';
    }</code> <?php include 'proofs/$_POST_array.php'; ?></p>.
                </div><!--End of $_POST array-->
                <div class="division_operator">
                    <h2>Division Operator</h2>
                    <p>In this proof I'm dividing two numbers and then printing them. <code>echo (15 / 3)</code> <?php include 'proofs/division_operator.php'; ?></p>
                </div><!--end of division operator-->
                <div class="less_than_operator">
                    <h2>less than operator</h2>
                    <p>In this proof I'm checking to see which variable is less than the other and then print the smaller variable. <code>if($a < $b) echo $a</code> <?php include 'proofs/less_than_operator.php'; ?></p>
                </div><!--end of less than operator-->
                <div class="concatenation_operator">
                    <h2>concatenation operator</h2>
                    <p>In this proof I'm joining two strings together to form a quote from the Big Bang Theory. <code>echo $a . $f;</code> <?php include 'proofs/concatenation_operator.php'; ?></p>
                </div>
            </div>
        <footer>
            <p>&copy; 2013 my tutorial podcast</p>
        </footer>
    </body>
</html>
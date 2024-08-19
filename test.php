<html>
    <body>
        <h1>Papa Max's Football class</h1>
        
        <?php 
            class Football {
                public $clubname;
                public $clubcountry;

                function setName($name){
                    $this->name = $name;
                }
                function getName() {
                    return $this->name;
                }
            }
            $arsenal = new Football();
            $chelsea = new Football();

            $arsenal->setName("Arsenal");
            $chelsea->setName("Chelsea");

            echo $arsenal->getName();
            echo "<br/>";
            echo $chelsea->getName();
        ?>
    </body>
</html>
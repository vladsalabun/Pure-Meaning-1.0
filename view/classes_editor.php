<div class="row">
	<div class="col-lg-12">
    <p align="left"> ← <a href="<?php echo configuration::MAIN_URL;?>?page=project&id=<?php echo $_GET['projectId']; ?>">Back to project <?php echo $_GET['projectId']; ?></a></p>
<?php
    $classes = $pure->getAllClasses($_GET['projectId']);
    
    foreach ($classes as $ck => $classesArr) {
?> 
    [ <a href="<?php echo configuration::MAIN_URL;?>?page=classes_editor&projectId=<?php echo $_GET['projectId']?>&class=<?php echo $classesArr['class'];?>">
    <?php echo $classesArr['class']; ?></a> ]
<?php
    }
?>
    </div>
</div>




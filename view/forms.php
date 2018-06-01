<div class="row">
	<div class="col-lg-4">
    <h4>Add new form:</h4>
    <form method="GET" action="<?php echo configuration::MAIN_URL;?>?page=new_form" autocomplete="OFF">
    <input type="hidden" name="page" value="new_form">
    <table class="table table-striped">
    <thead>
    <tr>
        <td>method:</td><td><select name="method"><option selected value="post">POST</option><option value="get">GET</option></select></td>
    </tr>
    <tr>
        <td>action:</td><td><input type="text" name="form_action" value=""></td>
    </tr>
    <tr>
        <td>autocomplete:</td><td><select name="autocomplete"><option selected value="off">off</option><option value="on">on</option></select></td>
    </tr>    
    <tr>
        <td>elements:</td><td><input type="number" name="elements" value="1"></td>
    </tr>
    <tr>
        <td>projectId:</td><td><input type="number" name="projectId" value="0"></td>
    </tr>
    <tr>
        <td></td><td><input type="submit" name="submit" value="Add new" class="submit_btn"></td>
    </tr>
    </tbody>
    </table>
    </form>
    </div>
    <div class="col-lg-8">
    <table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">ID:</th>
            <th scope="col">Fav:</th>
            <th scope="col">ProjectID:</th>
            <th scope="col">Form info:</th>
            <th scope="col">Edit:</th>
            <th scope="col">Fav:</th>
            <th scope="col">Delete:</th>
        </tr>
    </thead>
    <tbody>
<?php 
    // show form list, desc
    $formsArray = $pure->getForms();
    foreach ($formsArray as $n => $form) {
        
        // TODO: show favourive forms, moderation = 1
?>
    <tr>
        <td>
            <?php echo $form['ID']?>
        </td>
        <td>
            <?php if ($form['moderation'] == 1) { echo '<span class="glyphicon glyphicon-heart"></span>';}?>
        </td>
        <td>
            <a href="<?php echo configuration::MAIN_URL;?>?page=project&id=<?php echo $form['projectID']?>"><?php echo $form['projectID']?></a>
        </td>
        <td>
        <a href="<?php echo configuration::MAIN_URL;?>?page=form_generator&formID=<?php echo $form['ID']?>"><?php if ($form['info'] != null) { echo $form['info']; } else { echo 'no description';}?></a>
        </td>
        <td>Edit</td>
        <td>
        <form method="post" action="" autocomplete="off">
            <input type="hidden" name="action" value="fav_form">
            <input type="hidden" name="formId" value="<?php echo $form['ID']?>">
            <input type="submit" name="submit" value="Fav">
        </form>
        </td>
        <td>
        <form method="post" action="" autocomplete="off">
            <input type="hidden" name="action" value="delete_form">
            <input type="hidden" name="formId" value="<?php echo $form['ID']?>">
            <input type="submit" name="submit" value="Delete">
        </form>
        </td>
    </tr>
<?php
    }
    
?>
    </tbody>
    </table>
    </div>
</div>




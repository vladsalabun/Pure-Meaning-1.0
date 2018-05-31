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
        <td>action:</td><td><input type="text" name="action" value=""></td>
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
            <th scope="col">Form ID:</th>
            <th scope="col">ProjectID:</th>
            <th scope="col">Form info:</th>
            <th scope="col">Actions:</th>
        </tr>
    </thead>
    <tbody>
<?php 
    // show form list, desc
    $formsArray = $pure->getForms();
    foreach ($formsArray as $n => $form) {
?>
    <tr>
        <td><?php echo $form['ID']?></td>
        <td><a href="<?php echo configuration::MAIN_URL;?>?page=project&id=<?php echo $form['projectID']?>"><?php echo $form['projectID']?></a></td>
        <td><a href="<?php echo configuration::MAIN_URL;?>?page=form_generator&formID=<?php echo $form['ID']?>"><?php if ($form['info'] != null) { echo $form['info']; } else { echo 'no description';}?></a></td>
        <td>Edit / Favourite / Delete</td>
    </tr>
<?php
    }
    
?>
    </tbody>
    </table>
    </div>
</div>




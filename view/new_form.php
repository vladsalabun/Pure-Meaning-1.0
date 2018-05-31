<div class="row">
	<div class="col-lg-4">
    <pre>
<?php
    print_r($_GET);
?>
    </pre>
    <p>class text: .txtfield</p>
    <p>class submit: .submit_btn</p>
    </div>
    <div class="col-lg-8">
    <form method="POST" action="" autocomplete="OFF">
    <input type="hidden" name="action" value="add_new_form">
    <input type="hidden" name="element_count" value="<?php echo $_GET['elements']; ?>">
    <input type="hidden" name="method" value="<?php echo $_GET['method']; ?>">
    <input type="hidden" name="autocomplete" value="<?php echo $_GET['autocomplete']; ?>">
    <input type="hidden" name="projectId" value="<?php echo $_GET['projectId']; ?>">
    <table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Type:</th>
            <th scope="col">Name:</th>
            <th scope="col">Value:</th>
            <th scope="col">Placeholder:</th>
            <th scope="col">Class:</th>
        </tr>
    </thead>
    <tbody>
<?php 
    //configuration::FORM;
    $formsArray = $pure->getForms();
    for ($i = 0; $i < $_GET['elements']; $i++) {
?>
    <tr>
        <td>
            <select name="type<?php echo $i;?>">
            <?php foreach (configuration::FORM['type'] as $type => $typeParam) { ?>
            <option value="<?php echo $type?>"><?php echo $type?></option>
            <?php } ?>
            </select>
        </td>
        <td><input type="text" name="name<?php echo $i;?>" value="" class="txtfield"></td>
        <td><input type="text" name="value<?php echo $i;?>" value="" class="txtfield"></td>
        <td><input type="text" name="placeholder<?php echo $i;?>" value="" class="txtfield"></td>
        <td><input type="text" name="class<?php echo $i;?>" value="" class="txtfield"></td>
    </tr>
<?php
    }
    
?>
    <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><input type="submit" name="submit" value="Save form" class="submit_btn"></td>
    </tr>
    </tbody>
    </table>
    </div>
</div>




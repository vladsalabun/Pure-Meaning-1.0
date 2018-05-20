<?php 
    $element = $pure->getElementInfo($_GET['id']);
    print_r($element);
    $style = json_decode($element['style'],true);
    print_r($style); 
?>
<div class="row">
	<div class="col-lg-12">
    <p align="left"> ← <a href="">Back to project <?php echo $element['projectId']; ?></a></p>
    <h4>Edit element: #<?php echo $element['ID']; ?></h4>
    <table class="table table-striped">
  <thead >
    <tr>
      <th scope="col">Option</th>
      <th scope="col">Value:</th>
    </tr>
    </thead>
    <tbody>
    <form method="POST" id="edit_element" action="" autocomplete="OFF">
    <input type="hidden" name="element_id" value="<?php echo $element['ID']; ?>">
    <tr>
    <td>identifier</td>
    <td>
    <input type="text" name="identifier" value="<?php echo $element['identifier']; ?>" class="txtfield">
    </td>
    </tr>
    <tr>
    <td>class</td>
    <td>
    <input type="text" name="class" value="<?php echo $element['class']; ?>" class="txtfield">
    </td>
    </tr>
        <tr><td></td> <td><b>Other:</b></td></tr> 
<?php 
    if (is_array($style['other'])) {
        foreach ($style['other'] as $otherParam => $otherValue) {
?>
        <tr>
        <td><?php echo $otherParam ; ?></td>
        <td><input type="text" name="<?php echo $otherParam ; ?>" value="<?php echo $otherValue ; ?>" class="txtfield"></td>
        </tr>
<?php 
        } 
    }
?>      <tr>
        <td></td>
        <td>+ add other option: fish, text, something else</td>
        </tr>

    <tr>
    <td>style</td>
    <td>
    <pre>
    <?php 
       
    ?>
    <pre>
    </td>
    </tr>
    </form>
    </tbody>
</table>
    </div>
</div>




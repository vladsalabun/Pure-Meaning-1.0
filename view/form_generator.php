<div class="row">
	<div class="col-lg-6">
    <h3>Generate form #<?php echo $_GET['formID']; ?>:</h3>
<?php 
    
    $form = new formGenerator;
    $HtmlFormatter = new HtmlFormatter;

    // get form from database:
    $formId = $pure->getFormById($_GET['formID']);
    
    if ($formId != null) {
        // convert params to array:
        $formArray = json_decode($formId['formJson'], true);
        
        // TODO: show error if form elements have same names

        $formHtml = null;
        // make form code:
        $formHtml = $form->functionHeader($formArray['method'],$formArray['action'],$formArray['autocomplete']);
        $formHtml .= $form->pasreElements($formArray['elements']);
        $formHtml .= $form->functionFooter();

        // form preview:
        echo HtmlFormatter::format($formHtml);
   
?>
    </div>
    <div class="col-lg-6">
    <h3>Source code form #<?php echo $_GET['formID']; ?>:</h3>
<?php 
        // show source code:
        echo '<pre>'.htmlspecialchars(HtmlFormatter::format($formHtml)).'</pre>';        
    }
?>  
    </div>
</div>




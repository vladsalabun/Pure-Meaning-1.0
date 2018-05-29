<div class="row">
	<div class="col-lg-12">
    
    <h3>Generate PDO query:</h3>
    <?php 
        // TODO: JavaScript, get from configuration::MYSQL_TABLES and put to form (don't type all this shit manually)  
        // TODO: JavaScript, turn input green if it correctly filled  
        // TODO: result in modal window (json ajax)
    ?>
    <form method="POST" action="" autocomplete="OFF">
    <input type="hidden" name="action" value="generate_pdo">
    <table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">Question:</th>
        <th scope="col">Answer:</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Variables:</td>
        <td><input type="text" name="variables" placeholder="comma separated" value="<?php if (isset($_GET['variables'])) { echo $_GET['variables']; }?>" class="txtfield"></td>
        <td></td>
    </tr>
    <tr>
        <td>Type:</td>
        <td>
            <select name="whatToDo">
                <option value="select">SELECT</option>
                <option value="update">UPDATE</option>
                <option value="insert">INSERT</option>
            </select>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>Columns:</td>
        <td><input type="text" name="columns" placeholder="* or comma separated" value="<?php if (isset($_GET['columns'])) { echo $_GET['columns']; }?>" class="txtfield"></td>
        <td></td>
    </tr>
    </tr>
        <tr><td>Table:</td>
        <td><input type="text" name="table" placeholder="TableName" value="<?php if (isset($_GET['table'])) { echo $_GET['table']; }?>" class="txtfield"></td>
        <td></td>
    </tr>
    </tr>
        <tr><td>Condition:</td>
        <td><input type="text" name="condition" placeholder="WHERE ... AND ..." value="<?php if (isset($_GET['condition'])) { echo $_GET['condition']; }?>" class="txtfield"></td>
        <td></td>
    </tr> 
    </tr>
        <tr><td>ORDER BY:</td>
        <td><input type="text" name="orderBy" placeholder="ColumnName" value="<?php if (isset($_GET['orderBy'])) { echo $_GET['orderBy']; }?>" class="txtfield"></td>
        <td>
            <select name="ascdesc">
                <option value="ASC">ASC</option>
                <option value="DESC">DESC</option>
            </select>
        </td>
    </tr>     
    </tr>
        <tr><td>Limit:</td>
        <td><input type="number" name="limit" value="<?php if (isset($_GET['limit'])) { echo $_GET['limit']; } else {echo 0;}?>" class="txtfield"></td>
        <td></td>
    </tr>    
    <tr>
        <td></td>
        <td></td>
        <td><input type="submit" name="submit" value="Generate" class="submit_btn"></td>
    </tr>
    </tbody>
    </table>
    <?php 
   
    
    ?>
    </div>
</div>




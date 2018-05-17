<div class="row">
	<div class="col-lg-12" align="left">Project: 
<?php echo $_GET['id'];?>
<p><a href="<?php echo configuration::MAIN_URL;?>?page=preview&projectId=<?php echo $_GET['id'];?>" target="blank">Посилання на готовий шаблон</a></p>
<p><a href="<?php echo configuration::MAIN_URL;?>?page=template&projectId=<?php echo $_GET['id'];?>" target="blank">Редактор шаблону</a></p>
<p>TODO:</p>
<ol align="left">
    <li>Стандартні запитання і відповіді до клієнта</li>
    <li>Стандартні запитання і відповіді до мене (робочий чек-лист)</li>
    <li>Деталі замовлення</li>
</ol>
<h3>Шаблон:</h3>
<?php 
    // take all elements from database:
    $htmlTree = $pure->getDocumentTree($_GET['id']);
    // clean them to make sure they are goot for use:
    $cleanArray = $pure->cleanLeaves($pure->createTreeArray($htmlTree));
    
    function showDOM($array) {
        $temp = new pure;
?>       
<ul align="left">
<?php
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $elementInfo = $temp->getElementInfo(substr($key,5));

                echo '<li>'.$key.':'; 
                echo strlen($elementInfo['identifier']) > 0 ? ' id: <b>'.$elementInfo['identifier'].'</b>' : ''; 
                echo strlen($elementInfo['class']) > 0 ? ' class: <b>'.$elementInfo['class'].'</b>': '';
                echo ' [ <a href="" data-toggle="modal" data-target="#ModalNew'.substr($key,5).'">edit</a> | <a href="">add</a> ] </li>';
                
                echo '
                <div class="modal fade" id="ModalNew'.substr($key,5).'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    Block #'.substr($key,5).'<br><h3 class="modal-title" id="exampleModalLongTitle">';
                    echo strlen($elementInfo['identifier']) > 0 ? ' id: <b>'.$elementInfo['identifier'].'</b><br>' : ''; 
                    echo strlen($elementInfo['class']) > 0 ? ' class: <b>'.$elementInfo['class'].'</b>': '';
                    echo '</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">';
                  echo '</div>
                  <div class="modal-footer">
                  
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>';
                
                showDOM($value);
            } else {
                echo '<li>'.$value.':';
                $elementInfo = $temp->getElementInfo(substr($value,5));
                echo strlen($elementInfo['identifier']) > 0 ? ' id: <b>'.$elementInfo['identifier'].'</b>' : ''; 
                echo strlen($elementInfo['class']) > 0 ? ' class: <b>'.$elementInfo['class'].'</b>': '';
                echo ' [ <a href="" data-toggle="modal" data-target="#ModalNew'.substr($value,5).'">edit</a> | <a href="">add</a> ] </li>';
                
                echo '
                <div class="modal fade" id="ModalNew'.substr($value,5).'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    Block #'.substr($value,5).'<br><h3 class="modal-title" id="exampleModalLongTitle">';
                    echo strlen($elementInfo['identifier']) > 0 ? ' id: <b>'.$elementInfo['identifier'].'</b><br>' : ''; 
                    echo strlen($elementInfo['class']) > 0 ? ' class: <b>'.$elementInfo['class'].'</b>': '';
                    echo '</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">';
                  echo '</div>
                  <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>';
            }
        }
         echo '</ul>';
    }
    
    showDOM($cleanArray);
    
?>
    </div>
</div>




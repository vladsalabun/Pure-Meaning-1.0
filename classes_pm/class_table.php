<?php
    
    class tableGenerator extends pure
    {
        public function tableStart($array = null)
        {
            if ($array == null) {
              return '
                  <!--- TABLE ---><table class="table table-striped">
              ';
            } else {
              $string .= '
                  <!--- TABLE ---><table class="'.$array['class'].'">
                  <thead>
                      <tr>';
              foreach ($array['th'] as $value){            
                 $string .= '<th scope="col">'.$value.'</th>';
              }
              $string .= '</tr>
                  </thead>
                  <tbody>
              ';
              return $string;
            }
        }
        
        public function tableEnd($array = null)
        {
            return '</tbody></table><!--- /TABLE --->';
        }
        
        public function tr($array = null)
        {
            $string .= '<tr>';
            foreach ($array as $value) {
                $string .= '<td>'.$value.'</td>';
            }
            $string .= '</tr>';
            return $string;
        }
        
    }
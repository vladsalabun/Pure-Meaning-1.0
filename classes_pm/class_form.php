<?php
    
    class formGenerator extends pure
    {
        //print_r(configuration::FORM);
        
        public function functionHeader($method,$action,$autocomplete)
        {
            return '<!--- FORM ---><form method="'.$method.'" action="'.$action.'" autocomplete="'.$autocomplete.'">';
        }
        public function functionFooter()
        {
            return '</form><!--- /FORM --->';
        }       
        
        public function pasreElements($elementsArray) 
        {
            foreach ($elementsArray as $id => $elementArray) {
                $type = array_keys($elementArray)[0];
                if ($type == 'text') {
                    $string .= '<br><input type="'.$type.'" name="'.$elementArray[$type]['name'].'" value="'.$elementArray[$type]['value'].'" placeholder="'.$elementArray[$type]['placeholder'].'">';
                }
                else if ($type == 'hidden') {
                    $string .= '<br><input type="'.$type.'" name="'.$elementArray[$type]['name'].'" value="'.$elementArray[$type]['value'].'">';
                }
                // TODO: 
            }
            return $string;
        }
    }
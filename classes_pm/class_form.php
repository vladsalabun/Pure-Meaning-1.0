<?php
    
    class formGenerator extends pure
    {
        //print_r(configuration::FORM);

        // OLD:
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
                else if ($type == 'number') {
                    $string .= '<br><input type="'.$type.'" name="'.$elementArray[$type]['name'].'" value="'.$elementArray[$type]['value'].'">';
                } else {
                    $string .= '<!--- Unknown type: '.$type.' --->';
                }
                // TODO: 
            }
            return $string;
        }
        
        // <- OLD
        
        public function formStart($array = null)
        {
            if ($array == null) {
                return '<!--- FORM ---><form method="post" action="" autocomplete="off">';
            } else {
                return '<!--- FORM ---><form method="'.$array['method'].'" action="'.$array['action'].'" autocomplete="'.$array['autocomplete'].'">';
            }
        }
        
        public function formEnd($array = null)
        {
            return '</form><!--- /FORM --->';
        }
        public function hidden($array = null)
        {
            return '<input type="hidden" name="'.$array['name'].'" value="'.$array['value'].'">';
        }
        public function text($array = null)
        {
            return '<input type="text" name="'.$array['name'].'" value="'.$array['value'].'" placeholder="'.$array['placeholder'].'">';
        }       
        public function submit($array = null) 
        {
            if ($array == null) {
                return '<input type="submit" name="submit" value="Submit">';
            } else {
                return '<input type="submit" name="'.$array['name'].'" value="'.$array['value'].'" class="'.$array['class'].'">';
            }
        }

 
        
    }
<?php
    
    class formGenerator extends pure
    {
        //print_r(configuration::FORM);
        
        public function formStart($array = null)
        {
            if (isset($array['enctype']) == 'multipart/form-data') {
                $enctype = 'enctype="multipart/form-data"';
            }
            if (isset($array['method'])) { 
                $method = $array['method'];
            } else {
                $method = 'post';
            }
            if (isset($array['autocomplete'])) {
                $autocomplete = $array['autocomplete'];
            } else {
                $autocomplete = 'off';
            }
            if (isset($array['id'])) {
                $formID = 'id="'.$array['id'].'"';
            } else {
                $formID = '';
            }
            
            if (isset($array['class'])) {
                $formClass = 'class="'.$array['class'].'"';
            } else {
                $formClass = '';
            }
            
            if ($array == null) {
                return '<!--- FORM ---><form method="post" action="" autocomplete="off">';
            } else {
                return '<!--- FORM ---><form method="'.$method.'" '.$enctype.' action="'.$array['action'].'" autocomplete="'.$autocomplete.'" '.$formID.' '.$formClass.'>';
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
            if (isset($array['class'])) {
                $class = 'class="'.$array['class'].'"';
            }
            return '<input type="text" name="'.$array['name'].'" value="'.$array['value'].'" placeholder="'.$array['placeholder'].'" '.$class.'>';
        }

        public function textarea($array = null)
        {
            if (isset($array['class'])) {
                $class = 'class="'.$array['class'].'"';
            }
            return '<textarea name="'.$array['name'].'" '.$class.'>'.$array['value'].'</textarea>';
        }
        
        public function uploadFile($array = null)
        {
            if (isset($array['name'])) {
                $name = $array['name'];
            } else {
                $name = 'file';
            }
            return '<input name="'.$name.'" type="file">';
        } 

        public function select($array = null)
        {
            $sting = '<select name="'.$array['name'].'[]">';
            
            foreach ($array['value'] as $key => $value) {
                $sting .= '<option value="'.$key.'">'.$value.'</option>';
            }
            
            $sting .= '</select>';
            return $sting;
        }       
 
        public function datetime($array = null)
        {
            return '<input type="datetime-local" name="'.$array['name'].'" value="'.$array['value'].'">';
        }
 
        public function submit($array = null) 
        {
            if ($array == null) {
                return '<input type="submit" name="submit" value="Submit">';
            } else {
                return '<input type="submit" name="'.$array['name'].'" value="'.$array['value'].'" class="'.$array['class'].'">';
            }
        }
        
        public function fontSelectingForm($currentFont = null,$elementName = null) 
        { 
            $allFonts = $this->getAllFonts();
            
            if (in_array($currentFont,$allFonts)) {
                $currentFontID = array_search($currentFont,$allFonts);
            } else {
                $currentFontID = null;
            }
            
            $string = '<select id="editable-select-'.$elementName.'" name="'.$elementName.'">';
            foreach ($allFonts as $fontID => $fontFamily) {
                if ($fontID == $currentFontID) {
                    $selected = 'selected';
                } else {
                    $selected = null;
                }
                $string .= '<option '.$selected.'>'.$fontFamily.'</option>';
            }
            $string .= '</select>
            <script>
                $(\'#editable-select-'.$elementName.'\').editableSelect({ filter: false }); 
            </script>';
            
            return $string;
        }
        
        public function button($array = null) 
        {
            return '<button type="button" class="'.$array['class'].'">'.$array['anchor'].'</button>';
        }
 
 











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
    }
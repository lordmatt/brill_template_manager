<?php

//define this value for your project before you include this file
if(!defined('_brill_template_path_')){
    define('_brill_template_path_','./templates/'); // just a guess
}

if(false==class_exists('brill_template_manager')){
    /**
     * to use:
     * 
     * $templater = new brill_template_manager()
     * 
     * Set template variables like this:
     * 
     * $templater->max = 10;
     * $templater->name = 'Timothy';
     * 
     * get the template as a string like this:
     * 
     * $mystring = $templater->get_template('page', 'user', $args);
     * 
     * $args array is an alternative way to pass values $args overwrites same 
     * named vars set before
     * 
     * to output the template use:
     * 
     * $templater->do_template('page');
     * 
     * In this example, a sub-type of the template was not specified so the 
     * general version will be used.
     * 
     * How to format templates
     * 
     * templates are files that use a special naming paradigm
     * 
     * general-sub.php
     * or
     * general.php
     * 
     * Brill templates have access to the $this operator like this:
     * 
     * $this->template_part('form_top',$user); // use another template
     * 
     * echo $this->max;
     * 
     * You can tuck your PHP into "tags" like this:
     * 
     * <p>Your name is <?php echo $this->name; ?>!</p> 
     * 
     * @version 1.0.0
     * @author LordMatt <@lordmatt@mastodon.social>
     */
    class brill_template_manager {

        protected $vars = array();

        public function __set($name, $value) {
            $this->vars[$name]=$value;
        }

        public function __get($name) {
            if(false==isset($this->vars[$name])){
                return null;
            }
            return $this->vars[$name];
        }

        public function __isset($name) {
            return isset($this->vars[$name]);
        }

        public function __unset($name) {
            unset($this->vars[$name]);
        }

        public function get_template(string $name, string $sub, array $args):string {
            $templateOut = '';
            ob_start();
            $this->do_template($name, $sub);
            $templateOut = ob_get_contents();
            ob_end_clean();
            return $templateOut;
        }

        public function do_template(string $name, string $sub, array $args):string {
            foreach($args as $name=>$val){
                $this->vars[$name]=$val;
            }
            $this->template_part($name, $sub);
        }

        protected function template_part(string $name, string $sub,$fallback=false){
            $path = '.';
            if(defined('_brill_plugin_dir_')){
                $path=_brill_template_path_;
            }
            $templates = array();
            $templates[] = $path.$name.'-'.$sub.'.php';
            $templates[] = $path.$name.'.php';
            // trigger/filter goes here
            $loaded = false;
            foreach($templates as $temp){
                if(file_exists($temp)){
                    require $temp;
                    $loaded = true;
                    break;
                }
            }
            if(false==$loaded && false==$fallback){
                $this->template_part('default', 'missing', $true);
            }
        }

    }
}



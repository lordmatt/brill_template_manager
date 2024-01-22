# brill_template_manager
This is a simple template engine created for [https://isbrill.com](https://isbrill.com).

## to use:


### init

    define('_brill_template_path_','.path/to/templates/');
    $templater = new brill_template_manager();

### Set template variables like this:

    $templater->max = 10;
    $templater->name = 'Timothy';
 
### get the template as a string like this:

    $mystring = $templater->get_template('page', 'user', $args);

`$args` array is an alternative way to pass values $args overwrites the same named vars set directly

### to output the template use:

    $templater->do_template('page');

In this example, a sub-type of the template was not specified so the general version will be used.

## Templates 

### How to format template names

templates are files that use a special naming paradigm

* general-sub.php
* general.php

The first is the specific format while the second is the default or fallback if a specific version does not exist.

### function calls

Brill templates have access to the $this operator like this:

    $this->template_part('form_top',$user); // use sub-template

WARNING: You can create a never-ending loop by calling the template within itself. You are expected to plan ahead so this does not happen or risk nasty errors.

### variables    
    echo $this->max;

You can tuck your PHP into "tags" like this:

    <p>Your name is <?php echo $this->name; ?>!</p> 

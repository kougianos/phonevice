<?php /* Smarty version 3.1.27, created on 2019-07-23 14:27:47
         compiled from "/home/kougi/public_html/phoneVice/templates/header.html" */ ?>
<?php
/*%%SmartyHeaderCode:7946192655d36ef33c3f635_99198484%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f7c0e70cc218773e5f9b50864d4bc61344249cc' => 
    array (
      0 => '/home/kougi/public_html/phoneVice/templates/header.html',
      1 => 1563866312,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7946192655d36ef33c3f635_99198484',
  'variables' => 
  array (
    'LANGUAGE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5d36ef33c485c8_25150110',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5d36ef33c485c8_25150110')) {
function content_5d36ef33c485c8_25150110 ($_smarty_tpl) {
if (!is_callable('smarty_block_t')) require_once './smarty/plugins/block.t.php';

$_smarty_tpl->properties['nocache_hash'] = '7946192655d36ef33c3f635_99198484';
?>
<!DOCTYPE html>
<html lang="<?php echo $_smarty_tpl->tpl_vars['LANGUAGE']->value;?>
"><head><meta http-equiv="content-type" content="text/html; charset=UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><meta name="description" content="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
PhoneVice description<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"><title>Phone Vice</title><meta name="robots" content="index, follow"><?php echo '<script'; ?>
>var localePhonevice = "<?php echo $_smarty_tpl->tpl_vars['LANGUAGE']->value;?>
";var buttonPhonevice = "<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
PhoneVice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
";var heading = "<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
PhoneVice Heading<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
";<?php echo '</script'; ?>
><link rel="icon" href="images/favicon.ico" sizes="16x16 24x24 32x32 64x64" type="image/png"><link href="css/bootstrap.min.css" rel="stylesheet"><link href="css/style.css" rel="stylesheet"><?php echo '<script'; ?>
 src="scripts/jquery.min.js"><?php echo '</script'; ?>
><?php echo '<script'; ?>
 src="scripts/bootstrap.bundle.min.js"><?php echo '</script'; ?>
><?php echo '<script'; ?>
 src="scripts/custom.js"><?php echo '</script'; ?>
></head>
<?php }
}
?>
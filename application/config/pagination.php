<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Pagination
| -------------------------------------------------------------------------
| This file lets you define Pagination config.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/pagination.html
|
*/
//$config['per_page'] = 1;
//$config['uri_segment'] = 3;
$config['use_page_numbers'] = TRUE;

$config['full_tag_open'] = '<div class="pagination  pagination-small">
<ul>';
$config['full_tag_close'] = ' </ul>
</div>';

$config['first_link'] = 'Начало';
$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';

$config['last_link'] = 'Конец';
$config['last_tag_open'] = '<li>';
$config['last_tag_close'] = '</li>';

$config['next_link'] = '&gt;';
$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';

$config['prev_link'] = '&lt;';
$config['prev_tag_open'] = '<li>';
$config['prev_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="active"><a href="#">';
$config['cur_tag_close'] = '</a></li>';

$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';


/* End of file pagination.php */
/* Location: ./application/config/pagination.php */
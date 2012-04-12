<?php
$data = isset($data) ? $data : array();
$data['content'] = $this->load->view($this->config->item('auth_views_root') . 'pages/'.$page, $data, true);
$this->load->view('splash_template',  $data);
?>

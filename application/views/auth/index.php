<?php

//$this->load->view($this->config->item('auth_views_root') . 'header');

if(isset($data))
{
	$data['content'] = $this->load->view($this->config->item('auth_views_root') . 'pages/'.$page, $data, true);
}
else
{
	$data['content'] = $this->load->view($this->config->item('auth_views_root') . 'pages/'.$page, null, true);
}

//$this->load->view($this->config->item('auth_views_root') . 'footer');

$this->load->view('template',  $data);
?>
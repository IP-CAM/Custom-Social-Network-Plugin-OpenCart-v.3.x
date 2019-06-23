<?php
/**
 * Created by CodeDoctor Team.
 * User: nilge
 * Date: 15-06-19
 * Time: 07:03 AM
 * Project: ddc_shirdharth
 * Copyright: CodeDoctor Team (https://codedoctor.co.in)
 * License: This product/codes is/are property of Oxentic Technologies India Pvt. Ltd. Oxentic Technologies India Pvt. Ltd. or any other developers who have permission by Oxentic Technologies India Pvt. Ltd. has right to distribute or modify this code.
 */

class Controllerextensionmoduleniladrisocialmedia extends Controller
{
    private $error = array();

    public function index()
    {


        $this->load->language('extension/module/niladrisocialmedia');
        $this->document->setTitle($this->language->get('page_title'));
        $this->load->model('setting/module');
        $this->load->model('extension/module/niladrisocialmedia');

        $data = array();

        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('extension/module/niladrisocialmedia', 'user_token=' . $this->session->data['user_token'], true);
        } else {
            $data['action'] = $this->url->link('extension/module/niladrisocialmedia', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
        }


        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validation()) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_setting_module->addModule('niladrisocialmedia', array('status' => $this->request->post['status']));
            } else {
                $this->model_setting_module->editModule($this->request->get['module_id'],  array('status' => $this->request->post['status']));
            }

            $this->model_extension_module_niladrisocialmedia->groupInsertOrUpdateSocialNetwork();

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        if (isset($this->request->post['social']))
        {
            $niladri_social_networks = array_merge(array(
                'facebook' => '',
                'twitter' => '',
                'linkedin' => '',
                'youtube' => '',
                'instagram' => ''
            ), $this->request->post['social']);
            foreach ($niladri_social_networks as $name => $link)
            {
                $data["social_{$name}"] = $link;
            }
        } else{
            $niladri_social_networks = array_merge(array(
                'facebook' => '',
                'twitter' => '',
                'linkedin' => '',
                'youtube' => '',
                'instagram' => ''
            ), $this->model_extension_module_niladrisocialmedia->getSocialNetworks());

            foreach ($niladri_social_networks as $name => $value)
            {
                $data["social_{$name}"] = !empty($value['link']) ? $value['link'] : '';
            }
        }

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = '';
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        return $this->response->setOutput($this->load->view('extension/module/niladri/niladrisocialmedia', $data));
    }

    /**
     * Installation method of Module
     */
    public function install()
    {

        $this->load->model('extension/module/niladrisocialmedia');

        $this->model_extension_module_niladrisocialmedia->createSocialMediaTable();
    }

    /**
     * Uninstall method of Module
     */
    public function uninstall()
    {
        $this->load->model('extension/module/niladrisocialmedia');
        $this->model_extension_module_niladrisocialmedia->deleteSocialMediaTable();
    }


    public function getList()
    {

    }

    /**
     * Installation and un-installation validation for module
     * @return bool
     */
    protected function is_installation_validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/niladrisocialmedia')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    /**
     * Form validation during edit or save
     */
    protected function validation()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/niladrisocialmedia')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }
}
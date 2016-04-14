<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['upload_dir_absolute_path'] = '../../../uploads/cmsUploads/';

$config['upload_dir_relative_path'] = 'uploads/cmsUploads/';

$config['upload_dir_name'] = 'cmsUploads';

$config['allowed_upload_file_ext'] = array(
    'audio' => array('mpga', 'mp2', 'mp3', 'ra', 'rv', 'wav'),
    'video' => array('mpeg', 'mpg', 'mpe', 'mp4', 'flv', 'qt', 'mov', 'avi', 'movie'),
    'document' => array('pdf', 'xls', 'ppt', 'pptx', 'txt', 'text', 'log', 'rtx', 'rtf', 'xml', 'xsl', 'doc', 'docx', 'xlsx', 'word', 'xl', 'csv', 'pages', 'numbers'),
    'image' => array('bmp', 'gif', 'jpeg', 'jpg', 'jpe', 'png', 'tiff', 'tif'),
    'other' => array('psd', 'gtar', 'swf', 'tar', 'tgz', 'xhtml', 'zip', 'css', 'html', 'htm', 'shtml', 'svg'));


